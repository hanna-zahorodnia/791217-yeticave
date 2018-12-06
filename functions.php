<?php
date_default_timezone_set("Europe/Moscow");

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

function showTimeLeft() {
    $tomorrow_timestamp = strtotime('tomorrow midnight');
    $time_left = $tomorrow_timestamp - time();
    return date('H:i', $time_left);
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

?>
