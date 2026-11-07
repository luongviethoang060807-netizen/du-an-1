<!-- hoang -->

<?php

class CategoryController
{
    private Category $category;

    public function __construct()
    {
        $this->category = new Category();
    }

    public function index()
    {
        $categories = $this->category->getAllCategories();

        response_json([
            'status' => 'success',
            'categories' => $categories
        ]);
    }
}