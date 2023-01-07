<?
session_start();
require "../functions.php";

$email = $_POST["email"];
$password = $_POST["password"];
$user = get_user_by_email($email);

if (empty($user)) {
    add_flash_message("danger", "Неверный логин или пароль.");
    redirect_to("back");
}

$user_password = get_user_password($user);
if (!password_verify($password, $user_password)) {
    add_flash_message("danger", "Неверный логин или пароль.");
    redirect_to("back");
}

authorize_user($user);
redirect_to("/users.php");
