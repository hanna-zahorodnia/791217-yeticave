<?php
require_once 'init.php';
require_once 'functions.php';
require_once 'mysql_helper.php';

$tpl_data = [];

$sql_category = 'SELECT * FROM categories;';
$categories = getData($con, $sql_category);

if (!$con) {
    $error = mysqli_connect_error();
    $page_content = "<p>Ошибка подключения: " . $error . "</p>";
    $layout_content = include_template("lot-layout.php", ['content' => $page_content]);
    print($layout_content);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST['signup'];
    $errors = [];

    $required = ['email', 'password', 'name', 'message'];

    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Заполните, пожалуйста, поле ' . $field;
        }
    }

    if (empty($errors)) {
        $email = mysqli_real_escape_string($con, $form['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
        else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);

            if  ($_FILES['avatar']['error'] == 0) {
                $tmp_name = $_FILES['avatar']['tmp_name'];
                $path = $_FILES['avatar']['name'];

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $file_type = finfo_file($finfo, $tmp_name);


                if (!($file_type == "image/jpeg" || $file_type == "image/png")) {
                    $errors['avatar'] = "Не удалось загрузить изображение. Убедитесь, что формат соответсвует jpg/jpeg или png";
                } else {
                    $path = uniqid() . '.jpg';
                    move_uploaded_file($tmp_name, 'img/' . $path);
                    $form['photo_path'] = $path;
                }
            }
            if ($form['photo_path']) {
                $sql = 'INSERT INTO users (register_date, email, name, password, photo_path, contacts)'
                    . 'VALUES (NOW(), ?, ?, ?, ?, ?); ';
                $stmt = db_get_prepare_stmt($con, $sql, [$form['email'], $form['name'], $password, 'img/' . $form['photo_path'], $form['message']]);
                $res = mysqli_stmt_execute($stmt);
            } else {
                $sql = 'INSERT INTO users (register_date, email, name, password, photo_path, contacts)'
                    . 'VALUES (NOW(), ?, ?, ?, NULL, ?); ';
                $stmt = db_get_prepare_stmt($con, $sql, [$form['email'], $form['name'], $password, $form['message']]);
                $res = mysqli_stmt_execute($stmt);
            }
        }

        if ($res && empty($errors)) {
            header("Location: login.php");
            exit();
        }

        $tpl_data['errors'] = $errors;
        $tpl_data['values'] = $form;
        $page_content = include_template('sign-up.php', $tpl_data);
    }

    $tpl_data['errors'] = $errors;
    $tpl_data['values'] = $form;
}

$page_content = include_template('sign-up.php', $tpl_data);

$layout_content = include_template('lot-layout.php', ['user_name' => "", 'user_avatar' => "", 'content' => $page_content, 'categories' => $categories, 'title' => 'Yeticave | Регистрация']);
print($layout_content);
?>
