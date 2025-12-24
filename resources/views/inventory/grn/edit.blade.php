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
                                    <p class="text-sm text-gray-600">Update received quantities, rates, and review line totals</p>
                                </div>
                                <div class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full text-sm font-semibold">
                                    {{ count($grn->items) }} Items
                                </div>
                            </div>

                            <div class="rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200" id="grnEditItemsTable">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                    Item Description
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                    Receive Qty
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                    Rate (₹)
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                    Line Total (₹)
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($grn->items as $i => $row)
                                                @php
                                                    $qtyV  = old("items.$i.qty_received", $row->qty_received);
                                                    $rateV = old("items.$i.rate", $row->rate);
                                                    $lineV = round(((float)$qtyV) * ((float)$rateV), 2);
                                                @endphp
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
                                                                       value="{{ $qtyV }}"
                                                                       class="qty_received w-36 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-right transition duration-150 ease-in-out"
                                                                       required>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex justify-end">
                                                            <div class="relative">
                                                                <input type="number" step="0.01" min="0"
                                                                       name="items[{{ $i }}][rate]"
                                                                       value="{{ $rateV }}"
                                                                       class="rate w-36 px-4 py-2.5 pl-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-right transition duration-150 ease-in-out"
                                                                       required>
                                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                    <span class="text-gray-500 font-medium">₹</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                                        <div class="flex justify-end">
                                                            <input type="text"
                                                                   class="line_total w-40 px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-right font-semibold"
                                                                   value="{{ number_format($lineV, 2, '.', '') }}"
                                                                   readonly>
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
                                        Line totals and totals summary will update automatically when you change qty or rate.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Totals Section (editable in edit page) --}}
                        <div class="mt-6 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-5">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Totals</h3>
                                    <p class="text-sm text-gray-600">Update delivery / taxes if required</p>
                                </div>
                                {{-- <div class="text-sm text-gray-500">
                                    Current Net: <span class="font-semibold text-gray-900">₹{{ number_format((float)old('grand_total', $grn->grand_total), 2) }}</span>
                                </div> --}}
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-start-2 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Total Items Amount</label>
                                        <input id="sub_total" type="text"
                                               class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-right font-mono"
                                               readonly
                                               value="{{ number_format((float)old('sub_total', $grn->sub_total), 2, '.', '') }}">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Delivery Amount</label>
                                        <input id="delivery_amount" name="delivery_amount" type="number" step="0.01" min="0"
                                               class="w-full border-gray-300 rounded-lg px-3 py-2 text-right"
                                               value="{{ old('delivery_amount', $grn->delivery_amount ?? 0) }}">
                                    </div>

                                    <div class="flex items-center justify-between border border-gray-200 rounded-lg px-3 py-2 bg-white">
                                        <div class="flex items-center gap-3">
                                            <input id="sscl_enabled" name="sscl_enabled" type="checkbox" value="1"
                                                   class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                                   {{ old('sscl_enabled', $grn->sscl_enabled) ? 'checked' : '' }}>
                                            <label for="sscl_enabled" class="text-sm font-medium text-gray-700">
                                                Apply SSCL (2.5%)
                                            </label>
                                        </div>
                                        <div class="text-xs text-gray-500">auto</div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">SSCL Amount</label>
                                        <input id="sscl_amount" type="text"
                                               class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-right font-mono"
                                               readonly
                                               value="{{ number_format((float)old('sscl_amount', $grn->sscl_amount ?? 0), 2, '.', '') }}">
                                    </div>

                                    <div class="flex items-center justify-between border border-gray-200 rounded-lg px-3 py-2 bg-white">
                                        <div class="flex items-center gap-3">
                                            <input id="vat_enabled" name="vat_enabled" type="checkbox" value="1"
                                                   class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                                   {{ old('vat_enabled', $grn->vat_enabled) ? 'checked' : '' }}>
                                            <label for="vat_enabled" class="text-sm font-medium text-gray-700">
                                                Apply VAT (18%)
                                            </label>
                                        </div>
                                        <div class="text-xs text-gray-500">auto</div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">VAT Amount</label>
                                        <input id="vat_amount" type="text"
                                               class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-right font-mono"
                                               readonly
                                               value="{{ number_format((float)old('vat_amount', $grn->vat_amount ?? 0), 2, '.', '') }}">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-800">Net GRN Value</label>
                                        <input id="grand_total" name="grand_total" type="text"
                                               class="w-full border-gray-300 rounded-lg px-3 py-2 bg-indigo-50 font-bold text-lg text-right font-mono"
                                               readonly
                                               value="{{ number_format((float)old('grand_total', $grn->grand_total ?? 0), 2, '.', '') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Hidden fields (optional) if you want to POST computed numbers explicitly --}}
                            <input type="hidden" name="sub_total" id="sub_total_hidden" value="{{ (float)old('sub_total', $grn->sub_total) }}">
                            <input type="hidden" name="sscl_amount" id="sscl_amount_hidden" value="{{ (float)old('sscl_amount', $grn->sscl_amount) }}">
                            <input type="hidden" name="vat_amount" id="vat_amount_hidden" value="{{ (float)old('vat_amount', $grn->vat_amount) }}">
                            <input type="hidden" name="grand_total_calc" id="grand_total_hidden" value="{{ (float)old('grand_total', $grn->grand_total) }}">
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200 mt-8">
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById('grnEditItemsTable');

            const subTotalEl = document.getElementById('sub_total');
            const deliveryEl = document.getElementById('delivery_amount');

            const ssclEnabledEl = document.getElementById('sscl_enabled');
            const vatEnabledEl = document.getElementById('vat_enabled');

            const ssclAmountEl = document.getElementById('sscl_amount');
            const vatAmountEl  = document.getElementById('vat_amount');
            const grandTotalEl = document.getElementById('grand_total');

            // hidden values (optional)
            const subHidden   = document.getElementById('sub_total_hidden');
            const ssclHidden  = document.getElementById('sscl_amount_hidden');
            const vatHidden   = document.getElementById('vat_amount_hidden');
            const grandHidden = document.getElementById('grand_total_hidden');

            function toNum(v) {
                const n = parseFloat(v);
                return isNaN(n) ? 0 : n;
            }

            function round2(n) {
                return Math.round(n * 100) / 100;
            }

            function calcTotals() {
                let sub = 0;

                table.querySelectorAll('tbody tr').forEach(tr => {
                    const qtyEl  = tr.querySelector('.qty_received');
                    const rateEl = tr.querySelector('.rate');
                    const lineEl = tr.querySelector('.line_total');

                    const qty  = toNum(qtyEl?.value);
                    const rate = toNum(rateEl?.value);

                    const line = round2(qty * rate);
                    if (lineEl) lineEl.value = line.toFixed(2);

                    sub += line;
                });

                sub = round2(sub);

                const delivery = toNum(deliveryEl?.value);
                const base = sub + delivery;

                const sscl = ssclEnabledEl?.checked ? round2(base * 0.025) : 0;
                const vatBase = base + sscl;
                const vat = vatEnabledEl?.checked ? round2(vatBase * 0.18) : 0;

                const grand = round2(sub + delivery + sscl + vat);

                subTotalEl.value = sub.toFixed(2);
                ssclAmountEl.value = sscl.toFixed(2);
                vatAmountEl.value = vat.toFixed(2);
                grandTotalEl.value = grand.toFixed(2);

                if (subHidden) subHidden.value = sub.toFixed(2);
                if (ssclHidden) ssclHidden.value = sscl.toFixed(2);
                if (vatHidden) vatHidden.value = vat.toFixed(2);
                if (grandHidden) grandHidden.value = grand.toFixed(2);
            }

            // live recalculation
            document.addEventListener('input', (e) => {
                if (!e.target) return;

                if (
                    e.target.classList.contains('qty_received') ||
                    e.target.classList.contains('rate') ||
                    e.target.id === 'delivery_amount'
                ) {
                    calcTotals();
                }
            });

            ssclEnabledEl?.addEventListener('change', calcTotals);
            vatEnabledEl?.addEventListener('change', calcTotals);

            // initial calc (will align line totals + totals)
            calcTotals();
        });
    </script>

    <style>
        input[type="number"] { -moz-appearance: textfield; }
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

        .transform { transform: translateZ(0); }

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
