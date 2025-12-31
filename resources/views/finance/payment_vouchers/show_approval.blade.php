{{-- resources/views/finance/payment_vouchers/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Payment Voucher</h1>
                <p class="text-sm text-gray-600 mt-1">{{ $voucher->voucher_no }}</p>
            </div>

            <div class="flex items-center gap-2 flex-wrap justify-end">
                <a href="{{ url('/finance/payment_vouchers') }}"
                   class="px-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>

                <a href="{{ url('/finance/payment_vouchers/'.$voucher->id.'/edit') }}"
                   class="px-4 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>

                @if (strtolower($voucher->status ?? '') === 'pending')
                    <form action="{{ route('payment_vouchers.reject', $voucher) }}" method="POST" onsubmit="return confirm('Reject this voucher?');">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2.5 bg-red-50 text-red-700 border border-red-200 rounded-lg font-medium hover:bg-red-100 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject
                        </button>
                    </form>

                    <form action="{{ route('payment_vouchers.approve', $voucher) }}" method="POST" onsubmit="return confirm('Approve this voucher?');">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2.5 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7"/>
                            </svg>
                            Approve
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    @php
        $status = $voucher->status ?? 'Pending';
        $badge = match($status) {
            'Approved' => 'bg-green-50 text-green-700 border-green-200',
            'Rejected' => 'bg-red-50 text-red-700 border-red-200',
            default    => 'bg-yellow-50 text-yellow-700 border-yellow-200',
        };

        // ✅ show Payee + DR Account only for OTHER voucher type
        $isOther = ($voucher->voucher_type === 'OTHER');
    @endphp


{{-- <div>
    <h1>Reject Reason</h1>
</div> --}}

    {{-- <div>
        <div>

            <form action="{{ route('payment_vouchers.reject', $voucher) }}" method="POST" onsubmit="return confirm('Reject this voucher?');">
                @csrf
                <button type="submit"
                        class="px-4 py-2.5 bg-red-50 text-red-700 border border-red-200 rounded-lg font-medium hover:bg-red-100 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Reject
                </button>
            </form>

            <form action="{{ route('payment_vouchers.approve', $voucher) }}" method="POST" onsubmit="return confirm('Approve this voucher?');">
                @csrf
                <button type="submit"
                        class="px-4 py-2.5 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                    Approve
                </button>
            </form>

        </div>
    </div> --}}

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-lg p-8">

                {{-- Top Summary --}}
                <div class="mb-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Voucher Information</h2>
                            <p class="text-sm text-gray-500">View voucher details and items</p>
                        </div>

                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium border {{ $badge }}">
                            {{ $status }}
                        </span>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="p-4 rounded-xl border border-gray-200 bg-gray-50">
                            <div class="text-xs font-semibold text-gray-500 uppercase">Voucher No</div>
                            <div class="mt-1 text-base font-semibold text-gray-900">{{ $voucher->voucher_no }}</div>
                        </div>

                        <div class="p-4 rounded-xl border border-gray-200 bg-gray-50">
                            <div class="text-xs font-semibold text-gray-500 uppercase">Voucher Date</div>
                            <div class="mt-1 text-base font-semibold text-gray-900">{{ $voucher->voucher_date }}</div>
                        </div>

                        <div class="p-4 rounded-xl border border-gray-200 bg-gray-50">
                            <div class="text-xs font-semibold text-gray-500 uppercase">Voucher Type</div>
                            <div class="mt-1 text-base font-semibold text-gray-900">{{ $voucher->voucher_type }}</div>
                        </div>

                        <div class="p-4 rounded-xl border border-gray-200 bg-gray-50">
                            <div class="text-xs font-semibold text-gray-500 uppercase">Total Value</div>
                            <div class="mt-1 text-base font-extrabold text-indigo-700">
                                ₹{{ number_format((float)$voucher->total_value, 2) }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment Details --}}
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">Payment Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-2">
                            <div class="text-sm font-medium text-gray-700 mb-2">Payment Type</div>
                            <div class="px-4 py-3 rounded-lg border border-gray-200 bg-white">
                                {{ $voucher->payment_type ?? '-' }}
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <div class="text-sm font-medium text-gray-700 mb-2">CR Account</div>
                            <div class="px-4 py-3 rounded-lg border border-gray-200 bg-white">
                                {{ optional($voucher->crAccount)->account_name ?? $voucher->cr_account_id }}
                            </div>
                        </div>

                        @if(in_array($voucher->voucher_type, ['PO','GRN','BILL']))
                            <div class="md:col-span-4">
                                <div class="text-sm font-medium text-gray-700 mb-2">Supplier</div>
                                <div class="px-4 py-3 rounded-lg border border-gray-200 bg-white">
                                    {{ $supplierName ?? '-' }}
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    (Supplier is detected from the referenced PO/GRN/BILL records.)
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Items --}}
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">Voucher Items</h3>

                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Reference</th>

                                    @if($isOther)
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Payee</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">DR Account</th>
                                    @endif

                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700 uppercase">Amount</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($voucher->items as $it)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $it->ref_type }}</td>

                                        <td class="px-4 py-3 text-gray-700">
                                            @php
                                                $refLabel = $refLabels[$it->ref_type][$it->ref_id] ?? null;
                                            @endphp

                                            @if($it->ref_type === 'OTHER')
                                                -
                                            @else
                                                {{ $refLabel ?? ($it->ref_id ?? '-') }}
                                            @endif
                                        </td>

                                        @if($isOther)
                                            <td class="px-4 py-3 text-gray-700">{{ $it->payee ?? '-' }}</td>
                                            <td class="px-4 py-3 text-gray-700">
                                                {{ optional($it->drAccount)->account_name ?? $it->dr_account_id ?? '-' }}
                                            </td>
                                        @endif

                                        <td class="px-4 py-3 text-right font-semibold text-gray-900">
                                            ₹{{ number_format((float)$it->amount, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $isOther ? 5 : 3 }}" class="px-4 py-10 text-center text-gray-500">
                                            No items found for this voucher.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            @if($voucher->items && $voucher->items->count())
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="{{ $isOther ? 4 : 2 }}" class="px-4 py-3 text-right text-sm font-semibold text-gray-700">
                                            Total
                                        </td>
                                        <td class="px-4 py-3 text-right text-sm font-extrabold text-indigo-700">
                                            ₹{{ number_format((float)$voucher->total_value, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- Description --}}
                <div class="p-6 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl border border-indigo-100">
                    <div class="text-sm font-medium text-gray-700 mb-2">Description</div>
                    <div class="px-4 py-3 rounded-lg border border-gray-200 bg-white">
                        {{ $voucher->description ?? '-' }}
                    </div>
                </div>

                @if (strtolower($voucher->status ?? '') === 'pending')
                <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                    <form action="{{ route('payment_vouchers.reject', $voucher) }}" method="POST" onsubmit="return confirm('Reject this voucher?');">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2.5 bg-red-50 text-red-700 border border-red-200 rounded-lg font-medium hover:bg-red-100 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject
                        </button>
                    </form>

                    <form action="{{ route('payment_vouchers.approve', $voucher) }}" method="POST" onsubmit="return confirm('Approve this voucher?');">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2.5 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7"/>
                            </svg>
                            Approve
                        </button>
                    </form>
                </div>
                @endif


            </div>
        </div>
    </div>
</x-app-layout>
