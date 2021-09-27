-- database backup - 2021-08-15 09:05:34
SET NAMES utf8;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
SET foreign_key_checks = 0;
SET AUTOCOMMIT = 0;
START TRANSACTION;
DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `clients` VALUES('1','client1','client1 description','client1 address','1','2021-08-13 01:35:42','2021-08-13 01:35:42');
DROP TABLE IF EXISTS `device`;

CREATE TABLE `device` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `device_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  `timestamp_registered` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eMail_of_admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `configuration` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_up_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_down_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_heartbeat_minutes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp_last_accessed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address_of_last_access` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `device` VALUES('1','device1','1','1','2021-08-13 03:40:17','','teadfa dsfa dsa dsa','','','','2021-08-13 03:40:17','127.0.0.1','2021-08-13 03:40:17','2021-08-15 06:31:03','fa fd afd saf dsa fdsa dsa fds\na fds\n fd\nsa fd\nsa \ndsa dsa fdsa fdsa dsa dsa fdsafdafd a dsafdsa fds a\nfdsafda fdsa da fda fdsa fdsa fdsa fda afdfd adfs');
DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
DROP TABLE IF EXISTS `flow_entries`;

CREATE TABLE `flow_entries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `flow_id` bigint(20) unsigned DEFAULT NULL,
  `flow_entriable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flow_entriable_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` int(11) DEFAULT NULL,
  `sequence` int(11) NOT NULL DEFAULT 0,
  `run_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `run_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dates` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `flow_entries_flow_id_foreign` (`flow_id`),
  KEY `flow_entries_user_id_foreign` (`user_id`),
  CONSTRAINT `flow_entries_flow_id_foreign` FOREIGN KEY (`flow_id`) REFERENCES `flows` (`id`) ON DELETE CASCADE,
  CONSTRAINT `flow_entries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `flow_entries` VALUES('1','1','App\\Schedule','schedule1','5','1','12.08.2021','15.08.2021','13.08.2021,14.08.2021','2','2021-08-13 02:19:40','2021-08-13 02:19:40');
INSERT INTO `flow_entries` VALUES('3','1','App\\Site','1','10','2','13.08.2021','20.08.2021','18.08.2021','2','2021-08-13 02:32:41','2021-08-13 02:32:41');
INSERT INTO `flow_entries` VALUES('4','1','App\\Gallery','1','','3','13.08.2021','14.08.2021','12.08.2021,13.08.2021,14.08.2021','2','2021-08-13 04:42:45','2021-08-13 04:42:45');
DROP TABLE IF EXISTS `flows`;

CREATE TABLE `flows` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `flows_name_unique` (`name`),
  KEY `flows_user_id_foreign` (`user_id`),
  CONSTRAINT `flows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `flows` VALUES('1','flow1','flow1 description','','2','2021-08-13 02:17:25','2021-08-13 02:17:25');
DROP TABLE IF EXISTS `galleries`;

CREATE TABLE `galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `galleries_name_unique` (`name`),
  KEY `galleries_user_id_foreign` (`user_id`),
  CONSTRAINT `galleries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `galleries` VALUES('1','gallery1','uYJ4zY1ULHwS3x2aA','','2','2021-08-13 02:20:39','2021-08-13 02:20:39');
DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `images_name_unique` (`name`),
  KEY `images_user_id_foreign` (`user_id`),
  CONSTRAINT `images_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `images` VALUES('1','image1','','images/k7w0jjR4Y97hnGrNkdODvxYZczcuKYVah20eLqpK.png','2','2021-08-13 01:32:00','2021-08-13 01:32:00');
INSERT INTO `images` VALUES('2','image2','','images/BxOg5ejnRoeQB8LsLImdFHna8VT8l24zToZlfSL9.png','2','2021-08-13 01:32:14','2021-08-13 01:32:14');
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `migrations` VALUES('1','2013_07_16_084007_create_clients_table','1');
INSERT INTO `migrations` VALUES('2','2014_10_12_000000_create_users_table','1');
INSERT INTO `migrations` VALUES('3','2014_10_12_100000_create_password_resets_table','1');
INSERT INTO `migrations` VALUES('4','2019_08_19_000000_create_failed_jobs_table','1');
INSERT INTO `migrations` VALUES('5','2021_07_07_174153_create_images_table','1');
INSERT INTO `migrations` VALUES('6','2021_07_08_145751_create_flows_table','1');
INSERT INTO `migrations` VALUES('7','2021_07_08_154929_create_galleries_table','1');
INSERT INTO `migrations` VALUES('8','2021_07_08_161057_create_sites_table','1');
INSERT INTO `migrations` VALUES('9','2021_07_08_161158_create_schedules_table','1');
INSERT INTO `migrations` VALUES('10','2021_07_08_183320_create_flow_entries_table','1');
INSERT INTO `migrations` VALUES('11','2021_07_09_113759_create_device_table','1');
INSERT INTO `migrations` VALUES('12','2021_07_26_092943_create_sync_google_images_table','1');
DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
DROP TABLE IF EXISTS `schedules`;

CREATE TABLE `schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('kids','adults','general') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_image_id_foreign` (`image_id`),
  KEY `schedules_user_id_foreign` (`user_id`),
  CONSTRAINT `schedules_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE SET NULL,
  CONSTRAINT `schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `schedules` VALUES('1','13.08.2021','04:32','schedule1','adults','block1 line1','block1 line2','block1 line3','1','2','2021-08-13 01:33:38','2021-08-13 01:33:38');
INSERT INTO `schedules` VALUES('2','13.08.2021','04:34','schedule1','adults','block2 line1','block2 line2','block2 line3','2','2','2021-08-13 01:34:33','2021-08-13 01:34:33');
INSERT INTO `schedules` VALUES('3','15.08.2021','12:00','schedule1','adults','1','','','2','2','2021-08-15 05:54:30','2021-08-15 05:54:30');
INSERT INTO `schedules` VALUES('4','15.08.2021','08:09','schedule1','kids','kk','','','1','2','2021-08-15 05:55:05','2021-08-15 05:55:05');
INSERT INTO `schedules` VALUES('5','15.08.2021','09:09','schedule1','kids','jjjjj','','','1','2','2021-08-15 05:55:34','2021-08-15 05:55:34');
INSERT INTO `schedules` VALUES('6','15.08.2021','11:08','schedule1','kids','fk','','','2','2','2021-08-15 05:56:03','2021-08-15 05:56:03');
DROP TABLE IF EXISTS `sites`;

CREATE TABLE `sites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sites_name_unique` (`name`),
  KEY `sites_user_id_foreign` (`user_id`),
  CONSTRAINT `sites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `sites` VALUES('1','site1','https://pfarrei.info/pfiffig/pages/pfarrblatt.do?g=br&xsl=6&d=2','','2','2021-08-13 02:32:19','2021-08-13 02:32:19');
DROP TABLE IF EXISTS `sync_google_images`;

CREATE TABLE `sync_google_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gallery_id` bigint(20) unsigned NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sync_google_images_gallery_id_foreign` (`gallery_id`),
  CONSTRAINT `sync_google_images_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `sync_google_images` VALUES('1','1','https://lh3.googleusercontent.com/MUGSL1jha7P8-QRj61iAkY1q32uf0MbJ09LDcOZxI548I9sF4aI1r2LX40HQsphwtUZNCGfFRkHf29LKm_D-rj8_d2zOPWG6ottfCM2SDQ-yCBjelDJ9Rit_d-Z_MT2tu5KfF8Q_lEI=w1920-h1080-no','Patrozinium St. Josef am 01. Mai (Fotos: Annette Göring)','2021-08-13 02:25:02','2021-08-13 02:25:02');
INSERT INTO `sync_google_images` VALUES('2','1','https://lh3.googleusercontent.com/Zpvf5XztinmCLfCxxY_soZAozrF_zaRyPksZWN7r_9UG5hy8PZeP8ukjpTFHGefoP_Wdyyo0Nb17o3S_nzoKVWt8RsnBUIAyRiyYt-HqPsPayaTUTZdQr4_Tno9dzEjfNNoi408WeqA=w1920-h1080-no','Patrozinium St. Josef am 01. Mai (Fotos: Annette Göring)','2021-08-13 02:25:02','2021-08-13 02:25:02');
INSERT INTO `sync_google_images` VALUES('3','1','https://lh3.googleusercontent.com/Jlds2VDIsyU8oglXYd-I2cBmoona1uxbAbYAS_DS08-IHaGdSaiykgNEheJcfQ8HEeMw4usnshN4wiNmwJJdWLeJZbKs3tO4jtSBoplZPQcmQ3KE3oXeAQyVxaVcBDykvjDVJRKxsA4=w1920-h1080-no','Patrozinium St. Josef am 01. Mai (Fotos: Annette Göring)','2021-08-13 02:25:03','2021-08-13 02:25:03');
INSERT INTO `sync_google_images` VALUES('4','1','https://lh3.googleusercontent.com/LklUnCQMU_4a_plsDBYWvLYMLK_-lVoz6bLbkwLwNUB205gVCcozQZn2B8St8Z5hoRAzaelaTX-NWfAkY7yxWh6OGWVmZh1Pv5XnGCLf6AG8t_MtG_YTTuRnNBAPOcDL4S-SW8keo_c=w1920-h1080-no','Patrozinium St. Josef am 01. Mai (Fotos: Annette Göring)','2021-08-13 02:25:03','2021-08-13 02:25:03');
INSERT INTO `sync_google_images` VALUES('5','1','https://lh3.googleusercontent.com/qa6K90m9KrzlKKFh_wsQOUpSKTeYQlKXDCXOEuplI2IYpnWTBUs19fp7QIJNVt81zhzi0t5FCi2ArRDGjFrPm5wYu6OF0hijBGE5-uCPAzvUO7JhAyyUNc-0ISne5g4BE_5L9fICCAA=w1920-h1080-no','Patrozinium St. Josef am 01. Mai (Fotos: Annette Göring)','2021-08-13 02:25:03','2021-08-13 02:25:03');
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `type` enum('super_admin','admin','user') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatars/default.png',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  KEY `users_client_id_foreign` (`client_id`),
  CONSTRAINT `users_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `users` VALUES('1','super_admin@gmail.com','super','admin','super_admin','','11111111111','0','0','super_admin','$2y$10$t//ioASLQymheUKNCnHTj.jh.Kk4iqxXmi6JPfPOdUyXm2uuKS78W','','','avatars/default.png','','','');
INSERT INTO `users` VALUES('2','admin@gmail.com','alexei','volkov','admin','','111','0','1','admin','$2y$10$02XhNbv4NR0V/Cr2U6AXfOumVHvYIz65YLOQmx/i.OuN3KMna2LJ6','','1','avatars/default.png','','2021-08-13 01:23:25','2021-08-13 01:23:25');


COMMIT;