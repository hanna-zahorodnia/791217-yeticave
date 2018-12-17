<?php
require_once('init.php');
require_once('functions.php');
require_once('mysql_helper.php');

session_start();

if (!$con) {
    $error = mysqli_connect_error();
    $page_content = "<p>Ошибка подключения: " . $error . "</p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user']['id'])) {
    $form = $_POST['cost'];
    $_SESSION['current_lot']['errors'] = [];

    $user_id = $_SESSION['user']['id'];
    $lot = $_SESSION['current_lot'];
    $min_bid = $lot['price']+$lot['bid_step'];
    if ($form >= $min_bid) {
        $sql = 'INSERT INTO bid (set_date, amount, user, lot)
	    VALUES (NOW(), ?, ?, ?); ';
        $stmt = db_get_prepare_stmt($con, $sql, [$form, $user_id, $lot['id']]);
        $res = mysqli_stmt_execute($stmt);
    } elseif(empty($form)) {
        $_SESSION['current_lot']['errors'] = 'Введите вашу ставку';
    } elseif($form < $min_bid) {
        $_SESSION['current_lot']['errors'] = 'Ставка слишком мала';
    }

    header("Location: lot.php?id=" . $lot['id']);

}
