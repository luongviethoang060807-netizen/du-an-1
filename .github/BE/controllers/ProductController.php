<?php
class ProductController{
    private Product $product;
    public function __construct()
    {
        $this->product = new Product();
    }

    public function index(){
        $search = $_GET['search'] ?? $_GET['q'] ?? '';
        $categoryId = $_GET['category_id'] ?? $_GET['categoryId'] ?? null;
        $page = $_GET['page'] ?? 1;
        $perPage = $_GET['per_page'] ?? $_GET['perPage'] ?? 8;

        $products = $this->product->getFiltered(
            $search,
            $categoryId,
            $page,
            $perPage
        );

        response_json([
            'status' => 'success',
            'products' => $products,
            'filters' => [
                'search' => $search,
                'category_id' => $categoryId,
                'page' => $page,
                'per_page' => $perPage,
            ],
        ]);
    }

    //test mock data

    public function camChim(){
        $camChims = [
            [
                'id' => 1,
                'name' => 'Trần Hà Linh',
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRWRUgFJDVfIftWG6y8iggQuPYJSg0kP8FpqSuxMKGu4OD708czJy5mX9gF&s=10'
            ],
            [
                'id' => 2,
                'name' => 'Linh Tây',
                'image' => 'https://benhvienthammysiamthailand.vn/wp-content/uploads/2024/04/1-copy-7-1.jpg'  
            ]
        ];
        response_json([
            'status' => 'success',
            'camChims' => $camChims
        ]);
    }

}