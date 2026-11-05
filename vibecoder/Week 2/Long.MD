# Công việc BE-FE - Long

## Nền tảng
- Thiết lập cấu trúc dự án và GitHub; cấu hình BE PHP MVC, FE Vue 3/Vite, Vue Router, Axios, Bootstrap và build FE vào BE.

## Backend
- Thiết lập router và phản hồi JSON; xây dựng API kiểm tra, bài viết mẫu, sản phẩm và dữ liệu demo.
- Xây dựng đăng nhập bằng JWT; kiểm tra tài khoản từ bảng `users` qua `User->authenticate()`, xác minh mật khẩu bằng hash và chỉ cho phép tài khoản đã active.
- Xây dựng middleware Bearer token; bảo vệ API bài viết và sản phẩm.
- Tạo model dùng chung và model sản phẩm/người dùng.

## Frontend
- Dựng layout salon, trang chủ, trang test và form login.
- Tạo API client dùng base URL động, tự gửi Bearer token và lưu auth session sau khi đăng nhập.
- Thêm route login và menu theo trạng thái đăng nhập.

## Lưu ý tích hợp
- FE hiện gọi `/posts`, trong khi BE khai báo `?action=api-posts`; cần đồng bộ endpoint để tải bài viết.

## Luồng đăng nhập

### Đăng nhập
1. FE gửi email và mật khẩu đến `?action=api-login`.
2. `AuthController` khởi tạo `User` trong constructor và gọi `$this->userModel->authenticate($email, $password)`.
3. `User->authenticate()` tìm tài khoản trong bảng `users`, kiểm tra `is_active`, rồi dùng `password_verify()` so khớp mật khẩu với hash trong database.
4. Nếu hợp lệ, BE tạo JWT có `id`, `email` và `role`; FE lưu token và thông tin user trong `localStorage`.

File schema duy nhất là `BE/database/create_database.sql`. File này seed hai tài khoản active để phát triển:
- Admin: `admin@example.com`, mật khẩu `123456`
- User: `user@example.com`, mật khẩu `123456`

Mật khẩu trong database được lưu dưới dạng hash. Chạy file SQL trước khi thử đăng nhập.