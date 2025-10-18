<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Chi tiết User: {{ $user->name }}
                    </h2>
                    <p class="text-gray-600 text-sm">ID: {{ $user->id }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.watchlist', $user) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 shadow-lg">
                    Xem Watchlist
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- User Information -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Thông tin cá nhân</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center shadow-lg">
                                    <span class="text-white text-xl font-semibold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $user->role === 'admin' ? 'Admin' : 'User' }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Email</label>
                                    <p class="text-gray-800">{{ $user->email }}</p>
                                </div>

                                @if($user->phone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Số điện thoại</label>
                                    <p class="text-gray-800">{{ $user->phone }}</p>
                                </div>
                                @endif

                                @if($user->birth_date)
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Ngày sinh</label>
                                    <p class="text-gray-800">{{ $user->birth_date->format('d/m/Y') }}</p>
                                </div>
                                @endif

                                @if($user->gender)
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Giới tính</label>
                                    <p class="text-gray-800">
                                        @if($user->gender === 'male') Nam
                                        @elseif($user->gender === 'female') Nữ
                                        @else Khác
                                        @endif
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Ngày tham gia</label>
                                <p class="text-gray-800">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                <p class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-600">Cập nhật lần cuối</label>
                                <p class="text-gray-800">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                <p class="text-sm text-gray-500">{{ $user->updated_at->diffForHumans() }}</p>
                            </div>

                            @if($user->email_verified_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Email đã xác thực</label>
                                <p class="text-green-600">✓ {{ $user->email_verified_at->format('d/m/Y H:i') }}</p>
                            </div>
                            @else
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Email chưa xác thực</label>
                                <p class="text-red-600">✗ Chưa xác thực</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Watchlist Count -->
                <div class="bg-white border border-blue-200 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 opacity-90">Watchlist</p>
                            <p class="text-3xl font-bold text-blue-700">{{ $user->watchlist->count() }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Ratings Count -->
                <div class="bg-white border border-blue-200 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 opacity-90">Đánh giá</p>
                            <p class="text-3xl font-bold text-blue-700">{{ $user->ratings->count() }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Comments Count -->
                <div class="bg-white border border-blue-200 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 opacity-90">Bình luận</p>
                            <p class="text-3xl font-bold text-blue-700">{{ $user->comments->count() }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Average Rating -->
                <div class="bg-white border border-blue-200 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 opacity-90">Điểm TB</p>
                            <p class="text-3xl font-bold text-blue-700">
                                @if($user->ratings->count() > 0)
                                    {{ number_format($user->ratings->avg('score'), 1) }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Hoạt động gần đây</h3>
                    
                    <div class="space-y-4">
                        <!-- Recent Ratings -->
                        @if($user->ratings->count() > 0)
                            <div>
                                <h4 class="font-medium text-gray-700 mb-3">Đánh giá gần đây</h4>
                                <div class="space-y-2">
                                    @foreach($user->ratings->take(5) as $rating)
                                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-100">
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $rating->movie->title }}</p>
                                                <p class="text-sm text-gray-600">{{ $rating->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <span class="text-yellow-500">★</span>
                                                <span class="font-semibold text-gray-800">{{ $rating->score }}/10</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Recent Comments -->
                        @if($user->comments->count() > 0)
                            <div>
                                <h4 class="font-medium text-gray-700 mb-3">Bình luận gần đây</h4>
                                <div class="space-y-2">
                                    @foreach($user->comments->take(5) as $comment)
                                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                                            <div class="flex items-center justify-between mb-2">
                                                <p class="font-medium text-gray-800">{{ $comment->movie->title }}</p>
                                                <p class="text-sm text-gray-600">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                            <p class="text-gray-700">{{ Str::limit($comment->content, 100) }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($user->ratings->count() === 0 && $user->comments->count() === 0)
                        <div class="text-center py-8">
                            <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600">User chưa có hoạt động nào</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])
</x-app-layout>