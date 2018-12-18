CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` VARCHAR(128) NOT NULL,
  `name` VARCHAR(128) NOT NULL,
  `password` VARCHAR(128) DEFAULT NULL,
  `photo_path` VARCHAR(255) DEFAULT NULL,
  `contacts` VARCHAR(512),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

CREATE TABLE `lots` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255),
  `photo_path` VARCHAR(255) NOT NULL,
  `start_price` int(10) unsigned NOT NULL,
  `end_date` datetime NOT NULL,
  `bid_step` int(11) unsigned NOT NULL,
  `author` int(10) unsigned NOT NULL,
  `winner` int(10) unsigned DEFAULT NULL,
  `category` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  FOREIGN KEY (`winner`) REFERENCES `users` (`id`),
  FOREIGN KEY (`category`) REFERENCES `categories` (`id`)
);

CREATE TABLE `bid` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `set_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` int(10) unsigned NOT NULL,
  `user` INT UNSIGNED NOT NULL,
	`lot` INT UNSIGNED NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`user`) REFERENCES `users`(`id`),
	FOREIGN KEY (`lot`) REFERENCES `lots`(`id`)
);


