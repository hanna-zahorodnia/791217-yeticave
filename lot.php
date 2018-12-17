<?php
require_once 'init.php';
require_once 'functions.php';
require_once 'mysql_helper.php';

session_start();

if (empty($_SESSION['user'])) {
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
    $current_lot_price = getData($con, showMaxBid($_GET['id']));
    $current_lot[0]['price'] = $current_lot_price[0]['price'];


    if (!empty($_SESSION['user']['name'])) {
        $sql = getBidUserId($_GET['id'], $_SESSION['user']['id']);
        $result = mysqli_query($con, $sql);
        $usersIDs = mysqli_fetch_row($result);
        if ($usersIDs) {
            $_SESSION['user']['bid'] = 1;
        } else {
            $_SESSION['user']['bid'] = '';
        }
    }

    $sql_bids_num = showBidsNum($_GET['id']);
    $bids_num = getData($con, $sql_bids_num);

    $sql_bid_by_id = showBidById($_GET['id']);
    $current_bid = getData($con, $sql_bid_by_id);

    if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] === $_SESSION['current_lot']['author']) {
        $author_id = true;
    } else {
        $author_id = false;
    }

    $page_content = include_template('lot-index.php', ['lot' => $current_lot[0], 'history' => $bids_num[0], 'bid' => $current_bid, 'author_id' => $author_id]);
    $layout_content = include_template('lot-layout.php', ['user_name' => $user_name, 'user_avatar' => $user_avatar, 'content' => $page_content, 'title' => $current_lot[0]['title']]);
    $_SESSION['current_lot'] = $current_lot[0];

    print($layout_content);
}
?>
