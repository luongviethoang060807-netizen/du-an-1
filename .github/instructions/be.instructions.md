---
applyTo: "BE/**"
---

# BE Instructions

## Phạm vi và nguyên tắc
- Chỉ sửa `BE/` khi task thuộc BE. Không tự tiện sửa `FE/` để che lỗi API, cũng không thay schema/contract ngoài yêu cầu.
- Trước khi sửa, kiểm tra trạng thái thay đổi hiện có và đọc đúng route/controller/model/helper liên quan. Giữ nguyên thay đổi chưa commit của người khác; không ghi đè, revert, format hàng loạt hoặc chỉnh file ngoài phạm vi task.
- Chia task theo file hoặc vùng sở hữu rõ ràng. Mỗi file chỉ có một người/agent chịu trách nhiệm chỉnh tại một thời điểm. `routes/index.php`, helper chung, auth middleware và model dùng chung là vùng có ảnh hưởng rộng: phải phân công owner nếu nhiều task/nhánh cùng chạm.
- Chỉ sửa phần tối thiểu cần thiết. Không đổi framework, tạo tầng kiến trúc mới, thêm dependency hoặc refactor diện rộng nếu task không yêu cầu.

## Kiến trúc dự án
- Backend là PHP. Entry point `BE/index.php` nạp cấu hình/helper, đăng ký autoload cho `models/`, `controllers/`, `extensions/`, rồi nạp `routes/index.php`.
- Đăng ký API action trong `BE/routes/index.php`; xử lý request/điều phối trong controller; truy cập dữ liệu qua model và PDO. Theo pattern hiện có, không đặt truy vấn DB hoặc nghiệp vụ vào router.
- Tái sử dụng `response_json(...)`, validator, middleware và helper đang có sau khi đọc cách chúng hoạt động. Không tự echo JSON theo format khác nếu helper chuẩn đáp ứng được.
- Giữ tên file/vị trí theo cấu trúc `controllers/`, `models/`, `extensions/`, `configs/`, `routes/`, `database/`. Không chuyển hoặc đổi tên public API/class tùy tiện.

## Hợp đồng API: phối hợp bắt buộc với FE
- Một endpoint là contract công khai. Trước khi thêm/đổi endpoint, thống nhất với người phụ trách FE: action, HTTP method, query/body, xác thực, response thành công, lỗi và mã HTTP. Ghi contract trong task/trao đổi nhóm trước khi hai phía triển khai.
- Không đổi âm thầm tên action, key response, kiểu dữ liệu, quy tắc phân trang, mã HTTP hoặc yêu cầu auth đã được FE dùng. Nếu bắt buộc đổi, nêu contract cũ/mới, nơi bị ảnh hưởng và phối hợp cập nhật FE.
- Đọc các endpoint/controller lân cận làm chuẩn. Response thành công hiện thường có `status: 'success'` cùng key dữ liệu theo tài nguyên (ví dụ `products`); không giả định tất cả endpoint có cùng shape.
- FE gọi endpoint qua `FE/src/services/api.js` với action query (`?action=...`). Không yêu cầu FE hardcode host hoặc tạo HTTP client mới.
- Kiểm tra auth tại router/middleware theo endpoint. Với route bảo vệ, lấy danh tính từ payload đã xác minh của middleware; không tin user ID, role hay quyền do client gửi.

## An toàn dữ liệu và bảo mật
- Validate input ở ranh giới request: kiểu, định dạng, miền giá trị, trường bắt buộc và giới hạn độ dài. Trả lỗi nhất quán, không để warning/stack trace hoặc chi tiết nội bộ lộ ra response production.
- Truy vấn dữ liệu bằng prepared statements và bind parameter. Không nối input người dùng vào SQL; identifier động phải được giới hạn bằng allowlist, vì identifier không thể bind như value.
- Áp dụng quyền truy cập ở server cho từng thao tác/tài nguyên. Không coi ẩn nút hoặc route guard phía FE là kiểm soát bảo mật.
- Không ghi secret, mật khẩu, token, dữ liệu nhạy cảm hoặc thông tin kết nối vào source/log/response. Dùng cấu hình môi trường hiện có; không sửa `.env` thật hay in giá trị bí mật.
- Tránh thay đổi CORS, session, JWT, mail, upload hoặc cấu hình toàn cục như tác dụng phụ của feature. Những vùng này ảnh hưởng toàn ứng dụng và cần yêu cầu rõ, owner và kiểm chứng tương ứng.
- Với thay đổi schema, tạo migration SQL theo convention trong `database/migrations/`; không sửa migration đã áp dụng nếu không có kế hoạch migration rõ. Không chạy thao tác phá hủy/xóa dữ liệu nếu chưa được yêu cầu và xác nhận.

## Giao thức phối hợp để tránh xung đột
1. Trước khi làm, nêu file/phạm vi mình sở hữu và xác nhận không có người khác đang sửa cùng vùng. Kiểm tra `git status` và diff liên quan; không xóa hoặc hấp thụ thay đổi chưa rõ chủ sở hữu.
2. Với task FE-BE, thống nhất contract trước; chia ownership theo phía/file. Không để hai người cùng chỉnh một file. Nếu cần đổi file dùng chung, chỉ định một owner hoặc thực hiện tuần tự.
3. Nếu yêu cầu mới xung đột với code/contract hiện có, dừng đúng phần xung đột, mô tả bằng chứng và thống nhất quyết định; không âm thầm đổi API/schema.
4. Khi kết thúc, báo file đã sửa, contract và migration (nếu có), việc FE cần làm và lệnh kiểm tra đã chạy. Không tuyên bố kiểm tra pass nếu chưa chạy.

## Kiểm tra trước khi bàn giao
- Chạy `php -l` cho từng file PHP đã sửa, ví dụ `php -l BE/routes/index.php` từ thư mục gốc.
- Với API, kiểm tra request hợp lệ, input sai, chưa xác thực/không đủ quyền (nếu áp dụng), dữ liệu rỗng và lỗi; đảm bảo status code, JSON và contract đúng.
- Nếu có migration, kiểm tra thứ tự, tính lặp/an toàn theo convention hiện có và ảnh hưởng dữ liệu; không chạy trên database thật nếu chưa được cho phép.
- Kiểm tra diff để chắc không có file ngoài phạm vi, secret, thay đổi schema/contract ngoài ý muốn hoặc thao tác dữ liệu nguy hiểm.