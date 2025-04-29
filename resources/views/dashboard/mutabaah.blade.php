@extends('layouts.app')

@section('content')
<div class="relative bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header - Shorter width and overlapping with shadow -->
    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-3/4">
        <div class="bg-yellow-500 text-center py-3 rounded-lg shadow-md flex justify-between items-center px-4">
            <h2 class="text-xl font-bold text-gray-800">LAPORAN MUTABAAH</h2>
        </div>
    </div>

        <!-- Form Fields - Horizontal layout -->
        <br><br><br>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="flex items-center">
                <label class="block w-24">Tahun</label>
                <span class="mr-2">:</span>
                <input type="text" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" value="2023">
            </div>
            <div class="flex items-center">
                <label class="block w-24">Bulan</label>
                <span class="mr-2">:</span>
                <select class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
        </div>
        <!-- Pagination and Export -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            <div class="flex items-center bg-gray-50 rounded-md px-3 py-2 shadow-sm w-full md:w-auto">
                <span class="mr-2 text-gray-600">Tampilkan</span>
                <select class="border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                <span class="ml-2 text-gray-600">entri</span>
            </div>
            <div class="flex items-center space-x-3 w-full md:w-auto">
                <button onclick="exportToCSV()" class="bg-red-900 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow transition duration-300 flex items-center m-3">
                    <i data-lucide="file-text" class="w-4 h-4 mr-1"></i>
                    Ekspor CSV
                </button>
                @unless (auth()->user()->role !== 'mentee')
                <button onclick="openAddModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow transition duration-300 flex items-center m-3">
                    <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                    Tambah
                </button>
                @endunless

                {{-- <div class="flex items-center bg-gray-50 rounded-md px-3 py-1 shadow-sm w-full">
                    <span class="mr-2 text-gray-600">Cari:</span>
                    <input type="text" class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-yellow-500 w-full">
                </div> --}}
            </div>
        </div>

        <!-- Table with horizontal scrolling -->
        <div class="border border-gray-200 rounded-lg overflow-x-auto">
            <table class="min-w-max w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-2 py-2 text-left text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">No</th>
                        <th class="px-2 py-2 text-left text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="px-2 py-2 text-left text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">Nama</th>
                        <th class="px-2 py-2 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">Sholat<br>Jamaah</th>
                        <th class="px-2 py-2 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">Baca<br>Qur'an</th>
                        <th class="px-2 py-2 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">Sholat<br>Dhuha</th>
                        <th class="px-2 py-2 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">Puasa<br>Sunnah</th>
                        <th class="px-2 py-2 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">Sedekah<br>Subuh</th>
                        <th class="px-2 py-2 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">Relasi<br>Baru</th>
                        <th class="px-2 py-2 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">Menabung</th>
                        <th class="px-2 py-2 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">Penjualan</th>
                        <th class="px-2 py-2 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody id="report-tbody" class="bg-white divide-y divide-gray-200">
                    @foreach($reports as $index => $report)
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 sticky left-0 bg-white">{{ $index + 1 }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 sticky left-12 bg-white">{{ $report->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 sticky left-40 bg-white">{{ $report->mentee->user->full_name ?? 'Tidak diketahui' }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $report->solat_berjamaah }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $report->baca_quraan }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $report->solat_duha }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $report->puasa_sunnah }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $report->sodaqoh_subuh }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $report->relasibaru }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $report->menabung }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $report->penjualan }}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                            <button class="delete-btn text-red-600 hover:text-red-900" onclick="confirmDelete({{ $report->id }})">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-4 bg-gray-50 px-4 py-3 rounded-lg">
            <div>
                <span class="text-sm text-gray-700">Menampilkan 1 sampai 3 dari 3 entri</span>
            </div>
            <div class="flex space-x-1">
                <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-md flex items-center justify-center transition duration-300">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
            </div>
        </div>
    </div>

        <!-- Add this to your Blade template -->
        <div id="addModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Tambah Laporan Mutabaah</h3>
                    <button onclick="closeAddModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                
                <form id="mutabaahForm">
                    @csrf
                    <div class="space-y-4">
                        <!-- Mentee Search -->
                        {{-- <div class="relative">
                            <label for="mentee_search" class="block text-sm font-medium text-gray-700">Cari Mentee</label>
                            <input type="text" id="mentee_search" autocomplete="off" 
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="Ketik nama mentee...">
                            <input type="hidden" id="mentee_id" name="mentee_id" required>
                            <div id="mentee_results" class="hidden absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"></div>
                        </div> --}}

                        <!-- Radio Button Groups -->
                        @php
                            $fields = [
                                'Sholat Jamaah' => 'solat_berjamaah',
                                'Baca Qur\'an' => 'baca_quraan',
                                'Sholat Dhuha' => 'solat_duha',
                                'Puasa Sunnah' => 'puasa_sunnah',
                                'Sedekah Subuh' => 'sodaqoh_subuh',
                                'Relasi Baru' => 'relasibaru',
                                'Menabung' => 'menabung',
                                'Penjualan' => 'penjualan'
                            ];
                        @endphp

                        @foreach($fields as $label => $name)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                            <div class="mt-1 flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="{{ $name }}" value="IYA" required class="focus:ring-yellow-500 h-4 w-4 text-yellow-600 border-gray-300">
                                    <span class="ml-2">IYA</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="{{ $name }}" value="TIDAK" class="focus:ring-yellow-500 h-4 w-4 text-yellow-600 border-gray-300">
                                    <span class="ml-2">TIDAK</span>
                                </label>
                            </div>
                        </div>
                        @endforeach

                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="closeAddModal()" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
            </div>
        </div>

<!-- JavaScript for Modal Functionality -->
<script>
    // Mentee Search Functionality
    // function setupMenteeSearch() {
    //     const searchInput = document.getElementById('mentee_search');
    //     const resultsContainer = document.getElementById('mentee_results');
    //     const menteeIdInput = document.getElementById('mentee_id');
        
    //     async function searchMentees(query) {
    //         try {
    //             const response = await fetch(`/api/mentee`);
    //             if (!response.ok) throw new Error('Network response was not ok');
    //             return await response.json();
    //         } catch (error) {
    //             console.error('Error searching mentees:', error);
    //             return [];
    //         }
    //     }
        
    //     function displayResults(mentees) {
    //         resultsContainer.innerHTML = '';
            
    //         if (mentees.length === 0) {
    //             resultsContainer.classList.add('hidden');
    //             return;
    //         }
            
    //         mentees.forEach(mentee => {
    //             const div = document.createElement('div');
    //             div.className = 'cursor-default select-none relative py-2 pl-3 pr-9 hover:bg-yellow-50';
    //             div.innerHTML = `
    //                 <span class="font-normal block truncate">${mentee.user.full_name}</span>
    //                 <span class="text-gray-500 text-sm">${mentee.company.name}</span>
    //             `;
    //             div.addEventListener('click', () => {
    //                 searchInput.value = mentee.user.full_name;
    //                 menteeIdInput.value = mentee.id;
    //                 resultsContainer.classList.add('hidden');
    //             });
    //             resultsContainer.appendChild(div);
    //         });
            
    //         resultsContainer.classList.remove('hidden');
    //     }
        
    //     const debounceSearch = debounce(async (query) => {
    //         if (query.length < 2) {
    //             resultsContainer.classList.add('hidden');
    //             return;
    //         }
            
    //         const mentees = await searchMentees(query);
    //         displayResults(mentees);
    //     }, 300);
        
    //     searchInput.addEventListener('input', (e) => {
    //         debounceSearch(e.target.value.trim());
    //     });
        
    //     document.addEventListener('click', (e) => {
    //         if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
    //             resultsContainer.classList.add('hidden');
    //         }
    //     });
    // }
    document.addEventListener('DOMContentLoaded', loadReports);

    async function loadReports() {
        try {
            const response = await fetch('/api/mutabaah', {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const result = await response.json();
            const { data } = result;

            const tbody = document.getElementById('report-tbody');
            tbody.innerHTML = '';

            data.forEach((report, index) => {
                const row = `
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 sticky left-0 bg-white">${index + 1}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 sticky left-12 bg-white">${new Date(report.created_at).toLocaleDateString()}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 sticky left-40 bg-white">${report.mentee?.user?.full_name || 'Tidak diketahui'}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">${report.solat_berjamaah}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">${report.baca_quraan}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">${report.solat_duha}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">${report.puasa_sunnah}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">${report.sodaqoh_subuh}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">${report.relasibaru}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">${report.menabung}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">${report.penjualan}</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                            <button class="delete-btn text-red-600 hover:text-red-900" data-id="${report.id}">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });

            lucide.createIcons(); // refresh ikon trash
        } catch (error) {
            console.error('Error loading reports:', error);
        }
    }


    
    // Form Submission
    document.getElementById('mutabaahForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    // Tidak perlu mentee_id lagi karena akan diambil dari user yang login
    data.tanggal = new Date().toISOString().split('T')[0]; // Current date
    
    try {
        const response = await fetch('/api/create/mutabaah', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (response.ok) {
            alert('Laporan mutabaah berhasil disimpan');
            window.location.reload();
        } else {
            throw new Error(result.message || 'Terjadi kesalahan');
        }
    } catch (error) {
        console.error('Error:', error);
        alert(error.message);
    }
});
    
    // Delete Functionality
    function confirmDelete(reportId) {
        if (confirm('Apakah Anda yakin ingin menghapus laporan ini?')) {
            fetch(`/api/delete/mutabaah/${reportId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('Laporan berhasil dihapus');
                    window.location.reload();
                } else {
                    throw new Error('Gagal menghapus laporan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message);
            });
        }
    }
    
    // Utility Functions
    function debounce(func, timeout = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }
    
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }
    
    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        setupMenteeSearch();
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    function exportToCSV() {
        // Dapatkan filter yang sedang aktif
        const tahun = document.querySelector('input[type="text"]').value;
        const bulan = document.querySelector('select').value;
        
        // Buat URL dengan parameter filter
        let url = 'api/mutabaah/export';
        const params = new URLSearchParams();
        
        if (tahun) params.append('tahun', tahun);
        if (bulan) params.append('bulan', bulan);
        
        if (params.toString()) {
            url += `?${params.toString()}`;
        }
        
        // Trigger download
        window.location.href = url;
    }
</script>
@endsection