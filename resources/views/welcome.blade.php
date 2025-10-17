<x-app-layout>
    <!-- Hero Carousel Section -->
    @if($featuredMovies->count() > 0)
        <div class="relative bg-gray-900 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative">
                    <!-- Carousel Container -->
                    <div class="carousel-container" id="heroCarousel">
                        @foreach($featuredMovies as $index => $movie)
                            <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                                <div class="flex flex-col lg:flex-row items-center py-16 lg:py-24">
                                    <!-- Movie Info -->
                                    <div class="lg:w-1/2 lg:pr-12 mb-8 lg:mb-0">
                                        <div class="text-center lg:text-left">
                                            <h1 class="text-4xl lg:text-6xl font-bold text-white mb-4">
                                                {{ $movie->title }}
                                            </h1>
                                            <div class="flex items-center justify-center lg:justify-start space-x-4 mb-6">
                                                <span class="text-yellow-400 flex items-center">
                                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    {{ number_format($movie->average_rating, 1) }}
                                                </span>
                                                <span class="text-gray-300">{{ $movie->release_year }}</span>
                                                @if($movie->duration)
                                                    <span class="text-gray-300">{{ $movie->duration }} phút</span>
                                                @endif
                                            </div>
                                            @if($movie->description)
                                                <p class="text-gray-300 text-lg mb-8 leading-relaxed">
                                                    {{ Str::limit($movie->description, 200) }}
                                                </p>
                                            @endif
                                            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                                <a href="{{ route('movies.show', $movie) }}" 
                                                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 text-center">
                                                    Xem Chi Tiết
                                                </a>
                                                @auth
                                                    <button onclick="toggleWatchlist({{ $movie->id }})" 
                                                            id="hero-watchlist-btn-{{ $movie->id }}"
                                                            class="bg-gray-700 hover:bg-gray-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200">
                                                        {{ auth()->user()->hasInWatchlist($movie->id) ? 'Xóa khỏi Danh Sách' : 'Thêm vào Danh Sách' }}
                                                    </button>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Movie Poster -->
                                    <div class="lg:w-1/2">
                                        <div class="relative max-w-md mx-auto">
                                            @if($movie->poster_url)
                                                <img src="{{ $movie->poster_url }}" 
                                                     alt="{{ $movie->title }}" 
                                                     class="w-full h-96 lg:h-[500px] object-cover rounded-xl shadow-2xl">
                                            @else
                                                <div class="w-full h-96 lg:h-[500px] bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl shadow-2xl flex items-center justify-center">
                                                    <svg class="w-24 h-24 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v16a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h1z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Carousel Controls -->
                    <button onclick="previousSlide()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button onclick="nextSlide()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Carousel Indicators -->
                    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
                        @foreach($featuredMovies as $index => $movie)
                            <button onclick="goToSlide({{ $index }})" 
                                    class="carousel-indicator w-3 h-3 rounded-full transition-all duration-200 {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}" 
                                    data-slide="{{ $index }}"></button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Top Rated Movies Section -->
            @if($topRatedMovies->count() > 0)
                <section class="mb-16">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">Phim Được Đánh Giá Cao</h2>
                        <a href="{{ route('movies.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center">
                            Xem tất cả
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-6">
                        @foreach($topRatedMovies as $movie)
                            <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                                <a href="{{ route('movies.show', $movie) }}" class="block">
                                    <!-- Movie Poster -->
                                    <div class="aspect-[2/3] relative overflow-hidden">
                                        @if($movie->poster_url)
                                            <img src="{{ $movie->poster_url }}" 
                                                 alt="{{ $movie->title }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v16a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h1z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <!-- Rating Badge -->
                                        <div class="absolute top-2 left-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center space-x-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span>{{ number_format($movie->average_rating, 1) }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Movie Info -->
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-2">
                                            {{ $movie->title }}
                                        </h3>
                                        <div class="flex items-center text-xs text-gray-600">
                                            <span>{{ $movie->release_year }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Recently Added Movies Section -->
            @if($recentMovies->count() > 0)
                <section class="mb-16">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">Phim Mới Phát Hành</h2>
                        <a href="{{ route('movies.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center">
                            Xem tất cả
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-6">
                        @foreach($recentMovies as $movie)
                            <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                                <a href="{{ route('movies.show', $movie) }}" class="block">
                                    <!-- Movie Poster -->
                                    <div class="aspect-[2/3] relative overflow-hidden">
                                        @if($movie->poster_url)
                                            <img src="{{ $movie->poster_url }}" 
                                                 alt="{{ $movie->title }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v16a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h1z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <!-- New Badge -->
                                        <div class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            Mới
                                        </div>
                                    </div>
                                    
                                    <!-- Movie Info -->
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-2">
                                            {{ $movie->title }}
                                        </h3>
                                        <div class="flex items-center text-xs text-gray-600">
                                            <span>{{ $movie->release_year }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Recommendations Section -->
            <section class="mb-16">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Gợi Ý Theo Sở Thích</h2>
                </div>
                
                @auth
                    @if($recommendedMovies->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-6">
                            @foreach($recommendedMovies as $movie)
                                <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                                    <a href="{{ route('movies.show', $movie) }}" class="block">
                                        <!-- Movie Poster -->
                                        <div class="aspect-[2/3] relative overflow-hidden">
                                            @if($movie->poster_url)
                                                <img src="{{ $movie->poster_url }}" 
                                                     alt="{{ $movie->title }}" 
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                                                    <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v16a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h1z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            
                                            <!-- Recommendation Badge -->
                                            <div class="absolute top-2 left-2 bg-purple-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                                Gợi ý
                                            </div>
                                        </div>
                                        
                                        <!-- Movie Info -->
                                        <div class="p-4">
                                            <h3 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-2">
                                                {{ $movie->title }}
                                            </h3>
                                            <div class="flex items-center text-xs text-gray-600">
                                                <span>{{ $movie->release_year }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow-md p-8 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có gợi ý phù hợp</h3>
                            <p class="text-gray-600 mb-4">Hãy đánh giá một số bộ phim để chúng tôi có thể gợi ý phim phù hợp với sở thích của bạn!</p>
                            <a href="{{ route('movies.index') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200">
                                Khám phá phim
                            </a>
                        </div>
                    @endif
                @else
                    <div class="bg-white rounded-xl shadow-md p-8 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Đăng nhập để xem gợi ý</h3>
                        <p class="text-gray-600 mb-6">Đăng nhập và đánh giá các bộ phim để xem các phim phù hợp với bạn!</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200">
                                Đăng nhập
                            </a>
                            <a href="{{ route('register') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200">
                                Tạo tài khoản
                            </a>
                        </div>
                    </div>
                @endauth
            </section>

            <!-- Call to Action Section -->
            <section class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-xl overflow-hidden">
                <div class="px-8 py-12 text-center">
                    <div class="max-w-3xl mx-auto">
                        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">
                            Đánh giá và nêu quan điểm của bạn về các bộ phim!
                        </h2>
                        <p class="text-xl text-blue-100 mb-8">
                            Tham gia cộng đồng yêu phim, chia sẻ cảm nhận và khám phá những bộ phim tuyệt vời cùng chúng tôi.
                        </p>
                        
                        @guest
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('register') }}" 
                                   class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-bold text-lg transition-colors duration-200 shadow-lg">
                                    Đăng ký ngay
                                </a>
                                <a href="{{ route('login') }}" 
                                   class="bg-blue-500 hover:bg-blue-400 text-white px-8 py-3 rounded-lg font-bold text-lg transition-colors duration-200 border-2 border-white/20">
                                    Đăng nhập
                                </a>
                            </div>
                        @else
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('movies.index') }}" 
                                   class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-bold text-lg transition-colors duration-200 shadow-lg">
                                    Khám phá phim mới
                                </a>
                                <a href="{{ route('watchlist.index') }}" 
                                   class="bg-blue-500 hover:bg-blue-400 text-white px-8 py-3 rounded-lg font-bold text-lg transition-colors duration-200 border-2 border-white/20">
                                    Danh sách của tôi
                                </a>
                            </div>
                        @endguest
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Carousel JavaScript -->
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.carousel-indicator');
        const totalSlides = slides.length;

        function showSlide(n) {
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => {
                indicator.classList.remove('bg-white');
                indicator.classList.add('bg-white/50');
            });

            currentSlide = (n + totalSlides) % totalSlides;
            slides[currentSlide].classList.add('active');
            indicators[currentSlide].classList.remove('bg-white/50');
            indicators[currentSlide].classList.add('bg-white');
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function previousSlide() {
            showSlide(currentSlide - 1);
        }

        function goToSlide(n) {
            showSlide(n);
        }

        // Auto-play carousel
        setInterval(nextSlide, 5000);

        // Watchlist functionality
        function toggleWatchlist(movieId) {
            const button = document.getElementById(`hero-watchlist-btn-${movieId}`);
            if (!button) return;
            
            // Disable button temporarily
            button.disabled = true;
            button.classList.add('opacity-50');

            fetch(`/movies/${movieId}/watchlist`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button text
                    button.textContent = data.inWatchlist ? 'Xóa khỏi Danh Sách' : 'Thêm vào Danh Sách';

                    // Show success message
                    const message = document.createElement('div');
                    message.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                    message.textContent = data.message;
                    document.body.appendChild(message);
                    
                    setTimeout(() => {
                        message.remove();
                    }, 3000);
                } else {
                    alert(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thực hiện thao tác');
            })
            .finally(() => {
                // Re-enable button
                button.disabled = false;
                button.classList.remove('opacity-50');
            });
        }
    </script>

    <!-- Custom CSS for carousel -->
    <style>
        .carousel-slide {
            display: none;
        }
        .carousel-slide.active {
            display: block;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>