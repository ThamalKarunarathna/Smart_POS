<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit PO: {{ $po->po_no }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @if ($po->status === 'approved')
                    <div class="mb-4 p-3 rounded bg-yellow-100 text-yellow-800">
                        This PO is approved and locked.
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                        <ul class="list-disc ms-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('po.update', $po) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Supplier Name</label>
                            <input type="text" name="supplier_name"
                                   value="{{ old('supplier_name', $po->supplier_name) }}"
                                   class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">PO Date</label>
                            <input type="date" name="po_date"
                                   value="{{ old('po_date', \Carbon\Carbon::parse($po->po_date)->format('Y-m-d')) }}"
                                   class="w-full border rounded px-3 py-2" required>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold">Items</h3>
                            <button type="button" id="addRow"
                                    class="px-3 py-2 bg-gray-800 text-white rounded hover:bg-gray-900">
                                + Add Row
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full border" id="itemsTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="border px-3 py-2 text-left">Item</th>
                                        <th class="border px-3 py-2 text-left">Qty</th>
                                        <th class="border px-3 py-2 text-left">Rate</th>
                                        <th class="border px-3 py-2 text-left">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($po->items as $i => $row)
                                        <tr>
                                            <td class="border px-3 py-2">
                                                <select name="items[{{ $i }}][item_id]" class="w-full border rounded px-2 py-2" required>
                                                    <option value="">-- Select Item --</option>
                                                    @foreach($items as $it)
                                                        <option value="{{ $it->id }}" @selected($it->id == $row->item_id)>
                                                            {{ $it->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border px-3 py-2">
                                                <input type="number" step="0.001" min="0.001"
                                                       name="items[{{ $i }}][qty]"
                                                       value="{{ $row->qty }}"
                                                       class="w-full border rounded px-2 py-2" required>
                                            </td>
                                            <td class="border px-3 py-2">
                                                <input type="number" step="0.01" min="0"
                                                       name="items[{{ $i }}][rate]"
                                                       value="{{ $row->rate }}"
                                                       class="w-full border rounded px-2 py-2" required>
                                            </td>
                                            <td class="border px-3 py-2">
                                                <button type="button" class="removeRow text-red-700 hover:underline">Remove</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Update PO
                        </button>

                        <a href="{{ route('po.show', $po) }}" class="px-4 py-2 border rounded hover:bg-gray-50">
                            Back
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let rowIndex = {{ $po->items->count() }};

            const addRowBtn = document.getElementById('addRow');
            const tableBody = document.querySelector('#itemsTable tbody');

            addRowBtn.addEventListener('click', () => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="border px-3 py-2">
                        <select name="items[${rowIndex}][item_id]" class="w-full border rounded px-2 py-2" required>
                            <option value="">-- Select Item --</option>
                            @foreach($items as $it)
                                <option value="{{ $it->id }}">{{ $it->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="border px-3 py-2">
                        <input type="number" step="0.001" min="0.001"
                               name="items[${rowIndex}][qty]" class="w-full border rounded px-2 py-2" required>
                    </td>
                    <td class="border px-3 py-2">
                        <input type="number" step="0.01" min="0"
                               name="items[${rowIndex}][rate]" class="w-full border rounded px-2 py-2" required>
                    </td>
                    <td class="border px-3 py-2">
                        <button type="button" class="removeRow text-red-700 hover:underline">Remove</button>
                    </td>
                `;
                tableBody.appendChild(tr);
                rowIndex++;
            });

            document.addEventListener('click', (e) => {
                if (e.target && e.target.classList.contains('removeRow')) {
                    const rows = tableBody.querySelectorAll('tr');
                    if (rows.length === 1) return;
                    e.target.closest('tr').remove();
                }
            });
        });
    </script>
</x-app-layout>
