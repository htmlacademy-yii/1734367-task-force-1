CREATE TABLE `users` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(30) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `city_id` INT(11) UNSIGNED NOT NULL,
    `created_at` DATETIME DEFAULT SYSDATE(),
    `updated_at` DATETIME DEFAULT SYSDATE()
);

CREATE TABLE `profile` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `role` ENUM('customer', 'performer') DEFAULT 'customer',
    `rating` FLOAT,
    `date_birthday` DATETIME,
    `biography` VARCHAR(255),
    `avatar` VARCHAR(255),
    `phone` VARCHAR(20),
    `skype` VARCHAR(50),
    `telegram` VARCHAR(50),
    `last_activity` TIMESTAMP,
    `updated_at` DATETIME DEFAULT SYSDATE()
);

CREATE TABLE `cities` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `city` VARCHAR(30) NOT NULL
);

CREATE TABLE `categories` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `category` VARCHAR(30) NOT NULL
);

CREATE TABLE `profile_category` (
    `profile_id` INT(11) UNSIGNED,
    `category_id` INT(11) UNSIGNED
);

CREATE TABLE `tasks` (
     `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
     `title` VARCHAR(30) NOT NULL,
     `content` VARCHAR(255) NOT NULL,
     `category_id` INT(11) UNSIGNED NOT NULL,
     `status_id` INT(11) UNSIGNED DEFAULT 1,
     `cost` INT(11) UNSIGNED NOT NULL,
     `customer_id` INT(11) UNSIGNED NOT NULL,
     `performer_id` INT(11) UNSIGNED,
     `city_id` INT(11) UNSIGNED,
     `geo_latitude` FLOAT,
     `geo_longitude` FLOAT,
     `date_limit` TIMESTAMP NOT NULL,
     `date_published` TIMESTAMP,
     `created_at` DATETIME DEFAULT SYSDATE(),
     `updated_at` DATETIME DEFAULT SYSDATE()
);

CREATE TABLE `statuses` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `status` VARCHAR(20) NOT NULL
);

CREATE TABLE `path_files` (
    `task_id` INT(11) UNSIGNED,
    `path` VARCHAR(255)
);

CREATE TABLE `messages` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `task_id` INT(11) UNSIGNED NOT NULL,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `message` VARCHAR(255),
    `created_at` DATETIME DEFAULT SYSDATE()
);

CREATE TABLE `reviews` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `task_id` INT(11) UNSIGNED NOT NULL,
    `value` INT(11) NOT NULL,
    `comment` VARCHAR(255),
    `created_at` DATETIME DEFAULT SYSDATE()
);

CREATE TABLE `responses` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `task_id` INT(11) UNSIGNED NOT NULL,
    `performer_id` INT(11) UNSIGNED,
    `value` INT(11),
    `created_at` DATETIME DEFAULT SYSDATE()
);

CREATE TABLE `favorites` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT(11) UNSIGNED NOT NULL,
    `performer_id` INT(11) UNSIGNED NOT NULL
);

ALTER TABLE `profile` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

ALTER TABLE `profile_category` ADD FOREIGN KEY (`category_id`) REFERENCES `profile` (`id`);

ALTER TABLE `profile_category` ADD FOREIGN KEY (`profile_id`) REFERENCES `categories` (`id`);

ALTER TABLE `tasks` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

ALTER TABLE `tasks` ADD FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`);

ALTER TABLE `tasks` ADD FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

ALTER TABLE `tasks` ADD FOREIGN KEY (`performer_id`) REFERENCES `users` (`id`);

ALTER TABLE `tasks` ADD FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

ALTER TABLE `path_files` ADD FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`);

ALTER TABLE `messages` ADD FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`);

ALTER TABLE `messages` ADD FOREIGN KEY (`user_id`) REFERENCES `tasks` (`customer_id`);

ALTER TABLE `messages` ADD FOREIGN KEY (`user_id`) REFERENCES `tasks` (`performer_id`);

ALTER TABLE `reviews` ADD FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`);

ALTER TABLE `responses` ADD FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`);

ALTER TABLE `responses` ADD FOREIGN KEY (`performer_id`) REFERENCES `users` (`id`);

ALTER TABLE `favorites` ADD FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

ALTER TABLE `favorites` ADD FOREIGN KEY (`performer_id`) REFERENCES `users` (`id`);
