<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartPOS') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
<div class="min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white border-r border-gray-200">
        <div class="h-16 flex items-center px-4 border-b">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-semibold text-gray-800">
                <x-application-logo class="block h-8 w-auto fill-current text-gray-800" />
                <span>SmartPOS</span>
            </a>
        </div>

        <nav class="p-3 space-y-1 text-sm">
            <a href="{{ route('dashboard') }}"
               class="block px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-50' }}">
                Dashboard
            </a>

            {{-- Admin-only menu --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ url('/pos/orders') }}"
                   class="block px-3 py-2 rounded {{ request()->is('pos/orders*') ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-50' }}">
                    POS
                </a>

                <a href="{{ url('/customers') }}"
                   class="block px-3 py-2 rounded {{ request()->is('customers*') ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-50' }}">
                    Customer
                </a>

                <a href="{{ url('/items') }}"
                   class="block px-3 py-2 rounded {{ request()->is('items*') ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-50' }}">
                    Item
                </a>

                {{-- Inventory dropdown (Alpine) --}}
                <div x-data="{open:false}" class="px-1">
                    <button type="button"
                        @click="open=!open"
                        class="w-full flex items-center justify-between px-2 py-2 rounded hover:bg-gray-50">
                        <span>Inventory</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-cloak class="mt-1 ml-2 space-y-1">
                        <a href="{{ url('/po') }}"
                           class="block px-3 py-2 rounded {{ request()->is('po*') ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-50' }}">
                            PO
                        </a>
                        <a href="{{ url('/grn') }}"
                           class="block px-3 py-2 rounded {{ request()->is('grn*') ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-50' }}">
                            GRN
                        </a>
                    </div>
                </div>

                <a href="{{ url('/reports') }}"
                   class="block px-3 py-2 rounded {{ request()->is('reports*') ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-50' }}">
                    Report
                </a>
            @endif
        </nav>
    </aside>

    {{-- Right side: Topbar + Page --}}
    <div class="flex-1 flex flex-col">

        {{-- Topbar --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-end px-6">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-800">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </header>

        {{-- Content --}}
        <main class="flex-1 p-6">
            {{ $slot ?? '' }}

            {{-- If you are using @extends/@section pages, include this too: --}}
            @yield('content')
        </main>

    </div>
</div>
</body>
</html>
