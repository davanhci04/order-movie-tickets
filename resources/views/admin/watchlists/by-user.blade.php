<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-blue-800 leading-tight">
                    Quản lý Watchlist
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($users->count() > 0)
                        <div class="grid gap-6">
                            @foreach($users as $user)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <!-- User Avatar -->
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center">
                                                <span class="text-white font-semibold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            </div>
                                            
                                            <!-- User Info -->
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>
                                                <p class="text-gray-600">{{ $user->email }}</p>
                                                <div class="flex items-center space-x-4 mt-1">
                                                    <span class="text-sm text-gray-500">
                                                        Tham gia: {{ $user->created_at->format('d/m/Y') }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                        {{ $user->role === 'admin' ? 'Admin' : 'User' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Watchlist Info & Actions -->
                                        <div class="flex items-center space-x-6">
                                            <!-- Stats -->
                                            <div class="text-center">
                                                <p class="text-3xl font-bold {{ $user->watchlist_count > 0 ? 'text-purple-600' : 'text-gray-400' }}">{{ $user->watchlist_count }}</p>
                                                <p class="text-sm text-gray-600">
                                                    {{ $user->watchlist_count > 0 ? 'phim trong watchlist' : 'chưa có phim nào' }}
                                                </p>
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex flex-col space-y-2">
                                                @if($user->watchlist_count > 0)
                                                    <a href="{{ route('admin.users.watchlist', $user) }}" 
                                                       class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 text-center">
                                                        Xem Watchlist
                                                    </a>
                                                @else
                                                    <button disabled 
                                                            class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg text-sm font-medium cursor-not-allowed">
                                                        Watchlist trống
                                                    </button>
                                                @endif
                                                <a href="{{ route('admin.users.show', $user) }}" 
                                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 text-center">
                                                    Chi tiết User
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($users->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $users->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16">
                            <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có user nào trong hệ thống</h3>
                            <p class="text-gray-600">Hệ thống chưa có người dùng nào được đăng ký.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>