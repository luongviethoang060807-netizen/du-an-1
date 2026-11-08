<?php
/** Controller xử lý API đọc bình luận sản phẩm. */
class CommentController
{
    private Comment $comment;

    /** Khởi tạo model truy cập bảng comments. */
    public function __construct()
    {
        $this->comment = new Comment();
    }

    /**
     * Trả về bình luận theo slug sản phẩm, có phân trang và không yêu cầu đăng nhập.
     * Thiếu dữ liệu hợp lệ trả HTTP 400; không có sản phẩm trả HTTP 404.
     *
     * @return void
     */
    public function byProductSlug(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'GET') {
            response_json(['status' => 'error', 'message' => 'Phương thức không được hỗ trợ'], 405);
        }

        $slug = $_GET['slug'] ?? null;
        if (!is_string($slug) || trim($slug) === '' || strlen(trim($slug)) > 255) {
            response_json(['status' => 'error', 'message' => 'Slug sản phẩm không hợp lệ'], 400);
        }

        $pageInput = $_GET['page'] ?? '1';
        $perPageInput = $_GET['per_page'] ?? '10';
        $page = is_string($pageInput) && ctype_digit($pageInput) ? (int) $pageInput : 0;
        $perPage = is_string($perPageInput) && ctype_digit($perPageInput) ? (int) $perPageInput : 0;

        if ($page < 1 || $perPage < 1 || $perPage > 100 || ($page - 1) > intdiv(PHP_INT_MAX, $perPage)) {
            response_json(['status' => 'error', 'message' => 'Thông tin phân trang không hợp lệ'], 400);
        }

        $comments = $this->comment->getByProductSlug(trim($slug), $page, $perPage);
        if ($comments === null) {
            response_json(['status' => 'error', 'message' => 'Không tìm thấy sản phẩm'], 404);
        }

        response_json([
            'status' => 'success',
            'comments' => $comments,
        ]);
    }
}