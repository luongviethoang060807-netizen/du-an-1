/**
 * AuthController
 * VibeCoder: Long
 *
 * Chịu trách nhiệm xử lý auth API cho hệ thống.
 */
<?php

class AuthController
{
    private User $userModel;

    /**
     * Khởi tạo controller và model user để dùng trong các hàm xác thực.
     */
    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * API đăng nhập.
     *
     * 1. Đọc dữ liệu JSON từ request body
     * 2. Validate email/password
        * 3. Kiểm tra tài khoản trong cơ sở dữ liệu bằng $userModel->authenticate()
     * 4. Tạo JWT bằng jwt_sign()
     * 5. Trả token về cho client
     *
     * @return void
     */
    public function login()
    {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $email = trim((string) ($input['email'] ?? ''));
        $password = (string) ($input['password'] ?? '');

        if ($email === '' || $password === '') {
            http_response_code(400);
            response_json([
                'status' => 'error',
                'message' => 'Email và mật khẩu không được để trống'
            ], 400);
            return;
        }

        $user = $this->userModel->authenticate($email, $password);

        if ($user === false) {
            http_response_code(401);
            response_json([
                'status' => 'error',
                'message' => 'Sai email hoặc mật khẩu'
            ], 401);
            return;
        }

        $token = jwt_sign([
            'sub' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role'],
        ]);

        response_json([
            'status' => 'success',
            'message' => 'Đăng nhập thành công',
            'token' => $token,
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role'],
            ]
        ]);
    }

    /**
     * API đăng xuất.
     *
     * Với JWT stateless, server không lưu token nên logout thực chất là client bỏ
     * token đi. Hàm này vẫn cố gắng verify token nếu có để đảm bảo request hợp lệ,
     * sau đó trả về message “logout thành công”.
     *
     * @return void
     */
    public function logout()
    {
        $payload = requireBearerToken();

        response_json([
            'status' => 'success',
            'message' => 'Đăng xuất thành công',
            'user' => [
                'sub' => $payload['sub'] ?? null,
                'email' => $payload['email'] ?? null,
                'role' => $payload['role'] ?? null,
            ]
        ]);
    }
}
