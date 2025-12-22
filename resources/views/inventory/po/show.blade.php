<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                PO: {{ $po->po_no }}
            </h2>

            <div class="flex gap-2">
                <a href="{{ route('po.index') }}" class="px-4 py-2 border rounded hover:bg-gray-50">Back</a>

                @if($po->status !== 'approved')
                    <a href="{{ route('po.edit', $po) }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Edit
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Supplier</div>
                        <div class="font-medium">{{ $po->supplier_name ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">PO Date</div>
                        <div class="font-medium">{{ \Carbon\Carbon::parse($po->po_date)->format('Y-m-d') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Status</div>
                        <div class="font-medium">{{ strtoupper($po->status) }}</div>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="font-semibold mb-2">Items</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border px-3 py-2 text-left">Item</th>
                                    <th class="border px-3 py-2 text-right">Qty</th>
                                    <th class="border px-3 py-2 text-right">Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($po->items as $row)
                                    <tr>
                                        <td class="border px-3 py-2">{{ $row->item?->name }}</td>
                                        <td class="border px-3 py-2 text-right">{{ number_format($row->qty, 3) }}</td>
                                        <td class="border px-3 py-2 text-right">{{ number_format($row->rate, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-2">
                    @if($po->status === 'draft')
                        <form method="POST" action="{{ route('po.submit', $po) }}">
                            @csrf
                            <button class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                Submit for Approval
                            </button>
                        </form>
                    @endif

                    @if($po->status === 'pending')
                        <form method="POST" action="{{ route('po.approve', $po) }}">
                            @csrf
                            <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Approve
                            </button>
                        </form>

                        <form method="POST" action="{{ route('po.reject', $po) }}">
                            @csrf
                            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Reject
                            </button>
                        </form>
                    @endif

                    @if($po->status === 'approved')
                        <a href="{{ route('grn.create', $po) }}"
                           class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Create GRN for this PO
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
