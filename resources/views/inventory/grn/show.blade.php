<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                GRN: {{ $grn->grn_no }}
            </h2>

            <div class="flex gap-2">
                <a href="{{ route('grn.index') }}" class="px-4 py-2 border rounded hover:bg-gray-50">Back</a>

                @if($grn->status !== 'approved')
                    <a href="{{ route('grn.edit', $grn) }}"
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
                        <div class="text-sm text-gray-500">PO No</div>
                        <div class="font-medium">{{ $grn->purchaseOrder?->po_no }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">GRN Date</div>
                        <div class="font-medium">{{ \Carbon\Carbon::parse($grn->grn_date)->format('Y-m-d') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Status</div>
                        <div class="font-medium">{{ strtoupper($grn->status) }}</div>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="font-semibold mb-2">Items</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border px-3 py-2 text-left">Item</th>
                                    <th class="border px-3 py-2 text-right">Qty Received</th>
                                    <th class="border px-3 py-2 text-right">Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grn->items as $row)
                                    <tr>
                                        <td class="border px-3 py-2">{{ $row->item?->name }}</td>
                                        <td class="border px-3 py-2 text-right">{{ number_format($row->qty_received, 3) }}</td>
                                        <td class="border px-3 py-2 text-right">{{ number_format($row->rate, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-2">
                    @if($grn->status === 'draft')
                        <form method="POST" action="{{ route('grn.submit', $grn) }}">
                            @csrf
                            <button class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                Submit for Approval
                            </button>
                        </form>
                    @endif

                    @if($grn->status === 'pending')
                        <form method="POST" action="{{ route('grn.approve', $grn) }}">
                            @csrf
                            <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Approve (Update Stock)
                            </button>
                        </form>

                        <form method="POST" action="{{ route('grn.reject', $grn) }}">
                            @csrf
                            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Reject
                            </button>
                        </form>
                    @endif

                    @if($grn->status === 'approved')
                        <div class="px-4 py-2 rounded bg-green-50 text-green-800">
                            Approved ✅ Stock updated in ledger
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
