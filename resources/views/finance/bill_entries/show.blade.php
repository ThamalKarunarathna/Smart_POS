<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Bill Entry Details</h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                        {{ $entry->bill_entry_no }}
                    </span>
                    <span class="text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($entry->bill_date)->format('M d, Y') }}
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 no-print">
                <a href="{{ url('/finance/bill_entries') }}"
                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>

                <button onclick="window.print()"
                        class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </button>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-wrap gap-2 no-print">
                <a href="{{ url('/finance/bill_entries') }}"
                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>

                <button onclick="window.print()"
                        class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </button>
            </div>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- 🔽 PRINT AREA START -->
            <div id="printArea">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 print-container">

                    <!-- Company Header for Print -->
                    <div class="mb-8 text-center print-header">
                        <h1 class="text-2xl font-bold text-gray-900 mb-1">BILL ENTRY</h1>
                        <p class="text-sm text-gray-600">SmartPOS Finance System</p>
                        <div class="h-0.5 bg-gradient-to-r from-indigo-500 to-indigo-600 mt-3 mx-auto w-32"></div>
                    </div>

                    <!-- Status Badge -->
                    <div class="mb-6 flex justify-center">
                        @php
                            $statusColors = [
                                'draft' => 'bg-gray-100 text-gray-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'posted' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800'
                            ];
                            $statusClass = $statusColors[strtolower($entry->status)] ?? $statusColors['draft'];
                        @endphp
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $statusClass }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if(strtolower($entry->status) === 'posted')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                @elseif(strtolower($entry->status) === 'pending')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @elseif(strtolower($entry->status) === 'cancelled')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @endif
                            </svg>
                            {{ strtoupper($entry->status) }}
                        </span>
                    </div>

                    <!-- Information Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Bill Information Card -->
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="p-2 rounded-lg bg-blue-100 mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Bill Information</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Bill Entry No:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $entry->bill_entry_no }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Bill Date:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $entry->bill_date }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Reference No:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $entry->ref_no ?? '—' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Reference Date:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $entry->ref_date ?? '—' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information Card -->
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="p-2 rounded-lg bg-green-100 mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Account Information</h3>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-sm text-gray-600 mb-1">Creditor (Supplier)</div>
                                    <div class="text-sm font-medium text-gray-900">{{ optional($entry->creditor)->name ?? '—' }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600 mb-1">Credit Account</div>
                                    <div class="text-sm font-medium text-gray-900">{{ optional($entry->crAccount)->account_name ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Debit Entries Table -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="p-2 rounded-lg bg-red-100 mr-3">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Debit Entries</h3>
                        </div>

                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DR Account</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Account Code</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($entry->lines as $l)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ optional($l->drAccount)->account_name ?? '—' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $l->acc_code }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $l->description ?? '—' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                ₹{{ number_format($l->dr_amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right text-sm font-semibold text-gray-900">
                                            Total Amount
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            ₹{{ number_format($entry->total_dr, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Remark Section -->
                    @if($entry->remark)
                        <div class="mb-8 p-5 bg-gradient-to-r from-blue-50 to-white rounded-xl border border-blue-100">
                            <div class="flex items-center mb-3">
                                <div class="p-2 rounded-lg bg-blue-100 mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Remarks</h3>
                            </div>
                            <p class="text-sm text-gray-700">{{ $entry->remark }}</p>
                        </div>
                    @endif

                    <!-- Signatures for Print -->
                    <div class="mt-10 pt-8 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-8 text-center print-signatures">
                        <div>
                            <div class="h-12 border-b border-gray-300 mb-2"></div>
                            <p class="text-sm font-medium text-gray-700">Prepared By</p>
                            <p class="text-xs text-gray-500">______________________</p>
                        </div>
                        <div>
                            <div class="h-12 border-b border-gray-300 mb-2"></div>
                            <p class="text-sm font-medium text-gray-700">Checked By</p>
                            <p class="text-xs text-gray-500">______________________</p>
                        </div>
                        <div>
                            <div class="h-12 border-b border-gray-300 mb-2"></div>
                            <p class="text-sm font-medium text-gray-700">Approved By</p>
                            <p class="text-xs text-gray-500">______________________</p>
                        </div>
                    </div>

                    <!-- Print Footer -->
                    <div class="mt-10 pt-6 border-t border-gray-200 text-center print-footer">
                        <p class="text-xs text-gray-500">Generated on {{ now()->format('Y-m-d H:i:s') }} • SmartPOS Finance System</p>
                    </div>

                </div>
            </div>
            <!-- 🔼 PRINT AREA END -->

        </div>
    </div>

    <!-- 🖨️ PRINT CSS -->
    <style>
        @media print {
            body * {
                visibility: hidden !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            #printArea, #printArea * {
                visibility: visible !important;
            }

            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: white !important;
                color: black !important;
            }

            .no-print {
                display: none !important;
            }

            .print-container {
                border: none !important;
                box-shadow: none !important;
                padding: 20px !important;
                margin: 0 !important;
            }

            .print-header {
                padding-bottom: 20px !important;
                border-bottom: 2px solid #000 !important;
                margin-bottom: 20px !important;
            }

            .print-header h1 {
                font-size: 24px !important;
                font-weight: bold !important;
                margin-bottom: 5px !important;
            }

            table {
                border-collapse: collapse !important;
                width: 100% !important;
                font-size: 12px !important;
                margin: 15px 0 !important;
            }

            th, td {
                border: 1px solid #333 !important;
                padding: 8px !important;
                text-align: left !important;
            }

            th {
                background-color: #f3f4f6 !important;
                font-weight: bold !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            tfoot td {
                font-weight: bold !important;
                border-top: 2px solid #333 !important;
            }

            .print-signatures {
                page-break-inside: avoid !important;
                margin-top: 40px !important;
            }

            .print-footer {
                font-size: 10px !important;
                color: #666 !important;
                margin-top: 30px !important;
            }

            /* Hide non-essential elements in print */
            .flex, .grid, .rounded-xl, .shadow-sm, .bg-gradient-to-br {
                display: block !important;
                background: white !important;
                border: none !important;
                box-shadow: none !important;
            }

            .p-5, .p-6 {
                padding: 10px !important;
            }

            .mb-8, .mb-6, .mb-4 {
                margin-bottom: 15px !important;
            }

            .mt-10, .mt-8 {
                margin-top: 20px !important;
            }

            /* Ensure proper spacing */
            * {
                color: black !important;
                background-color: white !important;
            }
        }

        @media screen {
            .transition-colors {
                transition-property: background-color, border-color, color, fill, stroke;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 150ms;
            }

            .bg-gradient-to-r {
                background-size: 200% 100%;
                background-position: 100% 0;
            }

            .bg-gradient-to-r:hover {
                background-position: 0 0;
            }
        }
    </style>
</x-app-layout>
