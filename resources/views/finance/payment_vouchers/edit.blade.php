<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Payment Voucher</h1>
                <p class="text-sm text-gray-600 mt-1">{{ $voucher->voucher_no }}</p>
            </div>
            <a href="{{ url('/finance/payment_vouchers') }}"
                class="px-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 p-4 border-l-4 border-red-500 bg-red-50 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <h3 class="text-sm font-semibold text-red-800">Please fix the following errors:</h3>
                    </div>
                    <ul class="mt-2 list-disc pl-10 text-sm text-red-700">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/finance/payment_vouchers/' . $voucher->id) }}"
                class="bg-white rounded-2xl shadow-lg p-8">
                @csrf
                @method('PUT')
                <div id="pvItemsContainer"></div>
                <!-- Voucher Header Section -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">Voucher
                        Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Voucher No <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input name="voucher_no" value="{{ old('voucher_no', $voucher->voucher_no) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Voucher Date <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="date" name="voucher_date"
                                    value="{{ old('voucher_date', $voucher->voucher_date) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Payment Voucher Type <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                @php($vt = old('voucher_type', $voucher->voucher_type))
                                <select id="voucher_type" name="voucher_type"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white transition-colors"
                                    required>
                                    <option value="">-- Select Type --</option>
                                    <option value="PO" @selected($vt === 'PO')>PO</option>
                                    <option value="GRN" @selected($vt === 'GRN')>GRN</option>
                                    <option value="BILL" @selected($vt === 'BILL')>BILL</option>
                                    <option value="OTHER" @selected($vt === 'OTHER')>OTHER</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Content Section -->
                <div id="mainContent" class="mb-8">
                    <div
                        class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-8 text-center border border-gray-200">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-600 mb-2">Loading content...</h3>
                        <p class="text-sm text-gray-500">Please wait while we load the form</p>
                    </div>
                </div>

                <!-- Total & Description Section -->
                <div class="mb-8 p-6 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl border border-indigo-100">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <input name="description" value="{{ old('description', $voucher->description) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="Enter payment description">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total Value</label>
                            <div class="relative">
                                <input id="total_value" name="total_value"
                                    value="{{ number_format($voucher->total_value, 2, '.', '') }}" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-right bg-white font-bold text-lg text-indigo-700">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 font-medium">₹</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Details Section -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">Payment Details
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Type</label>
                            <div class="relative">
                                <input name="payment_type" value="{{ old('payment_type', $voucher->payment_type) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    placeholder="Cash / Cheque / Bank Transfer">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                CR Account <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="cr_account_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white transition-colors"
                                    required>
                                    <option value="">-- Select CR Account --</option>
                                    @foreach ($accounts as $a)
                                        <option value="{{ $a->id }}" @selected(old('cr_account_id', $voucher->cr_account_id) == $a->id)
                                            class="py-2">
                                            {{ $a->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                    <button type="submit"
                        class="px-8 py-3.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        Update Payment Voucher
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        const suppliers = @json($suppliers->map(fn($s) => ['id' => $s->id, 'name' => $s->name])->values());
        const accounts = @json($accounts->map(fn($a) => ['id' => $a->id, 'name' => $a->account_name])->values());

        // IMPORTANT: keep selected items after validation error
        let selected = @json(old('items') ? collect(old('items'))->values() : $itemsForJs);

        const initialType = @json(old('voucher_type', $voucher->voucher_type));
        const initialSupplierId = @json(old('supplier_id', $selectedSupplierId));

        const mainContent = document.getElementById('mainContent');
        const typeSelect = document.getElementById('voucher_type');
        const totalInput = document.getElementById('total_value');
        const form = document.querySelector('form');

        // hidden supplier_id to ensure controller receives it
        let supplierHidden = document.querySelector('input[name="supplier_id"]');
        if (!supplierHidden) {
            supplierHidden = document.createElement('input');
            supplierHidden.type = 'hidden';
            supplierHidden.name = 'supplier_id';
            supplierHidden.value = initialSupplierId || '';
            form.appendChild(supplierHidden);
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg transform transition-all duration-300 z-50 ${
                type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' :
                type === 'error' ? 'bg-red-50 border border-red-200 text-red-800' :
                'bg-blue-50 border border-blue-200 text-blue-800'
            }`;
            notification.innerHTML =
                `<div class="flex items-center"><div class="text-sm font-medium">${message}</div></div>`;
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.remove();
            }, 2500);
        }

        function setTotalFromSelected() {
            const t = selected.reduce((sum, i) => sum + (parseFloat(i.amount || 0) || 0), 0);
            totalInput.value = t.toFixed(2);
        }

       function renderHiddenItems(){
    const box = document.getElementById('pvItemsContainer');
    if(!box) return;

    box.innerHTML = ''; // clear

    selected.forEach((it, idx) => {
        const div = document.createElement('div');
        div.style.display = 'none';
        div.innerHTML = `
            <input name="items[${idx}][ref_type]" value="${it.ref_type ?? ''}">
            <input name="items[${idx}][ref_id]" value="${it.ref_id ?? ''}">
            <input name="items[${idx}][payee]" value="${it.payee ?? ''}">
            <input name="items[${idx}][dr_account_id]" value="${it.dr_account_id ?? ''}">
            <input name="items[${idx}][amount]" value="${it.amount ?? ''}">
        `;
        box.appendChild(div);
    });
}


        function supplierOptionsHtml(selectedSupplierId = '') {
            return `<option value="">-- Select Supplier --</option>` +
                suppliers.map(s =>
                    `<option value="${s.id}" ${String(selectedSupplierId)===String(s.id)?'selected':''}>${s.name}</option>`)
                .join('');
        }

        function accountOptionsHtml() {
            return `<option value="">-- Select Account --</option>` +
                accounts.map(a => `<option value="${a.id}">${a.name}</option>`).join('');
        }

        async function loadPending(type, supplierId) {
            const url = new URL("{{ route('payment_vouchers.pending') }}", window.location.origin);
            url.searchParams.set('type', type);
            url.searchParams.set('supplier_id', supplierId);

            selected
                .filter(x => x.ref_type === type && x.ref_id)
                .forEach(x => url.searchParams.append('selected_ids[]', x.ref_id));

            const res = await fetch(url.toString());
            const data = await res.json();
            return data.rows || [];
        }


        function buildPendingTable(type, rows, selectedSupplierId = '') {
            const labelNo = type === 'PO' ? 'PO No' : (type === 'GRN' ? 'GRN No' : 'BILL No');
            const labelDate = type === 'PO' ? 'PO Date' : (type === 'GRN' ? 'GRN Date' : 'BILL Date');
            const labelAmt = type === 'PO' ? 'PO Amount' : (type === 'GRN' ? 'GRN Amount' : 'BILL Amount');

            const selectedIds = new Set(selected.filter(x => x.ref_type === type).map(x => String(x.ref_id)));

            return `
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Supplier <span class="text-red-500">*</span></label>
                        <select id="supplier_id_ui" name="supplier_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            ${supplierOptionsHtml(selectedSupplierId)}
                        </select>
                    </div>

                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">${labelNo}</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">${labelDate}</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700 uppercase">${labelAmt}</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Select</th>
                                </tr>
                            </thead>
                            <tbody id="pendingBody" class="bg-white divide-y divide-gray-200">
                                ${rows.length ? rows.map(r=>`
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3">${r.no ?? ''}</td>
                                            <td class="px-4 py-3">${r.date ?? ''}</td>
                                            <td class="px-4 py-3 text-right">₹${Number(r.amount||0).toFixed(2)}</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox"
                                                    class="pickRef h-5 w-5"
                                                    data-type="${type}"
                                                    data-id="${r.id}"
                                                    data-amount="${r.amount}"
                                                    ${selectedIds.has(String(r.id)) ? 'checked' : ''}>
                                            </td>
                                        </tr>
                                    `).join('') : `
                                        <tr><td colspan="4" class="px-4 py-10 text-center text-gray-500">
                                            ${selectedSupplierId ? 'No pending records' : 'Select supplier to load records'}
                                        </td></tr>
                                    `}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        }

        // ✅ UPDATED OTHER FORM (always posts items[0] + autosync)
        function buildOtherForm() {
            const other = selected.find(x => x.ref_type === 'OTHER') || {
                payee: '',
                dr_account_id: '',
                amount: ''
            };

            return `
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payee *</label>
                            <input id="other_payee" value="${other.payee || ''}"
                                   class="w-full px-4 py-3 border rounded-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">DR Account *</label>
                            <select id="other_dr" class="w-full px-4 py-3 border rounded-lg">
                                ${accountOptionsHtml()}
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Amount *</label>
                            <input id="other_amount" value="${other.amount || ''}" type="number" step="0.01" min="0.01"
                                   class="w-full px-4 py-3 border rounded-lg text-right">
                        </div>
                    </div>

                    <!-- Always post items[0] for OTHER -->
                    <div style="display:none">
                        <input name="items[0][ref_type]" value="OTHER">
                        <input name="items[0][ref_id]" value="">
                        <input id="other_payee_h" name="items[0][payee]" value="${other.payee || ''}">
                        <input id="other_dr_h"    name="items[0][dr_account_id]" value="${other.dr_account_id || ''}">
                        <input id="other_amt_h"   name="items[0][amount]" value="${other.amount || ''}">
                    </div>

                    <div class="mt-5">
                        <button type="button" id="applyOther"
                                class="px-6 py-2.5 bg-purple-600 text-white rounded-lg">
                            Apply
                        </button>
                    </div>
                </div>
            `;
        }

        async function renderMain() {
            const type = typeSelect.value;

            if (!type) {
                mainContent.innerHTML = `<div class="p-8 text-center text-gray-500">Select voucher type</div>`;
                return;
            }

            if (type === 'OTHER') {
                mainContent.innerHTML = buildOtherForm();

                const other = selected.find(x => x.ref_type === 'OTHER');
                if (other?.dr_account_id) document.getElementById('other_dr').value = other.dr_account_id;

                const syncOther = () => {
                    const payee = document.getElementById('other_payee').value.trim();
                    const dr = document.getElementById('other_dr').value;
                    const amtN = parseFloat(document.getElementById('other_amount').value || "0");
                    const amt = (amtN && amtN > 0) ? amtN.toFixed(2) : '';

                    // keep hidden post fields updated
                    document.getElementById('other_payee_h').value = payee;
                    document.getElementById('other_dr_h').value = dr;
                    document.getElementById('other_amt_h').value = amt;

                    // keep selected + totals updated
                    if (payee && dr && amtN > 0) {
                        selected = [{
                            ref_type: 'OTHER',
                            ref_id: null,
                            payee,
                            dr_account_id: dr,
                            amount: amtN.toFixed(2)
                        }];
                        supplierHidden.value = '';
                        setTotalFromSelected();
                        renderHiddenItems();
                    } else {
                        selected = [];
                        setTotalFromSelected();
                        renderHiddenItems();
                    }
                };

                document.getElementById('other_payee').addEventListener('input', syncOther);
                document.getElementById('other_dr').addEventListener('change', syncOther);
                document.getElementById('other_amount').addEventListener('input', syncOther);

                // Apply button still works (just forces sync + message)
                document.getElementById('applyOther').onclick = () => {
                    syncOther();
                    if (selected.length === 0) {
                        showNotification('Payee, DR Account and Amount are required.', 'error');
                        return;
                    }
                    showNotification('Manual payment updated', 'success');
                };

                // initial sync on load
                syncOther();
                return;
            }

            // PO/GRN/BILL
            const supplierId = supplierHidden.value || initialSupplierId || '';

            async function paintPending(type, supplierId, rows) {
                mainContent.innerHTML = buildPendingTable(type, rows, supplierId);

                const supplierUI = document.getElementById('supplier_id_ui');
                supplierUI.value = supplierId || '';

                supplierUI.onchange = async () => {
                    const newSupplier = supplierUI.value || '';
                    supplierHidden.value = newSupplier;

                    // DO NOT clear selected here (edit must keep existing items)
                    const newRows = newSupplier ? await loadPending(type, newSupplier) : [];
                    await paintPending(type, newSupplier, newRows);

                    // keep totals / hidden items
                    setTotalFromSelected();
                    renderHiddenItems();
                };
            }

            // render once
            await paintPending(type, supplierId, []);

            if (supplierId) {
                const rows = await loadPending(type, supplierId);
                await paintPending(type, supplierId, rows);
            }

            setTotalFromSelected();
            renderHiddenItems();
        }

        // checkbox change (single handler)
        document.addEventListener('change', (e) => {
            if (!e.target.classList.contains('pickRef')) return;

            const type = e.target.dataset.type;
            const id = e.target.dataset.id;
            const amt = parseFloat(e.target.dataset.amount || "0").toFixed(2);

            if (e.target.checked) {
                if (!selected.some(x => x.ref_type === type && String(x.ref_id) === String(id))) {
                    selected.push({
                        ref_type: type,
                        ref_id: id,
                        amount: amt
                    });
                }
            } else {
                selected = selected.filter(x => !(x.ref_type === type && String(x.ref_id) === String(id)));
            }

            setTotalFromSelected();
            renderHiddenItems();
        });

        typeSelect.addEventListener('change', () => {
            selected = [];
            supplierHidden.value = '';
            setTotalFromSelected();
            renderHiddenItems();
            renderMain();
        });

        form.addEventListener('submit', function(e){

    const t = typeSelect.value;

    // supplier required for PO/GRN/BILL
    if(['PO','GRN','BILL'].includes(t) && !supplierHidden.value){
        e.preventDefault();
        showNotification('Supplier is required for this voucher type', 'error');
        return;
    }

    // OTHER validation (keep your existing logic)
    if(t === 'OTHER'){
        const payee = document.getElementById('other_payee')?.value?.trim() || '';
        const dr    = document.getElementById('other_dr')?.value || '';
        const amtN  = parseFloat(document.getElementById('other_amount')?.value || "0");

        if(!payee || !dr || !(amtN > 0)){
            e.preventDefault();
            showNotification('Payee, DR Account and Amount are required.', 'error');
            return;
        }
        return; // allow submit (OTHER posts items[0] already)
    }

    // ✅ For PO/GRN/BILL: rebuild selected from checked boxes (source of truth)
    const checked = Array.from(document.querySelectorAll('.pickRef:checked'));

    if(checked.length === 0){
        e.preventDefault();
        showNotification('Please select at least one record.', 'error');
        return;
    }

    selected = checked.map(cb => ({
        ref_type: cb.dataset.type,
        ref_id: cb.dataset.id,
        amount: parseFloat(cb.dataset.amount || "0").toFixed(2),
    }));

    renderHiddenItems();

    // ✅ Extra safety: if still empty, stop submit
    if(document.querySelectorAll('#pvItemsContainer input[name^="items["]').length === 0){
        e.preventDefault();
        showNotification('Items were not generated. Please refresh and try again.', 'error');
        return;
    }
});



        // initial
        // set initial type to old()/voucher value already in select, so just render
        setTotalFromSelected();
        renderHiddenItems();
        renderMain();
    </script>

</x-app-layout>
