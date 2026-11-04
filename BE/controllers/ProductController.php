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

}