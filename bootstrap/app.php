<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Khởi tạo Application
$app = Application::configure(basePath: dirname(__DIR__));

// Cấu hình routing
$app = $app->withRouting(
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
);

// Cấu hình middleware
$app = $app->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'force.https' => \App\Http\Middleware\ForceHttps::class,
    ]);

    // **Lưu ý:** Không gọi config() tại đây!
    // Middleware ForceHttps sẽ được áp dụng trong AppServiceProvider hoặc Kernel
});

// Cấu hình exception handler (nếu cần)
$app = $app->withExceptions(function (Exceptions $exceptions): void {
    //
});

// Trả về Application instance
return $app->create();
