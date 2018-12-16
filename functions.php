<?php
date_default_timezone_set("Europe/Warsaw");

function include_template($path, $data) {
    $path = 'templates/' . $path;
    $result = '';
    if (!file_exists($path)) {
        return $result;
    }
    ob_start();
    extract($data);
    require $path;
    $result = ob_get_clean();
    return $result;
}

function formatPrice($price) {
    $price = ceil($price);
    if ($price >= 1000) {
        $price = number_format($price, 0, '', ' ');
    }
    return $price . ' ₽';
}

function showTimeLeft($end_date) {
    if (strtotime($end_date) > strtotime('now')) {
        $time_left = strtotime($end_date) - strtotime('now');
        $hours = floor($time_left / 3600);
        $minutes = floor(($time_left % 3600) / 60);
        return $hours . ':' . $minutes;
    }
    return '00:00';
}


function getData($connect, $sql) {
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        return [];
    }
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
}

function showLotById($lot_id) {
    return '
    SELECT `lots`.`id`, `lots`.`title`, `lots`.`description`, `lots`.`photo_path`, `lots`.`end_date`, `lots`.`start_price`, `lots`.`bid_step`, `lots`.`author`, `lots`.`winner`, `categories`.`name` 
    FROM `lots`
    INNER JOIN `categories` ON `lots`.`category` = `categories`.`id`
    WHERE `lots`.`id` = ' . $lot_id . ' 
    GROUP BY `lots`.`id`; ';
}

function showCategories() {
    return '
    SELECT * FROM `categories`;
    ';
}

function showBidsNum($lot_id) {
    return '
    SELECT COUNT(`bid`.`lot`) AS `bids_count` 
    FROM `lots` 
    LEFT JOIN `bid` ON `lots`.`id` = `bid`.`lot` 
    WHERE `lots`.`id` = ' . $lot_id . '
    ';
}

function showBidById($lot_id) {
    return '
    SELECT `users`.`name`, `bid`.`amount`, `bid`.`set_date`
    FROM `bid`
    INNER JOIN `lots` ON `lots`.`id` = `bid`.`lot`
    LEFT JOIN `users` ON `users`.`id` = `bid`.`user`
    WHERE `lots`.`id` = ' . $lot_id . '
    ORDER BY `bid`.`set_date` DESC;
    ';
}

function getAvailableLot($number, $con) {
    $result = mysqli_query($con,"SELECT id FROM lots WHERE id='$number'");
    if ($num_rows = mysqli_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function showMaxBid($lot_id) {
    return '
        SELECT DISTINCT MAX(IF(`amount` IS NULL, `start_price`, `amount`)) AS `price`
        FROM `lots`
        LEFT JOIN `bid` ON `lots`.`id` = `bid`.`lot`
        WHERE `lots`.`id` = ' . $lot_id .'
        ';
}

function getBidUserId($lot_id, $id) {
    return '
        SELECT `bid`.`user`
        FROM `bid`
        WHERE `bid`.`lot` = ' . $lot_id . ' AND `bid`.`user` = ' . $id . '
    ';
}

function dimension($time, $type) {
    $dimension = [
        'j' => array('дней', 'день', 'дня'),
        'G' => array('часов', 'час', 'часа'),
        'i' => array('минут', 'минуту', 'минуты'),
    ];
    if ($time >= 5 && $time <= 20)
        $n = 0;
    else if ($time == 1 || $time % 10 == 1)
        $n = 1;
    else if (($time <= 4 && $time >= 1) || ($time % 10 <= 4 && $time % 10 >= 1))
        $n = 2;
    else
        $n = 0;
    return $time.' '.$dimension[$type][$n]. ' назад';

}

function showDate($time) {
    $newtime = time() - strtotime($time);
    if ($newtime < 60) {
        return 'меньше минуты назад';
    } elseif ($newtime < 3600) {
        return dimension((int)($newtime/60), 'i');
    } elseif ($newtime < 86400) {
        return dimension((int)($newtime/3600), 'G');
    } elseif ($newtime < 2592000) {
        return dimension((int)($newtime/86400), 'j');
    }
}

?>
