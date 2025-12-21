<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Overview
            </h2>
            <div class="mt-2 sm:mt-0 text-sm text-gray-500">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Today Order Count -->
                <a href="{{ url('/pos/orders') }}"
                   class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:border-blue-100 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-lg bg-blue-50 group-hover:bg-blue-100 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500">Today</span>
                    </div>
                    <div class="text-3xl font-bold text-gray-800 mb-2">
                        {{ number_format($todayOrderCount) }}
                    </div>
                    <div class="text-gray-600 font-medium">Total Orders</div>
                    <div class="mt-4 flex items-center text-sm text-blue-600 font-medium">
                        View orders
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </div>
                </a>

                <!-- Today Sales -->
                <a href="#"
                   class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:border-green-100 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-lg bg-green-50 group-hover:bg-green-100 transition-colors">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500">Today</span>
                    </div>
                    <div class="text-3xl font-bold text-gray-800 mb-2">
                        ${{ number_format($todaySalesTotal, 2) }}
                    </div>
                    <div class="text-gray-600 font-medium">Total Sales</div>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Report Coming Soon
                        </span>
                    </div>
                </a>

                <!-- Month Sales -->
                <a href="#"
                   class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:border-purple-100 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-lg bg-purple-50 group-hover:bg-purple-100 transition-colors">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500">{{ now()->format('F') }}</span>
                    </div>
                    <div class="text-3xl font-bold text-gray-800 mb-2">
                        ${{ number_format($monthSalesTotal, 2) }}
                    </div>
                    <div class="text-gray-600 font-medium">Monthly Sales</div>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Report Coming Soon
                        </span>
                    </div>
                </a>

                <!-- Month Cancelled Count -->
                <a href="{{ url('/pos/orders') }}"
                   class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:border-red-100 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-lg bg-red-50 group-hover:bg-red-100 transition-colors">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500">{{ now()->format('F') }}</span>
                    </div>
                    <div class="text-3xl font-bold text-gray-800 mb-2">
                        {{ number_format($monthCanceledCount) }}
                    </div>
                    <div class="text-gray-600 font-medium">Cancelled Invoices</div>
                    <div class="mt-4 flex items-center text-sm text-red-600 font-medium">
                        View cancelled orders
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </div>
                </a>

                <!-- Coming Soon 1 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-dashed">
                    <div class="flex flex-col items-center justify-center h-full text-center py-8">
                        <div class="p-3 rounded-lg bg-gray-100 mb-4">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div class="text-lg font-semibold text-gray-700 mb-2">New Feature</div>
                        <div class="text-gray-500 text-sm">Coming soon</div>
                    </div>
                </div>

                <!-- Coming Soon 2 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-dashed">
                    <div class="flex flex-col items-center justify-center h-full text-center py-8">
                        <div class="p-3 rounded-lg bg-gray-100 mb-4">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div class="text-lg font-semibold text-gray-700 mb-2">New Feature</div>
                        <div class="text-gray-500 text-sm">Coming soon</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions / Additional Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                    <span class="text-sm text-gray-500">Last updated: {{ now()->format('g:i A') }}</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ url('/pos') }}" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-gray-50 hover:border-gray-200 transition-colors">
                        <div class="p-2 rounded-lg bg-blue-50 mr-4">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">New POS Order</span>
                    </a>
                    <a href="{{ url('/pos/orders') }}" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-gray-50 hover:border-gray-200 transition-colors">
                        <div class="p-2 rounded-lg bg-green-50 mr-4">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">View All Orders</span>
                    </a>
                    <a href="#" class="flex items-center p-4 rounded-lg border border-gray-100 hover:bg-gray-50 hover:border-gray-200 transition-colors">
                        <div class="p-2 rounded-lg bg-purple-50 mr-4">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Generate Report</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
