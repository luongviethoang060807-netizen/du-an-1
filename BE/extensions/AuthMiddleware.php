/**
 * AuthMiddleware
 *
 * Đây là lớp kiểm tra quyền truy cập API bằng Bearer token.
 *
 * Luồng:
 * 1. Đọc header Authorization
 * 2. Kiểm tra định dạng "Bearer <token>"
 * 3. Gọi requireBearerToken() để verify JWT
 * 4. Nếu hợp lệ, cho request đi tiếp
 * 5. Nếu không hợp lệ, trả 401 JSON
 */
<?php

class AuthMiddleware
{
    /**
     * Yêu cầu request phải có token hợp lệ.
     *
     * @return array Payload người dùng trong token nếu token hợp lệ
     */
    public function requireAuth(): array
    {
        return requireBearerToken();
    }
}
