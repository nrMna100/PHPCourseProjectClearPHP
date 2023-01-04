<?
session_start();
require "../functions.php";

$email = $_POST["email"];
$password = $_POST["password"];
$user = get_user_by_email($email);

if (empty($user)) {
    set_flash_message("danger", "Неверный логин или пароль.");
    redirect_to("back");
}

$user_password = get_user_password($user);
if (!password_verify($password, $user_password)) {
    set_flash_message("danger", "Неверный логин или пароль.");
    redirect_to("back");
}

record_user($email, $user_password, $user["is_admin"], $user["id"]);
redirect_to("/users.php");
