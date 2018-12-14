<?php
require_once 'init.php';
require_once 'functions.php';

session_start();

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

if ($_SESSION) {
    $layout_content = include_template('layout.php', ['title' => 'Yeticave - Главная', 'user_name' => $_SESSION['user']['name'], 'user_avatar' => $_SESSION['user']['photo_path'], 'content' => $page_content, 'categories' => $categories]);
} else {
    $layout_content = include_template('layout.php', ['title' => 'Yeticave - Главная', 'user_name' => '', 'user_avatar' => '', 'content' => $page_content, 'categories' => $categories]);
}

print($layout_content);

?>



