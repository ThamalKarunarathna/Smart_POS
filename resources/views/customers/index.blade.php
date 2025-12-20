<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Customers</h2>
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
                    <a href="{{ url('/customers/create') }}" class="underline">Register Customer</a>
                </div>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left p-2 border">Code</th>
                            <th class="text-left p-2 border">Name</th>
                            <th class="text-left p-2 border">Phone</th>
                            <th class="text-left p-2 border">Status</th>
                            <th class="text-left p-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $c)
                            <tr>
                                <td class="p-2 border">{{ $c->customer_code }}</td>
                                <td class="p-2 border">{{ $c->name }}</td>
                                <td class="p-2 border">{{ $c->phone }}</td>
                                <td class="p-2 border">
                                    <span class="{{ $c->is_active ? 'text-green-700' : 'text-red-700' }}">
                                        {{ $c->is_active ? 'ACTIVE' : 'INACTIVE' }}
                                    </span>
                                </td>
                                <td class="p-2 border flex gap-3">
                                    <a class="underline" href="{{ url('/customers/'.$c->id.'/edit') }}">Edit</a>

                                    <form method="POST" action="{{ url('/customers/'.$c->id.'/toggle') }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="underline">
                                            {{ $c->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ url('/customers/'.$c->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="underline text-red-600"
                                            onclick="return confirm('Delete customer?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-2 border" colspan="5">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $customers->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
