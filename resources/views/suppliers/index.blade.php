<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Suppliers
            </h2>

            <a href="{{ url('/suppliers/create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                + Add Supplier
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
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

            <div>
                <a href="{{ url('/suppliers/create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                + Add Supplier
            </a>
            </div>

            <br>

            <div class="bg-white shadow sm:rounded-lg p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="border px-3 py-2 text-left">Supplier Code</th>
                                <th class="border px-3 py-2 text-left">Name</th>
                                <th class="border px-3 py-2 text-left">Phone</th>
                                <th class="border px-3 py-2 text-left">Contact Person</th>
                                <th class="border px-3 py-2 text-left">Email</th>
                                <th class="border px-3 py-2 text-left">VAT Reg No</th>
                                <th class="border px-3 py-2 text-left">Address</th>
                                <th class="border px-3 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $supplier)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-3 py-2 font-medium">{{ $supplier->supplier_code }}</td>
                                    <td class="border px-3 py-2 font-medium">{{ $supplier->name }}</td>
                                    <td class="border px-3 py-2">{{ $supplier->mobile }}</td>
                                    <td class="border px-3 py-2">{{ $supplier->contact_person ?? '—' }}</td>
                                    <td class="border px-3 py-2">{{ $supplier->email ?? '—' }}</td>
                                    <td class="border px-3 py-2">{{ $supplier->vatreg_no ?? '—' }}</td>
                                    <td class="border px-3 py-2">{{ $supplier->address }}</td>
                                    <td class="border px-3 py-2 whitespace-nowrap">
                                        <a href="{{ url('/suppliers/'.$supplier->id.'/edit') }}"
                                           class="text-blue-700 hover:underline me-3">
                                            Edit
                                        </a>

                                        <form action="{{ url('/suppliers/'.$supplier->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Delete this supplier?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-700 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border px-3 py-6 text-center text-gray-500">
                                        No suppliers found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $suppliers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
