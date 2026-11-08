USE `du-an-1`;

INSERT INTO `comments` (`product_id`, `user_id`, `content`)
SELECT `products`.`id`, `users`.`id`, 'Sản phẩm dùng ổn, đúng như mô tả.'
FROM `products`
JOIN `users` ON `users`.`email` = 'user@example.com'
WHERE `products`.`code` = 'CLAYMATION'
  AND NOT EXISTS (
    SELECT 1
    FROM `comments`
    WHERE `comments`.`product_id` = `products`.`id`
      AND `comments`.`user_id` = `users`.`id`
      AND `comments`.`content` = 'Sản phẩm dùng ổn, đúng như mô tả.'
  );

INSERT INTO `comments` (`product_id`, `user_id`, `content`)
SELECT `products`.`id`, `users`.`id`, 'Giữ nếp tốt, sẽ tiếp tục sử dụng.'
FROM `products`
JOIN `users` ON `users`.`email` = 'user@example.com'
WHERE `products`.`code` = 'GOT2B-GLUED'
  AND NOT EXISTS (
    SELECT 1
    FROM `comments`
    WHERE `comments`.`product_id` = `products`.`id`
      AND `comments`.`user_id` = `users`.`id`
      AND `comments`.`content` = 'Giữ nếp tốt, sẽ tiếp tục sử dụng.'
  );

INSERT INTO `comments` (`product_id`, `user_id`, `content`)
SELECT `products`.`id`, `users`.`id`, 'Mùi hương dễ chịu và tóc mềm hơn.'
FROM `products`
JOIN `users` ON `users`.`email` = 'user@example.com'
WHERE `products`.`code` = 'MOROCCANOIL'
  AND NOT EXISTS (
    SELECT 1
    FROM `comments`
    WHERE `comments`.`product_id` = `products`.`id`
      AND `comments`.`user_id` = `users`.`id`
      AND `comments`.`content` = 'Mùi hương dễ chịu và tóc mềm hơn.'
  );

INSERT INTO `comments` (`product_id`, `user_id`, `content`)
SELECT `products`.`id`, `users`.`id`, 'Dùng đều đặn thấy tóc ít khô xơ hơn.'
FROM `products`
JOIN `users` ON `users`.`email` = 'user@example.com'
WHERE `products`.`code` = 'COCOON-BUOI'
  AND NOT EXISTS (
    SELECT 1
    FROM `comments`
    WHERE `comments`.`product_id` = `products`.`id`
      AND `comments`.`user_id` = `users`.`id`
      AND `comments`.`content` = 'Dùng đều đặn thấy tóc ít khô xơ hơn.'
  );