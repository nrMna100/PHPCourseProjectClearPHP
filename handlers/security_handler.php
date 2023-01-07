<?
session_start();
require "../functions.php";

$email = $_POST["email"];
$password = $_POST["password"];
$duplicated_password = $_POST["duplicated_password"];

$user_id = $_GET["user_id"];
$current_user = get_user_by_id($user_id);
$comparable_user = get_user_by_email($email);

if (!empty($comparable_user) && !users_are_equal($comparable_user, $current_user, "email")) {
    add_flash_message("danger", "Этот email уже занят");
    redirect_to("back");
}

if ($password !== $duplicated_password) {
    add_flash_message("danger", "Пароли не совпадают");
    redirect_to("back");
}

if (password_verify($password, get_user_password($current_user))) {
    add_flash_message("danger", "Этот пароль уже установлен для текущего пользователя");
    redirect_to("back");
}

update_main_user_info($user_id, ["email" => $email, "password" => password_hash($password, PASSWORD_DEFAULT)]);

add_flash_message("success", "Профиль успешно обновлен.");
redirect_to("/page_profile.php?user_id={$user_id}");
