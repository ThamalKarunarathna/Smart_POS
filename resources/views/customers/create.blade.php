<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Register Customer</h2>
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

                <form method="POST" action="{{ url('/customers') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block">Customer Code</label>
                        <input name="customer_code" class="border p-2 w-full" value="{{ old('customer_code') }}" required>
                    </div>

                    <div>
                        <label class="block">Name</label>
                        <input name="name" class="border p-2 w-full" value="{{ old('name') }}" required>
                    </div>

                    <div>
                        <label class="block">Phone</label>
                        <input name="phone" class="border p-2 w-full" value="{{ old('phone') }}">
                    </div>

                    <div>
                        <label class="block">Email</label>
                        <input name="email" type="email" class="border p-2 w-full" value="{{ old('email') }}">
                    </div>

                    <div>
                        <label class="block">Address</label>
                        <input name="address" class="border p-2 w-full" value="{{ old('address') }}">
                    </div>

                    <div class="flex gap-3">
                        <button class="px-4 py-2 bg-black text-black rounded" type="submit">Save</button>
                        <a class="underline" href="{{ url('/customers') }}">Back</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
