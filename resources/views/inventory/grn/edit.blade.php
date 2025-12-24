<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Goods Receipt Note
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    GRN: <span class="font-medium bg-indigo-100 text-indigo-800 px-2 py-1 rounded">{{ $grn->grn_no }}</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Alert -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl border border-red-200 bg-gradient-to-r from-red-50 to-white shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-red-800">Validation Errors</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-indigo-100 mr-4">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Update GRN Details</h3>
                            <p class="text-sm text-gray-600">Modify the received quantities and rates as needed</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('grn.update', $grn) }}">
                    @csrf
                    @method('PUT')

                    <div class="p-6">
                        <!-- Basic Information Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                            <!-- GRN Date Card -->
                            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 shadow-sm">
                                <div class="flex items-center mb-3">
                                    <div class="p-2 rounded-lg bg-blue-100 mr-3">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <label class="block text-sm font-bold text-gray-700">
                                        GRN Date
                                    </label>
                                </div>
                                <input type="date" name="grn_date"
                                       value="{{ old('grn_date', \Carbon\Carbon::parse($grn->grn_date)->format('Y-m-d')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition duration-150 ease-in-out"
                                       required>
                            </div>

                            <!-- PO Information Card -->
                            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 shadow-sm">
                                <div class="flex items-start">
                                    <div class="p-2 rounded-lg bg-green-100 mr-3 mt-1">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <label class="block text-sm font-bold text-gray-700">Purchase Order</label>
                                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                Linked
                                            </span>
                                        </div>
                                        <div class="text-2xl font-bold text-gray-900 mb-1">
                                            {{ $grn->purchaseOrder?->po_no ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm text-gray-500">Reference purchase order number</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Items Table Section -->
                        <div class="mb-8">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Items List</h3>
                                    <p class="text-sm text-gray-600">Update received quantities and rates</p>
                                </div>
                                <div class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full text-sm font-semibold">
                                    {{ count($grn->items) }} Items
                                </div>
                            </div>

                            <div class="rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                                        </svg>
                                                        Item Description
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                    <div class="flex items-center justify-end">
                                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                        </svg>
                                                        Receive Qty
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                    <div class="flex items-center justify-end">
                                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Rate (₹)
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($grn->items as $i => $row)
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                                                <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                                </svg>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-semibold text-gray-900">{{ $row->item?->name }}</div>
                                                                <div class="text-xs text-gray-500">Item ID: {{ $row->item_id }}</div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="items[{{ $i }}][item_id]" value="{{ $row->item_id }}">
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex justify-end">
                                                            <div class="relative">
                                                                <input type="number" step="0.001" min="0.001"
                                                                       name="items[{{ $i }}][qty_received]"
                                                                       value="{{ old("items.$i.qty_received", $row->qty_received) }}"
                                                                       class="w-36 px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-right transition duration-150 ease-in-out"
                                                                       required>
                                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex justify-end">
                                                            <div class="relative">
                                                                <input type="number" step="0.01" min="0"
                                                                       name="items[{{ $i }}][rate]"
                                                                       value="{{ old("items.$i.rate", $row->rate) }}"
                                                                       class="w-36 px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-right transition duration-150 ease-in-out"
                                                                       required>
                                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                    <span class="text-gray-500 font-medium">₹</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-sm text-blue-700">
                                        Update the quantities and rates as needed. Changes will be reflected in inventory and accounting records.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <div>
                                <a href="{{ route('grn.show', $grn) }}"
                                   class="inline-flex items-center px-5 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Back to GRN Details
                                </a>
                            </div>
                            <div class="flex gap-3">
                                <button type="submit"
                                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Update GRN
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        input[type="number"] {
            -moz-appearance: textfield;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .focus\:ring-2:focus {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
        }

        .transform {
            transform: translateZ(0);
        }

        .transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .transition {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</x-app-layout>
