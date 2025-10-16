<nav x-data="{ open: false }" class="bg-white border-b border-blue-200 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('movies.index') }}">
                        @if(file_exists(public_path('images/logo.png')))
                            <img src="{{ asset('images/logo.png') }}" alt="MoviePortal Logo" class="w-20 h-20">
                        @else
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center shadow-sm">
                                <span class="text-white font-bold text-xl">🎬</span>
                            </div>
                        @endif
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-lg">
                    <form action="{{ route('movies.index') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Tìm kiếm phim..." 
                                   class="w-full px-4 py-2.5 pl-10 pr-4 text-sm text-blue-900 bg-blue-50 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 placeholder-blue-400">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Navigation Links -->
                <div class="hidden lg:flex items-center space-x-6">
                    <a href="{{ route('movies.index') }}" 
                       class="px-4 py-2 text-lg font-bold tracking-tight rounded-lg transition-all duration-200 {{ request()->routeIs('movies.*') ? 'text-blue-600 bg-blue-100' : 'text-blue-800 hover:text-blue-600 hover:bg-blue-50' }}">
                        {{ __('Phim') }}
                    </a>
                    
                    @auth
                        <a href="{{ route('movies.watchlist') }}"
                           class="px-4 py-2 text-lg font-bold tracking-tight rounded-lg transition-all duration-200 {{ request()->routeIs('movies.watchlist') ? 'text-blue-600 bg-blue-100' : 'text-blue-800 hover:text-blue-600 hover:bg-blue-50' }}">
                            {{ __('Watchlist') }}
                        </a>
                        
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-4 py-2 text-lg font-bold tracking-tight rounded-lg transition-all duration-200 {{ request()->routeIs('admin.*') ? 'text-blue-600 bg-blue-100' : 'text-blue-800 hover:text-blue-600 hover:bg-blue-50' }}">
                                {{ __('Dashboard') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2.5 border border-blue-200 text-sm font-medium rounded-lg text-blue-700 bg-white hover:text-blue-600 hover:bg-blue-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center">
                                        <span class="text-white text-xs font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                                    </div>
                                    <span class="hidden md:block">{{ Auth::user()->name }}</span>
                                </div>

                                <div class="ml-2">
                                    <svg class="fill-current h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-white border border-blue-200 rounded-xl shadow-lg py-2">
                                <x-dropdown-link :href="route('profile.edit')" class="px-4 py-3 text-sm font-medium text-blue-700 hover:text-blue-600 hover:bg-blue-50 transition duration-200">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>{{ __('Hồ sơ') }}</span>
                                    </div>
                                </x-dropdown-link>

                                <hr class="my-2 border-blue-100">

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')" class="px-4 py-3 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 transition duration-200"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        <div class="flex items-center space-x-3">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            <span>{{ __('Đăng xuất') }}</span>
                                        </div>
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2.5 text-sm font-semibold text-blue-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200">
                            Đăng nhập
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-blue-700 hover:text-blue-600 hover:bg-blue-50 focus:outline-none focus:bg-blue-50 focus:text-blue-600 transition duration-200">
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
        <!-- Mobile Search -->
        <div class="px-4 py-3 border-b border-blue-200">
            <form action="{{ route('movies.index') }}" method="GET">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Tìm kiếm phim..." 
                           class="w-full px-4 py-2.5 pl-10 pr-4 text-sm text-blue-900 bg-white border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-blue-400">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </form>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('movies.index')" :active="request()->routeIs('movies.*')" 
                                   class="flex items-center space-x-3 px-4 py-3 text-base font-medium rounded-lg mx-3 transition-all duration-200 {{ request()->routeIs('movies.*') ? 'text-blue-600 bg-blue-100' : 'text-blue-700 hover:text-blue-600 hover:bg-blue-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h3a1 1 0 110 2h-1v13a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 110-2h4z"></path>
                </svg>
                {{ __('Phim') }}
            </x-responsive-nav-link>
            
            @auth
                <x-responsive-nav-link :href="route('movies.watchlist')" :active="request()->routeIs('movies.watchlist')"
                                       class="flex items-center space-x-3 px-4 py-3 text-base font-medium rounded-lg mx-3 transition-all duration-200 {{ request()->routeIs('movies.watchlist') ? 'text-blue-600 bg-blue-100' : 'text-blue-700 hover:text-blue-600 hover:bg-blue-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    {{ __('Phim muốn xem') }}
                </x-responsive-nav-link>
                
                @if(Auth::user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')"
                                           class="flex items-center space-x-3 px-4 py-3 text-base font-medium rounded-lg mx-3 transition-all duration-200 {{ request()->routeIs('admin.*') ? 'text-blue-600 bg-blue-100' : 'text-blue-700 hover:text-blue-600 hover:bg-blue-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-blue-200">
                <div class="px-4 mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                        </div>
                        <div>
                            <div class="font-semibold text-base text-blue-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-blue-600">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" 
                                           class="flex items-center space-x-3 px-4 py-3 text-base font-medium text-blue-700 hover:text-blue-600 hover:bg-blue-100 rounded-lg mx-3 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('Hồ sơ') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')" 
                                               class="flex items-center space-x-3 px-4 py-3 text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg mx-3 transition-all duration-200"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('Đăng xuất') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-blue-200">
                <div class="px-4 space-y-2">
                    <a href="{{ route('login') }}" 
                       class="flex items-center space-x-3 px-4 py-3 text-base font-medium text-blue-700 hover:text-blue-600 hover:bg-blue-100 rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Đăng nhập
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav>
