<?php

/**
 * VibeCoder: Long
 * Mô hình thao tác với tài khoản trong bảng users.
 */
class User extends BaseModel
{
    protected $table = 'users';

    /**
     * Lấy danh sách tài khoản từ cơ sở dữ liệu.
     *
     * @return array Danh sách tài khoản.
     */
    public function getAll()
    {
        return $this->all();
    }

    /**
        * Tìm tài khoản theo địa chỉ email.
     *
        * @param string $email Địa chỉ email cần tìm.
        * @return array|false Thông tin tài khoản hoặc false nếu không tìm thấy.
     */
    public function findByEmail($email)
    {
        $sql = 'SELECT * FROM `users` WHERE `email` = :email LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => trim($email)]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
        * Tạo tài khoản mới sau khi kiểm tra email, vai trò và mã hóa mật khẩu.
        * Tài khoản mới mặc định chưa được kích hoạt cho đến khi xác minh.
     *
        * @param string $email Địa chỉ email của tài khoản.
        * @param string $password Mật khẩu dạng rõ, sẽ được mã hóa trước khi lưu.
        * @param string $role Vai trò của tài khoản: admin hoặc user.
        * @return bool True nếu tạo thành công, false nếu dữ liệu không hợp lệ.
     */
    public function createUser($email, $password, $role = 'user')
    {
        $email = trim($email);
        $allowedRoles = ['admin', 'user'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '' || !in_array($role, $allowedRoles, true)) {
            return false;
        }

        return $this->save([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
            'is_active' => 0,
        ]);
    }

    /**
        * Xác thực email và mật khẩu; chỉ trả về tài khoản đã được kích hoạt.
        * Mật khẩu đã mã hóa được loại khỏi kết quả để tránh lộ thông tin.
     *
        * @param string $email Địa chỉ email đăng nhập.
        * @param string $password Mật khẩu đăng nhập.
        * @return array|false Thông tin tài khoản đã xác thực hoặc false nếu thất bại.
     */
    public function authenticate($email, $password)
    {
        $user = $this->findByEmail($email);

        if (!$user || (int) $user['is_active'] !== 1 || !password_verify($password, $user['password'])) {
            return false;
        }

        unset($user['password']);

        return $user;
    }
}