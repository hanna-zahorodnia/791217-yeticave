<?php
require_once 'init.php';
require_once 'functions.php';
require_once 'mysql_helper.php';

$is_auth = rand(0, 1);

$user_name = 'Anna';
$user_avatar = 'img/user.jpg';

$errors = [];
$new_lot = [];

if ($con) {
    $sql_categories = showCategories();
    $categories = getData($con, $sql_categories);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_lot = $_POST;

    $required = ['lot-name', 'category', 'message', 'lot_date'];
    $required_number = ['lot-rate', 'lot-step'];

    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Заполните, пожалуйста, поле';
        }
    }

    foreach ($required_number as $number) {
        if (!(is_numeric($_POST[$number]) && $_POST[$number] > 0)) {
            $errors[$number] = 'Заполните, пожалуйста, поле';
        }
    }

    if (isset($_FILES['lot_img']['name'])) {
        $tmp_name = $_FILES['lot_img']['tmp_name'];
        $path = $_FILES['lot_img']['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if (!($file_type == "image/jpeg" || $file_type == "image/png")) {
            $errors['lot_img'] = "Не удалось загрузить изображение. Убедитесь, что формат соответсвует jpg/jpeg или png";
        } else {
            move_uploaded_file($tmp_name, 'img/' . $path);
            $data['photo_path'] = $path;
        }
    }

    else {
            $errors['file'] = 'Вы не загрузили изображение';
        }

    if (empty($errors)) {
        $sql = publishLot();
        $stmt = db_get_prepare_stmt($con, $sql, [$new_lot['lot-name'], $new_lot['message'], $new_lot['photo_path'], $new_lot['lot-rate'], $new_lot['lot-date'], $new_lot['lot-step']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $insert_lod_id = mysqli_insert_id($con);
            header("Location: lot.php?id=" . $insert_lod_id);
        }
    }

}

$page_content = include_template('add-lot.php', $categories, $errors, $new_lot);

$layout_content = include_template('lot-layout.php', ['is_auth' => $is_auth, 'user_name' => $user_name, 'content' => $page_content, 'categories' => $categories]);

print($layout_content);

?>
