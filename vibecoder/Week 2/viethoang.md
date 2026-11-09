# Nhật ký công việc - Viethoang

Ngày: 2026-11-09
Branch: `luongviethoang/feature/top5sp`

## Frontend - Top 5 sản phẩm
- Nối trang chủ `HomeView.vue` với API `api-products-top`; mặc định hiển thị sản phẩm bán chạy, có thể chuyển giữa Most viewed và Best-selling.
- Dùng `sort_by` và response `sort_by`/`products` từ API để hiển thị đúng tiêu chí và dữ liệu.
- Tạo component `ProductCardTop5.vue` theo thiết kế Stitch Sharp Barber: Bento grid bất đối xứng, hiệu ứng hover, thứ hạng, giá và chỉ số lượt xem/lượt bán.
- Thêm trạng thái Out of stock từ trường `stock`; nút Add to cart được disable khi hết hàng. Nút hiện chỉ mang tính giao diện, chưa xử lý giỏ hàng.
- Bổ sung loading, lỗi/thử lại và empty state cho khu vực Top 5; giữ nguyên chiều ngang banner và trang chủ.
- Bỏ View all khỏi tiêu đề Top 5; thêm Catalog vào menu desktop/mobile với trạng thái active riêng.
- Tinh chỉnh active Catalog desktop thành gạch chân; giữ nền active trên mobile và bổ sung padding cho mục active Login/Register/Profile.

## Kiểm tra
- `npm run build` trong `FE/`: pass.
- Browser kiểm tra đổi chế độ xếp hạng, layout desktop/mobile, active Catalog và nút Add to cart chỉ hiển thị.
- Giả lập `stock = 0`: badge Out of stock hiển thị và nút bị disable; dữ liệu thật hiện không có sản phẩm hết hàng.
- `git diff --check`: pass.
- Dev server chạy tại `http://localhost:5174/`.
