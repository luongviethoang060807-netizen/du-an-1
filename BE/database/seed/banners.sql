USE `du-an-1`;

INSERT INTO `banners` (`title`, `image`, `content`, `CTA_link`)
SELECT 'Chăm sóc tóc mỗi ngày', NULL,
  'Khám phá sản phẩm chăm sóc tóc phù hợp với nhu cầu của bạn.', '/catalog'
WHERE NOT EXISTS (
  SELECT 1 FROM `banners`
  WHERE `title` = 'Chăm sóc tóc mỗi ngày' AND `CTA_link` = '/catalog'
);

INSERT INTO `banners` (`title`, `image`, `content`, `CTA_link`)
SELECT 'Định hình phong cách riêng', NULL,
  'Chọn sáp và gel vuốt tóc để hoàn thiện kiểu tóc bạn yêu thích.',
  '/catalog?category_slug=gel-sap-vuot-toc'
WHERE NOT EXISTS (
  SELECT 1 FROM `banners`
  WHERE `title` = 'Định hình phong cách riêng'
    AND `CTA_link` = '/catalog?category_slug=gel-sap-vuot-toc'
);

INSERT INTO `banners` (`title`, `image`, `content`, `CTA_link`)
SELECT 'Nuôi dưỡng mái tóc khỏe', NULL,
  'Tìm sản phẩm dưỡng tóc giúp chăm sóc mái tóc từ gốc đến ngọn.',
  '/catalog?category_slug=duong-toc'
WHERE NOT EXISTS (
  SELECT 1 FROM `banners`
  WHERE `title` = 'Nuôi dưỡng mái tóc khỏe'
    AND `CTA_link` = '/catalog?category_slug=duong-toc'
);