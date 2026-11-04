<?php

class PostController{

    public function index(){
        // Mock data cho blog / bài viết của website cắt tóc nam nghệ thuật
        $posts = [
            [
                'id' => 1,
                'title' => 'Fade Undercut Nam Đậm Chất Thời Trang 2026',
                'slug' => 'fade-undercut-nam-dam-chat-thoi-trang-2026',
                'excerpt' => 'Kiểu tóc fade undercut mang lại vẻ nam tính, gọn gàng nhưng vẫn cực kỳ hiện đại.',
                'content' => 'Fade undercut là lựa chọn yêu thích của nhiều người trẻ muốn có vẻ ngoài lịch lãm và năng động. Kỹ thuật cắt tỉa lớp trên và các góc cạnh tinh tế giúp tạo điểm nhấn cho khuôn mặt. Kết hợp với chăm sóc tóc đúng cách, kiểu tóc này sẽ giữ được độ dày và hình dáng lâu hơn.',
                'author' => 'Master Duy',
                'category' => 'Phong cách',
                'image' => 'https://images.unsplash.com/photo-1517832606299-7ae9b720a186?auto=format&fit=crop&w=1200&q=80',
                'published_at' => '2026-11-01',
                'views' => 1250,
            ],
            [
                'id' => 2,
                'title' => '5 Lý Do Bạn Nên Cắt Tóc Theo Kiểu Pompadour',
                'slug' => '5-ly-do-ban-nen-cat-toc-theo-kieu-pompadour',
                'excerpt' => 'Pompadour không chỉ đẹp mà còn giúp gương mặt trông cân đối hơn.',
                'content' => 'Pompadour là kiểu tóc nam cổ điển nhưng vẫn rất phù hợp với xu hướng hiện đại. Với phần đỉnh tạo khối và mái mềm, kiểu tóc này giúp tạo sự chắc chắn cho tổng thể diện mạo. Nếu bạn muốn diện sắc sảo mà không quá cầu kỳ, đây là một lựa chọn cực đáng thử.',
                'author' => 'Stylist Huy',
                'category' => 'Xu hướng',
                'image' => 'https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?auto=format&fit=crop&w=1200&q=80',
                'published_at' => '2026-10-28',
                'views' => 980,
            ],
            [
                'id' => 3,
                'title' => 'Cắt Tóc Sát Nách Có Nên Dùng Không? Cách Chọn Phù Hợp Khuôn Mặt',
                'slug' => 'cat-toc-sat-nach-co-nen-dung-khong',
                'excerpt' => 'Kiểu tóc sát nách phù hợp với những ai thích sự mạnh mẽ và góc cạnh.',
                'content' => 'Kiểu tóc sát nách mang lại cảm giác nam tính và thể hiện phong cách cá nhân rõ nét. Tuy nhiên, để phù hợp với khuôn mặt và phong cách sống, cần cân nhắc độ dài, độ dày và phương pháp tạo kiểu. Một barber chuyên nghiệp sẽ giúp bạn điều chỉnh sao cho chiếc tóc vừa tôn dáng vừa bền đẹp.',
                'author' => 'Master Sơn',
                'category' => 'Tư vấn',
                'image' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?auto=format&fit=crop&w=1200&q=80',
                'published_at' => '2026-10-18',
                'views' => 1430,
            ],
            [
                'id' => 4,
                'title' => 'Chăm Sóc Tóc Sau Khi Cắt: 5 Mẹo Giữ Kiểu Tóc Luôn Chuẩn',
                'slug' => 'cham-soc-toc-sau-khi-cat-5-meo-giu-kieu-toc-luon-chuan',
                'excerpt' => 'Một kiểu tóc đẹp không chỉ phụ thuộc vào thợ cắt mà còn ở cách chăm sóc hằng ngày.',
                'content' => 'Sau khi cắt tóc, việc giữ kiểu tóc đều và bền là điều quan trọng. Nên dùng sữa dưỡng nhẹ, không gội đầu quá nhiều và tạo kiểu bằng sản phẩm vừa đủ. Ngoài ra, lịch cắt tóc định kỳ từ 3-5 tuần sẽ giúp giữ hình dáng luôn sắc nét.',
                'author' => 'Stylist Nam',
                'category' => 'Chăm sóc',
                'image' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1200&q=80',
                'published_at' => '2026-10-12',
                'views' => 870,
            ],
            [
                'id' => 5,
                'title' => 'Phong Cách Buzz Cut: Gọn Gàng, Mạnh Mẽ, Không Lo Mất Thời Gian',
                'slug' => 'phong-cach-buzz-cut-gon-gang-manh-me-khong-lo-mat-thoi-gian',
                'excerpt' => 'Buzz cut là sự lựa chọn lý tưởng cho người thích sự đơn giản nhưng vẫn nổi bật.',
                'content' => 'Buzz cut tạo cảm giác mạnh mẽ, trẻ trung và rất dễ chăm sóc. Dù đơn giản, kiểu tóc này lại mang lại sự tự tin và phù hợp với nhiều hoàn cảnh. Nếu bạn muốn tiết kiệm thời gian nhưng vẫn giữ được phong cách chuyên nghiệp, đây là một gợi ý tuyệt vời.',
                'author' => 'Master Anh',
                'category' => 'Phong cách',
                'image' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=1200&q=80',
                'published_at' => '2026-09-30',
                'views' => 2120,
            ],
        ];

        response_json([
            'status' => 'success',
            'posts' => $posts
        ]);
    }

}