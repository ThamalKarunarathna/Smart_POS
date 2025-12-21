<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Customer Management
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Manage your customer database and information
                </p>
            </div>
            <div class="mt-2 sm:mt-0">
                <a href="{{ url('/customers/create') }}"
                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-sm hover:shadow">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Register New Customer
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

            <!-- Original Register Button -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <a href="{{ url('/customers/create') }}"
                       class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Register Customer
                    </a>

                    <!-- Optional Search/Filter Area -->
                    <div class="text-sm text-gray-500">
                        {{ $customers->total() }} total customers
                    </div>
                </div>
            </div>

            <!-- Customer Stats -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-4">
                    <div class="text-sm font-medium text-blue-800">Total Customers</div>
                    <div class="mt-1 text-2xl font-bold text-gray-900">{{ $customers->total() }}</div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-100 rounded-xl p-4">
                    <div class="text-sm font-medium text-green-800">Active</div>
                    <div class="mt-1 text-2xl font-bold text-gray-900">
                        {{ $customers->where('is_active', true)->count() }}
                    </div>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-rose-50 border border-red-100 rounded-xl p-4">
                    <div class="text-sm font-medium text-red-800">Inactive</div>
                    <div class="mt-1 text-2xl font-bold text-gray-900">
                        {{ $customers->where('is_active', false)->count() }}
                    </div>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-violet-50 border border-purple-100 rounded-xl p-4">
                    <div class="text-sm font-medium text-purple-800">New Today</div>
                    <div class="mt-1 text-2xl font-bold text-gray-900">
                        {{ $customers->where('created_at', '>=', now()->startOfDay())->count() }}
                    </div>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Customer Code
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Customer Details
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Contact
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($customers as $c)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-mono font-semibold text-gray-900">{{ $c->customer_code }}</div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Added {{ $c->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center">
                                                <span class="font-semibold text-blue-600 text-sm">
                                                    {{ substr($c->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">{{ $c->name }}</div>
                                                @if($c->email)
                                                    <div class="text-sm text-gray-500">{{ $c->email }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-gray-900">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            {{ $c->phone ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($c->is_active)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                ACTIVE
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                INACTIVE
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <!-- Edit Button -->
                                            <a href="{{ url('/customers/'.$c->id.'/edit') }}"
                                               class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:ring-2 focus:ring-offset-1 focus:ring-gray-500 transition-colors text-sm"
                                               title="Edit Customer">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>

                                            <!-- Toggle Active/Inactive -->
                                            <form method="POST" action="{{ url('/customers/'.$c->id.'/toggle') }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 border {{ $c->is_active ? 'border-yellow-300 text-yellow-700 bg-yellow-50 hover:bg-yellow-100' : 'border-green-300 text-green-700 bg-green-50 hover:bg-green-100' }} rounded-lg hover:border-{{ $c->is_active ? 'yellow' : 'green' }}-400 focus:ring-2 focus:ring-offset-1 focus:ring-{{ $c->is_active ? 'yellow' : 'green' }}-500 transition-colors text-sm"
                                                        onclick="return confirm('{{ $c->is_active ? 'Deactivate' : 'Activate' }} this customer?')">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        @if($c->is_active)
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                        @endif
                                                    </svg>
                                                    {{ $c->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>

                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ url('/customers/'.$c->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-lg text-red-700 bg-red-50 hover:bg-red-100 hover:border-red-400 focus:ring-2 focus:ring-offset-1 focus:ring-red-500 transition-colors text-sm"
                                                        onclick="return confirm('Are you sure you want to delete this customer? This action cannot be undone.')">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 1.195a9.003 9.003 0 00-9-3.714"/>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No customers found</h3>
                                            <p class="text-gray-500 mb-4">Start by registering your first customer</p>
                                            <a href="{{ url('/customers/create') }}"
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                                </svg>
                                                Register First Customer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($customers->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                Showing <span class="font-medium">{{ $customers->firstItem() }}</span>
                                to <span class="font-medium">{{ $customers->lastItem() }}</span>
                                of <span class="font-medium">{{ $customers->total() }}</span> customers
                            </div>
                            <div class="flex space-x-2">
                                {{ $customers->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
