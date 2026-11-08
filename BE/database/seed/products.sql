USE `du-an-1`;

UPDATE `products`
SET `view_count` = GREATEST(`view_count`, 850 + `id` * 137),
    `sales_count` = GREATEST(`sales_count`, 17 + `id` * 11);

INSERT INTO `product_images` (`product_id`, `image_path`, `sort_order`)
SELECT `products`.`id`, `products`.`image`, 1
FROM `products`
WHERE `products`.`image` IS NOT NULL
  AND TRIM(`products`.`image`) <> ''
  AND NOT EXISTS (
    SELECT 1
    FROM `product_images`
    WHERE `product_images`.`product_id` = `products`.`id`
      AND `product_images`.`image_path` = `products`.`image`
  );