<?
session_start();
require "../functions.php";

$user_id = $_GET["user_id"];
$status_key = get_status_key($_POST["status"]);

update_status($user_id, $status_key);

add_flash_message("success", "Профиль успешно обновлен.");
redirect_to("/page_profile.php?user_id={$user_id}");
