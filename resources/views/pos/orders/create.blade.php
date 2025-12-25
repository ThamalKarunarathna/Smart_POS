<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Place New Order
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Create a new point-of-sale transaction
                </p>
            </div>
            <div class="mt-2 sm:mt-0">
                <a href="{{ url('/pos/orders') }}"
                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Orders
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

            <!-- Order Form -->
            <form method="POST" action="{{ url('/pos/orders') }}">
                @csrf

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Form Content -->
                    <div class="p-6 space-y-6">
                        <!-- Customer and Credit Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Selection -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Customer (Optional)
                                </label>
                               <select name="customer_id"
        id="customer_select"
        class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
    <option value="">WALK-IN CUSTOMER</option>
    @foreach($customers as $c)
        <option value="{{ $c->id }}"
                data-vat="{{ $c->vat_applicable }}"
                data-sscl="{{ $c->sscl_applicable }}">
            {{ $c->customer_code }} - {{ $c->name }}
        </option>
    @endforeach
</select>

                            </div>

                            <!-- Credit Checkbox -->
                            <div class="flex items-center pt-7">
                                <input id="credit_enabled" name="credit_enabled" type="checkbox" value="1"
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                       {{ old('credit_enabled') ? 'checked' : '' }}>
                                <label for="credit_enabled" class="ml-2 text-sm font-medium text-gray-700">
                                    Credit
                                </label>
                            </div>
                        </div>

                        <!-- Items Section -->
                        <div class="border border-gray-200 rounded-lg p-5 bg-gray-50">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-base font-semibold text-gray-900">Order Items</h3>
                                <button type="button"
                                        onclick="addRow()"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors text-sm">
                                    Add Item
                                </button>
                            </div>

                            <!-- Table Header -->
                            <div class="grid grid-cols-12 gap-3 mb-2 px-3 text-sm font-medium text-gray-700">
                                <div class="col-span-5">Item</div>
                                <div class="col-span-2">Qty</div>
                                <div class="col-span-2">Rate</div>
                                <div class="col-span-2">Line Total</div>
                                <div class="col-span-1"></div>
                            </div>

                            <!-- Items Container -->
                            <div id="rows" class="space-y-2">
                                <!-- Items will be added here dynamically -->
                            </div>
                        </div>

                        <!-- Totals Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left side - empty or can add notes -->
                            <div></div>

                            <!-- Right side - Calculations -->
                            <div class="space-y-4">
                                <!-- Total Items Amount -->
                                <div class="grid grid-cols-2 gap-3 items-center">
                                    <label class="text-sm font-medium text-gray-700 text-right">Total Items Amount</label>
                                    <input id="sub_total" type="text"
                                           class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-right"
                                           readonly value="0.00">
                                </div>

                                <!-- Delivery Amount -->
                                <div class="grid grid-cols-2 gap-3 items-center">
                                    <label class="text-sm font-medium text-gray-700 text-right">Discount Amount</label>
                                    <input id="discount" name="discount" type="number" step="0.01" min="0"
                                           class="w-full border-gray-300 rounded-lg px-3 py-2 text-right"
                                           value="{{ old('discount', 0) }}"
                                           onchange="calculateTotals()">
                                </div>

                                <!-- SSCL -->
                                <div class="grid grid-cols-2 gap-3 items-center">
                                    <div class="flex items-center justify-end gap-2">
                                        <input id="sscl_enabled" name="sscl_enabled" type="checkbox" value="1"
                                               class="h-4 w-4 text-blue-600 border-gray-300 rounded"
                                               {{ old('sscl_enabled') ? 'checked' : '' }}
                                               onchange="calculateTotals()">
                                        <label for="sscl_enabled" class="text-sm font-medium text-gray-700">
                                            SSCL (2.5%)
                                        </label>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">SSCL Amount</label>
                                        <input id="sscl_amount" type="text" name="sscl_amount"
                                               class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-right"
                                               readonly value="0.00">
                                    </div>
                                </div>

                                <!-- VAT -->
                                <div class="grid grid-cols-2 gap-3 items-center">
                                    <div class="flex items-center justify-end gap-2">
                                        <input id="vat_enabled" name="vat_enabled" type="checkbox" value="1"
                                               class="h-4 w-4 text-blue-600 border-gray-300 rounded"
                                               {{ old('vat_enabled') ? 'checked' : '' }}
                                               onchange="calculateTotals()">
                                        <label for="vat_enabled" class="text-sm font-medium text-gray-700">
                                            VAT (18%)
                                        </label>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">VAT Amount</label>
                                        <input id="vat_amount" type="text" name="vat_amount"
                                               class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-right"
                                               readonly value="0.00">
                                    </div>
                                </div>

                                <!-- Net Total -->
                                <div class="grid grid-cols-2 gap-3 items-center pt-2 border-t border-gray-200">
                                    <label class="text-sm font-semibold text-gray-800 text-right">Net Total</label>
                                    <input id="grand_total" type="text"
                                           class="w-full border-gray-300 rounded-lg px-3 py-2 bg-blue-50 font-bold text-lg text-right"
                                           readonly value="0.00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ url('/pos/orders') }}"
                           class="inline-flex items-center justify-center px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-sm hover:shadow">
                            Save & Print
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Items must include: id, name, item_code (optional), latest_price, available_stock
    const items = @json($items);

    // Lookups
    const itemPrices = {};
    const itemStocks = {};

    items.forEach(i => {
        itemPrices[i.id] = parseFloat(i.latest_price || 0);
        itemStocks[i.id] = parseFloat(i.available_stock || 0);
    });

    function toNum(v) {
        const n = parseFloat(v);
        return isNaN(n) ? 0 : n;
    }

    function handleCustomerTaxFlags() {
    const select = document.getElementById('customer_select');
    if (!select) return;

    const opt = select.options[select.selectedIndex];
    if (!opt || !opt.value) {
        // Walk-in customer → untick both
        document.getElementById('vat_enabled').checked = false;
        document.getElementById('sscl_enabled').checked = false;
        calculateTotals();
        return;
    }

    const vat  = opt.dataset.vat === '1';
    const sscl = opt.dataset.sscl === '1';

    document.getElementById('vat_enabled').checked  = vat;
    document.getElementById('sscl_enabled').checked = sscl;

    calculateTotals();
}


    function addRow(itemId = '', qty = 1) {
        const idx = document.querySelectorAll('.pos-row').length;

        let options = `<option value="">-- Select Item --</option>`;
        items.forEach(i => {
            const selected = (String(i.id) === String(itemId)) ? 'selected' : '';
            const stockVal = parseFloat(i.available_stock || 0);
            const stockTxt = stockVal.toFixed(3);

            // OPTIONAL: disable if no stock
            const disabled = stockVal <= 0 ? 'disabled' : '';

            options += `<option value="${i.id}" ${selected} ${disabled}>
                ${(i.item_code ?? '')} ${i.name} (Stock: ${stockTxt})
            </option>`;
        });

        const row = document.createElement('div');
        row.className = "pos-row grid grid-cols-12 gap-3 items-center p-3 bg-white border border-gray-200 rounded-lg hover:border-blue-300 transition-colors";
        row.innerHTML = `
            <div class="col-span-5">
                <select name="items[${idx}][item_id]"
                        class="item-select w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm"
                        onchange="updateRowPrice(this)"
                        required>
                    ${options}
                </select>
            </div>

            <div class="col-span-2">
                <input name="items[${idx}][qty]"
                       type="number"
                       step="0.001"
                       min="0.001"
                       class="qty-input w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm text-right"
                       value="${qty}"
                       onchange="updateRowTotal(this)"
                       oninput="updateRowTotal(this)"
                       required>
            </div>

            <div class="col-span-2">
                <input type="number"
                       step="0.01"
                       class="rate-input w-full border-gray-300 rounded-lg bg-gray-50 text-sm text-right"
                       readonly
                       value="0.00">
            </div>

            <div class="col-span-2">
                <input type="text"
                       class="line-total w-full border-gray-300 rounded-lg bg-gray-50 text-sm font-medium text-right"
                       readonly
                       value="0.00">
            </div>

            <div class="col-span-1 flex justify-center">
                <button type="button"
                        class="p-1.5 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors"
                        onclick="removeRow(this)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `;

        document.getElementById('rows').appendChild(row);

        // If row was created with a preselected item, set rate + totals immediately
        const sel = row.querySelector('.item-select');
        if (sel && sel.value) updateRowPrice(sel);
        else calculateTotals();
    }

    function updateRowPrice(selectElement) {
        const row = selectElement.closest('.pos-row');
        const itemId = selectElement.value;

        const rateInput = row.querySelector('.rate-input');
        const qtyInput  = row.querySelector('.qty-input');

        // Set rate from item_prices.latest_price
        const price = itemId ? (itemPrices[itemId] || 0) : 0;
        rateInput.value = price.toFixed(2);

        // OPTIONAL: show warning if qty > stock
        validateQtyAgainstStock(row);

        updateRowTotal(qtyInput);
    }

    function updateRowTotal(qtyInput) {
        const row = qtyInput.closest('.pos-row');

        const itemId = row.querySelector('.item-select')?.value;
        const qty  = toNum(qtyInput.value);
        const rate = toNum(row.querySelector('.rate-input')?.value);

        const lineTotal = qty * rate;

        row.querySelector('.line-total').value = (Math.round(lineTotal * 100) / 100).toFixed(2);

        validateQtyAgainstStock(row);
        calculateTotals();
    }

    function validateQtyAgainstStock(row) {
    const itemSelect = row.querySelector('.item-select');
    const qtyInput   = row.querySelector('.qty-input');

    if (!itemSelect || !qtyInput) return;

    const itemId = itemSelect.value;
    if (!itemId) return;

    const stock = itemStocks[itemId] ?? 0;
    const qty   = toNum(qtyInput.value);

    // find or create warning element
    let warning = row.querySelector('.stock-warning');
    if (!warning) {
        warning = document.createElement('p');
        warning.className = 'stock-warning mt-1 text-xs text-red-600';
        qtyInput.parentElement.appendChild(warning);
    }

    const itemName = itemSelect.options[itemSelect.selectedIndex]?.text || 'Item';

    if (qty > stock && stock >= 0) {
        // visual input state
        qtyInput.classList.add(
            'border-red-400',
            'focus:ring-red-500',
            'focus:border-red-500'
        );

        // professional message
        warning.textContent = `Insufficient stock. Available: ${stock.toFixed(3)} units.`;
        warning.classList.remove('hidden');
    } else {
        // clean state
        qtyInput.classList.remove(
            'border-red-400',
            'focus:ring-red-500',
            'focus:border-red-500'
        );

        warning.textContent = '';
        warning.classList.add('hidden');
    }
}


    function removeRow(button) {
        button.closest('.pos-row').remove();
        calculateTotals();
    }

    function calculateTotals() {
        // Subtotal from all line totals
        let subtotal = 0;
        document.querySelectorAll('.line-total').forEach(input => {
            subtotal += toNum(input.value);
        });
        subtotal = Math.round(subtotal * 100) / 100;

        const subTotalEl = document.getElementById('sub_total');
        const deliveryEl = document.getElementById('discount');
        const ssclEnabledEl = document.getElementById('sscl_enabled');
        const vatEnabledEl = document.getElementById('vat_enabled');
        const ssclAmountEl = document.getElementById('sscl_amount');
        const vatAmountEl = document.getElementById('vat_amount');
        const grandTotalEl = document.getElementById('grand_total');

        if (subTotalEl) subTotalEl.value = subtotal.toFixed(2);

        const delivery = deliveryEl ? toNum(deliveryEl.value) : 0;
        const base = subtotal - delivery;

        // SSCL 2.5% of (subtotal + delivery)
        const sscl = (ssclEnabledEl && ssclEnabledEl.checked) ? (Math.round(base * 0.025 * 100) / 100) : 0;
        if (ssclAmountEl) ssclAmountEl.value = sscl.toFixed(2);

        // VAT 18% of (subtotal + delivery + sscl)
        const vatBase = base + sscl;
        const vat = (vatEnabledEl && vatEnabledEl.checked) ? (Math.round(vatBase * 0.18 * 100) / 100) : 0;
        if (vatAmountEl) vatAmountEl.value = vat.toFixed(2);

        const grand = Math.round((subtotal - delivery + sscl + vat) * 100) / 100;
        if (grandTotalEl) grandTotalEl.value = grand.toFixed(2);
    }

    // Hook totals recalculation on delivery / tax toggles
    document.addEventListener('DOMContentLoaded', () => {
        const deliveryEl = document.getElementById('delivery_amount');
        const ssclEnabledEl = document.getElementById('sscl_enabled');
        const vatEnabledEl = document.getElementById('vat_enabled');

        const customerSelect = document.getElementById('customer_select');
if (customerSelect) {
    customerSelect.addEventListener('change', handleCustomerTaxFlags);
}


        if (deliveryEl) {
            deliveryEl.addEventListener('input', calculateTotals);
            deliveryEl.addEventListener('change', calculateTotals);
        }
        if (ssclEnabledEl) ssclEnabledEl.addEventListener('change', calculateTotals);
        if (vatEnabledEl) vatEnabledEl.addEventListener('change', calculateTotals);

        // Start with one row
        addRow();
    });
</script>

</x-app-layout>
