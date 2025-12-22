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

    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        .menu-item-transition {
            transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
        }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            // Load sidebar state from localStorage
            const savedState = localStorage.getItem('sidebarCollapsed');
            const isCollapsed = savedState === 'true';

            Alpine.store('sidebar', {
                collapsed: isCollapsed,

                toggle() {
                    this.collapsed = !this.collapsed;
                    localStorage.setItem('sidebarCollapsed', this.collapsed);
                },

                get width() {
                    return this.collapsed ? 'w-20' : 'w-64';
                },

                get iconRotation() {
                    return this.collapsed ? 'rotate-180' : '';
                }
            });
        });
    </script>
</head>

<body class="font-sans antialiased bg-gray-50" x-data="{ inventoryOpen: false }">
<div class="min-h-screen flex" x-data x-bind:class="$store.sidebar.collapsed ? 'lg:pl-20' : 'lg:pl-64'">

    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white border-r border-gray-200 shadow-lg sidebar-transition"
           :class="$store.sidebar.width">

        {{-- Logo Area --}}
        <div class="h-16 flex items-center px-4 border-b border-gray-100">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-2 font-semibold text-gray-800 min-w-0">
                <x-application-logo class="block h-8 w-auto fill-current text-gray-800 flex-shrink-0" />
                <span class="whitespace-nowrap transition-all duration-300 overflow-hidden"
                      :class="$store.sidebar.collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
                    SmartPOS
                </span>
            </a>
        </div>

        {{-- Toggle Button --}}
        <button @click="$store.sidebar.toggle()"
                class="absolute -right-3 top-24 bg-white border border-gray-300 rounded-full p-1.5 shadow-sm hover:shadow-md transition-all duration-300 hover:border-gray-400 z-10 hidden lg:block">
            <svg class="w-4 h-4 text-gray-600 transition-transform duration-300"
                 :class="$store.sidebar.iconRotation"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
        </button>

        {{-- Navigation Menu --}}
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-3 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors group"
               :class="request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 font-medium' : ''">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="ml-3 whitespace-nowrap transition-all duration-300 overflow-hidden menu-item-transition"
                      :class="$store.sidebar.collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
                    Dashboard
                </span>
            </a>

            {{-- Admin-only menu --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                {{-- POS --}}
                <a href="{{ url('/pos/orders') }}"
                   class="flex items-center px-3 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors group"
                   :class="request()->is('pos/orders*') ? 'bg-blue-50 text-blue-600 font-medium' : ''">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="ml-3 whitespace-nowrap transition-all duration-300 overflow-hidden menu-item-transition"
                          :class="$store.sidebar.collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
                        POS
                    </span>
                </a>

                {{-- Customer --}}
                <a href="{{ url('/customers') }}"
                   class="flex items-center px-3 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors group"
                   :class="request()->is('customers*') ? 'bg-blue-50 text-blue-600 font-medium' : ''">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 1.195a9.003 9.003 0 00-9-3.714"/>
                    </svg>
                    <span class="ml-3 whitespace-nowrap transition-all duration-300 overflow-hidden menu-item-transition"
                          :class="$store.sidebar.collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
                        Customers
                    </span>
                </a>

                {{-- Item --}}
                <a href="{{ url('/items') }}"
                   class="flex items-center px-3 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors group"
                   :class="request()->is('items*') ? 'bg-blue-50 text-blue-600 font-medium' : ''">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <span class="ml-3 whitespace-nowrap transition-all duration-300 overflow-hidden menu-item-transition"
                          :class="$store.sidebar.collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
                        Items
                    </span>
                </a>

                {{-- Inventory dropdown --}}
                <div>
                    <button type="button"
                            @click="inventoryOpen = !inventoryOpen"
                            class="w-full flex items-center px-3 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors group"
                            :class="request()->is('po*') || request()->is('grn*') ? 'bg-blue-50 text-blue-600 font-medium' : ''">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-all duration-300 overflow-hidden menu-item-transition"
                              :class="$store.sidebar.collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
                            Inventory
                        </span>
                        <svg class="w-4 h-4 ml-auto flex-shrink-0 transform transition"
                             :class="inventoryOpen ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="inventoryOpen" x-collapse
                         class="mt-1 space-y-1 overflow-hidden">
                        <a href="{{ url('/po.index') }}"
                           class="flex items-center pl-11 pr-3 py-2.5 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-colors group"
                           :class="request()->is('po*') ? 'bg-blue-50 text-blue-600 font-medium' : ''">
                            <span class="whitespace-nowrap transition-all duration-300 overflow-hidden menu-item-transition"
                                  :class="$store.sidebar.collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
                                PO
                            </span>
                        </a>
                        <a href="{{ url('/grn.index') }}"
                           class="flex items-center pl-11 pr-3 py-2.5 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-colors group"
                           :class="request()->is('grn*') ? 'bg-blue-50 text-blue-600 font-medium' : ''">
                            <span class="whitespace-nowrap transition-all duration-300 overflow-hidden menu-item-transition"
                                  :class="$store.sidebar.collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
                                GRN
                            </span>
                        </a>
                    </div>
                </div>

                {{-- Report --}}
                <a href="{{ url('/reports') }}"
                   class="flex items-center px-3 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors group"
                   :class="request()->is('reports*') ? 'bg-blue-50 text-blue-600 font-medium' : ''">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="ml-3 whitespace-nowrap transition-all duration-300 overflow-hidden menu-item-transition"
                          :class="$store.sidebar.collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
                        Reports
                    </span>
                </a>
            @endif
        </nav>

        {{-- User Profile Mini Card --}}
        <div class="border-t border-gray-100 p-4">
            <div class="flex items-center">
                <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-medium text-sm flex-shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-3 min-w-0 transition-all duration-300 overflow-hidden"
                     :class="$store.sidebar.collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
                    <p class="text-sm font-medium text-gray-700 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->role }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- Mobile Sidebar Backdrop --}}
    <div x-show="!$store.sidebar.collapsed" @click="$store.sidebar.collapsed = true"
         class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-100"
         x-cloak>
    </div>

    {{-- Main Content Area --}}
    <div class="flex-1 flex flex-col min-h-screen">
        {{-- Topbar --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shadow-sm">
            {{-- Mobile Menu Button --}}
            <button @click="$store.sidebar.collapsed = !$store.sidebar.collapsed"
                    class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Page Title --}}
            <div class="flex-1 ml-4 lg:ml-0">
                <h1 class="text-lg font-semibold text-gray-800">
                    @yield('page-title', 'Dashboard')
                </h1>
                <p class="text-sm text-gray-500 hidden md:block">
                    @yield('page-description', 'Welcome to SmartPOS')
                </p>
            </div>

            {{-- User Dropdown --}}
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none">
                        <div class="h-9 w-9 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-medium">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="text-left hidden md:block">
                            <div class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->role }}</div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>

                    <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                        @csrf
                    </form>

                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="flex items-center text-red-600 hover:text-red-700">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </header>

        {{-- Main Content --}}
        <main class="flex-1 p-6 bg-gray-50">
            {{ $slot }}

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
