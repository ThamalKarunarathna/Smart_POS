<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">GRN Approval Dashboard</h1>
                <p class="text-sm text-gray-600 mt-1">Review and approve pending Goods Receipt Notes</p>
            </div>
            <div class="flex items-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 mr-3">
                    {{ $grns->total() }} Total GRNs
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
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

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Goods Receipt Notes</h3>
                            <p class="text-sm text-gray-600">List of all GRNs requiring approval</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-sm text-gray-500">
                                Showing {{ $grns->firstItem() ?? 0 }}-{{ $grns->lastItem() ?? 0 }} of {{ $grns->total() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GRNs Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        GRN Details
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Purchase Order
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Date
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($grns as $grn)
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <!-- GRN Details Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-indigo-50 rounded-lg flex items-center justify-center group-hover:bg-indigo-100 transition-colors">
                                                <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <a href="{{ route('grn.show', $grn) }}"
                                                   class="text-sm font-semibold text-gray-900 hover:text-indigo-700 transition-colors">
                                                    {{ $grn->grn_no }}
                                                </a>
                                                <div class="text-xs text-gray-500 mt-0.5">
                                                    {{ $grn->items->count() }} items
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- PO Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $grn->purchaseOrder?->po_no ?? '—' }}</div>
                                        @if($grn->purchaseOrder?->supplier_name)
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $grn->purchaseOrder->supplier_name }}</div>
                                        @endif
                                    </td>

                                    <!-- Date Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($grn->grn_date)->format('Y-m-d') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($grn->grn_date)->diffForHumans() }}
                                        </div>
                                    </td>

                                    <!-- Status Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'draft' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                                'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'M5 13l4 4L19 7'],
                                                'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'M6 18L18 6M6 6l12 12']
                                            ];
                                            $status = $statusColors[$grn->status] ?? $statusColors['draft'];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $status['icon'] }}"/>
                                            </svg>
                                            {{ strtoupper($grn->status) }}
                                        </span>
                                    </td>

                                    <!-- Actions Column -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('grn.show', $grn) }}"
                                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="p-4 rounded-full bg-gray-100 mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">No GRNs Found</h3>
                                            <p class="text-sm text-gray-500">There are currently no goods receipt notes to display.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($grns->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Showing {{ $grns->firstItem() }} to {{ $grns->lastItem() }} of {{ $grns->total() }} results
                            </div>
                            <div class="flex space-x-2">
                                {{ $grns->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Stats Cards -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-gray-100 mr-4">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total GRNs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $grns->total() }}</p>
                        </div>
                    </div>
                </div>

                @php
                    $pendingCount = $grns->where('status', 'pending')->count();
                    $approvedCount = $grns->where('status', 'approved')->count();
                    $draftCount = $grns->where('status', 'draft')->count();
                @endphp

                <div class="bg-white rounded-xl p-5 border border-yellow-100 shadow-sm">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-yellow-100 mr-4">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-yellow-600">Pending Approval</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 border border-green-100 shadow-sm">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-green-100 mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-green-600">Approved</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $approvedCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-gray-100 mr-4">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Draft</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $draftCount }}</p>
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

        .group:hover .group-hover\:bg-indigo-100 {
            background-color: rgb(224 231 255);
        }

        .bg-gradient-to-r {
            background-size: 200% 100%;
            background-position: 100% 0;
        }

        .bg-gradient-to-r:hover {
            background-position: 0 0;
        }

        .divide-y > :not([hidden]) ~ :not([hidden]) {
            border-top-width: 1px;
            border-color: rgb(229 231 235);
        }
    </style>
</x-app-layout>
