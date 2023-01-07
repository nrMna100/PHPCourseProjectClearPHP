<?
session_start();
require "../functions.php";

$user_id = $_GET["user_id"];

$detailed_user_info = array();
$detailed_user_info["username"] = $_POST["username"];
$detailed_user_info["workplace"] = $_POST["workplace"];
$detailed_user_info["phone"] = $_POST["phone"];
$detailed_user_info["address"] = $_POST["address"];

update_detailed_user_info($user_id, $detailed_user_info);

add_flash_message("success", "Профиль успешно обновлен.");
redirect_to("/page_profile.php?user_id={$user_id}");
