<?php


class HomeController extends BaseController{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index(){
        $this->renderView('users/home',[
            'title' => 'Test danh sách User (Chắc có mình Trần Hà Linh :>> )',
            'users'=> $this->user->getAll(),
        ]);
    }

    public function check(){
        $message = "Test API, OKE!";
        response_json([
            'status' => 'success',
            'message' => $message
        ]);
    }

}