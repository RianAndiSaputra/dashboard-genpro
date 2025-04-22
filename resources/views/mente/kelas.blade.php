@extends("layouts.app")

@section("content")

<div class="relative bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header - Yellow header that overlaps the white card -->
    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-3/4">
        <div class="bg-yellow-500 text-center py-3 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800">KELAS</h2>
        </div>
    </div>

    <!-- Padding for header space -->
    <div class="pt-10 mb-6"></div>

    {{-- <!-- Date Range Filter -->
    <div class="flex items-center mb-6 gap-2">
        <div class="relative">
            <input type="date" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>
        <span class="mx-2">—</span>
        <div class="relative">
            <input type="date" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>
        <button class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-2 rounded-md transition duration-300">
            <i data-lucide="search" class="w-5 h-5"></i>
        </button>
    </div> --}}


    <!-- Financial Report Table -->
    <!-- Tombol Input Data -->
<div class="flex justify-end mb-4">
    <button onclick="openInputModal()" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md shadow-md transition duration-300 flex items-center">
        <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Input Data
    </button>
</div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kelas</th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mentor</th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Sekertaris</th>
                    {{-- <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mentee</th> --}}
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Generate 7 rows of empty data -->
                @for ($i = 1; $i <= 7; $i++)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-center">{{ $i }}</td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm"></td>
                    {{-- <td class="px-3 py-4 whitespace-nowrap text-sm"></td> --}}
                    <td class="px-3 py-4 whitespace-nowrap text-center">
                        <div class="flex justify-center space-x-1">
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded-md shadow-sm text-xs flex items-center transition duration-300" 
                                   onclick="openViewModal({{ $i }})">
                                <i data-lucide="eye" class="w-3 h-3 mr-1"></i> View
                            </button>
                            <button class="bg-red-900 hover:bg-red-900 text-white px-2 py-1 rounded-md shadow-sm text-xs flex items-center transition duration-300"
                                   onclick="openDeleteModal({{ $i }})">
                                <i data-lucide="trash-2" class="w-3 h-3 mr-1"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4 bg-gray-50 px-4 py-3 rounded-lg">
        <div>
            <span class="text-sm text-gray-700">Showing 1 to 7 of 7 entries</span>
        </div>
        <div class="flex space-x-1">
            <button class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-md flex items-center justify-center transition duration-300">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

<!-- Input Modal -->
<div id="inputModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Input Data Kelas</h3>
            <button onclick="closeInputModal()" class="text-gray-400 hover:text-gray-500">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <form>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mentor</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekretaris</label>
                <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeInputModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                    Batal
                </button>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>


<!-- View Details Modal -->
<div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-3xl">
      
      <!-- Header Modal -->
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Detail Mentee</h3>
        <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-500">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>
  
      <!-- Info Mentor -->
      <div class="bg-gray-50 p-4 rounded-md mb-4">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="text-sm text-gray-500">Mentor:</p>
            <p class="font-medium" id="view-mentor-name">-</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Jumlah Mentee:</p>
            <p class="font-medium" id="view-mentee-count">-</p>
          </div>
        </div>
      </div>
  
      <!-- Tabel Daftar Mentee -->
      <div class="bg-white rounded-md shadow p-4">
        <h4 class="font-medium mb-2">Daftar Nama Mentee</h4>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr class="bg-gray-50">
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Mentee</th>
                {{-- 
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th> 
                --}}
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="view-mentee-list">
              <!-- Data Mentee Akan Diisi di Sini -->
              <tr>
                <td class="px-3 py-2 text-sm">1</td>
                <td class="px-3 py-2 text-sm">Nama Contoh</td>
                {{-- 
                <td class="px-3 py-2 text-sm">Kelas A</td>
                <td class="px-3 py-2 text-sm">Aktif</td> 
                --}}
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  
      <!-- Tombol Tutup -->
      <div class="flex justify-end mt-6">
        <button onclick="closeViewModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition duration-300">
          Tutup
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
            <p class="text-gray-700">Are you sure you want to delete this financial report? This action cannot be undone.</p>
        </div>
        
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition duration-300">
                Cancel
            </button>
            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition duration-300">
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
    });
    
    // View Modal Functions
    function openViewModal(id) {
        // In a real app, you would fetch data for this ID
        document.getElementById('viewModal').classList.remove('hidden');
    }
    
    function closeViewModal() {
        document.getElementById('viewModal').classList.add('hidden');
    }
    
    // Delete Modal Functions
    function openDeleteModal(id) {
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>

@endsection