CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL,
  `city_id` int NOT NULL,
  `created_at` datetime DEFAULT (now()),
  `updated_at` datetime DEFAULT (now())
);

CREATE TABLE `profile` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `role` ENUM ('customer', 'performer') DEFAULT "customer",
  `rating` float,
  `date_birthday` datetime,
  `biography` varchar(255),
  `avatar` varchar(255),
  `phone` varchar(255),
  `skype` varchar(255),
  `telegram` varchar(255),
  `last_activity` timestamp,
  `updated_at` datetime DEFAULT (now())
);

CREATE TABLE `cities` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `city` varchar(255) NOT NULL
);

CREATE TABLE `categories` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `category` varchar(255) NOT NULL
);

CREATE TABLE `profile_category` (
  `profile_id` int,
  `category_id` int
);

CREATE TABLE `tasks` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `status_id` int DEFAULT 1,
  `cost` int NOT NULL,
  `customer_id` int NOT NULL,
  `performer_id` int,
  `city_id` int,
  `geo_latitude` float,
  `geo_longitude` float,
  `date_limit` timestamp NOT NULL,
  `date_published` datetime,
  `created_at` datetime DEFAULT (now()),
  `updated_at` datetime DEFAULT (now())
);

CREATE TABLE `statuses` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `status` varchar(255) NOT NULL
);

CREATE TABLE `path_files` (
  `task_id` int,
  `path` varchar(255)
);

CREATE TABLE `messages` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `user_id` int NOT NULL,
  `message` varchar(255),
  `created_at` datetime DEFAULT (now())
);

CREATE TABLE `reviews` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `value` int NOT NULL,
  `comment` varchar(255),
  `created_at` datetime DEFAULT (now())
);

CREATE TABLE `responses` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `performer_id` int,
  `value` int,
  `created_at` datetime DEFAULT (now())
);

CREATE TABLE `favorites` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `performer_id` int NOT NULL
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
