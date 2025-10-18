<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-800 leading-tight">
            Bảng điều khiển quản trị
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Movies Card -->
                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-bold text-gray-600">Tổng số phim</p>
                            <p class="text-4xl font-black text-blue-600">{{ \App\Models\Movie::count() }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-50">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Users Card -->
                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-bold text-gray-600">Tổng số người dùng</p>
                            <p class="text-4xl font-black text-blue-600">{{ \App\Models\User::count() }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-50">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Ratings Card -->
                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-bold text-gray-600">Tổng số đánh giá</p>
                            <p class="text-4xl font-black text-green-600">{{ \App\Models\Rating::count() }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-green-50">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Comments Card -->
                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-bold text-gray-600">Tổng số bình luận</p>
                            <p class="text-4xl font-black text-green-600">{{ \App\Models\Comment::count() }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-green-50">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Functions -->
            <div class="bg-gray-50 rounded-xl p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Chức năng quản lý</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Movies Management -->
                    <a href="{{ route('admin.movies.index') }}" class="group bg-white p-6 rounded-lg border-2 border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 rounded-lg bg-gray-100 group-hover:bg-blue-50 transition-colors duration-300">
                                <svg class="w-6 h-6 text-gray-600 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Quản lý phim</h3>
                        <p class="text-gray-600 text-sm">Thêm, sửa, xóa phim trong hệ thống</p>
                    </a>
                    
                    <!-- Users Management -->
                    <a href="{{ route('admin.users.index') }}" class="group bg-white p-6 rounded-lg border-2 border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 rounded-lg bg-gray-100 group-hover:bg-blue-50 transition-colors duration-300">
                                <svg class="w-6 h-6 text-gray-600 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Quản lý người dùng</h3>
                        <p class="text-gray-600 text-sm">Quản lý tài khoản và thông tin người dùng</p>
                    </a>

                    <!-- Watchlist Management -->
                    <a href="{{ route('admin.watchlists.index') }}" class="group bg-white p-6 rounded-lg border-2 border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 rounded-lg bg-gray-100 group-hover:bg-blue-50 transition-colors duration-300">
                                <svg class="w-6 h-6 text-gray-600 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Quản lý Watchlist</h3>
                        <p class="text-gray-600 text-sm">Xem và quản lý danh sách phim yêu thích</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])
</x-app-layout>
