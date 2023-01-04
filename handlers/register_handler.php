<?
session_start();
require "../functions.php";

$email = $_POST["email"];
$password = $_POST["password"];

$user = get_user_by_email($email);

if (!empty($user)) {
    set_flash_message("danger", "Этот эл. адрес уже занят другим пользователем.");
    redirect_to("back");
}

$user_data_to_upload = array("email" => $email, "password" => password_hash($password, PASSWORD_DEFAULT));
add_user_to_db($user_data_to_upload, "main");
set_flash_message("success", "Регистрация успешна.");
redirect_to("/page_login.php");
