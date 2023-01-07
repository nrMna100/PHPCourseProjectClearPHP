<?
session_start();
require "../functions.php";

$user = get_user_by_email($_POST["email"]);

if (!empty($user)) {
    add_flash_message("danger", "Этот эл. адрес уже занят другим пользователем.");
    redirect_to("back");
}

$main_user_info = array();
$main_user_info["email"] = $_POST["email"];
$main_user_info["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);

$user_id = add_user($main_user_info);

$detailed_user_info = array();
$detailed_user_info["id"] = $user_id;
$detailed_user_info["username"] = $_POST["username"];
$detailed_user_info["workplace"] = $_POST["workplace"];
$detailed_user_info["phone"] = $_POST["phone"];
$detailed_user_info["address"] = $_POST["address"];

$status_key = get_status_key($_POST["status"]);
$detailed_user_info["status"] = $status_key;

$avatar = $_FILES["avatar"];
if (!is_file_empty($avatar) && is_image($avatar)) {
    $unique_file_name = get_unique_image_name($avatar);
    $filed_directory = '../img/avatars/';
    upload_file_to_dir($filed_directory, $avatar, $unique_file_name);
} else {
    $default_avatar_name = "default-avatar.png";
}

$detailed_user_info["avatar"] = $unique_file_name ?? $default_avatar_name;

add_detailed_user_info($detailed_user_info);

$socials = array();
$socials["id"] = $user_id;
$socials["vk"] = $_POST["vk"];
$socials["telegram"] = $_POST["telegram"];
$socials["instagram"] = $_POST["instagram"];

add_socials($socials);

add_flash_message("success", "Пользователь успешно добавлен.");
redirect_to("/users.php");
