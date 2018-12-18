USE yeticave;

INSERT INTO `categories` (`name`)
VALUES ('Доски и лыжи');

INSERT INTO `categories` (`name`)
VALUES ('Крепления');

INSERT INTO `categories` (`name`)
VALUES ('Ботинки');

INSERT INTO `categories` (`name`)
VALUES ('Одежда');

INSERT INTO `categories` (`name`)
VALUES ('Инструменты');

INSERT INTO `categories` (`name`)
VALUES ('Разное');


INSERT INTO `users` (`register_date`, `email`, `name`, `password`, `photo_path`, `contacts`)
VALUES
	('2018-11-26 09:44:51','zahorodnia.h@gmail.com','Анна','secret','img/avatar.jpg','тел. +7 676 555 56 96'),
	('2018-11-26 10:11:19','jon.snow@mail.ru','Джон','secret','img/user.jpg','континент Весторос'),
	('2018-11-26 10:11:19','dumbledore@hogwarts.com','Альбус','secret',NULL,'Хогвартс');


INSERT INTO `lots` (`title`, `description`, `photo_path`, `start_price`, `end_date`, `bid_step`, `author`, `category`)
VALUES ('2014 Rossignol District Snowboard', 'no description', 'img/lot-1.jpg', 10999, '2018-12-25 23:59:59', 300, 1, 1);

INSERT INTO `lots` (`title`, `description`, `photo_path`, `start_price`, `end_date`, `bid_step`, `author`, `category`)
VALUES ('DC Ply Mens 2016/2017 Snowboard', 'no description', 'img/lot-2.jpg', 159999, '2018-12-27 23:59:59', 500, 2, 1);

INSERT INTO `lots` (`title`, `description`, `photo_path`, `start_price`, `end_date`, `bid_step`, `author`, `category`)
VALUES ('Крепления Union Contact Pro 2015 года размер L/XL', 'no description', 'img/lot-3.jpg', 8000, '2018-12-28 23:59:59', 100, 3, 2);

INSERT INTO `lots` (`title`, `description`, `photo_path`, `start_price`, `end_date`, `bid_step`, `author`, `category`)
VALUES ('Ботинки для сноуборда DC Mutiny Charocal', 'no description', 'img/lot-4.jpg', 10999, '2018-12-31 23:59:59', 350, 1, 3);

INSERT INTO `lots` (`title`, `description`, `photo_path`, `start_price`, `end_date`, `bid_step`, `author`, `category`)
VALUES ('Куртка для сноуборда DC Mutiny Charocal', 'no description', 'img/lot-5.jpg', 7500, '2018-12-30 23:59:59', 50, 2, 4);

INSERT INTO `lots` (`title`, `description`, `photo_path`, `start_price`, `end_date`, `bid_step`, `author`, `category`)
VALUES ('Маска Oakley Canopy', 'no description', 'img/lot-6.jpg', 5400, '2018-12-29 23:59:59', 45, 3, 6);


INSERT INTO `bid` (`amount`, `user`, `lot`)
VALUES (11299, 3, 1);

INSERT INTO `bid` (`amount`, `user`, `lot`)
VALUES (8100, 3, 3);

INSERT INTO `bid` (`amount`, `user`, `lot`)
VALUES (8200, 1, 3);

-- Получение всех категорий

SELECT `name` FROM `categories`;

-- Получение открытых лотов

SELECT DISTINCT `lots`.`title`, `start_price`, `photo_path`, MAX(IF(`amount` IS NULL, `start_price`, `amount`)) AS `price`, COUNT(`lot`) AS `bids_number`, `categories`.`name`
FROM `lots`
LEFT JOIN `bid` ON `lots`.`id` = `bid`.`lot`
INNER JOIN `categories` ON `lots`.`category` = `categories`.`id`
WHERE CURRENT_TIMESTAMP() < `end_date`
GROUP BY `lots`.`title`, `start_price`, `photo_path`, `category`;

-- Показ лота по его id. В данном случает id = 1

SELECT `lots`.`id`, `lots`.`title`, `lots`.`description`, `lots`.`photo_path`, `lots`.`end_date`, `lots`.`start_price`, `lots`.`bid_step`, `lots`.`author`, `lots`.`winner`, `categories`.`name`
FROM `lots`
INNER JOIN `categories` ON `lots`.`category` = `categories`.`id`
WHERE `lots`.`id` = 1;

-- Обновление названия лота по его id. В данном случает id = 1

UPDATE `lots`
SET `lots`.`title` = 'Обновлённое название лота'
WHERE `lots`.`id` = 1;

-- Получение списка самых свежих ставок для лота по его id. В данном случает id = 3

SELECT `bid`.`set_date`, `bid`.`amount`, `bid`.`user`
FROM `bid`
WHERE `bid`.`lot` = 3
ORDER BY `bid`.`set_date` DESC;
