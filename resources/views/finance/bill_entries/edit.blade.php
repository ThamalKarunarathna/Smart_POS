<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Bill Entry</h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm font-medium text-gray-600">{{ $entry->bill_entry_no }}</span>
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                        Editing Mode
                    </span>
                </div>
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
                            <h3 class="text-lg font-bold text-gray-900">Update Bill Entry Details</h3>
                            <p class="text-sm text-gray-600">Modify the transaction details as needed</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ url('/finance/bill_entries/'.$entry->id) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Header Information -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <!-- Bill No -->
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
                                <input value="{{ $entry->bill_entry_no }}" disabled
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 font-medium focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">Fixed</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">Entry number cannot be modified</p>
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
                            <input type="date" name="bill_date" value="{{ $entry->bill_date }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
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
                            <input name="ref_no" value="{{ $entry->ref_no }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400"
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
                            <input type="date" name="ref_date" value="{{ $entry->ref_date }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}" @selected($s->id == $entry->creditor_id)>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500">Select the supplier/creditor for this entry</p>
                        </div>
                    </div>

                    <!-- Lines Section -->
                    <div class="mb-8 rounded-xl border border-gray-200 p-5 bg-gradient-to-br from-gray-50 to-white">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Debit Entries</h3>
                            <p class="text-sm text-gray-600">Edit debit lines for this transaction</p>
                        </div>

                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DR Account</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Account Code</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DR Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="linesBody" class="bg-white divide-y divide-gray-200">
                                    @foreach($entry->lines as $i => $line)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3">
                                                <select name="lines[{{ $i }}][dr_account_id]"
                                                        class="dr-account w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                                    @foreach($accounts as $a)
                                                        <option value="{{ $a->id }}"
                                                            data-code="{{ $a->account_code }}"
                                                            @selected($a->id == $line->dr_account_id)>
                                                            {{ $a->account_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="relative">
                                                    <input class="acc-code w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50"
                                                           value="{{ $line->acc_code }}" readonly>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <input name="lines[{{ $i }}][description]" value="{{ $line->description }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400"
                                                       placeholder="Enter description">
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="relative">
                                                    <input name="lines[{{ $i }}][dr_amount]" value="{{ $line->dr_amount }}"
                                                           class="drAmount w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400"
                                                           step="0.01" placeholder="0.00">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 font-medium">₹</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Credit Account -->
                    <div class="mb-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin"round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Credit Account *
                                </span>
                            </label>
                            <select name="cr_account_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @foreach($accounts as $a)
                                    <option value="{{ $a->id }}" @selected($a->id == $entry->cr_account_id)>
                                        {{ $a->account_name }}
                                    </option>
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
                            <textarea name="remark"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-gray-400 resize-none"
                                      placeholder="Enter any additional remarks or notes"
                                      rows="3">{{ $entry->remark }}</textarea>
                            <p class="text-xs text-gray-500">Optional notes or comments about this entry</p>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="pt-6 border-t border-gray-200 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center px-8 py-3 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all hover:shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Update Bill Entry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('change', e => {
            if (!e.target.classList.contains('dr-account')) return;
            const code = e.target.selectedOptions[0].dataset.code || '';
            e.target.closest('tr').querySelector('.acc-code').value = code;
        });
    </script>

    <style>
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

        input[readonly], input[disabled] {
            cursor: not-allowed;
            background-color: #f9fafb;
        }
    </style>
</x-app-layout>
