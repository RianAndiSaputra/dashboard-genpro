@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Yellow Card -->
        <div class="yellow-card card h-24"></div>
        
        <!-- Pink Card -->
        <div class="pink-card card h-24"></div>
    </div>

    <!-- Bottom Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-4" style="background-color: #E3256B;">
                <i data-lucide="trending-up" class="w-6 h-6 text-white"></i>
            </div>
            <div class="w-full h-0.5 bg-gray-200 mt-2"></div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-4" style="background-color: #FFBF00;">
                <i data-lucide="dollar-sign" class="w-6 h-6 text-white"></i>
            </div>
            <div class="w-full h-0.5 bg-gray-200 mt-2"></div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-4" style="background-color: #8A2BE2;">
                <i data-lucide="bar-chart-2" class="w-6 h-6 text-white"></i>
            </div>
            <div class="w-full h-0.5 bg-gray-200 mt-2"></div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-4" style="background-color: #3498DB;">
                <i data-lucide="pie-chart" class="w-6 h-6 text-white"></i>
            </div>
            <div class="w-full h-0.5 bg-gray-200 mt-2"></div>
        </div>
    </div>
@endsection