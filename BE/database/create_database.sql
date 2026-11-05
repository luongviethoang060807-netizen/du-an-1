CREATE DATABASE IF NOT EXISTS `du-an-1`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `du-an-1`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL COMMENT 'Store password_hash() output, never plaintext',
  `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  `is_active` TINYINT(1) NOT NULL DEFAULT 0,
  `verification_token` CHAR(64) DEFAULT NULL,
  `password_reset_token` CHAR(64) DEFAULT NULL,
  `password_reset_expires_at` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_email` (`email`),
  UNIQUE KEY `uq_users_verification_token` (`verification_token`),
  UNIQUE KEY `uq_users_password_reset_token` (`password_reset_token`),
  KEY `idx_users_is_active` (`is_active`)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

INSERT IGNORE INTO `users` (`email`, `password`, `role`, `is_active`) VALUES
  ('admin@example.com', '$2y$10$066QrkY05hFMkGFLja.0w.fx8Twdc2CZcZ.JYCqHVm2rZUiEn2mum', 'admin', 1),
  ('user@example.com', '$2y$10$B5Bj./l3dPpVz1WrlGv8B.MJV8sYJid9n4QczriMjSjMDa5J8qwPS', 'user', 1);

UPDATE `users`
SET `password` = '$2y$10$066QrkY05hFMkGFLja.0w.fx8Twdc2CZcZ.JYCqHVm2rZUiEn2mum'
WHERE `email` = 'admin@example.com' AND `password` = '123456';

UPDATE `users`
SET `password` = '$2y$10$B5Bj./l3dPpVz1WrlGv8B.MJV8sYJid9n4QczriMjSjMDa5J8qwPS'
WHERE `email` = 'user@example.com' AND `password` = '123456';

CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_categories_slug` (`slug`)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `category_id` INT NOT NULL,
  `code` VARCHAR(100) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `sale_price` DECIMAL(10,2) DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `stock` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_products_code` (`code`),
  UNIQUE KEY `uq_products_slug` (`slug`),
  CONSTRAINT `fk_products_category`
    FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

INSERT IGNORE INTO `categories` (`name`, `slug`) VALUES
  ('Gel, Sáp vuốt tóc', 'gel-sap-vuot-toc'),
  ('Dưỡng tóc', 'duong-toc');

INSERT IGNORE INTO `products`
  (`category_id`, `code`, `name`, `slug`, `price`, `sale_price`, `image`, `description`, `stock`)
SELECT `categories`.`id`, 'CLAYMATION', 'Sáp Vuốt Tóc Hanz de Fuko Claymation',
  'sap-vuot-toc-hanz-de-fuko-claymation', 480000, 450000, 'claymation.jpg',
  'Sáp giữ nếp cực cao, không bóng, tạo độ phồng tự nhiên.', 50
FROM `categories` WHERE `categories`.`slug` = 'gel-sap-vuot-toc';

INSERT IGNORE INTO `products`
  (`category_id`, `code`, `name`, `slug`, `price`, `sale_price`, `image`, `description`, `stock`)
SELECT `categories`.`id`, 'GOT2B-GLUED', 'Gel Vuốt Tóc Got2b Glued Spiking Wax',
  'gel-vuot-toc-got2b-glued-spiking-wax', 250000, NULL, 'got2b.jpg',
  'Gel định hình kiểu tóc siêu cứng suốt cả ngày.', 30
FROM `categories` WHERE `categories`.`slug` = 'gel-sap-vuot-toc';

INSERT IGNORE INTO `products`
  (`category_id`, `code`, `name`, `slug`, `price`, `sale_price`, `image`, `description`, `stock`)
SELECT `categories`.`id`, 'MOROCCANOIL', 'Tinh Dầu Dưỡng Tóc Moroccanoil Treatment',
  'tinh-dau-duong-toc-moroccanoil-treatment', 750000, 720000, 'moroccanoil.jpg',
  'Phục hồi tóc hư tổn, tăng độ bóng mượt và chắc khỏe.', 25
FROM `categories` WHERE `categories`.`slug` = 'duong-toc';

INSERT IGNORE INTO `products`
  (`category_id`, `code`, `name`, `slug`, `price`, `sale_price`, `image`, `description`, `stock`)
SELECT `categories`.`id`, 'COCOON-BUOI', 'Xịt Dưỡng Tóc Bưởi Cocoon',
  'xit-duong-toc-buoi-cocoon', 145000, NULL, 'cocoon.jpg',
  'Giảm gãy rụng và kích thích mọc tóc tự nhiên.', 100
FROM `categories` WHERE `categories`.`slug` = 'duong-toc';
