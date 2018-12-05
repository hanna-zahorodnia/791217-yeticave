<?php
require_once 'init.php';
require_once 'functions.php';

$is_auth = rand(0, 1);

$user_name = 'Anna';
$user_avatar = 'img/user.jpg';

if (!isset($_GET['id'])) {
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');

    $page_content = '<p>К сожалению, данный лот не существует или был удален</p>';
} else {

    $con = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);
    mysqli_set_charset($con, "utf8");

    if ($con) {
        $sql_lot_by_id = showLotById($_GET['id']);
        $current_lot = getData($con, $sql_lot_by_id);
    }
}

$page_content = include_template('lot-index.php', $current_lot[0]);

$layout_content = include_template('lot-layout.php', ['is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $page_content]);

print($layout_content);

?>
