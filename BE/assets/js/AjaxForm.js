class AjaxForm {
    // Hàm khởi tạo - tương đương __construct() trong PHP
    constructor(formSelector, actionUrl) {
        this.form = document.querySelector(formSelector);
        this.url = actionUrl;
        this.errors = {}; // Mảng chứa lỗi giống như $errors = [] trong PHP

        if (this.form) {
            this.registerEvent();
        }
    }

    // Đăng ký sự kiện submit form
    registerEvent() {
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.clearErrors();
            this.submit();
        });
    }

    // Hàm dọn dẹp lỗi cũ trước khi gửi request
    clearErrors() {
        this.errors = {};
        this.form.querySelectorAll('.error-msg').forEach(el => el.innerText = '');
    }

    // Hàm xử lý gửi dữ liệu - tương đương với logic Fetch/CURL
    submit() {
        // Gom dữ liệu từ form (tương tự $_POST và $_FILES)
        const formData = new FormData(this.form);

        fetch(this.url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Kiểm tra trạng thái trả về giống cách check mảng trong PHP
            if (data.status === 'success') {
                this.onSuccess(data);
            } else if (data.status === 'error') {
                this.errors = data.errors; // Gán mảng lỗi từ PHP về class JS
                this.renderErrors();
            }
        })
        .catch(err => {
            console.error('Lỗi kết nối Server:', err);
        });
    }

    // Hàm tự động "đổ" lỗi ra giao diện dựa trên Key của mảng
    renderErrors() {
        // Vòng lặp foreach quen thuộc để duyệt mảng lỗi
        for (let key in this.errors) {
            const errorElement = this.form.querySelector(`.error-${key}`);
            if (errorElement) {
                errorElement.innerText =`[error]: ${this.errors[key]}`;
            }else {
                // Thêm dòng này để cảnh báo ngay trong Console nếu bạn gõ sai class ở HTML
                console.warn(`Cảnh báo: Không tìm thấy thẻ hiển thị lỗi cho trường [.error-${key}]`);
            }
        }
    }

    // Hàm này sẽ được "Override" (ghi đè) ở từng trang giống như kế thừa class
    onSuccess(response) {
        alert(response.message || 'Thao tác thành công!');
    }

   
}
