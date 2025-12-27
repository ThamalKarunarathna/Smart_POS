<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Journal Entry</h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm font-medium text-gray-600">{{ $entry->journal_no }}</span>
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                        Editing Mode
                    </span>
                </div>
            </div>
            <a href="{{ url('/finance/journal_entries') }}"
               class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Journal Entries
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
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
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
                        <div class="p-3 rounded-xl bg-blue-100 mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Update Journal Voucher</h3>
                            <p class="text-sm text-gray-600">Modify the journal entry details as needed</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ url('/finance/journal_entries/'.$entry->id) }}" class="p-6">
                    @csrf @method('PUT')

                    <!-- Header Information -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <!-- Journal No -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Journal No *
                                </span>
                            </label>
                            <input name="journal_no" value="{{ old('journal_no', $entry->journal_no) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   required>
                            <p class="text-xs text-gray-500">Journal voucher number</p>
                        </div>

                        <!-- Voucher Date -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Voucher Date *
                                </span>
                            </label>
                            <input type="date" name="voucher_date" value="{{ old('voucher_date', $entry->voucher_date) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   required>
                            <p class="text-xs text-gray-500">Date of the journal voucher</p>
                        </div>
                    </div>

                    <!-- Entries Section -->
                    <div class="mb-8 rounded-xl border border-gray-200 p-5 bg-gradient-to-br from-gray-50 to-white">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Journal Entries</h3>
                                <p class="text-sm text-gray-600">Modify debit and credit entries for this journal</p>
                            </div>
                            <button type="button" id="addRowBtn"
                                    class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
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
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <span class="flex items-center text-green-600">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                CR Account
                                            </span>
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <span class="flex items-center text-red-600">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                DR Account
                                            </span>
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Amount</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>

                                <tbody id="linesBody" class="bg-white divide-y divide-gray-200">
                                    @foreach($entry->lines as $i => $l)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3">
                                                <input name="lines[{{ $i }}][description]" value="{{ $l->description }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400"
                                                       placeholder="Enter description">
                                            </td>
                                            <td class="px-4 py-3">
                                                <select name="lines[{{ $i }}][cr_account_id]"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                        required>
                                                    <option value="">-- Select Account --</option>
                                                    @foreach($accounts as $a)
                                                        <option value="{{ $a->id }}" @selected($l->cr_account_id == $a->id)>
                                                            {{ $a->account_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-3">
                                                <select name="lines[{{ $i }}][dr_account_id]"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                        required>
                                                    <option value="">-- Select Account --</option>
                                                    @foreach($accounts as $a)
                                                        <option value="{{ $a->id }}" @selected($l->dr_account_id == $a->id)>
                                                            {{ $a->account_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="relative">
                                                    <input type="number" step="0.01" min="0.01"
                                                           name="lines[{{ $i }}][amount]"
                                                           value="{{ $l->amount }}"
                                                           class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-right placeholder-gray-400 amount"
                                                           required placeholder="0.00">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 font-medium">₹</span>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Total Amount -->
                        <div class="flex justify-end mt-6">
                            <div class="w-64">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Total Amount</label>
                                <div class="relative">
                                    <input id="totalAmount" value="{{ number_format($entry->total_amount, 2) }}" readonly
                                           class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg bg-gray-50 text-right font-bold text-lg">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-medium">₹</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Remark Section -->
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
                            <textarea name="remark"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400 resize-none"
                                      rows="3"
                                      placeholder="Enter any additional remarks or notes about this journal entry">{{ old('remark', $entry->remark) }}</textarea>
                            <p class="text-xs text-gray-500">Optional notes or comments about this journal entry</p>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="pt-6 border-t border-gray-200 flex justify-center">
                        <button type="submit"
                                class="inline-flex items-center px-8 py-3 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all hover:shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Update Journal Entry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const accountsOptionsHtml = @json(
            '<option value="">-- Select Account --</option>' .
            $accounts->map(fn($a)=>'<option value="'.$a->id.'">'.e($a->account_name).'</option>')->implode('')
        );

        let rowIndex = {{ $entry->lines->count() }};

        function recalcTotal(){
            let t = 0;
            document.querySelectorAll('.amount').forEach(i=>{
                const v = parseFloat(i.value || "0");
                t += isNaN(v) ? 0 : v;
            });
            document.getElementById('totalAmount').value = t.toFixed(2);
        }

        document.getElementById('addRowBtn').addEventListener('click', ()=>{
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50 transition-colors';
            tr.innerHTML = `
                <td class="px-4 py-3">
                    <input name="lines[${rowIndex}][description]"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400"
                           placeholder="Enter description">
                </td>
                <td class="px-4 py-3">
                    <select name="lines[${rowIndex}][cr_account_id]"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required>
                        ${accountsOptionsHtml}
                    </select>
                </td>
                <td class="px-4 py-3">
                    <select name="lines[${rowIndex}][dr_account_id]"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required>
                        ${accountsOptionsHtml}
                    </select>
                </td>
                <td class="px-4 py-3">
                    <div class="relative">
                        <input type="number" step="0.01" min="0.01"
                               name="lines[${rowIndex}][amount]"
                               class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-right placeholder-gray-400 amount"
                               required placeholder="0.00">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-medium">₹</span>
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

        document.addEventListener('click', (e)=>{
            if(e.target.classList.contains('removeRowBtn') || e.target.closest('.removeRowBtn')){
                const tbody = document.getElementById('linesBody');
                if(tbody.children.length <= 1) return;
                e.target.closest('tr').remove();
                recalcTotal();
            }
        });

        document.addEventListener('input', (e)=>{
            if(e.target.classList.contains('amount')) recalcTotal();
        });

        recalcTotal();
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
