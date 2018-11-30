<?php
require_once 'functions.php';

$db_host = "localhost";
$db_user = "root";
$db_password = "Hanna29121993";
$db_name = "yeticave";

$con = mysqli_connect($db_host, $db_user, $db_password, $db_name);
mysqli_set_charset($con, "utf8");

$categories = [];
$page_content = '';

?>
