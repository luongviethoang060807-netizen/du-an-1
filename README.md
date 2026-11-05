# Du An 1

Dự án web salon tóc nam theo mô hình monorepo. Backend PHP MVC và frontend Vue 3 được tách riêng để dễ phát triển, test và tích hợp API.

## Tổng quan

- Backend: [BE](BE)
- Frontend: [FE](FE)
- Tài liệu auth riêng: [AUTH_README.md](AUTH_README.md)

## Mục tiêu dự án

- Xây dựng landing page salon tóc nam
- Hiển thị bài viết / tin tức
- Quản lý sản phẩm và dịch vụ
- Tách rõ frontend/backend để dễ mở rộng
- Dễ test API bằng Thunder Client hoặc trình duyệt

## Cấu trúc thư mục

```bash
du-an-1/
├── BE/
│   ├── configs/
│   ├── controllers/
│   ├── extensions/
│   ├── models/
│   ├── public/
│   │   └── dist/
│   ├── routes/
│   ├── views/
│   ├── index.php
│   └── ...
│
├── FE/
│   ├── src/
│   ├── .env
│   ├── .env.production
│   ├── package.json
│   ├── vite.config.js
│   └── ...
│
├── AUTH_README.md
├── README.md
├── .gitignore
└── ...
```

## Công nghệ sử dụng

### Backend
- PHP 8+
- MVC tùy chỉnh
- Route API
- JSON response
- JWT cho auth (chi tiết ở [AUTH_README.md](AUTH_README.md))

### Frontend
- Vue 3
- Vite
- Vue Router
- Axios
- Bootstrap 5

## Yêu cầu môi trường

- PHP 8+
- Laragon / XAMPP / Apache local
- Node.js 18+
- npm

## Cách chạy dự án

### 1. Cập nhật database

Đảm bảo MySQL đang chạy trong Laragon, sau đó mở PowerShell tại thư mục gốc dự án và chạy lệnh duy nhất:

```powershell
Get-Content -Raw .\BE\database\create_database.sql | mysql --host=localhost --port=3306 --user=root
```

File [BE/database/create_database.sql](BE/database/create_database.sql) là file SQL duy nhất cho backend. Nó tạo database `du-an-1`, các bảng `users`, `categories`, `products` và dữ liệu sản phẩm mẫu. Cấu hình kết nối mặc định là `localhost:3306`, user `root`, mật khẩu trống, khớp với `BE/configs/env.php`. Máy cần có lệnh `mysql` trong `PATH` (có thể mở terminal từ Laragon nếu PowerShell không nhận lệnh). Không cần import bằng phpMyAdmin.

Khi có thay đổi cấu trúc hoặc dữ liệu khởi tạo, cập nhật file SQL duy nhất này rồi chạy lại cùng lệnh. Các lệnh tạo bảng và thêm dữ liệu mẫu được viết để có thể chạy lặp lại. Nếu MySQL có mật khẩu, thêm `--password` để MySQL hỏi mật khẩu khi chạy.

### 2. Backend
Mở bằng Laragon hoặc local PHP server:

```text
http://localhost/du-an-1/BE/
```

### 3. Frontend
```bash
cd FE
npm install
npm run dev
```

Sau đó truy cập:

```text
http://localhost:5173
```

## Build frontend cho production

```bash
cd FE
npm run build
```

Build sẽ xuất vào thư mục:

```text
BE/public/dist
```

## API backend

Một số endpoint demo:

```text
http://localhost/du-an-1/BE/?action=api-login
http://localhost/du-an-1/BE/?action=api-logout
http://localhost/du-an-1/BE/?action=api-posts
http://localhost/du-an-1/BE/?action=api-products
```

## Tài liệu liên quan

- [AUTH_README.md](AUTH_README.md): hướng dẫn chi tiết về JWT, Bearer token và middleware auth

## Ghi chú

- Frontend và backend được tách biệt rõ ràng.
- Dự án hiện đang sử dụng mô hình API JSON đơn giản, dễ mở rộng.
- Auth thực hiện theo JWT, nhưng detail kỹ thuật được giữ riêng trong [AUTH_README.md](AUTH_README.md) để README vẫn là hướng dẫn chung dự án.

## Mục tiêu phát triển tiếp theo

- Landing page salon tóc nam
- Trang bài viết / tin tức
- Quản lý dịch vụ / sản phẩm
- Tích hợp đặt lịch / booking
- Tối ưu trải nghiệm frontend và API
