<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Purchase Order Details
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    PO #{{ $po->po_no }}
                </p>
            </div>
            <div class="mt-2 sm:mt-0 flex gap-2">
                <a href="{{ route('po.index') }}"
                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>

                @if($po->status !== 'approved')
                    <a href="{{ route('po.edit', $po) }}"
                       class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- PO Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-blue-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-blue-100">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-gray-900">PO #{{ $po->po_no }}</h3>
                                <p class="text-sm text-gray-500">Purchase order information and details</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                @if($po->status === 'draft') bg-gray-100 text-gray-800
                                @elseif($po->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($po->status === 'approved') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ strtoupper($po->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- PO Details -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-gray-50 to-blue-50 border border-gray-100 rounded-lg p-5">
                            <div class="flex items-center mb-2">
                                <div class="p-2 rounded-lg bg-blue-100">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</div>
                                    <div class="font-semibold text-gray-900 mt-1">{{ $po->supplier_name ?? '—' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-gray-50 to-blue-50 border border-gray-100 rounded-lg p-5">
                            <div class="flex items-center mb-2">
                                <div class="p-2 rounded-lg bg-blue-100">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">PO Date</div>
                                    <div class="font-semibold text-gray-900 mt-1">
                                        {{ \Carbon\Carbon::parse($po->po_date)->format('F d, Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-gray-50 to-blue-50 border border-gray-100 rounded-lg p-5">
                            <div class="flex items-center mb-2">
                                <div class="p-2 rounded-lg bg-blue-100">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Created</div>
                                    <div class="font-semibold text-gray-900 mt-1">
                                        {{ $po->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Purchase Items</h3>
                            <div class="text-sm text-gray-500">
                                {{ $po->items->count() }} items
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Item Description
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Unit Rate
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($po->items as $row)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-900">{{ $row->item?->name }}</div>
                                                @if($row->item?->item_code)
                                                    <div class="text-sm text-gray-500">{{ $row->item->item_code }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-right font-mono font-medium text-gray-900">
                                                    {{ number_format($row->qty, 3) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-right font-mono font-medium text-gray-900">
                                                    ${{ number_format($row->rate, 2) }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <div class="flex flex-wrap gap-3">
                            @if($po->status === 'draft')
                                <form method="POST" action="{{ route('po.submit', $po) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2.5 bg-yellow-600 text-white font-medium rounded-lg hover:bg-yellow-700 focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Submit for Approval
                                    </button>
                                </form>
                            @endif

                            @if($po->status === 'pending')
                                <form method="POST" action="{{ route('po.approve', $po) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Approve
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('po.reject', $po) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Reject
                                    </button>
                                </form>
                            @endif

                            @if($po->status === 'approved')
                                <a href="{{ route('grn.create', $po) }}"
                                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all shadow-sm hover:shadow">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Create GRN for this PO
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
