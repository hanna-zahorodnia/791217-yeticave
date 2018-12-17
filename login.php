<?php
require_once('init.php');
require_once('functions.php');
require_once 'mysql_helper.php';

session_start();

$sql_category = 'SELECT * FROM categories;';
$categories = getData($con, $sql_category);

if (!$con) {
    $error = mysqli_connect_error();
    $page_content = "<p>Ошибка подключения: " . $error . "</p>";
    $layout_content = include_template("lot-layout.php", ['title' => 'Yeticave', 'categories' => $categories, 'content' => $page_content]);
    print($layout_content);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $required = ['email', 'password'];
    $errors = [];

    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Заполните, пожалуйста, поле';
        } else {
            $form['email'] = $form['email'];
        }
    }

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $sql = "SELECT * FROM `users` "
        . "WHERE `users`.`email` = '$email'";
    $res = mysqli_query($con, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный адрес почты';
    }

    if (!count($errors) and $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit();
        } else {
            $errors['password'] = 'Неверный пароль';
            $page_content = include_template('login.php', ['form' => $form, 'errors' => $errors]);
        }
    }

    if (count($errors)) {
        $page_content = include_template('login.php', ['form' => $form, 'errors' => $errors]);
    }
    else {
        header("Location: login.php");
        exit();
    }
}
else {
    if (isset($_SESSION['user']['name'])) {
        header("Location: index.php");
    }
    else {
        $page_content = include_template('login.php', []);
    }
}
$layout_content = include_template('lot-layout.php', ['content' => $page_content, 'categories' => $categories, 'title' => 'Yeticave', 'user_name' => '']);
print($layout_content);
?>
