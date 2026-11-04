<?php
/**
 * Router chính của ứng dụng.
 *
 * Mỗi action tương ứng với một endpoint API hoặc page.
 * Những route cần bảo vệ auth thì gọi middleware trước khi vào controller.
 */

$action = $_GET['action'] ?? '/';

switch ($action) {
    case '/':
        (new HomeController)->index();
        break;

    case 'api-check':
        (new HomeController)->check();
        break;

    case 'api-login':
        (new AuthController)->login();
        break;

    case 'api-logout':
        (new AuthController)->logout();
        break;

    // API cần xác thực người dùng
    case 'api-posts':
        (new AuthMiddleware())->requireAuth();
        (new PostController)->index();
        break;

    case 'api-products':
        (new AuthMiddleware())->requireAuth();
        (new ProductController)->index();
        break;

    // API test cho thằng mặt cặc Hoàng Vinh
    case 'api-guns':
        (new GunController)->index();
        break;

    default:
        // Xử lý khi không khớp route nào (404 Not Found)
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
        break;
}