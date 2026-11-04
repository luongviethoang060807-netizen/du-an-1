<?php

class User extends BaseModel{
    // khai báo thuộc tính
    protected $table = 'users';
    // lấy ra danh sách sản phẩm
    // public function getAll(){
    //     $sql = "SELECT * FROM {$this->table}";
    //     $stmt = $this->pdo->query($sql);
    //     return $stmt->fetchAll();
    // }

    public function getAll(){
        return [
            'user_1'=> [
                'id' => 1,
                'user_name' => 'Trình Hà Lân',
                'image' => 'default.jpg',
                'created_at' => '6/9/6996'
            ]
        ];
    }
    
}