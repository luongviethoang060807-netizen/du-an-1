<?php
class BannerController
{
    private Banner $banner;

    public function __construct()
    {
        $this->banner = new Banner();
    }

    public function index()
    {
        response_json([
            'status' => 'success',
            'banners' => $this->banner->getAllBanners(),
        ]);
    }
}