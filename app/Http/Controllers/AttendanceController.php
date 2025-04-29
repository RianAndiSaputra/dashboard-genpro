<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\MenteeProfile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;

class AttendanceController extends Controller
{
    // Get all attendances with location info
    public function index()
    {
        $attendances = Attendance::with('mentee.user')->get();
        
        // Process each attendance to add location info
        $processedAttendances = $attendances->map(function ($attendance) {
            // Add location info to each attendance
            $attendanceWithLocation = $this->addLocationInfo($attendance);
            return $attendanceWithLocation;
        });
        
        return view('mente.absen', compact('attendances'));
        // Return with additional stats
        return response()->json([
            'data' => $processedAttendances,
            'stats' => [
                'total' => $attendances->count(),
                'today' => $attendances->where('check_in_time', '>=', now()->startOfDay())->count()
            ]
        ]);
    }

    public function historyAbsen(MenteeProfile $mentee, Request $request)
    {

        // Dapatkan mentee_id dari user yang login
        $menteeId = auth()->user()->menteeProfile->id;
        
        if (!$menteeId) {
            return response()->json([
                'message' => 'User is not registered as a mentee',
                'data' => []
            ], 400);
        }

        $query = Attendance::with(['mentee.user'])
            ->where('mentee_id', $menteeId);

        // Filter waktu
        switch ($request->filter) {
            case 'today':
                $query->whereDate('check_in_time', today());
                break;
            case 'week':
                $query->whereBetween('check_in_time', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('check_in_time', now()->month);
                break;
        }

        $attendances = $query->orderBy('check_in_time', 'desc')->get();

        return response()->json([
            'data' => $attendances->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'check_in_time' => $attendance->check_in_time,
                    'selfie_url' => $attendance->selfie_url,
                    'latitude' => $attendance->latitude,
                    'longitude' => $attendance->longitude,
                    // 'location_info' => [
                    //     'address' => $attendance->address,
                    //     'map_link' => $attendance->map_link
                    // ]
                    'location_info' => $this->addLocationInfo($attendance),
                ];
            }),
            'stats' => [
                'total' => $attendances->count(),
                'today' => Attendance::where('mentee_id', $menteeId)
                                ->whereDate('check_in_time', today())
                                ->count()
            ]
        ]);
    }

    // Create new attendance
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mentee_id' => 'required|exists:mentee_profiles,id',
            'check_in_time' => 'required|date_format:Y-m-d H:i:s',
            // 'selfie_url' => 'required|url|max:255',
            'selfie_url' => 'required|string|starts_with:data:image/',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ]);
        
        if (strpos($validated['selfie_url'], 'data:image/') === 0) {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $validated['selfie_url']));
            $filename = 'selfie_'.time().'.jpg';
            Storage::put('public/selfies/'.$filename, $image);
            $validated['selfie_url'] = Storage::url('public/selfies/'.$filename);
        }

        $attendance = Attendance::create($validated);
        
        return response()->json([
            'message' => 'Absensi berhasil dicatat',
            'data' => $this->addLocationInfo($attendance)
        ], 201);
    }

    // Get single attendance
    public function show($id)
    {
        $attendance = Attendance::with('mentee.user')->findOrFail($id);
        return response()->json($this->addLocationInfo($attendance));
    }

    // Helper method untuk menambahkan info lokasi
    private function addLocationInfo($attendance)
    {
        // Clone to array to avoid modifying the model
        $attendanceData = $attendance->toArray();
        
        // Get location details using coordinates
        $locationInfo = $this->getLocationDetails(
            $attendance->latitude, 
            $attendance->longitude
        );
        
        // Add location info to attendance data
        $attendanceData['location_info'] = $locationInfo;
        
        return $attendanceData;
    }

    // Method untuk mendapatkan detail lokasi dengan caching
    private function getLocationDetails($latitude, $longitude)
    {
        // Create cache key based on coordinates (rounded to 5 decimal places for nearby locations)
        $cacheKey = 'location_' . round($latitude, 5) . '_' . round($longitude, 5);
        
        // Check cache first (cache for 30 days)
        return Cache::remember($cacheKey, 60 * 24 * 30, function () use ($latitude, $longitude) {
            try {
                // Check rate limiting 
                $rateLimiterKey = 'geolocation-api:' . request()->ip();
                
                if (RateLimiter::tooManyAttempts($rateLimiterKey, 1)) {
                    $seconds = RateLimiter::availableIn($rateLimiterKey);
                    \Log::warning("Nominatim rate limit hit. Available in {$seconds} seconds.");
                    return $this->getFallbackLocationInfo($latitude, $longitude);
                }
                
                // Make request to Nominatim with proper headers
                $response = Http::withHeaders([
                    'User-Agent' => config('app.name') . ' Application/1.0',
                    'Referer' => config('app.url')
                ])->get("https://nominatim.openstreetmap.org/reverse", [
                    'format' => 'json',
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'zoom' => 16,
                    'addressdetails' => 1
                ]);
                
                // Track this request for rate limiting (1 request per minute)
                RateLimiter::hit($rateLimiterKey, 60);
                
                if (!$response->successful()) {
                    \Log::error("Failed to get location data: " . $response->status());
                    return $this->getFallbackLocationInfo($latitude, $longitude);
                }
                
                $data = $response->json();
                
                // Extract detailed address components
                $addressComponents = $data['address'] ?? [];
                $formattedAddress = $data['display_name'] ?? $this->getFallbackAddress($latitude, $longitude);
                
                // Build a more structured address string from components
                $detailedAddress = $this->buildFormattedAddress($addressComponents, $formattedAddress);
                
                return [
                    'address' => $detailedAddress,
                    'address_components' => $addressComponents,
                    'map_link' => "https://www.google.com/maps?q={$latitude},{$longitude}",
                    'coordinates' => [
                        'latitude' => $latitude,
                        'longitude' => $longitude
                    ],
                    'raw_data' => $data
                ];
                
            } catch (\Exception $e) {
                \Log::error('Geolocation error: ' . $e->getMessage());
                return $this->getFallbackLocationInfo($latitude, $longitude);
            }
        });
    }
    
    // Build a formatted address string from components
    private function buildFormattedAddress($addressComponents, $fallbackAddress) 
    {
        if (empty($addressComponents)) {
            return $fallbackAddress;
        }
        
        $addressParts = [];
        
        // Add road/street
        if (isset($addressComponents['road'])) {
            $addressParts[] = $addressComponents['road'];
            
            // Add house number if available
            if (isset($addressComponents['house_number'])) {
                $addressParts[0] .= ' ' . $addressComponents['house_number'];
            }
        }
        
        // Add suburb/district
        if (isset($addressComponents['suburb'])) {
            $addressParts[] = $addressComponents['suburb'];
        } elseif (isset($addressComponents['neighbourhood'])) {
            $addressParts[] = $addressComponents['neighbourhood'];
        }
        
        // Add city/town
        if (isset($addressComponents['city'])) {
            $addressParts[] = $addressComponents['city'];
        } elseif (isset($addressComponents['town'])) {
            $addressParts[] = $addressComponents['town'];
        } elseif (isset($addressComponents['village'])) {
            $addressParts[] = $addressComponents['village'];
        }
        
        // Add state and country
        if (isset($addressComponents['state'])) {
            $addressParts[] = $addressComponents['state'];
        }
        
        if (isset($addressComponents['country'])) {
            $addressParts[] = $addressComponents['country'];
        }
        
        return !empty($addressParts) ? implode(', ', $addressParts) : $fallbackAddress;
    }

    // Fallback for when geocoding fails
    private function getFallbackLocationInfo($lat, $lng) 
    {
        return [
            'address' => $this->getFallbackAddress($lat, $lng),
            'map_link' => "https://www.google.com/maps?q={$lat},{$lng}",
            'coordinates' => [
                'latitude' => $lat,
                'longitude' => $lng
            ]
        ];
    }

    // Generate a coordinate-based fallback address
    private function getFallbackAddress($lat, $lng)
    {
        // Convert to Indonesian coordinate format
        $latDir = $lat >= 0 ? 'LU' : 'LS';
        $lngDir = $lng >= 0 ? 'BT' : 'BB';
        
        return abs($lat) . '° ' . $latDir . ', ' . 
            abs($lng) . '° ' . $lngDir;
    }

    // Get attendance history for a specific mentee
    public function history($menteeId)
    {
        $attendances = Attendance::with('mentee.user')
            ->where('mentee_id', $menteeId)
            ->orderBy('check_in_time', 'desc')
            ->get();

        $processedAttendances = $attendances->map(function ($attendance) {
            return $this->addLocationInfo($attendance);
        });

        return view('mente.absen_history', [
            'attendances' => $processedAttendances,
            'mentee' => $attendances->first()->mentee ?? null
        ]);
    }
}