# Công việc BE-FE - Long

## Nền tảng
- Thiết lập cấu trúc dự án và GitHub; cấu hình BE PHP MVC, FE Vue 3/Vite, Vue Router, Axios, Bootstrap và build FE vào BE.

## Backend
- Thiết lập router và phản hồi JSON; xây dựng API kiểm tra, bài viết mẫu, sản phẩm và dữ liệu demo.
- Xây dựng đăng nhập bằng JWT; kiểm tra tài khoản từ bảng `users` qua `User->authenticate()`, xác minh mật khẩu bằng hash và chỉ cho phép tài khoản đã active.
- Xây dựng middleware Bearer token; bảo vệ API bài viết và sản phẩm.
- Bổ sung API đăng ký/xác minh email; token ngẫu nhiên chỉ lưu hash, có hạn 60 phút và chỉ dùng một lần.
- Bổ sung API quên mật khẩu, đặt lại mật khẩu bằng email token và đổi mật khẩu có xác thực Bearer token.
- Tách helper gửi mail PHPMailer, dùng chung cấu hình SMTP và template cyberpunk cho email xác minh/reset.
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

Schema khởi tạo và seed dữ liệu nằm trong `BE/database/create_database.sql`. File này seed hai tài khoản active để phát triển:
- Admin: `admin@example.com`, mật khẩu `123456`
- User: `user@example.com`, mật khẩu `123456`

Mật khẩu trong database được lưu dưới dạng hash. Chạy file SQL trước khi thử đăng nhập.

## API xác thực bổ sung - Week 2

- `POST ?action=api-register`: nhận JSON `email`, `password`. Tài khoản mới mặc định role `user`, chưa active; mật khẩu được hash. Link xác minh hết hạn sau 60 phút.
- `GET ?action=api-verify-email&token=...`: kích hoạt tài khoản nếu token hợp lệ, chưa dùng và chưa hết hạn.
- Đăng ký lại bằng email pending sẽ cấp token mới và gửi lại email, không thay đổi mật khẩu đã lưu. Email đã active trả `409`.
- `POST ?action=api-forgot-password`: nhận JSON `email`, không yêu cầu đăng nhập. Response chung tránh tiết lộ email có tài khoản hay không; chỉ tài khoản active nhận email reset.
- `GET ?action=api-reset-password&token=...`: kiểm tra token reset còn hạn, không tiêu thụ token.
- `POST ?action=api-reset-password`: nhận JSON `token`, `new_password`; đặt mật khẩu mới và tiêu thụ token. Reset token cũng hết hạn sau 60 phút.
- `POST ?action=api-change-password`: yêu cầu `Authorization: Bearer <JWT>`, nhận JSON `current_password`, `new_password`; xác minh mật khẩu hiện tại trước khi cập nhật.
- `BE/configs/mail_helper.php` gửi email xác minh và reset qua PHPMailer. Không ghi SMTP credential vào tài liệu hoặc commit.
- Cột `verification_expires_at` được khai báo trong `create_database.sql`; database hiện hữu dùng migration `BE/database/migrations/20261106_add_verification_expires_at.sql`. Migration đã áp dụng trên database local.

PHP lint, kiểm tra runtime wiring và test model trên database local đã đạt. Chưa thực hiện gửi email SMTP end-to-end.