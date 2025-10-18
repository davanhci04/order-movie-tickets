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
                    Quản lý Phim
                </h2>
            </div>
            <a href="{{ route('admin.movies.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Thêm phim mới
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left py-3 px-4 text-gray-700 font-semibold">Poster</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-semibold">Tiêu đề</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-semibold">Năm</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-semibold">Thể loại</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-semibold">Đánh giá</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-semibold">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($movies as $movie)
                                    <tr class="hover:bg-gray-50 transition duration-200">
                                        <td class="py-4 px-4">
                                            @if($movie->poster_url)
                                                <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-12 h-16 object-cover rounded shadow-sm">
                                            @else
                                                <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="font-medium text-gray-900">{{ $movie->title }}</div>
                                            @if($movie->director)
                                                <div class="text-sm text-gray-500">Đạo diễn: {{ $movie->director }}</div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 text-gray-700">{{ $movie->release_year }}</td>
                                        <td class="py-4 px-4">
                                            @if($movie->genre)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $movie->genre }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center">
                                                <span class="text-yellow-400">★</span>
                                                <span class="ml-1 text-gray-700 font-medium">{{ number_format($movie->average_rating, 1) }}</span>
                                                <span class="text-sm text-gray-500 ml-1">({{ $movie->ratings->count() }})</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('movies.show', $movie) }}" 
                                                   class="text-blue-600 hover:text-blue-900 text-xs bg-blue-100 px-2 py-1 rounded" target="_blank">
                                                    Xem
                                                </a>
                                                <a href="{{ route('admin.movies.edit', $movie) }}" 
                                                   class="text-green-600 hover:text-green-900 text-xs bg-green-100 px-2 py-1 rounded">
                                                    Sửa
                                                </a>
                                                <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900 text-xs bg-red-100 px-2 py-1 rounded" 
                                                            onclick="return confirm('Bạn có chắc chắn? Điều này sẽ xóa tất cả đánh giá và bình luận cho phim này.')">
                                                        Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-16 text-center">
                                            <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V3a1 1 0 011 1v11.586l2 2A1 1 0 0120 18v-7a1 1 0 00-1-1h-2V7a1 1 0 00-1-1H8a1 1 0 00-1 1v3H5a1 1 0 00-1 1v7a1 1 0 001.414.414l2-2V4z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có phim nào</h3>
                                            <p class="text-gray-600 mb-4">Hệ thống chưa có phim nào được thêm vào.</p>
                                            <a href="{{ route('admin.movies.create') }}" 
                                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                                Thêm phim đầu tiên
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($movies->hasPages())
                        <div class="mt-6">
                            {{ $movies->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>