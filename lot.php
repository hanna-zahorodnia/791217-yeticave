<?php
require_once 'init.php';
require_once 'functions.php';

session_start();

if (empty($_SESSION)) {
    $user_name = '';
    $user_avatar = '';
} else {
    $user_name = $_SESSION['user']['name'];
    $user_avatar = $_SESSION['user']['photo_path'] ? $_SESSION['user']['photo_path'] : "";
}


if (!isset($_GET['id']) || !getAvailableLot($_GET['id'], $con)) {
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');

} else if ($con) {
    $sql_lot_by_id = showLotById($_GET['id']);
    $current_lot = getData($con, $sql_lot_by_id);
    $page_content = include_template('lot-index.php', $current_lot[0]);
    $layout_content = include_template('lot-layout.php', ['user_name' => $user_name, 'user_avatar' => $user_avatar, 'content' => $page_content, 'title' => $current_lot[0]['title']]);
    print($layout_content);
}

?>
