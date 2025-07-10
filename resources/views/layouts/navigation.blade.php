<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-600 to-blue-800 border-b border-blue-700 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-white bg-opacity-20 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                        </div>
                        <div class="text-white">
                            <div class="font-bold text-lg leading-tight">DN WASSIP</div>
                            <div class="text-xs text-blue-200">Water Supply & Management</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                                class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20 text-white' : '' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')"
                                class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('customers.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
                        {{ __('Customers') }}
                    </x-nav-link>
                    <x-nav-link :href="route('guarantors.index')" :active="request()->routeIs('guarantors.*')"
                                class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('guarantors.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
                        {{ __('Guarantors') }}
                    </x-nav-link>
                    <x-nav-link :href="route('meters.index')" :active="request()->routeIs('meters.*')"
                                class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('meters.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
                        {{ __('Meters') }}
                    </x-nav-link>
                    <x-nav-link :href="route('readings.index')" :active="request()->routeIs('readings.*')"
                                class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('readings.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
                        {{ __('Readings') }}
                    </x-nav-link>
                    <x-nav-link :href="route('bills.index')" :active="request()->routeIs('bills.*')"
                                class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('bills.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
                        {{ __('Bills') }}
                    </x-nav-link>
                    <x-nav-link :href="route('settings.rates.index')" :active="request()->routeIs('settings.rates.*')"
                                class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('settings.rates.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
                        {{ __('Rates') }}
                    </x-nav-link>
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')"
                                class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('users.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
                        {{ __('Users') }}
                    </x-nav-link>
                    <x-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*')"
                                class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('settings.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
                        {{ __('Settings') }}
                    </x-nav-link>
                    <x-nav-link :href="route('activity-logs.index')" :active="request()->routeIs('activity-logs.*')"
                                class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('activity-logs.*') ? 'bg-white bg-opacity-20 text-white' : '' }}">
                        {{ __('Activity Logs') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-white bg-opacity-10 hover:bg-opacity-20 focus:outline-none transition ease-in-out duration-150">
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

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10 focus:outline-none focus:bg-white focus:bg-opacity-10 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-blue-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                   class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')"
                                   class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10">
                {{ __('Customers') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('guarantors.index')" :active="request()->routeIs('guarantors.*')"
                                   class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10">
                {{ __('Guarantors') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('meters.index')" :active="request()->routeIs('meters.*')"
                                   class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10">
                {{ __('Meters') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('readings.index')" :active="request()->routeIs('readings.*')"
                                   class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10">
                {{ __('Readings') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('bills.index')" :active="request()->routeIs('bills.*')"
                                   class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10">
                {{ __('Bills') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('settings.rates.index')" :active="request()->routeIs('settings.rates.*')"
                                   class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10">
                {{ __('Rates') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')"
                                   class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10">
                {{ __('Users') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*')"
                                   class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10">
                {{ __('Settings') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('activity-logs.index')" :active="request()->routeIs('activity-logs.*')"
                                   class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10">
                {{ __('Activity Logs') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-blue-600">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-blue-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')"
                                       class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-white hover:text-blue-200 hover:bg-white hover:bg-opacity-10">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
