<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create Payment Voucher</h1>
                <p class="text-sm text-gray-600 mt-1">Select voucher type to customize the form</p>
            </div>
            <a href="{{ url('/finance/payment_vouchers') }}"
               class="px-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
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
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <h3 class="text-sm font-semibold text-red-800">Please fix the following errors:</h3>
                    </div>
                    <ul class="mt-2 list-disc pl-10 text-sm text-red-700">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="pvForm" method="POST" action="{{ url('/finance/payment_vouchers') }}" class="bg-white rounded-2xl shadow-lg p-8">
                @csrf

                {{-- ✅ send voucher no to backend --}}
                <input type="hidden" name="voucher_no" value="{{ $voucherNo }}">

                {{-- dynamic hidden items will be injected here --}}
                <div id="itemsHidden"></div>

                <!-- Voucher Header Section -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">Voucher Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Voucher No</label>
                            <div class="relative">
                                <input type="text" value="{{ $voucherNo }}"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-600 font-mono cursor-not-allowed"
                                       readonly>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Voucher Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="voucher_date" value="{{ old('voucher_date', date('Y-m-d')) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                   required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Payment Voucher Type <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="voucher_type" name="voucher_type"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white transition-colors"
                                        required>
                                    <option value="">-- Select Type --</option>
                                    <option value="PO">PO</option>
                                    <option value="GRN">GRN</option>
                                    <option value="BILL">BILL</option>
                                    <option value="OTHER">OTHER</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Content Section -->
                <div id="mainContent" class="mb-8">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-8 text-center border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-600 mb-2">Select Voucher Type</h3>
                        <p class="text-sm text-gray-500">Choose a voucher type above to load the corresponding form</p>
                    </div>
                </div>

                <!-- Total & Description Section -->
                <div class="mb-8 p-6 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl border border-indigo-100">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <input name="description" value="{{ old('description') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                   placeholder="Enter payment description">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total Value</label>
                            <div class="relative">
                                <input id="total_value" name="total_value" value="0.00" readonly
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
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">Payment Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Type</label>
                            <input name="payment_type" value="{{ old('payment_type') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                   placeholder="Cash / Cheque / Bank Transfer">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                CR Account <span class="text-red-500">*</span>
                            </label>
                            <select name="cr_account_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                                    required>
                                <option value="">-- Select CR Account --</option>
                                @foreach($accounts as $a)
                                    <option value="{{ $a->id }}">{{ $a->account_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                    <button type="submit"
                            class="px-8 py-3.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg">
                        Save Payment Voucher
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        const suppliers = @json($suppliers->map(fn($s)=>['id'=>$s->id,'name'=>$s->name]));
        const accounts  = @json($accounts->map(fn($a)=>['id'=>$a->id,'name'=>$a->account_name]));

        const form        = document.getElementById('pvForm');
        const mainContent  = document.getElementById('mainContent');
        const typeSelect   = document.getElementById('voucher_type');
        const totalInput   = document.getElementById('total_value');
        const itemsHidden  = document.getElementById('itemsHidden');

        let selected = [];

        function setTotalFromSelected(){
            const t = selected.reduce((sum,i)=> sum + (parseFloat(i.amount||0) || 0), 0);
            totalInput.value = t.toFixed(2);
        }

        function renderHiddenItems(){
            itemsHidden.innerHTML = '';

            selected.forEach((it, idx)=>{
                // ✅ IMPORTANT: hidden + correct names
                itemsHidden.insertAdjacentHTML('beforeend', `
                    <input type="hidden" name="items[${idx}][ref_type]" value="${it.ref_type}">
                    <input type="hidden" name="items[${idx}][ref_id]" value="${it.ref_id ?? ''}">
                    <input type="hidden" name="items[${idx}][payee]" value="${it.payee ?? ''}">
                    <input type="hidden" name="items[${idx}][dr_account_id]" value="${it.dr_account_id ?? ''}">
                    <input type="hidden" name="items[${idx}][amount]" value="${it.amount}">
                `);
            });
        }

        function supplierOptionsHtml(){
            return `<option value="">-- Select Supplier --</option>` +
                suppliers.map(s=>`<option value="${s.id}">${s.name}</option>`).join('');
        }

        function accountOptionsHtml(){
            return `<option value="">-- Select Account --</option>` +
                accounts.map(a=>`<option value="${a.id}">${a.name}</option>`).join('');
        }

        async function loadPending(type, supplierId){
            const url = new URL("{{ route('payment_vouchers.pending') }}", window.location.origin);
            url.searchParams.set('type', type);
            url.searchParams.set('supplier_id', supplierId);

            const res = await fetch(url.toString());
            const data = await res.json();
            return data.rows || [];
        }

        function buildPendingTable(type){
            const labelNo   = type === 'PO' ? 'PO No' : (type === 'GRN' ? 'GRN No' : 'BILL No');
            const labelDate = type === 'PO' ? 'PO Date' : (type === 'GRN' ? 'GRN Date' : 'BILL Date');
            const labelAmt  = type === 'PO' ? 'PO Amount' : (type === 'GRN' ? 'GRN Amount' : 'BILL Amount');

            return `
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Select ${type} Records</h3>
                        <p class="text-sm text-gray-600">Choose supplier to load pending records</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Supplier <span class="text-red-500">*</span></label>
                        <select id="supplier_id" name="supplier_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                            ${supplierOptionsHtml()}
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
                                <tr>
                                    <td colspan="4" class="px-4 py-10 text-center text-gray-500">
                                        Select a supplier to view pending records
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        }function buildPendingTable(type){
    const labelNo   = type === 'PO' ? 'PO No' : (type === 'GRN' ? 'GRN No' : 'BILL No');
    const labelDate = type === 'PO' ? 'PO Date' : (type === 'GRN' ? 'GRN Date' : 'BILL Date');
    const labelAmt  = type === 'PO' ? 'PO Amount' : (type === 'GRN' ? 'GRN Amount' : 'BILL Amount');

    return `
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Select ${type} Records</h3>
                <p class="text-sm text-gray-600">Choose supplier to load pending records</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Supplier <span class="text-red-500">*</span>
                </label>

                <!-- ✅ FIX: add name="supplier_id" -->
                <select id="supplier_id" name="supplier_id" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                    ${supplierOptionsHtml()}
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
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-gray-500">
                                Select a supplier to view pending records
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    `;
}


        function buildOtherForm(){
            return `
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Manual Payment Entry</h3>
                    <p class="text-sm text-gray-600 mb-6">Enter Payee, DR Account and Amount, then click Apply</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payee *</label>
                            <input id="other_payee" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Payee name">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">DR Account *</label>
                            <select id="other_dr" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white">
                                ${accountOptionsHtml()}
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Amount *</label>
                            <input id="other_amount" type="number" step="0.01" min="0.01" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-right" placeholder="0.00">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" id="applyOther" class="px-6 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Apply
                        </button>
                    </div>
                </div>
            `;
        }

        function showNotification(message, type='info'){
            alert(message); // keep simple (you can plug your toast again)
        }

        async function renderMain(){
            selected = [];
            setTotalFromSelected();
            renderHiddenItems();

            const type = typeSelect.value;
            if(!type){
                mainContent.innerHTML = `
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-8 text-center border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-600 mb-2">Select Voucher Type</h3>
                        <p class="text-sm text-gray-500">Choose a voucher type above to load the corresponding form</p>
                    </div>
                `;
                return;
            }

            if(type === 'OTHER'){
                mainContent.innerHTML = buildOtherForm();

                document.getElementById('applyOther').addEventListener('click', ()=>{
                    const payee = document.getElementById('other_payee').value.trim();
                    const dr    = document.getElementById('other_dr').value;
                    const amtN  = parseFloat(document.getElementById('other_amount').value || "0");

                    if(!payee || !dr || !amtN || amtN <= 0){
                        showNotification('Payee, DR Account and Amount are required.', 'error');
                        return;
                    }

                    selected = [{
                        ref_type:'OTHER',
                        ref_id:null,
                        payee: payee,
                        dr_account_id: dr,
                        amount: amtN.toFixed(2)
                    }];

                    setTotalFromSelected();
                    renderHiddenItems();
                    showNotification('Applied.', 'success');
                });

                return;
            }

            mainContent.innerHTML = buildPendingTable(type);

            const supplierSelect = document.getElementById('supplier_id');
            supplierSelect.addEventListener('change', async ()=>{
                const supplierId = supplierSelect.value;

                // clear old selections for this type
                selected = selected.filter(x => x.ref_type !== type);
                setTotalFromSelected();
                renderHiddenItems();

                const body = document.getElementById('pendingBody');

                if(!supplierId){
                    body.innerHTML = `
                        <tr><td colspan="4" class="px-4 py-10 text-center text-gray-500">Select a supplier to view pending records</td></tr>
                    `;
                    return;
                }

                const rows = await loadPending(type, supplierId);

                body.innerHTML = rows.length ? rows.map(r=>`
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">${r.no ?? ''}</td>
                        <td class="px-4 py-3">${r.date ?? ''}</td>
                        <td class="px-4 py-3 text-right font-semibold">₹${Number(r.amount||0).toFixed(2)}</td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox"
                                class="pickRef"
                                data-type="${type}"
                                data-id="${r.id}"
                                data-amount="${r.amount}">
                        </td>
                    </tr>
                `).join('') : `
                    <tr><td colspan="4" class="px-4 py-10 text-center text-gray-500">No pending ${type} records</td></tr>
                `;
            });
        }

        // checkbox changes
        document.addEventListener('change', (e)=>{
            if(!e.target.classList.contains('pickRef')) return;

            const type = e.target.dataset.type;
            const id   = e.target.dataset.id;
            const amt  = parseFloat(e.target.dataset.amount || "0").toFixed(2);

            if(e.target.checked){
                selected.push({ref_type:type, ref_id:id, amount:amt});
            } else {
                selected = selected.filter(x => !(x.ref_type===type && String(x.ref_id)===String(id)));
            }

            setTotalFromSelected();
            renderHiddenItems();
        });

        // ✅ FINAL IMPORTANT: block submit if no items selected
        form.addEventListener('submit', (e)=>{
            const type = typeSelect.value;

            // always rebuild hidden items right before submit
            renderHiddenItems();

            if(!type){
                e.preventDefault();
                showNotification('Select Voucher Type.', 'error');
                return;
            }

            if(type === 'OTHER'){
                if(selected.length < 1){
                    e.preventDefault();
                    showNotification('For OTHER, click Apply after entering Payee/DR/Amount.', 'error');
                    return;
                }
            } else {
                // PO / GRN / BILL
                if(selected.length < 1){
                    e.preventDefault();
                    showNotification(`Select at least one ${type} record.`, 'error');
                    return;
                }
            }
        });

        typeSelect.addEventListener('change', renderMain);
        renderMain();
    </script>
</x-app-layout>
