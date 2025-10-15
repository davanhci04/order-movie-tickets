# API Controllers Documentation

## Tổng quan

Tôi đã tạo một hệ thống API Controllers hoàn chỉnh cho ứng dụng đặt vé xem phim của bạn. API Controllers được tổ chức trong folder `app/Http/Controllers/Api/`.

## Cấu trúc API Controllers

```
app/Http/Controllers/Api/
├── BaseApiController.php       # Base controller với các helper methods
├── AuthApiController.php       # Authentication API
├── MovieApiController.php      # Movie management API
├── CommentApiController.php    # Comment management API
└── RatingApiController.php     # Rating management API
```

## Tính năng chính

### 1. BaseApiController
- Cung cấp các helper methods cho response chuẩn
- Methods: `sendResponse()`, `sendError()`, `sendValidationError()`, etc.
- Hỗ trợ pagination response

### 2. MovieApiController
- `GET /api/movies` - Danh sách phim (có pagination)
- `GET /api/movies/{id}` - Chi tiết phim
- `GET /api/movies/search?q=query` - Tìm kiếm phim
- `GET /api/movies/popular` - Phim phổ biến

### 3. CommentApiController
- `GET /api/movies/{movie}/comments` - Danh sách comments của phim
- `POST /api/movies/{movie}/comments` - Thêm comment
- `PUT /api/comments/{comment}` - Cập nhật comment
- `DELETE /api/comments/{comment}` - Xóa comment

### 4. RatingApiController
- `POST /api/movies/{movie}/rating` - Đánh giá phim
- `GET /api/movies/{movie}/rating` - Lấy đánh giá của user
- `DELETE /api/movies/{movie}/rating` - Xóa đánh giá

### 5. AuthApiController
- `POST /api/register` - Đăng ký
- `POST /api/login` - Đăng nhập
- `GET /api/profile` - Thông tin user
- `PUT /api/profile` - Cập nhật profile
- `POST /api/logout` - Đăng xuất
- `POST /api/refresh` - Refresh token

## Các bước tiếp theo cần thực hiện

### 1. Cài đặt Laravel Sanctum (cho API authentication)
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### 2. Cấu hình User model
Thêm trait `HasApiTokens` vào User model:
```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // ...
}
```

### 3. Tạo API routes
Tạo file `routes/api.php` hoặc thêm vào file hiện có:
```php
use App\Http\Controllers\Api\MovieApiController;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\RatingApiController;
use App\Http\Controllers\Api\AuthApiController;

// Public routes
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::get('/movies', [MovieApiController::class, 'index']);
Route::get('/movies/{movie}', [MovieApiController::class, 'show']);
Route::get('/movies/search', [MovieApiController::class, 'search']);
Route::get('/movies/popular', [MovieApiController::class, 'popular']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/profile', [AuthApiController::class, 'profile']);
    Route::put('/profile', [AuthApiController::class, 'updateProfile']);
    Route::post('/refresh', [AuthApiController::class, 'refresh']);
    
    // Comments
    Route::get('/movies/{movie}/comments', [CommentApiController::class, 'index']);
    Route::post('/movies/{movie}/comments', [CommentApiController::class, 'store']);
    Route::put('/comments/{comment}', [CommentApiController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentApiController::class, 'destroy']);
    
    // Ratings
    Route::get('/movies/{movie}/rating', [RatingApiController::class, 'show']);
    Route::post('/movies/{movie}/rating', [RatingApiController::class, 'store']);
    Route::delete('/movies/{movie}/rating', [RatingApiController::class, 'destroy']);
});
```

### 4. Cấu hình CORS (nếu cần)
Trong `config/cors.php`:
```php
'paths' => ['api/*'],
'allowed_methods' => ['*'],
'allowed_origins' => ['*'], // Hoặc domain cụ thể
'allowed_headers' => ['*'],
```

## Response Format

Tất cả API responses sử dụng format chuẩn:

### Success Response
```json
{
    "success": true,
    "message": "Success message",
    "data": {
        // Response data
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        // Validation errors (nếu có)
    }
}
```

### Pagination Response
```json
{
    "success": true,
    "message": "Success",
    "data": {
        "data": [...],
        "pagination": {
            "current_page": 1,
            "last_page": 5,
            "per_page": 10,
            "total": 50,
            "from": 1,
            "to": 10
        }
    }
}
```

## Lưu ý
- Các API Controllers đã được thiết kế để tương thích với controllers hiện có
- Sử dụng same models và relationships
- Có proper error handling và validation
- Hỗ trợ authentication và authorization
- Response format nhất quán

Bạn có thể mở rộng thêm các API endpoints theo nhu cầu!