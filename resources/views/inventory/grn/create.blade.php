<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create Goods Receipt Note
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    GRN: <span class="font-medium">{{ $grnNo ?? 'New' }}</span> •
                    PO: <span class="font-medium">{{ $po->po_no }}</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Alert -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg border-l-4 border-red-500 bg-red-50 shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <h3 class="font-semibold text-red-800">Please correct the following errors</h3>
                    </div>
                    <ul class="mt-2 text-sm text-red-700 list-disc ms-8">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center">
                        <div class="p-2 rounded-lg bg-indigo-50 mr-3">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">GRN Details</h3>
                            <p class="text-sm text-gray-600">Complete the form to create Goods Receipt Note</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('grn.store', $po) }}">
                    @csrf

                    <div class="p-6">
                        <!-- Basic Information Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="space-y-4">
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            GRN Date
                                        </span>
                                    </label>
                                    <input type="date" name="grn_date"
                                           value="{{ old('grn_date', now()->format('Y-m-d')) }}"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-start">
                                    <div class="p-2 rounded-lg bg-blue-50 mr-3 mt-1">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Supplier</label>
                                        <div class="text-lg font-medium text-gray-900">{{ $po->supplier_name ?? '—' }}</div>
                                        <div class="text-sm text-gray-600 mt-1">Supplier details from Purchase Order</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Items Table Section -->
                        <div class="mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Receive Items</h3>
                                    <p class="text-sm text-gray-600">Enter received quantities for each item</p>
                                </div>
                                <div class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium">
                                    {{ count($po->items) }} Items
                                </div>
                            </div>

                            <div class="rounded-xl border border-gray-200 overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                Item Description
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                PO Quantity
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                Receive Quantity
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                Rate (₹)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($po->items as $i => $row)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center">
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">{{ $row->item?->name }}</div>
                                                            <input type="hidden" name="items[{{ $i }}][item_id]" value="{{ $row->item_id }}">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <div class="text-sm text-gray-900 bg-gray-50 inline-block px-3 py-1 rounded">
                                                        {{ number_format($row->qty, 3) }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <div class="flex justify-end">
                                                        <div class="relative">
                                                            <input type="number" step="0.001" min="0.001"
                                                                   name="items[{{ $i }}][qty_received]"
                                                                   value="{{ old("items.$i.qty_received", $row->qty) }}"
                                                                   class="w-32 px-3 py-2 border border-gray-300 rounded-lg text-right focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                                                   required>
                                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 sm:text-sm">#</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <div class="flex justify-end">
                                                        <div class="relative">
                                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 sm:text-sm">₹</span>
                                                            </div>
                                                            <input type="number" step="0.01" min="0"
                                                                   name="items[{{ $i }}][rate]"
                                                                   value="{{ old("items.$i.rate", $row->rate) }}"
                                                                   class="w-32 pl-8 pr-3 py-2 border border-gray-300 rounded-lg text-right focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                                                   required>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 text-sm text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Enter the actual received quantities for each item
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <div>
                                <a href="{{ route('po.show', $po) }}"
                                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Back to Purchase Order
                                </a>
                            </div>
                            <div class="flex gap-3">
                                <button type="submit"
                                        class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                    </svg>
                                    Save as Draft
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            opacity: 1;
            height: auto;
        }

        .focus\:ring-2:focus {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
        }
    </style>
</x-app-layout>
