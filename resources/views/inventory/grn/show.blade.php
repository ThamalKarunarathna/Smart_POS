<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Goods Receipt Note</h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                        GRN: {{ $grn->grn_no }}
                    </span>
                    <span class="text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($grn->grn_date)->format('M d, Y') }}
                    </span>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('grn.index') }}"
                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>

                @if($grn->status !== 'approved')
                    <a href="{{ route('grn.edit', $grn) }}"
                       class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit GRN
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl border border-green-200 bg-gradient-to-r from-green-50 to-white shadow-sm animate-fade-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl border border-red-200 bg-gradient-to-r from-red-50 to-white shadow-sm animate-fade-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Header Card -->
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-indigo-100 mr-4">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">GRN Overview</h2>
                            <p class="text-sm text-gray-600">Complete details of this goods receipt note</p>
                        </div>
                    </div>
                </div>

                <!-- Info Cards Grid -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- PO Card -->
                        <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-5 border border-blue-100 shadow-sm">
                            <div class="flex items-center mb-3">
                                <div class="p-2 rounded-lg bg-blue-100 mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-blue-700">Purchase Order</div>
                                    <div class="text-2xl font-bold text-gray-900 mt-1">{{ $grn->purchaseOrder?->po_no ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Date Card -->
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-3">
                                <div class="p-2 rounded-lg bg-gray-100 mr-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-700">GRN Date</div>
                                    <div class="text-2xl font-bold text-gray-900 mt-1">
                                        {{ \Carbon\Carbon::parse($grn->grn_date)->format('Y-m-d') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Card -->
                        <div class="bg-gradient-to-br from-{{ $grn->status === 'approved' ? 'green' : ($grn->status === 'pending' ? 'yellow' : 'gray') }}-50 to-white rounded-xl p-5 border border-{{ $grn->status === 'approved' ? 'green' : ($grn->status === 'pending' ? 'yellow' : 'gray') }}-100 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-lg bg-{{ $grn->status === 'approved' ? 'green' : ($grn->status === 'pending' ? 'yellow' : 'gray') }}-100 mr-3">
                                        <svg class="w-5 h-5 text-{{ $grn->status === 'approved' ? 'green' : ($grn->status === 'pending' ? 'yellow' : 'gray') }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($grn->status === 'approved')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            @elseif($grn->status === 'pending')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @endif
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-{{ $grn->status === 'approved' ? 'green' : ($grn->status === 'pending' ? 'yellow' : 'gray') }}-700">Status</div>
                                        <div class="text-2xl font-bold text-gray-900 mt-1 capitalize">{{ $grn->status }}</div>
                                    </div>
                                </div>
                                @if($grn->status === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Stock Updated
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Received Items</h3>
                                <p class="text-sm text-gray-600">{{ count($grn->items) }} items received</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                Total Value: ₹{{ number_format($grn->items->sum(fn($item) => $item->qty_received * $item->rate), 2) }}
                            </div>
                        </div>

                        <div class="rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                                    </svg>
                                                    Item Description
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Quantity Received
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Unit Rate
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Total Value
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($grn->items as $row)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                            </svg>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-semibold text-gray-900">{{ $row->item?->name }}</div>
                                                            <div class="text-xs text-gray-500">ID: {{ $row->item_id }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <div class="text-sm font-semibold text-gray-900">{{ number_format($row->qty_received, 3) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <div class="text-sm text-gray-900">₹{{ number_format($row->rate, 2) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <div class="text-sm font-bold text-gray-900">
                                                        ₹{{ number_format($row->qty_received * $row->rate, 2) }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Status Action Buttons -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                @if($grn->status === 'approved')
                                    <div class="inline-flex items-center px-4 py-3 rounded-lg bg-green-50 border border-green-200">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <div class="font-medium text-green-800">GRN Approved</div>
                                            <div class="text-sm text-green-700">Stock has been updated in the ledger</div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-3">
                                @if($grn->status === 'draft')
                                    <form method="POST" action="{{ route('grn.submit', $grn) }}" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                            </svg>
                                            Submit for Approval
                                        </button>
                                    </form>
                                @endif

                                @if($grn->status === 'pending')
                                    <form method="POST" action="{{ route('grn.approve', $grn) }}" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Approve & Update Stock
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('grn.reject', $grn) }}" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                                onclick="return confirm('Are you sure you want to reject this GRN?')">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Reject GRN
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        .bg-gradient-to-r {
            background-size: 200% 100%;
            background-position: 100% 0;
        }

        .bg-gradient-to-r:hover {
            background-position: 0 0;
        }
    </style>
</x-app-layout>
