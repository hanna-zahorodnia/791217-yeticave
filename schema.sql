CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` char(255) NOT NULL,
  `name` char(255) NOT NULL,
  `password` char(64) DEFAULT NULL,
  `photo_path` char(255) DEFAULT NULL,
  `contacts` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

CREATE TABLE `lots` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` char(255) NOT NULL,
  `description` char(255) NOT NULL,
  `photo_path` char(255) NOT NULL,
  `start_price` int(10) unsigned NOT NULL,
  `end_date` datetime NOT NULL,
  `bid_step` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `bid` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `set_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
);
