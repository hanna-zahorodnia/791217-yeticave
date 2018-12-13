<?php

require_once('init.php');
require_once('functions.php');
require_once 'mysql_helper.php';

session_start();
$_SESSION = [];

header("Location: index.php");
exit();

?>
