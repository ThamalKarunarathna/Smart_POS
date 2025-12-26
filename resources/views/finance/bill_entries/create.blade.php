<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create Bill Entry</h1>
                <p class="text-sm text-gray-600 mt-1">Record a new financial transaction with detailed entries</p>
            </div>
            <a href="{{ url('/bill-entries') }}"
               class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Bill Entries
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Message -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl border border-red-200 bg-gradient-to-r from-red-50 to-white shadow-sm animate-fade-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-red-800">Please correct the following errors</h3>
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

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-indigo-100 mr-4">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">New Bill Entry</h3>
                            <p class="text-sm text-gray-600">Complete the form below to create a new bill entry</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ url('finance/bill_entries') }}" class="p-6">
                    @csrf

                    <!-- Header Information -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <!-- Bill Entry No -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Bill Entry No
                                </span>
                            </label>
                            <div class="relative">
                                <input type="text" value="{{ $billEntryNo }}" disabled
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 font-medium focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">Auto</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">Automatically generated entry number</p>
                        </div>

                        <!-- Bill Date -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Bill Date *
                                </span>
                            </label>
                            <input type="date" name="bill_date" value="{{ old('bill_date', date('Y-m-d')) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                   required>
                            <p class="text-xs text-gray-500">Date of the bill entry</p>
                        </div>

                        <!-- Ref No -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    Reference No
                                </span>
                            </label>
                            <input type="text" name="ref_no" value="{{ old('ref_no') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors placeholder-gray-400"
                                   placeholder="Enter reference number">
                            <p class="text-xs text-gray-500">External reference number</p>
                        </div>

                        <!-- Ref Date -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Reference Date
                                </span>
                            </label>
                            <input type="date" name="ref_date" value="{{ old('ref_date') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <p class="text-xs text-gray-500">Date of the reference document</p>
                        </div>
                    </div>

                    <!-- Creditor (Supplier) -->
                    <div class="mb-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Creditor (Supplier) *
                                </span>
                            </label>
                            <select name="creditor_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    required>
                                <option value="">-- Select Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500">Select the supplier/creditor for this entry</p>
                        </div>
                    </div>

                    <!-- Entries Section -->
                    <div class="mb-8 rounded-xl border border-gray-200 p-5 bg-gradient-to-br from-gray-50 to-white">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Debit Entries</h3>
                                <p class="text-sm text-gray-600">Add debit lines for this transaction</p>
                            </div>
                            <button type="button" id="addRowBtn"
                                    class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Add Entry
                            </button>
                        </div>

                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DR Account</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Account Code</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DR Amount</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="linesBody" class="bg-white divide-y divide-gray-200">
                                    <!-- Default row -->
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">
                                            <select name="lines[0][dr_account_id]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors dr-account" required>
                                                <option value="">-- Select Account --</option>
                                                @foreach($accounts as $a)
                                                    <option value="{{ $a->id }}" data-code="{{ $a->account_code }}">
                                                        {{ $a->account_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="relative">
                                                <input type="text" name="lines[0][acc_code]"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 acc-code" readonly>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="text" name="lines[0][description]"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors placeholder-gray-400"
                                                   placeholder="Enter description">
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="relative">
                                                <input type="number" step="0.01" min="0.01"
                                                       name="lines[0][dr_amount]"
                                                       class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors placeholder-gray-400 drAmount"
                                                       required placeholder="0.00">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 font-medium"></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <button type="button"
                                                    class="removeRowBtn inline-flex items-center p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- CR Account -->
                    <div class="mb-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Credit Account *
                                </span>
                            </label>
                            <select name="cr_account_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    required>
                                <option value="">-- Select Account --</option>
                                @foreach($accounts as $a)
                                    <option value="{{ $a->id }}">{{ $a->account_name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500">Select the credit account for this transaction</p>
                        </div>
                    </div>

                    <!-- Remark -->
                    <div class="mb-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                    Remarks
                                </span>
                            </label>
                            <textarea name="remark" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors placeholder-gray-400 resize-none"
                                      placeholder="Enter any additional remarks or notes">{{ old('remark') }}</textarea>
                            <p class="text-xs text-gray-500">Optional notes or comments about this entry</p>
                        </div>
                    </div>

                    <!-- Totals Section -->
                    <div class="mb-8 p-6 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-200">
                        <div class="flex flex-col md:flex-row items-center justify-center gap-8">
                            <div class="text-center">
                                <div class="text-sm text-gray-600 font-medium mb-2">Transaction Summary</div>
                            </div>

                            <div class="text-center">
                                <div class="text-sm font-semibold text-gray-700 mb-2">Total Credit</div>
                                <div class="relative">
                                    <input type="text" id="totalCr" value="0.00" readonly
                                           class="w-48 px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-center font-semibold text-lg">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-medium"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <div class="text-sm font-semibold text-gray-700 mb-2">Total Debit</div>
                                <div class="relative">
                                    <input type="text" id="totalDr" value="0.00" readonly
                                           class="w-48 px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-center font-semibold text-lg">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-medium"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="pt-6 border-t border-gray-200 flex justify-center">
                        <button type="submit"
                                class="inline-flex items-center px-8 py-3 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Save Bill Entry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS for Add Entry + totals -->
    <script>
        const accountsOptionsHtml = @json(
            '<option value="">-- Select Account --</option>' .
            $accounts->map(fn($a)=>'<option value="'.$a->id.'" data-code="'.e($a->account_code).'">'.e($a->account_name).'</option>')->implode('')
        );

        let rowIndex = 1;

        function recalcTotals() {
            let total = 0;
            document.querySelectorAll('.drAmount').forEach(inp => {
                const v = parseFloat(inp.value || "0");
                total += isNaN(v) ? 0 : v;
            });
            document.getElementById('totalDr').value = total.toFixed(2);
            document.getElementById('totalCr').value = total.toFixed(2);
        }

        document.addEventListener('change', function(e) {
            if (!e.target.classList.contains('dr-account')) return;

            const select = e.target;
            const row = select.closest('tr');
            const codeInput = row.querySelector('.acc-code');
            if (!codeInput) return;

            const selectedOption = select.options[select.selectedIndex];
            const code = selectedOption.getAttribute('data-code') || '';
            codeInput.value = code;
        });

        document.getElementById('addRowBtn').addEventListener('click', () => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50 transition-colors';

            tr.innerHTML = `
                <td class="px-4 py-3">
                    <select name="lines[${rowIndex}][dr_account_id]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors dr-account" required>
                        ${accountsOptionsHtml}
                    </select>
                </td>
                <td class="px-4 py-3">
                    <div class="relative">
                        <input type="text" name="lines[${rowIndex}][acc_code]"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 acc-code" readonly>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <input type="text" name="lines[${rowIndex}][description]"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors placeholder-gray-400"
                           placeholder="Enter description">
                </td>
                <td class="px-4 py-3">
                    <div class="relative">
                        <input type="number" step="0.01" min="0.01"
                               name="lines[${rowIndex}][dr_amount]"
                               class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors placeholder-gray-400 drAmount"
                               required placeholder="0.00">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-medium"></span>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <button type="button"
                            class="removeRowBtn inline-flex items-center p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </td>
            `;
            document.getElementById('linesBody').appendChild(tr);
            rowIndex++;
        });

        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('removeRowBtn') || e.target.closest('.removeRowBtn')) {
                const tbody = document.getElementById('linesBody');
                if (tbody.children.length <= 1) return; // keep at least 1 row
                e.target.closest('tr').remove();
                recalcTotals();
            }
        });

        document.addEventListener('input', (e) => {
            if (e.target.classList.contains('drAmount')) recalcTotals();
        });

        recalcTotals();
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
        }

        .placeholder-gray-400::placeholder {
            color: #9CA3AF;
        }

        .resize-none {
            resize: none;
        }

        .bg-gradient-to-r {
            background-size: 200% 100%;
            background-position: 100% 0;
        }

        .bg-gradient-to-r:hover {
            background-position: 0 0;
        }
    </style>
</x-app-layout>
