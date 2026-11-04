<?php

class GunController{
    public function index(){
        $guns = [
            [
                'id' => 1,
                'name' => 'M4A1',
                'category' => 'Rifle',
                'origin' => 'USA',
                'price' => 3200,
                'stock' => 12,
                'status' => 'Available',
                'description' => 'Súng trường tấn công linh hoạt, phù hợp cho chiến thuật tầm trung.'
            ],
            [
                'id' => 2,
                'name' => 'AK-47',
                'category' => 'Rifle',
                'origin' => 'Russia',
                'price' => 2900,
                'stock' => 18,
                'status' => 'Available',
                'description' => 'Súng trường nổi tiếng với độ bền cao và độ tin cậy trong mọi điều kiện.'
            ],
            [
                'id' => 3,
                'name' => 'Glock 17',
                'category' => 'Pistol',
                'origin' => 'Austria',
                'price' => 850,
                'stock' => 25,
                'status' => 'Available',
                'description' => 'Súng ngắn tiện dụng, dễ thao tác và phổ biến trong thực chiến.'
            ],
            [
                'id' => 4,
                'name' => 'M249 SAW',
                'category' => 'Machine Gun',
                'origin' => 'USA',
                'price' => 9800,
                'stock' => 5,
                'status' => 'Limited',
                'description' => 'Súng máy hạng nặng với khả năng bắn liên tục và công suất lớn.'
            ],
            [
                'id' => 5,
                'name' => 'Desert Eagle',
                'category' => 'Pistol',
                'origin' => 'USA',
                'price' => 1450,
                'stock' => 9,
                'status' => 'Available',
                'description' => 'Súng ngắn mạnh mẽ, phù hợp cho mục đích tầm xa và kiểm soát lực bắn.'
            ]
        ];

        response_json([
            'status' => 'success',
            'guns' => $guns
        ]);
    }
}