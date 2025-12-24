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

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
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

                <form method="POST" action="{{ route('po.update', $po) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    {{-- Basic --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Supplier <span class="text-red-500">*</span>
                            </label>

                            {{-- FIXED: value must be supplier id --}}
                            <select name="supplier_id"
                                    class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    required>
                                <option value="">-- Select Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ (old('supplier_id', $po->supplier_id) == $supplier->id) ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                PO Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="po_date"
                                   value="{{ old('po_date', \Carbon\Carbon::parse($po->po_date)->format('Y-m-d')) }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                   required>
                        </div>
                    </div>

                    {{-- Items --}}
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

                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden" id="itemsTable">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="border-b px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Item</th>
                                    <th class="border-b px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Qty</th>
                                    <th class="border-b px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Rate</th>
                                    <th class="border-b px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Line Total</th>
                                    <th class="border-b px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($po->items as $i => $row)
                                    @php $line = round(((float)$row->qty) * ((float)$row->rate), 2); @endphp
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
                                            <input type="number" step="0.001" min="0.001"
                                                   name="items[{{ $i }}][qty]"
                                                   value="{{ old("items.$i.qty", $row->qty) }}"
                                                   class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                                   required placeholder="0.000">
                                        </td>

                                        <td class="border-b px-4 py-3">
                                            <input type="number" step="0.01" min="0"
                                                   name="items[{{ $i }}][rate]"
                                                   value="{{ old("items.$i.rate", $row->rate) }}"
                                                   class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                                   required placeholder="0.00">
                                        </td>

                                        <td class="border-b px-4 py-3">
                                            <input type="text"
                                                   class="line_total w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-right"
                                                   value="{{ number_format($line, 2, '.', '') }}"
                                                   readonly>
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

                    {{-- Totals Section (same as create) --}}
                    <div class="mt-6 bg-white border border-gray-200 rounded-lg p-5">
                        <div class="mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-start-2">
                                        <label class="block text-sm font-medium text-gray-700">Total Items Amount</label>
                                        <input id="sub_total" type="text"
                                               class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-right"
                                               readonly value="0.00">
                                    </div>
                                    <div class="md:col-start-2">
                                        <label class="block text-sm font-medium text-gray-700">Delivery Amount</label>
                                        <input id="delivery_amount" name="delivery_amount" type="number" step="0.01" min="0"
                                               class="w-full border-gray-300 rounded-lg px-3 py-2 text-right"
                                               value="{{ old('delivery_amount', $po->delivery_amount ?? 0) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center gap-3">
                                <input id="sscl_enabled" name="sscl_enabled" type="checkbox" value="1"
                                       class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                       {{ old('sscl_enabled', $po->sscl_enabled ?? 0) ? 'checked' : '' }}>
                                <label for="sscl_enabled" class="text-sm font-medium text-gray-700">
                                    Apply SSCL (2.5%)
                                </label>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">SSCL Amount</label>
                                <input id="sscl_amount" type="text"
                                       class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-right"
                                       readonly value="0.00">
                            </div>

                            <div class="flex items-center gap-3">
                                <input id="vat_enabled" name="vat_enabled" type="checkbox" value="1"
                                       class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                       {{ old('vat_enabled', $po->vat_enabled ?? 0) ? 'checked' : '' }}>
                                <label for="vat_enabled" class="text-sm font-medium text-gray-700">
                                    Apply VAT (18%)
                                </label>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">VAT Amount</label>
                                <input id="vat_amount" type="text"
                                       class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-right"
                                       readonly value="0.00">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-800">Net PO Value</label>
                                <input id="grand_total" type="text"
                                       class="w-full border-gray-300 rounded-lg px-3 py-2 bg-indigo-50 font-bold text-lg text-right"
                                       readonly value="0.00">
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
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

            const subTotalEl = document.getElementById('sub_total');
            const deliveryEl = document.getElementById('delivery_amount');
            const ssclEnabledEl = document.getElementById('sscl_enabled');
            const vatEnabledEl = document.getElementById('vat_enabled');
            const ssclAmountEl = document.getElementById('sscl_amount');
            const vatAmountEl = document.getElementById('vat_amount');
            const grandTotalEl = document.getElementById('grand_total');

            function toNum(v) {
                const n = parseFloat(v);
                return isNaN(n) ? 0 : n;
            }

            function calcTotals() {
                let subTotal = 0;

                tableBody.querySelectorAll('tr').forEach(tr => {
                    const qtyEl = tr.querySelector('input[name*="[qty]"]');
                    const rateEl = tr.querySelector('input[name*="[rate]"]');
                    const lineEl = tr.querySelector('.line_total');

                    const qty = toNum(qtyEl?.value);
                    const rate = toNum(rateEl?.value);
                    const line = qty * rate;

                    if (lineEl) lineEl.value = (Math.round(line * 100) / 100).toFixed(2);

                    subTotal += line;
                });

                subTotal = Math.round(subTotal * 100) / 100;

                const delivery = toNum(deliveryEl.value);
                const base = subTotal + delivery;

                const sscl = ssclEnabledEl.checked ? (Math.round(base * 0.025 * 100) / 100) : 0;
                const vatBase = base + sscl;
                const vat = vatEnabledEl.checked ? (Math.round(vatBase * 0.18 * 100) / 100) : 0;

                const grand = Math.round((subTotal + delivery + sscl + vat) * 100) / 100;

                subTotalEl.value = subTotal.toFixed(2);
                ssclAmountEl.value = sscl.toFixed(2);
                vatAmountEl.value = vat.toFixed(2);
                grandTotalEl.value = grand.toFixed(2);
            }

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
                               name="items[${rowIndex}][qty]"
                               class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               required placeholder="0.000">
                    </td>
                    <td class="border-b px-4 py-3">
                        <input type="number" step="0.01" min="0"
                               name="items[${rowIndex}][rate]"
                               class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               required placeholder="0.00">
                    </td>
                    <td class="border-b px-4 py-3">
                        <input type="text"
                               class="line_total w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-right"
                               value="0.00" readonly>
                    </td>
                    <td class="border-b px-4 py-3">
                        <button type="button"
                                class="removeRow inline-flex items-center p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </td>
                `;
                tableBody.appendChild(tr);
                rowIndex++;
                calcTotals();
            });

            document.addEventListener('click', (e) => {
                if (e.target && (e.target.classList.contains('removeRow') || e.target.closest('.removeRow'))) {
                    const rows = tableBody.querySelectorAll('tr');
                    if (rows.length === 1) return;
                    e.target.closest('tr').remove();
                    calcTotals();
                }
            });

            document.addEventListener('input', (e) => {
                if (!e.target) return;

                if (
                    e.target.name?.includes('[qty]') ||
                    e.target.name?.includes('[rate]') ||
                    e.target.id === 'delivery_amount'
                ) {
                    calcTotals();
                }
            });

            ssclEnabledEl.addEventListener('change', calcTotals);
            vatEnabledEl.addEventListener('change', calcTotals);

            // initial calc
            calcTotals();
        });
    </script>
</x-app-layout>
