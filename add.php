<?php
require_once 'init.php';
require_once 'functions.php';
require_once 'mysql_helper.php';

session_start();

if (empty($_SESSION['user'])) {
    http_response_code(403);
    exit();
} else {
    $user_name = $_SESSION['user']['name'];
    $user_avatar = $_SESSION['user']['photo_path'] ? $_SESSION['user']['photo_path'] : "";
}

$errors = [];

$sql_category = 'SELECT * FROM categories;';
$categories = getData($con, $sql_category);

if (!$con) {
    $error = mysqli_connect_error();
    $page_content = "<p>Ошибка подключения: " . $error . "</p>";
    $layout_content = include_template("lot-layout.php", ['content' => $page_content]);
    print($layout_content);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;

    $required = ['lot-name', 'category', 'message', 'lot-date'];
    $required_number = ['lot-rate', 'lot-step'];

    foreach ($required as $field) {
        if (empty($lot[$field])) {
            $errors[$field] = 'Заполните, пожалуйста, поле';
        } else {
            $lot[$field] = $lot[$field];
        }
    }

    $lot_date = strtotime($lot['lot-date']);
    $one_day = 86400;

    if ($lot_date < time() + $one_day) {
        $errors['lot-date'] = 'Введите дату в будущем';
    }

    foreach ($required_number as $number) {
        if (!(is_numeric($_POST[$number]) && $_POST[$number] > 0)) {
            $errors[$number] = 'Заполните, пожалуйста, поле';
        }
    }

    if  ($_FILES['lot_img']['error'] == 0) {
        $tmp_name = htmlspecialchars($_FILES['lot_img']['tmp_name']);
        $path = htmlspecialchars($_FILES['lot_img']['name']);

        $file_type = mime_content_type($tmp_name);


        if (!($file_type == "image/jpeg" || $file_type == "image/png")) {
            $errors['lot_img'] = "Не удалось загрузить изображение. Убедитесь, что формат соответсвует jpg/jpeg или png";
        } else {
            $path = uniqid() . '.jpg';
            move_uploaded_file($tmp_name, 'img/' . $path);
            $lot['photo_path'] = $path;
        }
    }

    else {
        $errors['lot_img'] = 'Вы не загрузили изображение';
    }

    if (empty($errors)) {
        $sql = 'INSERT INTO lots (add_date, title, description, photo_path, start_price, end_date, bid_step, author, winner, category)'
            . 'VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, NULL, ?); ';
        $stmt = db_get_prepare_stmt($con, $sql, [$lot['lot-name'], $lot['message'], 'img/' . $lot['photo_path'], $lot['lot-rate'], $lot['lot-date'], $lot['lot-step'], $_SESSION['user']['id'], $lot['category']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $insert_lod_id = mysqli_insert_id($con);
            header("Location: lot.php?id=" . $insert_lod_id);
        }

        $page_content = include_template('add-lot.php', ['categories' => $categories, 'errors' => $errors, 'lot' => $lot]);
        $layout_content = include_template('lot-layout.php', ['user_name' => $user_name, 'content' => $page_content, 'categories' => $categories, 'title' => 'Добавление лота']);

        print($layout_content);
    }
}

if (isset($lot)) {
    $page_content = include_template('add-lot.php', ['categories' => $categories, 'errors' => $errors, 'lot' => $lot]);
    $layout_content = include_template('lot-layout.php', ['user_name' => $_SESSION['user']['name'], 'user_avatar' => $_SESSION['user']['photo_path'], 'content' => $page_content, 'categories' => $categories, 'title' => 'Добавление лота']);
} else {
    $page_content = include_template('add-lot.php', ['categories' => $categories, 'errors' => $errors]);
    $layout_content = include_template('lot-layout.php', ['user_name' => $_SESSION['user']['name'], 'user_avatar' => $_SESSION['user']['photo_path'], 'content' => $page_content, 'categories' => $categories, 'title' => 'Добавление лота']);
}

print($layout_content);
?>
