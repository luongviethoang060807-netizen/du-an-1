<?php

abstract class BaseController 
{
    /**
     * Hàm render view tập trung
     * @param string $view Tên file view (ví dụ: 'users/home')
     * @param array $data Mảng dữ liệu truyền vào view
     */
    protected function renderView(string $view, array $data = []) 
    {
        // Biến mảng $data thành các biến cục bộ trong view
        // Ví dụ: ['title' => 'Users'] sẽ thành $title = 'Users' trong view
        extract($data);

        // Đảm bảo $view được truyền vào để main.php nhận diện
        // Chúng ta vẫn giữ $view là một biến trong scope của hàm này
        
        // Load layout chính
        require_once PATH_VIEW . 'main.php';
    }
}