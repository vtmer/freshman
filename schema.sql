DROP TABLE IF EXISTS `fm_users_roles`;
DROP TABLE IF EXISTS `fm_user_metas`;
DROP TABLE IF EXISTS `fm_post_metas`;
DROP TABLE IF EXISTS `fm_posts_categories`;
DROP TABLE IF EXISTS `fm_roles_permissions`;
DROP TABLE IF EXISTS `fm_posts_tags`;
DROP TABLE IF EXISTS `fm_categories`;
DROP TABLE IF EXISTS `fm_tags`;
DROP TABLE IF EXISTS `fm_sessions`;
DROP TABLE IF EXISTS `fm_permissions`;
DROP TABLE IF EXISTS `fm_roles`;
DROP TABLE IF EXISTS `fm_posts`;
DROP TABLE IF EXISTS `fm_users`;
CREATE TABLE `fm_users` (
	`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`login_name` varchar(50),
	`display_name` varchar(50),
	`password` varchar(64),
        `active` TINYINT(1),
        UNIQUE KEY `login_name` (`login_name`),
        UNIQUE KEY `display_name` (`display_name`)
);
CREATE TABLE `fm_roles` (
	`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`name` varchar(255),
        UNIQUE KEY `name` (`name`)
);
CREATE TABLE `fm_permissions` (
	`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`pattern` varchar(255),
        UNIQUE KEY `pattern` (`pattern`)
);
CREATE TABLE `fm_users_roles` (
	`user_id` int,
	`role_id` int,
	FOREIGN KEY(`user_id`) REFERENCES `fm_users` (`id`),
	FOREIGN KEY(`role_id`) REFERENCES `fm_roles` (`id`)
);
CREATE TABLE `fm_roles_permissions` (
	`role_id` int,
	`permission_id` int,
	FOREIGN KEY(`role_id`) REFERENCES `fm_roles` (`id`),
	FOREIGN KEY(`permission_id`) REFERENCES `fm_permissions` (`id`)
);
CREATE TABLE `fm_posts` (
	`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`title` varchar(500) NOT NULL,
	`content` varchar(100000) NOT NULL,
	`source` varchar(255) DEFAULT '',      /* 来源 */
	`author_id` int,
	`created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`status` int NOT NULL DEFAULT '0',
	FOREIGN KEY(`author_id`) REFERENCES `fm_users` (`id`)
);
CREATE TABLE `fm_tags` (
	`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
        UNIQUE KEY `name` (`name`)
);
CREATE TABLE `fm_posts_tags` (
	`post_id` int,
	`tag_id` int,
	FOREIGN KEY(`post_id`) REFERENCES `fm_posts` (`id`),
	FOREIGN KEY(`tag_id`) REFERENCES `fm_tags` (`id`)
);
CREATE TABLE `fm_categories` (
	`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
        UNIQUE KEY `name` (`name`)
);
CREATE TABLE `fm_posts_categories` (
	`post_id` int,
	`category_id` int,
	FOREIGN KEY(`post_id`) REFERENCES `fm_posts` (`id`),
	FOREIGN KEY(`category_id`) REFERENCES `fm_categories` (`id`)
);
CREATE TABLE `fm_post_metas` (
	`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`key` varchar(1000) NOT NULL,
	`value` varchar(1000) NOT NULL,
	`post_id` int,
	FOREIGN KEY(`post_id`) REFERENCES `fm_posts` (`id`)
);
CREATE TABLE `fm_user_metas` (
	`id` int PRIMARY KEY,
	`key` varchar(1000),
	`value` varchar(1000),
	`user_id` int,
	FOREIGN KEY(`user_id`) REFERENCES `fm_users` (`id`)
);
CREATE TABLE `fm_sessions` (
	`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`key` varchar(64) NOT NULL,
	`user_id` int,
	FOREIGN KEY(`user_id`) REFERENCES `fm_users` (`id`),
        UNIQUE KEY `key` (`key`)
);
