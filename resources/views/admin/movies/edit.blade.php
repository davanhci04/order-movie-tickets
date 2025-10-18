<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.movies.index') }}" class="text-blue-600 hover:text-blue-800 transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-blue-800 leading-tight">
                    Chỉnh sửa: {{ $movie->title }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium mb-2 text-gray-700">Tiêu đề phim *</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $movie->title) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Release Year -->
                            <div>
                                <label for="release_year" class="block text-sm font-medium mb-2 text-gray-700">Năm phát hành *</label>
                                <input type="number" name="release_year" id="release_year" value="{{ old('release_year', $movie->release_year) }}" 
                                       min="1900" max="{{ date('Y') + 5 }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                                @error('release_year')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Genre -->
                            <div>
                                <label for="genre" class="block text-sm font-medium mb-2 text-gray-700">Thể loại</label>
                                <input type="text" name="genre" id="genre" value="{{ old('genre', $movie->genre) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Ví dụ: Hành động, Tình cảm, Hài kịch">
                                @error('genre')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Director -->
                            <div>
                                <label for="director" class="block text-sm font-medium mb-2 text-gray-700">Đạo diễn</label>
                                <input type="text" name="director" id="director" value="{{ old('director', $movie->director) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                @error('director')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="duration" class="block text-sm font-medium mb-2 text-gray-700">Thời lượng (phút)</label>
                                <input type="number" name="duration" id="duration" value="{{ old('duration', $movie->duration) }}" 
                                       min="1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                @error('duration')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Poster -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium mb-3 text-gray-700">Poster phim</label>
                                
                                <!-- Current Poster -->
                                @if($movie->poster_url)
                                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                        <p class="text-sm text-gray-600 mb-2">Poster hiện tại:</p>
                                        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="max-w-xs rounded-lg shadow-md">
                                    </div>
                                @endif
                                
                                <!-- Tab Navigation -->
                                <div class="flex space-x-1 mb-4 bg-gray-100 p-1 rounded-lg">
                                    <button type="button" id="upload-tab" class="flex-1 py-2 px-3 text-sm font-medium rounded-md bg-white text-blue-600 shadow-sm">
                                        📁 Upload từ máy tính
                                    </button>
                                    <button type="button" id="url-tab" class="flex-1 py-2 px-3 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700">
                                        🔗 Nhập URL
                                    </button>
                                </div>

                                <!-- Upload File Section -->
                                <div id="upload-section" class="space-y-3">
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                                        <input type="file" name="poster_file" id="poster_file" accept="image/*" class="hidden">
                                        <label for="poster_file" class="cursor-pointer">
                                            <div class="space-y-3">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <div class="text-gray-600">
                                                    <span class="font-medium text-blue-600 hover:text-blue-500">Chọn file mới</span>
                                                    <span> hoặc kéo thả vào đây</span>
                                                </div>
                                                <p class="text-xs text-gray-500">PNG, JPG, WEBP up to 5MB</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div id="file-preview" class="hidden">
                                        <img id="preview-image" class="max-w-xs mx-auto rounded-lg shadow-md" alt="Preview">
                                        <p id="file-name" class="text-sm text-gray-600 text-center mt-2"></p>
                                    </div>
                                </div>

                                <!-- URL Section -->
                                <div id="url-section" class="hidden">
                                    <input type="url" name="poster_url" id="poster_url" value="{{ old('poster_url', $movie->poster_url) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="https://example.com/poster.jpg">
                                    <p class="text-xs text-gray-500 mt-1">Nhập URL trực tiếp đến hình ảnh poster</p>
                                </div>

                                @error('poster_file')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                @error('poster_url')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium mb-2 text-gray-700">Mô tả *</label>
                                <textarea name="description" id="description" rows="4" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Nhập mô tả về phim...">{{ old('description', $movie->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Stats -->
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                            <h3 class="font-medium mb-3 text-blue-800">Thống kê hiện tại</h3>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-yellow-600">{{ number_format($movie->average_rating, 1) }}</div>
                                    <div class="text-gray-600">Điểm trung bình</div>
                                    <div class="text-xs text-gray-500">/ 10 điểm</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">{{ $movie->ratings->count() }}</div>
                                    <div class="text-gray-600">Lượt đánh giá</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">{{ $movie->comments->count() }}</div>
                                    <div class="text-gray-600">Bình luận</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.movies.index') }}" 
                               class="text-gray-600 hover:text-gray-800 font-medium">
                                Hủy
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                                Cập nhật Phim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const uploadTab = document.getElementById('upload-tab');
            const urlTab = document.getElementById('url-tab');
            const uploadSection = document.getElementById('upload-section');
            const urlSection = document.getElementById('url-section');
            const posterFile = document.getElementById('poster_file');
            const filePreview = document.getElementById('file-preview');
            const previewImage = document.getElementById('preview-image');
            const fileName = document.getElementById('file-name');

            // Tab switching
            uploadTab.addEventListener('click', function() {
                uploadTab.className = 'flex-1 py-2 px-3 text-sm font-medium rounded-md bg-white text-blue-600 shadow-sm';
                urlTab.className = 'flex-1 py-2 px-3 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700';
                uploadSection.classList.remove('hidden');
                urlSection.classList.add('hidden');
            });

            urlTab.addEventListener('click', function() {
                urlTab.className = 'flex-1 py-2 px-3 text-sm font-medium rounded-md bg-white text-blue-600 shadow-sm';
                uploadTab.className = 'flex-1 py-2 px-3 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700';
                urlSection.classList.remove('hidden');
                uploadSection.classList.add('hidden');
            });

            // File preview
            posterFile.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        fileName.textContent = file.name;
                        filePreview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    filePreview.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>