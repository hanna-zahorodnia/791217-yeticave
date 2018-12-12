<?php
require_once 'init.php';
require_once 'functions.php';

$is_auth = rand(0, 1);

$user_name = 'Anna';
$user_avatar = 'img/user.jpg';


if (!isset($_GET['id']) || !getAvailableLot($_GET['id'], $con)) {
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');

} else if ($con) {
    $sql_lot_by_id = showLotById($_GET['id']);
    $current_lot = getData($con, $sql_lot_by_id);
    $page_content = include_template('lot-index.php', $current_lot[0]);
    $layout_content = include_template('lot-layout.php', ['is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $page_content]);

    print($layout_content);
}

?>
