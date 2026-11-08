USE `du-an-1`;

CREATE TABLE IF NOT EXISTS `product_images` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` INT NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_product_images_product_sort` (`product_id`, `sort_order`),
  CONSTRAINT `fk_product_images_product`
    FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;