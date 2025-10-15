<nav x-data="{ open: false }" class="bg-white border-b border-blue-200 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('movies.index') }}" class="flex items-center space-x-2">
                        @if(file_exists(public_path('images/logo.png')))
                            <img src="{{ asset('images/logo.png') }}" alt="MoviePortal Logo" class="w-8 h-8 rounded">
                        @else
                            <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center">
                                <span class="text-white font-bold text-lg">🎬</span>
                            </div>
                        @endif
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('movies.index')" :active="request()->routeIs('movies.*')" 
                                class="nav-link-hover {{ request()->routeIs('movies.*') ? 'text-blue-600 border-blue-600' : 'text-blue-800 border-transparent hover:text-blue-600' }} border-b-2">
                        {{ __('Movies') }}
                    </x-nav-link>
                    
                    @auth
                        @if(Auth::user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')"
                                    class="nav-link-hover {{ request()->routeIs('admin.*') ? 'text-blue-600 border-blue-600' : 'text-blue-800 border-transparent hover:text-blue-600' }} border-b-2">
                            {{ __('Admin Panel') }}
                        </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-800 bg-white hover:text-blue-600 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-white border border-blue-200 rounded-md shadow-lg">
                                <x-dropdown-link :href="route('profile.edit')" class="text-blue-800 hover:text-blue-600 hover:bg-blue-50">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')" class="text-blue-800 hover:text-blue-600 hover:bg-blue-50"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-blue-800 hover:text-blue-600 transition duration-200">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-blue-800 hover:text-blue-600 hover:bg-blue-50 focus:outline-none focus:bg-blue-50 focus:text-blue-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-blue-50 border-t border-blue-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('movies.index')" :active="request()->routeIs('movies.*')" 
                                   class="{{ request()->routeIs('movies.*') ? 'text-blue-600 bg-blue-100' : 'text-blue-800 hover:text-blue-600 hover:bg-blue-100' }}">
                {{ __('Movies') }}
            </x-responsive-nav-link>
            
            @auth
                @if(Auth::user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')"
                                           class="{{ request()->routeIs('admin.*') ? 'text-blue-600 bg-blue-100' : 'text-blue-800 hover:text-blue-600 hover:bg-blue-100' }}">
                        {{ __('Admin Panel') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-blue-200">
                <div class="px-4">
                    <div class="font-medium text-base text-blue-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-blue-600">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-blue-800 hover:text-blue-600 hover:bg-blue-100">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')" class="text-blue-800 hover:text-blue-600 hover:bg-blue-100"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-blue-200">
                <div class="px-4 space-y-2">
                    <a href="{{ route('login') }}" class="block text-blue-800 hover:text-blue-600 py-2">Login</a>
                    <a href="{{ route('register') }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md">Register</a>
                </div>
            </div>
        @endauth
    </div>
</nav>
