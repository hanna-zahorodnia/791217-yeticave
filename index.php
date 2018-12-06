<?php
require_once 'init.php';
require_once 'functions.php';

$is_auth = rand(0, 1);

$user_name = 'Anna';
$user_avatar = 'img/user.jpg';

if (!$con) {
    $error = "Ошибка подключения: " . mysqli_connect_error();
    $page_content = "<p>Ошибка MySQL: " . $error. "</p>";
} else {

    $sql = 'SELECT `name` FROM `categories`';
    $result = mysqli_query($con, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($con);
        $page_content = "<p>Ошибка MySQL: " . $error. "</p>";
    }

    $sql = 'SELECT DISTINCT `lots`.`id`, `lots`.`title`, `start_price`, `photo_path`, MAX(IF(`amount` IS NULL, `start_price`, `amount`)) AS `price`, COUNT(`lot`) AS `bids_number`, `categories`.`name` FROM `lots`'
        . 'LEFT JOIN `bid` ON `lots`.`id` = `bid`.`lot` '
        . 'INNER JOIN `categories` ON `lots`.`category` = `categories`.`id` '
        . 'WHERE CURRENT_TIMESTAMP() < `end_date` '
        . 'GROUP BY `lots`.`id`, `lots`.`title`, `start_price`, `photo_path`, `category`; ';

    if ($result = mysqli_query($con, $sql)) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $page_content = include_template('index.php', ['lots' => $lots]);
    }
    else {
        $error = mysqli_error($con);
        $page_content = "<p>Ошибка MySQL: " . $error. "</p>";
    }
}

$page_content = include_template('index.php', ['lots' => $lots, 'categories' => $categories]);

$layout_content = include_template('layout.php', ['title' => 'Yeticave - Главная', 'is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $page_content, 'categories' => $categories]);

print($layout_content);

?>



