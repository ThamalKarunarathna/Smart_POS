<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Items</h2>
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
                    <a href="{{ url('/items/create') }}" class="underline">Add Item</a>
                </div>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left p-2 border">Code</th>
                            <th class="text-left p-2 border">Name</th>
                            <th class="text-left p-2 border">Unit</th>
                            <th class="text-left p-2 border">Status</th>
                            <th class="text-left p-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td class="p-2 border">{{ $item->item_code }}</td>
                                <td class="p-2 border">{{ $item->name }}</td>
                                <td class="p-2 border">{{ $item->unit }}</td>
                                <td class="p-2 border">{{ $item->status }}</td>
                                <td class="p-2 border">
                                    <a class="underline mr-3" href="{{ url('/items/'.$item->id.'/edit') }}">Edit</a>
                                    <a class="underline mr-3" href="{{ url('/items/'.$item->id.'/prices') }}">Prices</a>

                                    <form method="POST" action="{{ url('/items/'.$item->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="underline text-red-600" onclick="return confirm('Delete item?')" type="submit">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-2 border" colspan="5">No items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $items->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
