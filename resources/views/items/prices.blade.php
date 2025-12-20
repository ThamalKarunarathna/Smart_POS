<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Prices - {{ $item->name }} ({{ $item->item_code }})
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/items/'.$item->id.'/prices') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block">Selling Price</label>
                        <input name="selling_price" class="border p-2 w-full" required>
                    </div>

                    <div>
                        <label class="block">Cost Price (optional)</label>
                        <input name="cost_price" class="border p-2 w-full">
                    </div>

                    <div>
                        <label class="block">Effective From (optional)</label>
                        <input type="date" name="effective_from" class="border p-2 w-full">
                        <small class="text-gray-500">Leave empty to use today.</small>
                    </div>

                    <button class="px-4 py-2 bg-black text-black rounded" type="submit">
                        Save & Activate Price
                    </button>
                </form>

                <hr class="my-6">

                <h3 class="font-semibold mb-3">Price History</h3>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left p-2 border">Effective From</th>
                            <th class="text-left p-2 border">Selling</th>
                            <th class="text-left p-2 border">Cost</th>
                            <th class="text-left p-2 border">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prices as $p)
                            <tr>
                                <td class="p-2 border">{{ $p->effective_from }}</td>
                                <td class="p-2 border">{{ number_format($p->selling_price, 2) }}</td>
                                <td class="p-2 border">{{ $p->cost_price !== null ? number_format($p->cost_price, 2) : '-' }}</td>
                                <td class="p-2 border">{{ $p->is_active ? 'YES' : 'NO' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-2 border" colspan="4">No prices yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    <a class="underline" href="{{ url('/items') }}">Back to Items</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
