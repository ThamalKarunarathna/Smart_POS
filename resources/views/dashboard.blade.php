<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                        <!-- Items -->
                        <a href="{{ url('/items') }}"
                           class="block rounded-lg border border-gray-200 p-6 hover:bg-gray-50 transition">
                            <div class="text-lg font-semibold">Items</div>
                            <div class="text-sm text-gray-600 mt-1">Manage items & prices</div>
                        </a>

                        <!-- Customers -->
                        <a href="{{ url('/customers') }}"
                           class="block rounded-lg border border-gray-200 p-6 hover:bg-gray-50 transition">
                            <div class="text-lg font-semibold">Customers</div>
                            <div class="text-sm text-gray-600 mt-1">Register & manage customers</div>
                        </a>

                        <!-- POS -->
                        <a href="{{ url('/pos/orders/create') }}"
                           class="block rounded-lg border border-gray-200 p-6 hover:bg-gray-50 transition">
                            <div class="text-lg font-semibold">POS</div>
                            <div class="text-sm text-gray-600 mt-1">Create orders & print invoice</div>
                        </a>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
