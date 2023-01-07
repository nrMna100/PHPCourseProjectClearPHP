<?
session_start();
require "../functions.php";

if (!user_is_authorized())
    redirect_to("/page_login.php");

$user_id = $_GET["user_id"];
$user = get_user_by_id($user_id);

if (!is_admin(get_authorized_user()) && !users_are_equal($user, get_authorized_user())) {
    add_flash_message("danger", "Можно редактировать только свой профиль.");
    redirect_to("/users.php");
}

if (users_are_equal($user, get_authorized_user())) {
    delete_authorized_user();
    delete_user($user_id);
    redirect_to("/page_login.php");
} else {
    delete_user($user_id);
    add_flash_message("success", "Профиль успешно удален.");
    redirect_to("/users.php");
}
