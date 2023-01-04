<?
session_start();
require "../functions.php";

$user = get_user_by_email($email);

if (!empty($user)) {
    set_flash_message("danger", "Этот эл. адрес уже занят другим пользователем.");
    redirect_to("back");
}

$user_data_to_upload = array();
foreach ($_POST as $key => $val) {
    if ($key === "password") {
        $user_data_to_upload[$key] = password_hash($val, PASSWORD_DEFAULT);
    } else {
        $user_data_to_upload[$key] = $val;
    }
}

$file = $_FILES['avatar'];

if (!is_file_empty($file) && is_image($file)) {
    $unique_file_name = get_unique_image_name($file);
    $filed_directory = '../img/avatars/';
    upload_image_to_dir($filed_directory, $file, $unique_file_name);
}

$user_data_to_upload["avatar"] = $unique_file_name ?? "";


add_user_to_db($user_data_to_upload, "full");
set_flash_message("success", "Пользователь успешно добавлен.");
redirect_to("/users.php");
