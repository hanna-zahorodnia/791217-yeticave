<?php
$is_auth = rand(0, 1);

$user_name = 'Anna';
$user_avatar = 'img/user.jpg';

$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];

$lots = [
    1 => [
        'name' => '2014 Rossignol District Snowboard',
        'category' => $categories[0],
        'price' => 10999,
        'img' => 'img/lot-1.jpg'
    ],

    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => $categories[0],
        'price' => 159999,
        'img' => 'img/lot-2.jpg'
    ],

    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => $categories[1],
        'price' => 8000,
        'img' => 'img/lot-3.jpg'
    ],

    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => $categories[2],
        'price' => 10999,
        'img' => 'img/lot-4.jpg'
    ],

    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => $categories[3],
        'price' => 7500,
        'img' => 'img/lot-5.jpg'
    ],

    [
        'name' => 'Маска Oakley Canopy',
        'category' => $categories[5],
        'price' => 5400,
        'img' => 'img/lot-6.jpg'
    ]

];

function formatPrice($price) {
    $price = ceil($price);
    if ($price >= 1000) {
        $price = number_format($price, 0, '', ' ');
    }
    return $price . ' ₽';
}

require('functions.php');
$page_content = include_template('index.php', ['lots' => $lots, 'categories' => $categories]);

$layout_content = include_template('layout.php', ['title' => 'Yeticave - Главная', 'is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $page_content, 'categories' => $categories]);

print($layout_content);

?>



