@extends('layouts.app')

@section('content')
<div class="relative bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header -->
    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-3/4">
        <div class="bg-yellow-500 text-center py-3 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800">SUMMARY FINANCIAL REPORT BUSINESS CLUB</h2>
        </div>
    </div>

    <div class="pt-10 mb-6"></div>

    <div class="mb-4 flex justify-end">

    </div>

    <!-- Create Button -->
    <div class="flex justify-end mb-4">
        <button onclick="exportCsv()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center m-3">
            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
            Export CSV
        </button>
        <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center m-3">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i> Tambah Laporan
        </button>
    </div>

    <!-- Date Range Filter -->
    {{-- <div class="flex items-center mb-6 gap-2">
        <input type="date" id="startDate" class="border border-gray-300 rounded-md px-3 py-2">
        <span class="mx-2">—</span>
        <input type="date" id="endDate" class="border border-gray-300 rounded-md px-3 py-2">
        <button onclick="filterData()" class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-2 rounded-md">
            <i data-lucide="search" class="w-5 h-5"></i>
        </button>
    </div> --}}

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-3 py-3 text-center text-xs font-bold text-gray-900 uppercase">No</th>
                    <th class="px-3 py-3 text-center text-xs font-bold text-gray-900 uppercase">Bulan</th>
                    <th class="px-3 py-3 text-center text-xs font-bold text-gray-900 uppercase">Nama Perusahaan</th>
                    <th class="px-3 py-3 text-center text-xs font-bold text-gray-900 uppercase">Omzet</th>
                    <th class="px-3 py-3 text-center text-xs font-bold text-gray-900 uppercase">HPP</th>
                    <th class="px-3 py-3 text-center text-xs font-bold text-gray-900 uppercase">Gross Profit</th>
                    <th class="px-3 py-3 text-center text-xs font-bold text-gray-900 uppercase">Nett Profit</th>
                    <th class="px-3 py-3 text-center text-xs font-bold text-gray-900 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($progress as $index => $report)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-center">{{ $index + 1 }}</td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-center">
                        {{ \Carbon\Carbon::parse($report['created_at'])->format('F Y') }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-center">
                        {{ $report['company']['nama_perusahaan'] }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-center">
                        Rp {{ number_format($report['omzet']['realisasi'], 0, ',', '.') }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-center">
                        Rp {{ number_format($report['hpp']['realisasi'], 0, ',', '.') }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-center">
                        Rp {{ number_format($report['grossProfit']['realisasi'], 0, ',', '.') }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-center">
                        Rp {{ number_format($report['netProfit']['realisasi'], 0, ',', '.') }}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-center">
                        <div class="flex justify-center space-x-1">
                            <button onclick="openViewModal({{ $report }})" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded-md text-xs flex items-center">
                                <i data-lucide="eye" class="w-3 h-3 mr-1"></i> View
                            </button>
                            <button onclick="openDeleteModal({{ $report['id'] }})" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md text-xs flex items-center">
                                <i data-lucide="trash-2" class="w-3 h-3 mr-1"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-4xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Detail Laporan Keuangan</h3>
                <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-500">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-50 p-4 rounded-md">
                    <p class="text-sm text-gray-500">Perusahaan:</p>
                    <p class="font-medium" id="modal-company-name"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-md">
                    <p class="text-sm text-gray-500">Bulan:</p>
                    <p class="font-medium" id="modal-month"></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach(['omzet', 'hpp', 'gross_profit', 'net_profit', 'gross_profit_margin', 'nett_profit_margin'] as $metric)
                <div class="bg-white p-4 rounded-md shadow">
                    <h4 class="font-medium mb-2 text-capitalize">{{ str_replace('_', ' ', $metric) }}</h4>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-blue-50 p-2 rounded-md">
                            <p class="text-xs text-gray-500">Target</p>
                            <p class="text-sm font-semibold" id="modal-{{ $metric }}-targert"></p>
                        </div>
                        <div class="bg-green-50 p-2 rounded-md">
                            <p class="text-xs text-gray-500">Realisasi</p>
                            <p class="text-sm font-semibold" id="modal-{{ $metric }}-realisasi"></p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end">
                <button onclick="closeViewModal()" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-md">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-4xl max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Tambah Laporan Keuangan</h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-500">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="financialReportForm" onsubmit="submitFinancialReport(event)">
                <!-- Company Selection -->
                <div class="mb-4">
                    <label for="company_search" class="block text-sm font-medium text-gray-700 mb-1">Perusahaan</label>
                    <div class="relative">
                        <input type="text" id="company_search" placeholder="Cari perusahaan..." class="w-full border border-gray-300 rounded-md px-3 py-2" autocomplete="off">
                        <input type="hidden" id="company_id" name="company_id" required>
                        
                        <!-- Search suggestions dropdown -->
                        <div id="company_suggestions" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto">
                            <!-- Suggestions will be populated here via JS -->
                        </div>
                    </div>
                    <p id="company_selected" class="mt-1 text-sm text-green-600 hidden">
                        <span id="selected_company_name"></span>
                        <button type="button" onclick="clearCompanySelection()" class="ml-2 text-red-500 hover:text-red-700">
                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                        </button>
                    </p>
                </div>

                <!-- Omzet -->
                <div class="bg-white p-4 rounded-md shadow mb-4">
                    <h4 class="font-medium mb-2">Omzet</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="omzet_target" class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                <input type="number" id="omzet_target" name="omzet[targert]" class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2" required>
                            </div>
                        </div>
                        <div>
                            <label for="omzet_realisasi" class="block text-sm font-medium text-gray-700 mb-1">Realisasi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                <input type="number" id="omzet_realisasi" name="omzet[realisasi]" class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HPP -->
                <div class="bg-white p-4 rounded-md shadow mb-4">
                    <h4 class="font-medium mb-2">HPP</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="hpp_target" class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                <input type="number" id="hpp_target" name="hpp[targert]" class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2" required>
                            </div>
                        </div>
                        <div>
                            <label for="hpp_realisasi" class="block text-sm font-medium text-gray-700 mb-1">Realisasi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                <input type="number" id="hpp_realisasi" name="hpp[realisasi]" class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biaya Operasional -->
                <div class="bg-white p-4 rounded-md shadow mb-4">
                    <h4 class="font-medium mb-2">Biaya Operasional</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="biayaops_target" class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                <input type="number" id="biayaops_target" name="biayaops[targert]" class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2" required>
                            </div>
                        </div>
                        <div>
                            <label for="biayaops_realisasi" class="block text-sm font-medium text-gray-700 mb-1">Realisasi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                <input type="number" id="biayaops_realisasi" name="biayaops[realisasi]" class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gross Profit -->
                <div class="bg-white p-4 rounded-md shadow mb-4">
                    <h4 class="font-medium mb-2">Gross Profit</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="gross_profit_target" class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                <input type="number" id="gross_profit_target" name="gross_profit[targert]" class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2" required>
                            </div>
                        </div>
                        <div>
                            <label for="gross_profit_realisasi" class="block text-sm font-medium text-gray-700 mb-1">Realisasi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                <input type="number" id="gross_profit_realisasi" name="gross_profit[realisasi]" class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Net Profit -->
                <div class="bg-white p-4 rounded-md shadow mb-4">
                    <h4 class="font-medium mb-2">Net Profit</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="net_profit_target" class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                <input type="number" id="net_profit_target" name="net_profit[targert]" class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2" required>
                            </div>
                        </div>
                        <div>
                            <label for="net_profit_realisasi" class="block text-sm font-medium text-gray-700 mb-1">Realisasi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                <input type="number" id="net_profit_realisasi" name="net_profit[realisasi]" class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gross Profit Margin -->
                <div class="bg-white p-4 rounded-md shadow mb-4">
                    <h4 class="font-medium mb-2">Gross Profit Margin</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="gross_profit_margin_target" class="block text-sm font-medium text-gray-700 mb-1">Target (%)</label>
                            <input type="number" id="gross_profit_margin_target" name="gross_profit_margin[targert]" step="0.01" max="100" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                        </div>
                        <div>
                            <label for="gross_profit_margin_realisasi" class="block text-sm font-medium text-gray-700 mb-1">Realisasi (%)</label>
                            <input type="number" id="gross_profit_margin_realisasi" name="gross_profit_margin[realisasi]" step="0.01" max="100" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                        </div>
                    </div>
                </div>

                <!-- Net Profit Margin -->
                <div class="bg-white p-4 rounded-md shadow mb-4">
                    <h4 class="font-medium mb-2">Net Profit Margin</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="nett_profit_margin_target" class="block text-sm font-medium text-gray-700 mb-1">Target (%)</label>
                            <input type="number" id="nett_profit_margin_target" name="nett_profit_margin[targert]" step="0.01" max="100" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                        </div>
                        <div>
                            <label for="nett_profit_margin_realisasi" class="block text-sm font-medium text-gray-700 mb-1">Realisasi (%)</label>
                            <input type="number" id="nett_profit_margin_realisasi" name="nett_profit_margin[realisasi]" step="0.01" max="100" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeCreateModal()" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-md">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    let companies = [];
    let selectedCompany = null;
    // Existing functions
    function openViewModal(report) {
        const modal = document.getElementById('viewModal');
        const formatCurrency = (value) => `Rp ${value?.toLocaleString('id-ID') || 0}`;
        const formatPercent = (value) => `${value}%`;

        // Populate data
        document.getElementById('modal-company-name').textContent = report.company.nama_perusahaan;
        document.getElementById('modal-month').textContent = new Date(report.created_at).toLocaleDateString('id-ID', {
            month: 'long',
            year: 'numeric'
        });

        // Populate metrics
        const metrics = ['omzet', 'hpp', 'gross_profit', 'net_profit', 'gross_profit_margin', 'nett_profit_margin'];
        metrics.forEach(metric => {
            const targetElem = document.getElementById(`modal-${metric}-targert`);
            const realisasiElem = document.getElementById(`modal-${metric}-realisasi`);
            
            if(targetElem && realisasiElem) {
                targetElem.textContent = metric.includes('margin') 
                    ? formatPercent(report[metric]?.targert)
                    : formatCurrency(report[metric]?.targert);
                
                realisasiElem.textContent = metric.includes('margin')
                    ? formatPercent(report[metric]?.realisasi)
                    : formatCurrency(report[metric]?.realisasi);
            }
        });

        modal.classList.remove('hidden');
    }

    function closeViewModal() {
        document.getElementById('viewModal').classList.add('hidden');
    }

    // function filterData() {
    //     const start = document.getElementById('startDate').value;
    //     const end = document.getElementById('endDate').value;
    //     // Implement your filtering logic here
    //     console.log('Filter data from:', start, 'to', end);
    // }

    // New functions for create modal
    function openCreateModal() {
        fetchCompanies();
        document.getElementById('createModal').classList.remove('hidden');
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
        document.getElementById('financialReportForm').reset();
    }

    async function fetchCompanies() {
        try {
            const response = await fetch('/api/company', {
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) throw new Error('Failed to fetch companies');
            
            companies = await response.json();
        } catch (error) {
            console.error('Error fetching companies:', error);
            showToast('error', 'Gagal memuat data perusahaan');
        }
    }
    
    // Function to show company suggestions
    function showCompanySuggestions() {
        const searchInput = document.getElementById('company_search');
        const suggestionsContainer = document.getElementById('company_suggestions');
        const searchValue = searchInput.value.toLowerCase();
        
        // Clear previous suggestions
        suggestionsContainer.innerHTML = '';
        
        if (searchValue.length < 2) {
            suggestionsContainer.classList.add('hidden');
            return;
        }
        
        // Filter companies based on search
        const filteredCompanies = companies.filter(company => 
            company.nama_perusahaan.toLowerCase().includes(searchValue)
        );
        
        if (filteredCompanies.length === 0) {
            suggestionsContainer.classList.add('hidden');
            return;
        }
        
        // Create suggestion items
        filteredCompanies.forEach(company => {
            const suggestionItem = document.createElement('div');
            suggestionItem.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
            suggestionItem.textContent = company.nama_perusahaan;
            suggestionItem.onclick = () => selectCompany(company);
            suggestionsContainer.appendChild(suggestionItem);
        });
        
        suggestionsContainer.classList.remove('hidden');
    }
    
    // Function to select a company
    function selectCompany(company) {
        selectedCompany = company;
        
        // Update UI
        document.getElementById('company_search').value = '';
        document.getElementById('company_id').value = company.id;
        document.getElementById('selected_company_name').textContent = company.nama_perusahaan;
        document.getElementById('company_selected').classList.remove('hidden');
        document.getElementById('company_suggestions').classList.add('hidden');
        
        // Optionally hide the search input and show only the selected company
        document.getElementById('company_search').classList.add('hidden');
    }
    
    // Function to clear company selection
    function clearCompanySelection() {
        selectedCompany = null;
        
        // Update UI
        document.getElementById('company_id').value = '';
        document.getElementById('company_selected').classList.add('hidden');
        document.getElementById('company_search').classList.remove('hidden');
        document.getElementById('company_search').focus();
    }
    
    // Initialize event listeners for company search
    function initCompanySearch() {
        const searchInput = document.getElementById('company_search');
        const suggestionsContainer = document.getElementById('company_suggestions');
        
        // Fetch companies when modal opens
        fetchCompanies();
        
        // Search input event
        searchInput.addEventListener('input', showCompanySuggestions);
        
        // Close suggestions when clicking outside
        document.addEventListener('click', function(event) {
            if (!searchInput.contains(event.target) && !suggestionsContainer.contains(event.target)) {
                suggestionsContainer.classList.add('hidden');
            }
        });
        
        // Open suggestions when focusing on search input
        searchInput.addEventListener('focus', function() {
            if (searchInput.value.length >= 2) {
                showCompanySuggestions();
            }
        });
    }
    
    // Initialize when modal is opened
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
        initCompanySearch();
    }

    async function submitFinancialReport(event) {
        event.preventDefault();
        
        const form = document.getElementById('financialReportForm');
        const formData = new FormData(form);
        const jsonData = {};
        
        // Structure the data to match the controller's expected format
        jsonData.company_id = formData.get('company_id');
        
        // Prepare omzet data
        jsonData.omzet = {
            targert: parseFloat(formData.get('omzet[targert]')),
            realisasi: parseFloat(formData.get('omzet[realisasi]'))
        };
        
        // Prepare hpp data
        jsonData.hpp = {
            targert: parseFloat(formData.get('hpp[targert]')),
            realisasi: parseFloat(formData.get('hpp[realisasi]'))
        };
        
        // Prepare biayaops data
        jsonData.biayaops = {
            targert: parseFloat(formData.get('biayaops[targert]')),
            realisasi: parseFloat(formData.get('biayaops[realisasi]'))
        };
        
        // Prepare gross_profit data
        jsonData.gross_profit = {
            targert: parseFloat(formData.get('gross_profit[targert]')),
            realisasi: parseFloat(formData.get('gross_profit[realisasi]'))
        };
        
        // Prepare net_profit data
        jsonData.net_profit = {
            targert: parseFloat(formData.get('net_profit[targert]')),
            realisasi: parseFloat(formData.get('net_profit[realisasi]'))
        };
        
        // Prepare gross_profit_margin data
        jsonData.gross_profit_margin = {
            targert: parseFloat(formData.get('gross_profit_margin[targert]')),
            realisasi: parseFloat(formData.get('gross_profit_margin[realisasi]'))
        };
        
        // Prepare net_profit_margin data
        jsonData.nett_profit_margin = {
            targert: parseFloat(formData.get('nett_profit_margin[targert]')),
            realisasi: parseFloat(formData.get('nett_profit_margin[realisasi]'))
        };
        
        try {
            const response = await fetch('/api/progress/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(jsonData)
            });
            
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Failed to create report');
            }
            
            const result = await response.json();
            showToast('success', 'Laporan berhasil dibuat');
            closeCreateModal();
            
            // Reload the page to refresh the table
            window.location.reload();
        } catch (error) {
            console.error('Error:', error);
            showToast('error', error.message || 'Gagal membuat laporan');
        }
    }

    // Toast notification function
    function showToast(type, message) {
        // Implement your toast notification logic here
        // Example using a simple alert for now
        if (type === 'error') {
            alert('Error: ' + message);
        } else {
            alert(message);
        }
    }

    async function fetchFinancialReports(startDate = null, endDate = null) {
        try {
            let url = '/api/progress/mentee';
            const params = new URLSearchParams();
            
            if (startDate) params.append('start_date', startDate);
            if (endDate) params.append('end_date', endDate);
            
            if (params.toString()) url += `?${params.toString()}`;
            
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            return await response.json();
        } catch (error) {
            console.error('Error fetching data:', error);
            showToast('error', 'Gagal memuat data');
            return { data: [] };
        }
    }

    function exportCsv() {
        // Tampilkan loading atau disable tombol
        const exportButton = document.querySelector('button[onclick="exportCsv()"]');
        const originalContent = exportButton.innerHTML;
        exportButton.disabled = true;
        exportButton.innerHTML = '<i data-lucide="loader" class="w-4 h-4 mr-2 animate-spin"></i> Exporting...';
        
        // Lakukan request untuk download file
        fetch('/api/progress/export-csv', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Export failed');
            }
            return response.blob();
        })
        .then(blob => {
            // Buat URL untuk blob dan download file
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'laporan_keuangan_' + new Date().toISOString().slice(0,10) + '.csv';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            a.remove();
            
            // Kembalikan tombol ke keadaan semula
            exportButton.disabled = false;
            exportButton.innerHTML = originalContent;
            
            // Update lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            showToast('success', 'Berhasil mengunduh laporan');
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Kembalikan tombol ke keadaan semula
            exportButton.disabled = false;
            exportButton.innerHTML = originalContent;
            
            // Update lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            showToast('error', 'Gagal mengunduh laporan');
        });
    }

</script>
@endsection 