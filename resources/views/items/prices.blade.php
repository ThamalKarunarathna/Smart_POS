<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Price Management
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $item->name }} ({{ $item->item_code }})
                </p>
            </div>
            <div class="mt-2 sm:mt-0">
                <a href="{{ url('/items') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Items
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Item Overview Card -->
            <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-5">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 rounded-lg bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $item->name }}</h3>
                            <div class="flex flex-wrap gap-4 mt-1 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    {{ $item->item_code }}
                                </span>
                                @if($item->unit)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    Unit: {{ $item->unit }}
                                </span>
                                @endif
                                @if($item->currentPrice)
                                <span class="flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Current Price: ${{ number_format($item->currentPrice->selling_price, 2) }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ url('/items/'.$item->id.'/edit') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Item
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
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

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 mb-2">Please correct the following errors:</h3>
                            <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Add New Price Form -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Form Header -->
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-green-50">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-green-100">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-gray-900">Set New Price</h3>
                                <p class="text-sm text-gray-500">Add a new price entry for this item</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Content -->
                    <form method="POST" action="{{ url('/items/'.$item->id.'/prices') }}" class="p-6 space-y-6">
                        @csrf

                        <!-- Selling Price -->
                        <div class="space-y-2">
                            <label for="selling_price" class="block text-sm font-medium text-gray-700">
                                Selling Price
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input id="selling_price"
                                       name="selling_price"
                                       type="number"
                                       step="0.01"
                                       min="0"
                                       required
                                       class="pl-10 w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                       placeholder="0.00">
                            </div>
                            <p class="text-xs text-gray-500">Price customers will pay</p>
                        </div>

                        <!-- Cost Price -->
                        <div class="space-y-2">
                            <label for="cost_price" class="block text-sm font-medium text-gray-700">
                                Cost Price (Optional)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input id="cost_price"
                                       name="cost_price"
                                       type="number"
                                       step="0.01"
                                       min="0"
                                       class="pl-10 w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                       placeholder="0.00">
                            </div>
                            <p class="text-xs text-gray-500">Your purchase cost for this item</p>
                        </div>

                        <!-- Effective From -->
                        <div class="space-y-2">
                            <label for="effective_from" class="block text-sm font-medium text-gray-700">
                                Effective From (Optional)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input id="effective_from"
                                       name="effective_from"
                                       type="date"
                                       class="pl-10 w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                            </div>
                            <p class="text-xs text-gray-500">Leave empty to activate immediately</p>
                        </div>

                        <!-- Margin Calculator -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Margin Calculator</h4>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div>
                                    <div class="text-gray-500">Cost</div>
                                    <div id="cost-display" class="font-medium">$0.00</div>
                                </div>
                                <div>
                                    <div class="text-gray-500">Selling</div>
                                    <div id="selling-display" class="font-medium">$0.00</div>
                                </div>
                                <div>
                                    <div class="text-gray-500">Margin</div>
                                    <div id="margin-display" class="font-medium text-green-600">0%</div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:from-green-700 hover:to-green-800 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all shadow-sm hover:shadow">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save & Activate Price
                        </button>
                    </form>
                </div>

                <!-- Price History -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-blue-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg bg-blue-100">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-semibold text-gray-900">Price History</h3>
                                    <p class="text-sm text-gray-500">Past and current price entries</p>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $prices->count() }} entries</span>
                        </div>
                    </div>

                    <!-- Price Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Effective From
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Selling Price
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Cost Price
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($prices as $p)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ \Carbon\Carbon::parse($p->effective_from)->format('M d, Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($p->effective_from)->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">
                                                ${{ number_format($p->selling_price, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if($p->cost_price)
                                                    ${{ number_format($p->cost_price, 2) }}
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($p->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Historical
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <h4 class="text-lg font-medium text-gray-900 mb-1">No price history</h4>
                                                <p class="text-gray-500">Add your first price to get started</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Stats -->
                    @if($prices->count() > 0)
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <div class="text-xs text-gray-500">Current Price</div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        ${{ number_format($prices->where('is_active', true)->first()->selling_price ?? 0, 2) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Highest Price</div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        ${{ number_format($prices->max('selling_price'), 2) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Lowest Price</div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        ${{ number_format($prices->min('selling_price'), 2) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Avg. Margin</div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        @php
                                            $pricesWithCost = $prices->where('cost_price', '>', 0);
                                            if($pricesWithCost->count() > 0) {
                                                $avgMargin = $pricesWithCost->avg(function($price) {
                                                    return (($price->selling_price - $price->cost_price) / $price->cost_price) * 100;
                                                });
                                                echo round($avgMargin, 1) . '%';
                                            } else {
                                                echo '—';
                                            }
                                        @endphp
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ url('/items/'.$item->id.'/edit') }}"
                   class="bg-white border border-gray-200 rounded-xl p-5 hover:border-blue-300 hover:shadow-md transition-all group">
                    <div class="flex items-center">
                        <div class="p-2 rounded-lg bg-blue-50 group-hover:bg-blue-100 transition-colors">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-900">Edit Item Details</h3>
                            <p class="text-sm text-gray-500">Update item information and specifications</p>
                        </div>
                    </div>
                </a>

                <a href="{{ url('/items/'.$item->id.'/bulk-prices') }}"
                   class="bg-white border border-gray-200 rounded-xl p-5 hover:border-green-300 hover:shadow-md transition-all group">
                    <div class="flex items-center">
                        <div class="p-2 rounded-lg bg-green-50 group-hover:bg-green-100 transition-colors">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-900">Bulk Price Update</h3>
                            <p class="text-sm text-gray-500">Import prices from CSV or Excel</p>
                        </div>
                    </div>
                </a>

                <a href="{{ url('/items') }}"
                   class="bg-white border border-gray-200 rounded-xl p-5 hover:border-purple-300 hover:shadow-md transition-all group">
                    <div class="flex items-center">
                        <div class="p-2 rounded-lg bg-purple-50 group-hover:bg-purple-100 transition-colors">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-900">Back to Items</h3>
                            <p class="text-sm text-gray-500">Return to items management</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    // Margin Calculator
    document.addEventListener('DOMContentLoaded', function() {
        const sellingInput = document.getElementById('selling_price');
        const costInput = document.getElementById('cost_price');
        const costDisplay = document.getElementById('cost-display');
        const sellingDisplay = document.getElementById('selling-display');
        const marginDisplay = document.getElementById('margin-display');

        function calculateMargin() {
            const selling = parseFloat(sellingInput.value) || 0;
            const cost = parseFloat(costInput.value) || 0;

            costDisplay.textContent = '$' + cost.toFixed(2);
            sellingDisplay.textContent = '$' + selling.toFixed(2);

            if (cost > 0 && selling > 0) {
                const margin = ((selling - cost) / cost) * 100;
                marginDisplay.textContent = margin.toFixed(1) + '%';
                marginDisplay.className = margin >= 0 ? 'font-medium text-green-600' : 'font-medium text-red-600';
            } else {
                marginDisplay.textContent = '0%';
                marginDisplay.className = 'font-medium text-gray-600';
            }
        }

        sellingInput.addEventListener('input', calculateMargin);
        costInput.addEventListener('input', calculateMargin);

        // Set default date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('effective_from').value = today;

        // Initial calculation
        calculateMargin();
    });
    </script>
    @endpush
</x-app-layout>
