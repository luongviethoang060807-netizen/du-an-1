---
applyTo: "FE/**"
---

# FE Instructions

## Phạm vi và nguyên tắc
- Chỉ sửa `FE/` khi task thuộc FE. Không tự tiện sửa `BE/`, hợp đồng API, schema DB hoặc cấu hình deploy để làm giao diện chạy được.
- Trước khi sửa, kiểm tra trạng thái thay đổi hiện có và đọc đúng component/service/router liên quan. Giữ nguyên thay đổi chưa commit của người khác; không ghi đè, revert, format hàng loạt hoặc chỉnh file ngoài phạm vi task.
- Chia task theo file hoặc vùng sở hữu rõ ràng. Mỗi file chỉ có một người/agent chịu trách nhiệm chỉnh tại một thời điểm. Không cùng lúc sửa `App.vue`, router, API service hoặc stylesheet toàn cục nếu chưa phân công rõ.
- Chỉ sửa phần tối thiểu cần thiết. Không đổi framework, tạo service HTTP mới, thêm dependency hay refactor diện rộng nếu task không yêu cầu.

## Stack và cấu trúc hiện có
- Frontend dùng Vue 3, Vite, Vue Router, Axios và Bootstrap 5. Theo cấu trúc `FE/src/`: router ở `router/index.js`, API tập trung ở `services/api.js`, xác thực ở `services/auth.js`, view ở `views/`, component dùng lại ở `components/`.
- Dùng Composition API và `<script setup>` theo pattern trong các view lân cận. Dùng `ref`/`computed` phù hợp; không dùng `this`.
- Dùng Bootstrap đã được import trong `main.js`; CSS scoped cho riêng component, `style.css` chỉ cho style thực sự toàn cục.
- Không thêm thư viện hoặc đổi cấu trúc file nếu pattern sẵn có đáp ứng được.

## Tích hợp API: hợp đồng là ranh giới giữa FE và BE
- Mọi request phải đi qua `@/services/api`. Không dùng `fetch`, không tạo Axios instance riêng, không hardcode host/base URL. Service đã tự cấu hình base URL và Bearer token.
- Dùng query action theo router PHP hiện có, ví dụ `api.get('/?action=api-products')`. Không đoán action, HTTP method, tên field, kiểu dữ liệu, quy tắc phân trang hoặc yêu cầu đăng nhập.
- Trước khi tích hợp endpoint mới/thay đổi, xác nhận hợp đồng với người phụ trách BE: action, method, query/body, auth, response thành công, lỗi và mã HTTP. Ghi rõ hợp đồng trong task hoặc trao đổi nhóm trước khi hai phía triển khai. Nếu chưa xác nhận, không tự tạo contract giả; hoàn thành phần UI cô lập hoặc hỏi đúng thông tin còn thiếu.
- FE không sửa route/controller/model/schema BE để khớp cách FE đang gọi. Nếu phát hiện contract không khớp, báo cụ thể request và response mong đợi, rồi phối hợp người sở hữu BE.
- Đọc đúng response thực tế và dùng đúng property; chỉ fallback giữa các key khi API có quy định như vậy. Không nuốt lỗi bằng mảng rỗng khiến lỗi server bị hiểu nhầm là không có dữ liệu.
- Với request bất đồng bộ, biểu diễn loading, empty và error theo nhu cầu màn hình; xử lý lỗi Axios và tránh cập nhật trạng thái sau khi component đã bị hủy khi có nguy cơ race.
- Endpoint cần đăng nhập phải dựa trên cơ chế auth đang có (`services/auth.js`, router guard và interceptor); không tự gửi user ID/role do client cung cấp để thay danh tính đã xác thực.

## Router, component và dữ liệu
- Khi thêm trang: tạo view dưới `src/views/`, đăng ký route trong `src/router/index.js`, dùng `router-link`/router hiện có. Vì router là file dùng chung, phải phối hợp quyền sở hữu trước khi sửa đồng thời.
- Tái sử dụng component/service hiện có nếu phù hợp; không nhồi logic màn hình không liên quan vào `App.vue`.
- Dùng `:key` ổn định cho `v-for`, kiểm tra dữ liệu trước khi render và giữ xử lý form/loading/error trong phạm vi feature.
- Không thay đổi cách lưu token, điều hướng 401, base URL hoặc interceptor trong `services/api.js` trừ khi task trực tiếp yêu cầu; các thay đổi này ảnh hưởng toàn ứng dụng và phải được xác nhận trong task.

## Giao thức phối hợp để tránh xung đột
1. Trước khi làm, nêu file/phạm vi mình sở hữu và xác nhận không có người khác đang sửa cùng vùng. Kiểm tra `git status` và diff liên quan; không xóa hoặc hấp thụ thay đổi chưa rõ chủ sở hữu.
2. Với task FE-BE, thống nhất contract trước; chia ownership theo phía/file. Không để hai người cùng chỉnh một file. Nếu cần đổi file dùng chung, chỉ định một owner hoặc thực hiện tuần tự.
3. Nếu yêu cầu mới xung đột với code/contract hiện có, dừng đúng phần xung đột, mô tả bằng chứng và thống nhất quyết định; không âm thầm đổi API.
4. Khi kết thúc, báo file đã sửa, contract đã dùng, thay đổi nào cần BE/FE tiếp tục và lệnh kiểm tra đã chạy. Không tuyên bố kiểm tra pass nếu chưa chạy.

## Kiểm tra trước khi bàn giao
- Chạy `npm run build` trong `FE/` sau khi sửa. Dự án hiện không khai báo test script; không bịa ra test command.
- Kiểm tra diff để chắc không có file ngoài phạm vi, secret, URL môi trường cứng hoặc thay đổi contract ngoài ý muốn.