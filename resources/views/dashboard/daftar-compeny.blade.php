@extends('layouts.app')

@section('content')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="relative bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header - Shorter width and overlapping with shadow -->
    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-3/4">
        <div class="bg-yellow-500 text-center py-3 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800">DAFTAR COMPANY</h2>
        </div>
    </div>

    <!-- Padding for header space -->
    <div class="pt-10 mb-6"></div>

    <!-- Pagination and Export -->
    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center bg-gray-50 rounded-md px-3 py-2 shadow-sm">
            <span class="mr-2 text-gray-600">Show</span>
            <select class="border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
            <span class="ml-2 text-gray-600">entries</span>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="openAddModal()" class="bg-yellow-600 hover:bg-yellow-900 text-white px-4 py-2 rounded-md shadow transition duration-300 flex items-center">
                <i data-lucide="plus" class="w-4 h-4 mr-1"></i> Tambah
            </button>
            <button id="exportBtn" onclick="exportCompanies()" class="bg-red-700 hover:bg-red-900 text-white px-4 py-2 rounded-md shadow transition duration-300 flex items-center">
                <i data-lucide="file-text" class="w-4 h-4 mr-1"></i>
                Export
            </button>
            <div class="flex items-center bg-gray-50 rounded-md px-3 py-1 shadow-sm">
                <span class="mr-2 text-gray-600">Search:</span>
                <input type="text" class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Company</h3>
                <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-500">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
    
            <div class="space-y-4">
                <!-- Input Cari User -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari User</label>
                    <input type="text" id="user-search" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Ketik nama user...">
                    <input type="hidden" id="add-user-id">
                    <div id="user-results" class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md max-h-60 overflow-auto hidden">
                        <!-- Hasil pencarian akan muncul di sini -->
                    </div>
                </div>
    
                <!-- Input Nama Perusahaan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                    <input type="text" id="add-company-name" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>
    
                <!-- Input Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="add-email" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>
    
                <!-- Input Nomor WA -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WA</label>
    <input type="tel" 
           id="add-whatsapp" 
           pattern="[0-9]*" 
           inputmode="numeric"  
           class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
           onkeypress="return /[0-9]/i.test(event.key)"
           oninput="this.value = this.value.replace(/\D/g, '')">
                </div>
            </div>
    
            <div class="flex justify-end mt-6 space-x-3">
                <button onclick="closeAddModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition duration-300">
                    Cancel
                </button>
                <button onclick="submitAddForm()" class="bg-yellow-900 hover:bg-yellow-900 text-white px-4 py-2 rounded-md transition duration-300">
                    Simpan
                </button>
            </div>
        </div>
    </div>
    

    <!-- Table with modern styling -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Perusahaan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Owner</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor WhatsApp</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">TOOLS</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="companiesTableBody">
                <!-- Table rows will be populated dynamically via JavaScript -->
                @foreach($companies ?? [] as $index => $company)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $company->nama_perusahaan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $company->user ? $company->user->full_name : 'N/A' }}</td>                    
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $company->nomor_wa }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $company->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex justify-center space-x-2">
                            <button class="bg-yellow-900 hover:bg-yellow-900 text-white px-3 py-1 rounded-md shadow-sm text-xs flex items-center transition duration-300" 
                                   onclick="openEditModal({{ $company->id }})">
                                <i data-lucide="edit" class="w-3 h-3 mr-1"></i> Edit
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md shadow-sm text-xs flex items-center transition duration-300"
                                   onclick="openDeleteModal({{ $company->id }})">
                                <i data-lucide="trash-2" class="w-3 h-3 mr-1"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                
                <!-- If no companies, show empty rows -->
                @if(empty($companies) || count($companies) == 0)
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data perusahaan.
                        </td>
                    </tr>
                @else
                    @foreach($companies as $index => $company)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $company->nama_perusahaan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $company->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $company->nomor_wa }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $company->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center space-x-2">
                                <button class="bg-yellow-900 hover:bg-yellow-900 text-white px-3 py-1 rounded-md shadow-sm text-xs flex items-center transition duration-300" 
                                    onclick="openEditModal({{ $company->id }})">
                                    <i data-lucide="edit" class="w-3 h-3 mr-1"></i> Edit
                                </button>
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md shadow-sm text-xs flex items-center transition duration-300"
                                    onclick="openDeleteModal({{ $company->id }})">
                                    <i data-lucide="trash-2" class="w-3 h-3 mr-1"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4 bg-gray-50 px-4 py-3 rounded-lg">
        <div>
            <span class="text-sm text-gray-700">Showing 1 to {{ count($companies ?? []) }} of {{ count($companies ?? []) }} entries</span>
        </div>
        <div class="flex space-x-1">
            <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-md flex items-center justify-center transition duration-300">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Edit Company</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                <input type="text" id="edit-company-name" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Owner</label>
                <input 
                    type="text" 
                    id="search-owner" 
                    placeholder="Ketik nama/email owner..."
                    class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    onkeyup="searchOwner(this.value)"
                >
                <div id="owner-results" class="hidden mt-2 border border-gray-200 rounded-md max-h-40 overflow-y-auto">
                    <!-- Hasil pencarian muncul di sini -->
                </div>
                <input type="hidden" id="selected-owner-id">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
    <input type="tel" 
           id="edit-whatsapp" 
           pattern="[0-9]*" 
           inputmode="numeric"
           class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
           onkeypress="return /[0-9]/i.test(event.key)"
           oninput="this.value = this.value.replace(/\D/g, '')">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="edit-email" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
        </div>
        
        <div class="flex justify-end mt-6 space-x-3">
            <button onclick="closeEditModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition duration-300">
                Cancel
            </button>
            <button onclick="submitEditForm()" class="bg-red-700 hover:bg-red-900 text-white px-4 py-2 rounded-md transition duration-300">
                Save Changes
            </button>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Confirm Delete</h3>
            <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-500">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <div class="mb-6">
            <p class="text-gray-700">Are you sure you want to delete this company? This action cannot be undone.</p>
        </div>
        
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition duration-300">
                Cancel
            </button>
            <button onclick="confirmDelete()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition duration-300">
                Delete
            </button>
        </div>
    </div>
</div>

<!-- JavaScript for Modal Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // fungsi pencarian data
        const searchContainer = document.querySelector('.flex.items-center.bg-gray-50');
    const searchInput = searchContainer.querySelector('input');
    
    if (searchInput && searchContainer) {
        searchInput.id = 'companySearch';
        
        // Create search button
        const searchButton = document.createElement('button');
        searchButton.className = 'ml-2 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md shadow transition duration-300 flex items-center';
        searchButton.innerHTML = '<i data-lucide="search" class="w-4 h-4"></i>';
        searchButton.addEventListener('click', function() {
            searchCompanies(searchInput.value);
        });
        
        // Append button to container
        searchContainer.appendChild(searchButton);
        
        // Also allow search on Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchCompanies(this.value);
            }
        });
        
        // Initialize the icon
        lucide.createIcons({
            icons: {
                'search': true
            }
        });
    }

        // 

        // For add form
    const addWhatsappInput = document.getElementById('add-whatsapp');
        if (addWhatsappInput) {
            addWhatsappInput.setAttribute('type', 'tel');
            addWhatsappInput.setAttribute('pattern', '[0-9]*');
            
            addWhatsappInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/\D/g, '');
            });
    }
    
    // For edit form
    const editWhatsappInput = document.getElementById('edit-whatsapp');
    if (editWhatsappInput) {

        editWhatsappInput.setAttribute('type', 'tel');
        editWhatsappInput.setAttribute('pattern', '[0-9]*');
        

        editWhatsappInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });
    }

     // Add event listener to Export button
     const exportButton = document.querySelector('button.bg-red-700');
    if (exportButton) {
        exportButton.addEventListener('click', exportCompanies);
    }
    });
    
    // Hilangkan preload supaya sidebar bisa muncul sesuai localStorage
    window.addEventListener('DOMContentLoaded', () => {
        document.documentElement.classList.remove('preload');

        const html = document.documentElement;
        const sidebarToggle = document.getElementById('sidebarToggle');

        // Cek localStorage dan terapkan class collapsed
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            html.classList.add('sidebar-collapsed');
        }

        // Toggle listener
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                html.classList.toggle('sidebar-collapsed');
                const isNowCollapsed = html.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', isNowCollapsed);
            });
        }

        // Inisialisasi ikon lucide
        lucide.createIcons();
        
        // Load companies data
        loadCompanies();
    });
    
    // Fungsi untuk memuat data perusahaan
    function loadCompanies() {
        fetch("/api/company", {
            method: "GET",
            headers: {
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(res => res.json())
        .then(data => {
            // Implementasi untuk menampilkan data ke dalam tabel jika dibutuhkan
            console.log("Companies loaded:", data);
            
            // Kosongkan area tbody
            const tableBody = document.getElementById('companiesTableBody');
            if (tableBody && data.length > 0) {
                tableBody.innerHTML = '';
                
                // Populate table with data
                data.forEach((company, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${index + 1}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${company.nama_perusahaan || ''}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${company.user?.full_name || 'N/A'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${company.nomor_wa || ''}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${company.email || ''}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center space-x-2">
                                <button class="bg-yellow-300 hover:bg-yellow-700 text-white px-3 py-1 rounded-md shadow-sm text-xs flex items-center transition duration-300" 
                                       onclick="openEditModal(${company.id})">
                                    <i data-lucide="edit" class="w-3 h-3 mr-1"></i> Edit
                                </button>
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md shadow-sm text-xs flex items-center transition duration-300"
                                       onclick="openDeleteModal(${company.id})">
                                    <i data-lucide="trash-2" class="w-3 h-3 mr-1"></i> Hapus
                                </button>
                            </div>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
                
                // Reinitialize lucide icons for the new buttons
                lucide.createIcons();
            }
        })
        .catch(error => {
            console.error("Error loading companies:", error);
            showAlert("Error loading companies data", "error");
        });
    }

    // Fungsi Modal Tambah
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        // Reset form fields
        document.getElementById('add-user-id').value = '';
        document.getElementById('add-company-name').value = '';
        document.getElementById('add-email').value = '';
        document.getElementById('add-whatsapp').value = '';
    }
    
    // Fungsi Modal Edit
    let currentEditId = null;
    
    function openEditModal(id) {
        currentEditId = id;
        document.getElementById('editModal').classList.remove('hidden');
        
        fetch(`/api/detail/company/${id}`, {
            method: "GET",
            headers: {
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(res => res.json())
        .then(company => {
            // Hanya isi field yang ada di modal
            document.getElementById('edit-company-name').value = company.nama_perusahaan || '';
            document.getElementById('edit-whatsapp').value = company.nomor_wa || '';
            document.getElementById('edit-email').value = company.email || '';
            
            // Jika ingin menampilkan owner saat ini di input pencarian:
            if (company.user) {
                document.getElementById('search-owner').value = `${company.user.full_name}`;
                document.getElementById('selected-owner-id').value = company.user.user_id;
            }
        })
        .catch(error => {
            console.error("Error fetching company details:", error);
            showAlert("Error fetching company details", "error");
            closeEditModal();
        });
    }
    
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        currentEditId = null;
    }
    
    // Fungsi untuk menyimpan perubahan edit
    function submitEditForm() {
        if (!currentEditId) {
            showAlert("No company selected for editing", "error");
            return;
        }
        
        const data = {
            nama_perusahaan: document.getElementById('edit-company-name').value,
            nomor_wa: document.getElementById('edit-whatsapp').value,
            email: document.getElementById('edit-email').value,
            user_id: document.getElementById('selected-owner-id').value
        };
        
        console.log("Sending data:", data);
        
        // Using the correct API endpoint based on your controller
        fetch(`/api/update/company/${currentEditId}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            const contentType = response.headers.get('content-type');
            const responseData = contentType?.includes('application/json') 
                ? await response.json()
                : await response.text();
            
            if (!response.ok) {
                // Jika response tidak OK (status bukan 2xx)
                const errorMessage = responseData.message || 
                                (typeof responseData === 'string' ? responseData : "Error updating company");
                throw new Error(errorMessage);
            }
            
            return responseData;
        })
    }
    // fungsi cari nama owner di edit
    function searchOwner(query) {
        if (query.length < 2) {
            document.getElementById('owner-results').classList.add('hidden');
            return;
    }

    fetch(`/api/search/owners?q=${query}`)
        .then(res => res.json())
        .then(users => {
            const resultsContainer = document.getElementById('owner-results');
            resultsContainer.innerHTML = '';
            
            if (users.length === 0) {
                resultsContainer.innerHTML = '<p class="p-2 text-sm text-gray-500">Tidak ditemukan</p>';
            } else {
                users.forEach(user => {
                    const userElement = document.createElement('div');
                    userElement.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                    userElement.textContent = `${user.name}`;
                    userElement.onclick = () => selectOwner(user);
                    resultsContainer.appendChild(userElement);
                });
            }
            resultsContainer.classList.remove('hidden');
        });
}

function selectOwner(user) {
    document.getElementById('selected-owner-id').value = user.user_id;
    document.getElementById('search-owner').value = `${user.name}`;
    document.getElementById('owner-results').classList.add('hidden');
}


    // Fungsi Modal Delete
    let currentDeleteId = null;
    
    function openDeleteModal(id) {
        currentDeleteId = id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        currentDeleteId = null;
    }
    
    // Fungsi untuk menghapus company
    function confirmDelete() {
        if (!currentDeleteId) {
            showAlert("No company selected for deletion", "error");
            return;
        }
        
        fetch(`/api/delete/company/${currentDeleteId}`, {
            method: "DELETE",
            headers: {
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(res => res.json())
        .then(response => {
            console.log("Company deleted:", response);
            // showAlert("Company deleted successfully", "success");
            closeDeleteModal();
            loadCompanies(); // Refresh table instead of full page reload
        })
        .catch(error => {
            console.error("Error deleting company:", error);
            // showAlert("Error deleting company", "error");
        });
    }

    // Fungsi untuk tambah data
    function submitAddForm() {
    const data = {
        user_id: document.getElementById('add-user-id').value,
        nama_perusahaan: document.getElementById('add-company-name').value,
        email: document.getElementById('add-email').value,
        nomor_wa: document.getElementById('add-whatsapp').value
    };

    fetch("/api/create/company", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify(data)
    })
    .then(res => {
        if (!res.ok) {
            // If response status is not in the 200-299 range
            return res.json().then(errorData => {
                throw new Error(errorData.message || "Error adding company");
            });
        }
        return res.json();
    })
    .then(response => {
        console.log("Company added:", response);
        // showAlert("Company added successfully", "success");
        closeAddModal();
        loadCompanies(); // Refresh table
    })
    .catch(error => {
        console.error("Error adding company:", error);
        // showAlert(error.message || "Error adding company", "error");
    });
}
    
    // Fungsi untuk menampilkan alert
    function showAlert(message, type) {
        // Create alert element
        const alertDiv = document.createElement('div');
        alertDiv.className = `fixed top-5 right-5 p-4 rounded-md shadow-lg z-50 flex items-center ${
            type === 'success' ? 'bg-yellow-300 border-l-4 border-yellow-300 text-yellow-700' : 
            'bg-red-100 border-l-4 border-red-500 text-red-700'
        }`;
        
        // Add icon
        const iconType = type === 'success' ? 'check-circle' : 'alert-circle';
        alertDiv.innerHTML = `
            <div class="mr-3">
                <i data-lucide="${iconType}" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="font-medium">${message}</p>
            </div>
            <button class="ml-auto" onclick="this.parentElement.remove()">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        `;
        
        // Add to DOM
        document.body.appendChild(alertDiv);
        
        // Initialize icons in the alert
        lucide.createIcons({
            icons: {
                'check-circle': true,
                'alert-circle': true,
                'x': true
            },
            attrs: {
                class: ["stroke-current"]
            }
        });
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode === document.body) {
                document.body.removeChild(alertDiv);
            }
        }, 5000);
    }

    function openInputModal(id) {
        document.getElementById('inputModal').classList.remove('hidden');
    }

    function closeInputModal() {
        document.getElementById('inputModal').classList.add('hidden');
    }

    // pencarian user
    // Fungsi untuk pencarian user
document.getElementById('user-search').addEventListener('input', function(e) {
    const query = e.target.value;
    if (query.length < 2) {
        document.getElementById('user-results').classList.add('hidden');
        return;
    }

    fetch(`/api/search-users?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(users => {
            const resultsContainer = document.getElementById('user-results');
            resultsContainer.innerHTML = '';
            
            if (users.length === 0) {
                resultsContainer.innerHTML = '<div class="p-2 text-gray-500">User tidak ditemukan</div>';
            } else {
                users.forEach(user => {
                    const userElement = document.createElement('div');
                    userElement.className = 'p-2 hover:bg-gray-100 cursor-pointer border-b border-gray-200';
                    userElement.innerHTML = `
                        <div class="font-medium">${user.full_name}</div>
                        <div class="text-xs text-gray-500">${user.email}</div>
                    `;
                    userElement.addEventListener('click', () => {
                        document.getElementById('user-search').value = user.full_name;
                        document.getElementById('add-user-id').value = user.user_id;
                        resultsContainer.classList.add('hidden');
                    });
                    resultsContainer.appendChild(userElement);
                });
            }
            
            resultsContainer.classList.remove('hidden');
        });
});

// Tutup dropdown saat klik di luar
document.addEventListener('click', function(e) {
    if (!e.target.closest('#user-search') && !e.target.closest('#user-results')) {
        document.getElementById('user-results').classList.add('hidden');
    }
});

// fungsi export
// Function to export companies data to CSV
function exportCompanies() {
    // Fetch company data
    fetch("/api/company", {
        method: "GET",
        headers: {
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        }
    })
    .then(res => res.json())
    .then(data => {
        // Define CSV header
        let csvContent = "No,Nama Perusahaan,Nama Owner,Nomor WhatsApp,Email\n";
        
        // Add company data rows
        data.forEach((company, index) => {
            const ownerName = company.user?.full_name || 'N/A';
            const row = [
                index + 1,
                company.nama_perusahaan || '',
                ownerName,
                company.nomor_wa || '',
                company.email || ''
            ].map(cell => `"${String(cell).replace(/"/g, '""')}"`).join(',');
            
            csvContent += row + "\n";
        });
        
        // Create download link
        const encodedUri = encodeURI("data:text/csv;charset=utf-8," + csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", `companies_export_${new Date().toISOString().split('T')[0]}.csv`);
        document.body.appendChild(link);
        
        // Trigger download
        link.click();
        
        // Clean up
        document.body.removeChild(link);
        
        showAlert("Export successful", "success");
    })
    .catch(error => {
        console.error("Error exporting companies:", error);
        showAlert("Failed to export companies data", "error");
    });
}

// Add click event listener to the Export button
document.addEventListener('DOMContentLoaded', function() {
    const exportButton = document.querySelector('button.bg-red-700');
    if (exportButton) {
        exportButton.addEventListener('click', exportCompanies);
    }
});


// fungsi serchnya
function searchCompanies(query) {
    query = query.toLowerCase().trim();
    
    // If query is empty, reset the table
    if (query === '') {
        loadCompanies();
        return;
    }
    
    // Get all table rows
    const rows = document.querySelectorAll('#companiesTableBody tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let found = false;
        
        // Skip searching in empty message row
        if (cells.length <= 1) return;
        
        // Search in all columns except the first (No) and last (Tools)
        for (let i = 1; i < cells.length - 1; i++) {
            const cellText = cells[i].textContent.toLowerCase();
            if (cellText.includes(query)) {
                found = true;
                break;
            }
        }
        
        // Show or hide row based on search result
        if (found) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // If no results found, show message
    const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
    if (visibleRows.length === 0) {
        const tbody = document.getElementById('companiesTableBody');
        const noResultRow = document.createElement('tr');
        noResultRow.id = 'noResultsRow';
        noResultRow.innerHTML = `
            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                No matching companies found.
            </td>
        `;
        
        // Remove any existing no results row
        const existingNoResultRow = document.getElementById('noResultsRow');
        if (existingNoResultRow) {
            existingNoResultRow.remove();
        }
        
        tbody.appendChild(noResultRow);
    } else {
        // Remove no results row if it exists
        const existingNoResultRow = document.getElementById('noResultsRow');
        if (existingNoResultRow) {
            existingNoResultRow.remove();
        }
    }
}

// Add event listener to search input
// Function to search company data
function searchCompanies(query) {
    query = query.toLowerCase().trim();
    
    // If query is empty, reset the table
    if (query === '') {
        loadCompanies();
        return;
    }
    
    // Get all table rows
    const rows = document.querySelectorAll('#companiesTableBody tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let found = false;
        
        // Skip searching in empty message row
        if (cells.length <= 1) return;
        
        // Search in all columns except the first (No) and last (Tools)
        for (let i = 1; i < cells.length - 1; i++) {
            const cellText = cells[i].textContent.toLowerCase();
            if (cellText.includes(query)) {
                found = true;
                break;
            }
        }
        
        // Show or hide row based on search result
        if (found) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // If no results found, show message
    const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
    if (visibleRows.length === 0) {
        const tbody = document.getElementById('companiesTableBody');
        const noResultRow = document.createElement('tr');
        noResultRow.id = 'noResultsRow';
        noResultRow.innerHTML = `
            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                No matching companies found.
            </td>
        `;
        
        // Remove any existing no results row
        const existingNoResultRow = document.getElementById('noResultsRow');
        if (existingNoResultRow) {
            existingNoResultRow.remove();
        }
        
        tbody.appendChild(noResultRow);
    } else {
        // Remove no results row if it exists
        const existingNoResultRow = document.getElementById('noResultsRow');
        if (existingNoResultRow) {
            existingNoResultRow.remove();
        }
    }
}

// Add event listener to search input
document.addEventListener('DOMContentLoaded', function() {
    // Add ID to search input if it doesn't have one
    const searchInput = document.querySelector('.flex.items-center.bg-gray-50 input');
    if (searchInput) {
        searchInput.id = 'companySearch';
        
        // Add input event listener
        searchInput.addEventListener('input', function() {
            searchCompanies(this.value);
        });
    }
     // Rest of your DOMContentLoaded code...
});

// Replace all showAlert functions with SweetAlert
function showAlert(message, type) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: type,
        title: message
    });
}

// Update the submitAddForm function with better error handling
function submitAddForm() {
    const data = {
        user_id: document.getElementById('add-user-id').value,
        nama_perusahaan: document.getElementById('add-company-name').value,
        email: document.getElementById('add-email').value,
        nomor_wa: document.getElementById('add-whatsapp').value
    };

    // Validate required fields
    if (!data.user_id || !data.nama_perusahaan) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'User and Company Name are required fields!',
            confirmButtonColor: '#d33',
        });
        return;
    }

    fetch("/api/create/company", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify(data)
    })
    .then(async response => {
        const contentType = response.headers.get('content-type');
        const responseData = contentType?.includes('application/json') 
            ? await response.json()
            : await response.text();
        
        if (!response.ok) {
            const errorMessage = responseData.message || 
                            (typeof responseData === 'string' ? responseData : "Error adding company");
            throw new Error(errorMessage);
        }
        
        return responseData;
    })
    .then(response => {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Company added successfully',
            confirmButtonColor: '#3085d6',
        });
        closeAddModal();
        loadCompanies();
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: error.message || 'Failed to add company',
            confirmButtonColor: '#d33',
        });
    });
}

// Update the submitEditForm function with SweetAlert
function submitEditForm() {
    if (!currentEditId) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No company selected for editing',
            confirmButtonColor: '#d33',
        });
        return;
    }
    
    const data = {
        nama_perusahaan: document.getElementById('edit-company-name').value,
        nomor_wa: document.getElementById('edit-whatsapp').value,
        email: document.getElementById('edit-email').value,
        user_id: document.getElementById('selected-owner-id').value
    };

    // Validate required fields
    if (!data.nama_perusahaan) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Company Name is required!',
            confirmButtonColor: '#d33',
        });
        return;
    }
    
    fetch(`/api/update/company/${currentEditId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify(data)
    })
    .then(async response => {
        const contentType = response.headers.get('content-type');
        const responseData = contentType?.includes('application/json') 
            ? await response.json()
            : await response.text();
        
        if (!response.ok) {
            const errorMessage = responseData.message || 
                            (typeof responseData === 'string' ? responseData : "Error updating company");
            throw new Error(errorMessage);
        }
        
        return responseData;
    })
    .then(response => {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Company updated successfully',
            confirmButtonColor: '#3085d6',
        });
        closeEditModal();
        loadCompanies();
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: error.message || 'Failed to update company',
            confirmButtonColor: '#d33',
        });
    });
}

// Update the confirmDelete function with SweetAlert confirmation
function confirmDelete() {
    if (!currentDeleteId) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No company selected for deletion',
            confirmButtonColor: '#d33',
        });
        return;
    }
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/api/delete/company/${currentDeleteId}`, {
                method: "DELETE",
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                }
            })
            .then(res => res.json())
            .then(response => {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Company has been deleted.',
                    confirmButtonColor: '#3085d6',
                });
                closeDeleteModal();
                loadCompanies();
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.message || 'Failed to delete company',
                    confirmButtonColor: '#d33',
                });
            });
        }
    });
}

// Update the exportCompanies function with SweetAlert
function exportCompanies() {
    Swal.fire({
        title: 'Exporting Data',
        html: 'Preparing company data for export...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch("/api/company", {
        method: "GET",
        headers: {
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Data',
                text: 'There are no companies to export',
                confirmButtonColor: '#3085d6',
            });
            return;
        }
        
        let csvContent = "No,Nama Perusahaan,Nama Owner,Nomor WhatsApp,Email\n";
        
        data.forEach((company, index) => {
            const ownerName = company.user?.full_name || 'N/A';
            const row = [
                index + 1,
                company.nama_perusahaan || '',
                ownerName,
                company.nomor_wa || '',
                company.email || ''
            ].map(cell => `"${String(cell).replace(/"/g, '""')}"`).join(',');
            
            csvContent += row + "\n";
        });
        
        const encodedUri = encodeURI("data:text/csv;charset=utf-8," + csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", `companies_export_${new Date().toISOString().split('T')[0]}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        Swal.fire({
            icon: 'success',
            title: 'Export Successful',
            text: 'Company data has been exported',
            confirmButtonColor: '#3085d6',
        });
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Export Failed',
            text: error.message || 'Failed to export company data',
            confirmButtonColor: '#d33',
        });
    });
}
</script>
@endsection