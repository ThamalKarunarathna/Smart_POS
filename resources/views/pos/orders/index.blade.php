<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">POS Orders</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <a href="{{ url('/pos/orders/create') }}"
                       class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700">
                        Place Order
                    </a>
                </div>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left p-2 border">Order No</th>
                            <th class="text-left p-2 border">Customer</th>
                            <th class="text-left p-2 border">Status</th>
                            <th class="text-left p-2 border">Total</th>
                            <th class="text-left p-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                            <tr>
                                <td class="p-2 border">{{ $o->order_no }}</td>
                                <td class="p-2 border">{{ $o->customer?->name ?? 'WALK-IN' }}</td>
                                <td class="p-2 border">
                                    <span class="{{ $o->status === 'cancelled' ? 'text-red-700' : 'text-green-700' }}">
                                        {{ strtoupper($o->status) }}
                                    </span>
                                </td>
                                <td class="p-2 border">{{ number_format($o->grand_total, 2) }}</td>
                                <td class="p-2 border flex gap-2">
                                    <a class="px-3 py-1 bg-gray-700 text-black rounded hover:bg-gray-800"
                                       href="{{ url('/pos/orders/'.$o->id.'/print') }}">
                                        Print
                                    </a>

                                    @if($o->status !== 'cancelled')
                                        <a class="px-3 py-1 bg-yellow-600 text-black rounded hover:bg-yellow-700"
                                           href="{{ url('/pos/orders/'.$o->id.'/edit') }}">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ url('/pos/orders/'.$o->id.'/cancel') }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-black rounded hover:bg-red-700"
                                                onclick="return confirm('Cancel this order?')">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td class="p-2 border" colspan="5">No orders.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
