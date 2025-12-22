<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Purchase Order
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $po->po_no }}
                </p>
            </div>
            <div class="mt-2 sm:mt-0">
                <a href="{{ route('po.show', $po) }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to PO
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Approved Warning -->
            @if ($po->status === 'approved')
                <div class="mb-6 p-4 bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-800">
                                This purchase order is approved and locked for editing.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 mb-2">Please correct the following errors:</h3>
                            <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- PO Info Card -->
            <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 rounded-lg bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">PO #{{ $po->po_no }}</h3>
                            <div class="flex flex-wrap gap-4 mt-1 text-sm text-gray-600">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $po->status === 'approved' ? 'bg-green-100 text-green-800' : ($po->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ strtoupper($po->status) }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($po->po_date)->format('M d, Y') }}
                                </span>
                                @if($po->supplier_name)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    {{ $po->supplier_name }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-indigo-50">
                    <div class="flex items-center">
                        <div class="p-2 rounded-lg bg-indigo-100">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-900">Edit Purchase Order Details</h3>
                            <p class="text-sm text-gray-500">Update supplier information and items</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form method="POST" action="{{ route('po.update', $po) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Supplier Name
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <input type="text"
                                       name="supplier_name"
                                       value="{{ old('supplier_name', $po->supplier_name) }}"
                                       class="pl-10 w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                       placeholder="Enter supplier name">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                PO Date
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="date"
                                       name="po_date"
                                       value="{{ old('po_date', \Carbon\Carbon::parse($po->po_date)->format('Y-m-d')) }}"
                                       class="pl-10 w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Items Section -->
                    <div class="border border-gray-200 rounded-lg p-5 bg-gradient-to-br from-gray-50 to-indigo-50">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Purchase Items</h3>
                                <p class="text-sm text-gray-500">Update items in this purchase order</p>
                            </div>
                            <button type="button"
                                    id="addRow"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Add Row
                            </button>
                        </div>

                        <!-- Items Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden" id="itemsTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="border-b px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Item
                                        </th>
                                        <th class="border-b px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th class="border-b px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Rate
                                        </th>
                                        <th class="border-b px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($po->items as $i => $row)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="border-b px-4 py-3">
                                                <select name="items[{{ $i }}][item_id]"
                                                        class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                                        required>
                                                    <option value="">-- Select Item --</option>
                                                    @foreach($items as $it)
                                                        <option value="{{ $it->id }}" @selected($it->id == $row->item_id)>
                                                            {{ $it->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border-b px-4 py-3">
                                                <input type="number"
                                                       step="0.001"
                                                       min="0.001"
                                                       name="items[{{ $i }}][qty]"
                                                       value="{{ $row->qty }}"
                                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                                       required
                                                       placeholder="0.000">
                                            </td>
                                            <td class="border-b px-4 py-3">
                                                <input type="number"
                                                       step="0.01"
                                                       min="0"
                                                       name="items[{{ $i }}][rate]"
                                                       value="{{ $row->rate }}"
                                                       class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                                       required
                                                       placeholder="0.00">
                                            </td>
                                            <td class="border-b px-4 py-3">
                                                <button type="button"
                                                        class="removeRow inline-flex items-center p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                        <a href="{{ route('po.show', $po) }}"
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </a>
                        <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all shadow-sm hover:shadow">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Purchase Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let rowIndex = {{ $po->items->count() }};

            const addRowBtn = document.getElementById('addRow');
            const tableBody = document.querySelector('#itemsTable tbody');

            addRowBtn.addEventListener('click', () => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50 transition-colors';
                tr.innerHTML = `
                    <td class="border-b px-4 py-3">
                        <select name="items[${rowIndex}][item_id]" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
                            <option value="">-- Select Item --</option>
                            @foreach($items as $it)
                                <option value="{{ $it->id }}">{{ $it->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="border-b px-4 py-3">
                        <input type="number" step="0.001" min="0.001"
                               name="items[${rowIndex}][qty]" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required placeholder="0.000">
                    </td>
                    <td class="border-b px-4 py-3">
                        <input type="number" step="0.01" min="0"
                               name="items[${rowIndex}][rate]" class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required placeholder="0.00">
                    </td>
                    <td class="border-b px-4 py-3">
                        <button type="button" class="removeRow inline-flex items-center p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </td>
                `;
                tableBody.appendChild(tr);
                rowIndex++;
            });

            document.addEventListener('click', (e) => {
                if (e.target && (e.target.classList.contains('removeRow') || e.target.closest('.removeRow'))) {
                    const rows = tableBody.querySelectorAll('tr');
                    if (rows.length === 1) return;
                    e.target.closest('tr').remove();
                }
            });
        });
    </script>
</x-app-layout>
