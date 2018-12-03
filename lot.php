<?php
require_once 'init.php';

$is_auth = rand(0, 1);

$user_name = 'Anna';
$user_avatar = 'img/user.jpg';

if (!isset($_GET['id'])) {
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");

    $page_content = "<p>К сожалению, данный лот не существует или был удален</p>";
} else {
    $lot_id = $_GET['id'];

    if (!$con) {
        $error = "Ошибка подключения: " . mysqli_connect_error();
        $page_content = "<p>Ошибка MySQL: " . $error. "</p>";
    } else {

        $sql = 'SELECT `lots`.`id`, `lots`.`title`, `lots`.`description`, `lots`.`photo_path`, `lots`.`end_date`, `lots`.`start_price`, `lots`.`bid_step`, `lots`.`author`, `lots`.`winner`, `categories`.`name` FROM `lots`'
            . 'INNER JOIN `categories` ON `lots`.`category` = `categories`.`id` '
            . 'WHERE `lots`.`id` = ' . $lot_id . ' '
            . 'GROUP BY `lots`.`id`; ';

        $result = mysqli_query($con, $sql);

        if (!$result) {
            $error = mysqli_error($con);
            $page_content = "<p>Ошибка MySQL: " . $error. "</p>";
        } else {
            $lot = mysqli_fetch_assoc($result);
            $page_content = include_template('lot-index.php', ['lot' => $lot]);
        }
    }
}

function formatPrice($price) {
    $price = ceil($price);
    if ($price >= 1000) {
        $price = number_format($price, 0, '', ' ');
    }
    return $price . ' ₽';
}

$layout_content = include_template('lot-layout.php', ['is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $page_content, 'categories' => $categories]);

print($layout_content);

?>
