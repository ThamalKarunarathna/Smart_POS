<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Order {{ $order->order_no }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/pos/orders/'.$order->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium">Customer (optional)</label>
                        <select name="customer_id" class="border p-2 w-full">
                            <option value="">WALK-IN CUSTOMER</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" {{ $order->customer_id == $c->id ? 'selected' : '' }}>
                                    {{ $c->customer_code }} - {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium">Discount</label>
                        <input name="discount" type="number" step="0.01"
                               class="border p-2 w-full" value="{{ $order->discount }}">
                    </div>

                    <div class="border rounded p-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-semibold">Items</h3>
                            <button type="button" onclick="addRow()"
                                    class="px-3 py-1 bg-gray-700 text-white rounded hover:bg-gray-800">
                                + Add Item
                            </button>
                        </div>

                        <div id="rows" class="space-y-2"></div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Update & Print
                        </button>

                        <a href="{{ url('/pos/orders') }}"
                           class="px-4 py-2 bg-gray-600 text-black rounded hover:bg-gray-700">
                            Back
                        </a>
                    </div>
                </form>

                <script>
                    const items = @json($items);
                    const existing = @json($order->items);

                    function addRow(itemId = '', qty = 1) {
                        const idx = document.querySelectorAll('.pos-row').length;

                        let options = `<option value="">-- Select Item --</option>`;
                        items.forEach(i => {
                            const selected = (String(i.id) === String(itemId)) ? 'selected' : '';
                            options += `<option value="${i.id}" ${selected}>${i.item_code ?? ''} ${i.name}</option>`;
                        });

                        const row = document.createElement('div');
                        row.className = "pos-row flex gap-2";
                        row.innerHTML = `
                            <select name="items[${idx}][item_id]" class="border p-2 w-2/3" required>
                                ${options}
                            </select>
                            <input name="items[${idx}][qty]" type="number" step="0.001"
                                   class="border p-2 w-1/3" value="${qty}" required>
                            <button type="button" class="px-3 bg-red-600 text-white rounded"
                                    onclick="this.parentElement.remove()">
                                X
                            </button>
                        `;

                        document.getElementById('rows').appendChild(row);
                    }

                    // load existing rows
                    existing.forEach(r => addRow(r.item_id, r.qty));
                </script>

            </div>
        </div>
    </div>
</x-app-layout>
