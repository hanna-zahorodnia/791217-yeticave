<?php

$config = [
    'db_host' => 'localhost',
    'db_user' => 'root',
    'db_password' => 'Hanna29121993',
    'db_name' => 'yeticave',
];

$con = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);
mysqli_set_charset($con, "utf8");

?>
