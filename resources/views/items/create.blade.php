<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Item</h2>
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

                <form method="POST" action="{{ url('/items') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block">Item Code</label>
                        <input name="item_code" class="border p-2 w-full" value="{{ old('item_code') }}" required>
                    </div>

                    <div>
                        <label class="block">Name</label>
                        <input name="name" class="border p-2 w-full" value="{{ old('name') }}" required>
                    </div>

                    <div>
                        <label class="block">Unit</label>
                        <input name="unit" class="border p-2 w-full" value="{{ old('unit') }}">
                    </div>

                    <div>
                        <label class="block">Status</label>
                        <select name="status" class="border p-2 w-full">
                            <option value="active">active</option>
                            <option value="inactive">inactive</option>
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button class="px-4 py-2 bg-black text-black rounded" type="submit">Save</button>
                        <a class="underline" href="{{ url('/items') }}">Back</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
