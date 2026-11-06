<!-- dựng thêm 1 api lấy về full danh sách categories từ Database
cả 2 api products và categories đều không cần chặn middleware auth (tức là không bắt người dùng đăng nhập mới xem được danh sách sản phẩm và danh mục) -->


<?php
class Category extends BaseModel
{
    protected $table = 'categories';

    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories ORDER BY id ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}