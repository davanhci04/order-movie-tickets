<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MoviePortal') }} - Đăng ký</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 min-h-screen">
    <div class="min-h-screen flex">
        <!-- Left side - Welcome message -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-blue-800 relative overflow-hidden">
            <!-- Background pattern -->
            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"%23ffffff\" fill-opacity=\"0.05\"><path d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/></g></g></svg></div>
            
            <div class="relative z-10 flex items-center justify-center w-full h-full">
                <div class="text-center text-white">
                    <!-- Logo -->
                    <div class="">
                        @if(file_exists(public_path('images/logo-white.png')))
                            <img src="{{ asset('images/logo-white.png') }}" alt="MoviePortal Logo" class="w-32 h-32 mx-auto">
                        @endif
                        {{-- <h1 class="text-4xl font-bold">MoviePortal</h1>
                        <p class="text-xl text-blue-100 mt-2">Khám phá thế giới điện ảnh</p> --}}
                    </div>

                    <!-- Welcome message -->
                    <div class="max-w-md mx-auto">
                        <h2 class="text-2xl font-semibold mb-6">Tham gia cộng đồng yêu phim!</h2>
                        <div class="space-y-4 text-left">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center mt-0.5">
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                </div>
                                <div>
                                    <h3 class="font-medium">Miễn phí hoàn toàn</h3>
                                    <p class="text-sm text-blue-100">Tất cả tính năng đều được sử dụng miễn phí</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center mt-0.5">
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                </div>
                                <div>
                                    <h3 class="font-medium">Đánh giá & Bình luận</h3>
                                    <p class="text-sm text-blue-100">Chia sẻ ý kiến về những bộ phim bạn yêu thích</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center mt-0.5">
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                </div>
                                <div>
                                    <h3 class="font-medium">Danh sách cá nhân</h3>
                                    <p class="text-sm text-blue-100">Tạo và quản lý danh sách phim của riêng bạn</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center mt-0.5">
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                </div>
                                <div>
                                    <h3 class="font-medium">Cộng đồng</h3>
                                    <p class="text-sm text-blue-100">Kết nối với những người có cùng sở thích</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side - Register form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Mobile logo -->
                <div class="lg:hidden text-center mb-8">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="MoviePortal Logo" class="w-20 h-20 mx-auto mb-4">
                    @endif
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-2xl border border-blue-200">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-blue-900">Tạo tài khoản</h2>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-blue-700 mb-2">
                                Họ và tên
                            </label>
                            <input id="name" 
                                   class="w-full px-4 py-3 bg-white border border-blue-300 rounded-lg text-blue-900 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="name"
                                   placeholder="Nhập họ và tên của bạn" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-blue-700 mb-2">
                                Email
                            </label>
                            <input id="email" 
                                   class="w-full px-4 py-3 bg-white border border-blue-300 rounded-lg text-blue-900 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="username"
                                   placeholder="Nhập email của bạn" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-blue-700 mb-2">
                                Mật khẩu
                            </label>
                            <input id="password" 
                                   class="w-full px-4 py-3 bg-white border border-blue-300 rounded-lg text-blue-900 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                   type="password"
                                   name="password"
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Tạo mật khẩu" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-blue-700 mb-2">
                                Xác nhận mật khẩu
                            </label>
                            <input id="password_confirmation" 
                                   class="w-full px-4 py-3 bg-white border border-blue-300 rounded-lg text-blue-900 placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                   type="password"
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Nhập lại mật khẩu" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white">
                            Tạo tài khoản
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-blue-600">
                            Đã có tài khoản? 
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium transition duration-200">
                                Đăng nhập ngay
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Back to home -->
                <div class="text-center mt-6">
                    <a href="{{ route('movies.index') }}" class="text-blue-100 hover:text-white transition duration-200 flex items-center justify-center space-x-2">
                        <span>←</span>
                        <span>Quay lại trang chủ</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
