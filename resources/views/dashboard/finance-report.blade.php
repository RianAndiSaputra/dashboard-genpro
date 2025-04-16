@extends('layouts.app')

@section('content')
<div class="relative bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header - Shorter width and overlapping with shadow -->
    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-3/4">
        <div class="bg-yellow-500 text-center py-3 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800">FINANCIAL REPORT BUSINESS CLUB</h2>
        </div>
    </div>

    <!-- Padding for header space -->
    <div class="pt-10 mb-6"></div>

    <!-- Date Range Selector -->
    <div class="flex items-center space-x-2 mb-4">
        <input type="date" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
        <span class="text-gray-600">—</span>
        <input type="date" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
        <button class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-md shadow transition duration-300 flex items-center">
            <i data-lucide="search" class="w-4 h-4"></i>
        </button>
    </div>

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
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow transition duration-300 flex items-center">
                <i data-lucide="file-text" class="w-4 h-4 mr-1"></i>
                Export
            </button>
            <div class="flex items-center bg-gray-50 rounded-md px-3 py-1 shadow-sm">
                <span class="mr-2 text-gray-600">Search:</span>
                <input type="text" class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
        </div>
    </div>

    <!-- Table with modern styling -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name/Description</th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div>Item Type/Method</div>
                        <div class="text-xs uppercase">Cash/Transfer</div>
                    </th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div>Income</div>
                        <div class="text-xs normal-case">(Rp)</div>
                    </th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div>Expense</div>
                        <div class="text-xs normal-case">(Rp)</div>
                    </th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div>Balance</div>
                        <div class="text-xs normal-case">(Rp)</div>
                    </th>
                    <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Row 1 -->
                <tr>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-center text-gray-900">1</td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap">
                        <div class="flex justify-center space-x-1">
                            <button class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                                Edit
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Rows 2-6 -->
                @for ($i = 2; $i <= 6; $i++)
                <tr>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-center text-gray-900">{{ $i }}</td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-3 py-4 whitespace-nowrap">
                        <div class="flex justify-center space-x-1">
                            <button class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                                Edit
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                Delete
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
            <span class="text-sm text-gray-700">Showing 1 to 6 of 6 entries</span>
        </div>
        <div class="flex space-x-1">
            <a href="#" class="bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded-md flex items-center justify-center transition duration-300">
                <span class="sr-only">Previous</span>
                &laquo;
            </a>
            <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md flex items-center justify-center transition duration-300">
                1
            </a>
            <a href="#" class="bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded-md flex items-center justify-center transition duration-300">
                <span class="sr-only">Next</span>
                &raquo;
            </a>
        </div>
    </div>
</div>

<!-- Add Transaction Modal -->
<div id="addTransactionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Add Financial Transaction</h3>
            <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-500">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <input type="text" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Invoice Number</label>
                <input type="text" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                <select class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Amount (Rp)</label>
                <input type="number" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
        </div>
        
        <div class="flex justify-end mt-6 space-x-3">
            <button onclick="closeAddModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition duration-300">
                Cancel
            </button>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-300">
                Save Transaction
            </button>
        </div>
    </div>
</div>

<!-- Edit Transaction Modal -->
<div id="editTransactionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Edit Financial Transaction</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" id="edit-date" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <input type="text" id="edit-description" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Invoice Number</label>
                <input type="text" id="edit-invoice" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select id="edit-type" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                <select id="edit-payment-method" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Amount (Rp)</label>
                <input type="number" id="edit-amount" class="border border-gray-300 rounded-md w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
        </div>
        
        <div class="flex justify-end mt-6 space-x-3">
            <button onclick="closeEditModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition duration-300">
                Cancel
            </button>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-300">
                Update Transaction
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
            <p class="text-gray-700">Are you sure you want to delete this financial transaction? This action cannot be undone.</p>
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
    
    // Add Transaction Modal Functions
    function openAddModal() {
        document.getElementById('addTransactionModal').classList.remove('hidden');
    }
    
    function closeAddModal() {
        document.getElementById('addTransactionModal').classList.add('hidden');
    }
    
    // Edit Transaction Modal Functions
    function openEditModal(id) {
        document.getElementById('editTransactionModal').classList.remove('hidden');
    }
    
    function closeEditModal() {
        document.getElementById('editTransactionModal').classList.add('hidden');
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