<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit GRN: {{ $grn->grn_no }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                        <ul class="list-disc ms-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('grn.update', $grn) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">GRN Date</label>
                            <input type="date" name="grn_date"
                                   value="{{ old('grn_date', \Carbon\Carbon::parse($grn->grn_date)->format('Y-m-d')) }}"
                                   class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="text-sm text-gray-600 flex items-end">
                            <div>
                                <div class="font-semibold">PO</div>
                                <div>{{ $grn->purchaseOrder?->po_no }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="font-semibold mb-2">Items</h3>

                        <div class="overflow-x-auto">
                            <table class="min-w-full border">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="border px-3 py-2 text-left">Item</th>
                                        <th class="border px-3 py-2 text-right">Receive Qty</th>
                                        <th class="border px-3 py-2 text-right">Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grn->items as $i => $row)
                                        <tr>
                                            <td class="border px-3 py-2">
                                                {{ $row->item?->name }}
                                                <input type="hidden" name="items[{{ $i }}][item_id]" value="{{ $row->item_id }}">
                                            </td>
                                            <td class="border px-3 py-2 text-right">
                                                <input type="number" step="0.001" min="0.001"
                                                       name="items[{{ $i }}][qty_received]"
                                                       value="{{ old("items.$i.qty_received", $row->qty_received) }}"
                                                       class="w-40 border rounded px-2 py-2 text-right" required>
                                            </td>
                                            <td class="border px-3 py-2 text-right">
                                                <input type="number" step="0.01" min="0"
                                                       name="items[{{ $i }}][rate]"
                                                       value="{{ old("items.$i.rate", $row->rate) }}"
                                                       class="w-40 border rounded px-2 py-2 text-right" required>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Update GRN
                        </button>

                        <a href="{{ route('grn.show', $grn) }}" class="px-4 py-2 border rounded hover:bg-gray-50">
                            Back
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
