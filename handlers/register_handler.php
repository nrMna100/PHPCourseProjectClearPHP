<?
session_start();
require "../functions.php";

$email = $_POST["email"];
$password = $_POST["password"];

$user = get_user_by_email($email);

if (!empty($user)) {
    add_flash_message("danger", "Этот эл. адрес уже занят другим пользователем.");
    redirect_to("back");
}

$user_id = add_user(["email" => $email, "password" => password_hash($password, PASSWORD_DEFAULT)]);

add_user_id($user_id, "users_secondary_info");
add_user_id($user_id, "users_socials");

$default_avatar_name = get_default_avatar_name();
update_avatar($user_id, $default_avatar_name);

add_flash_message("success", "Регистрация успешна.");
redirect_to("/page_login.php");
