<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Supplier
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

                <form method="POST" action="{{ url('/suppliers') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Supplier Code *</label>
                            <input type="text"
       value="{{ $nextSupplierCode ?? '' }}"
       class="w-full border rounded px-3 py-2 bg-gray-100"
       readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Phone *</label>
                            <input type="tel" name="mobile" value="{{ old('mobile') }}"
                                   class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Contact Person</label>
                            <input type="text" name="contact_person" value="{{ old('contact_person') }}"
                                   class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">VAT Reg No</label>
                            <input type="number" name="vatreg_no" value="{{ old('vatreg_no') }}"
                                   class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1">Address *</label>
                            <textarea name="address" rows="3"
                                      class="w-full border rounded px-3 py-2" required>{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Save
                        </button>

                        <a href="{{ url('/suppliers') }}"
                           class="px-4 py-2 border rounded hover:bg-gray-50">
                            Back
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
