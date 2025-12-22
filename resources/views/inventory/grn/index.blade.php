<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            GRN List
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="border px-3 py-2 text-left">GRN No</th>
                                <th class="border px-3 py-2 text-left">PO No</th>
                                <th class="border px-3 py-2 text-left">GRN Date</th>
                                <th class="border px-3 py-2 text-left">Status</th>
                                <th class="border px-3 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grns as $grn)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-3 py-2 font-medium">
                                        <a class="text-indigo-700 hover:underline" href="{{ route('grn.show', $grn) }}">
                                            {{ $grn->grn_no }}
                                        </a>
                                    </td>
                                    <td class="border px-3 py-2">
                                        {{ $grn->purchaseOrder?->po_no ?? '—' }}
                                    </td>
                                    <td class="border px-3 py-2">
                                        {{ \Carbon\Carbon::parse($grn->grn_date)->format('Y-m-d') }}
                                    </td>
                                    <td class="border px-3 py-2">
                                        <span class="px-2 py-1 rounded text-xs
                                            @if($grn->status==='draft') bg-gray-200 text-gray-800
                                            @elseif($grn->status==='pending') bg-yellow-100 text-yellow-800
                                            @elseif($grn->status==='approved') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                            @endif
                                        ">
                                            {{ strtoupper($grn->status) }}
                                        </span>
                                    </td>
                                    <td class="border px-3 py-2 space-x-2">
                                        <a href="{{ route('grn.show', $grn) }}" class="text-indigo-700 hover:underline">View</a>
                                        @if($grn->status !== 'approved')
                                            <a href="{{ route('grn.edit', $grn) }}" class="text-blue-700 hover:underline">Edit</a>

                                            <form action="{{ route('grn.destroy', $grn) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Delete this GRN?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-700 hover:underline">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border px-3 py-6 text-center text-gray-500">
                                        No GRNs found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $grns->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
