<nav x-data="{ invOpen: false }" class="bg-white border-b border-gray-100">
    <div class="flex min-h-screen">

        <!-- LEFT SIDEBAR -->
        <aside class="w-64 border-r border-gray-200 bg-white">
            <!-- Logo -->
            <div class="h-16 flex items-center px-6 border-b border-gray-200">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    <span class="font-semibold text-gray-800">SmartPOS</span>
                </a>
            </div>

            <!-- Menu -->
            <div class="p-4 space-y-1">

                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-100 font-semibold' : '' }}">
                    Dashboard
                </a>

                {{-- ADMIN MENU ONLY (optional) --}}
                @if(auth()->check() && auth()->user()->role === 'admin')

                    <a href="{{ url('/pos/orders') }}"
                       class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->is('pos/orders*') ? 'bg-gray-100 font-semibold' : '' }}">
                        POS
                    </a>

                    <a href="{{ url('/customers') }}"
                       class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->is('customers*') ? 'bg-gray-100 font-semibold' : '' }}">
                        Customer
                    </a>

                    <a href="{{ url('/items') }}"
                       class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->is('items*') ? 'bg-gray-100 font-semibold' : '' }}">
                        Item
                    </a>

                    <!-- Inventory (dropdown) -->
                    <button type="button"
                            @click="invOpen = !invOpen"
                            class="w-full flex items-center justify-between px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                        <span>Inventory</span>
                        <svg class="w-4 h-4 transform transition"
                             :class="invOpen ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="invOpen" class="pl-4 space-y-1">
                        <a href="{{ url('/po') }}"
                           class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 {{ request()->is('po*') ? 'bg-gray-100 font-semibold' : '' }}">
                            PO
                        </a>
                        <a href="{{ url('/grn') }}"
                           class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 {{ request()->is('grn*') ? 'bg-gray-100 font-semibold' : '' }}">
                            GRN
                        </a>
                    </div>

                    <a href="{{ url('/reports') }}"
                       class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 {{ request()->is('reports*') ? 'bg-gray-100 font-semibold' : '' }}">
                        Report
                    </a>

                @endif

            </div>
        </aside>

        <!-- RIGHT SIDE (TOP BAR + PAGE CONTENT) -->
        <div class="flex-1">
            <!-- Top bar (user dropdown) -->
            <div class="h-16 flex items-center justify-end px-6 border-b border-gray-200 bg-white">
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Nothing else here. Your app layout will render content below -->
        </div>

    </div>
</nav>
