<?
session_start();
require "../functions.php";

$user_id = $_GET["user_id"];
$detailed_user_info = get_user_by_id($user_id, "users_secondary_info");

$avatar = $_FILES["avatar"];
$default_avatar_name = "default-avatar.png";

if (!is_file_empty($avatar) && is_image($avatar)) {
    $unique_file_name = get_unique_image_name($avatar);
    $filed_directory = '../img/avatars/';
    upload_file_to_dir($filed_directory, $avatar, $unique_file_name);

    $user_avatar_from_db = get_user_avatar($detailed_user_info);
    if ($user_avatar_from_db !== $default_avatar_name)
        delete_file_from_dir($filed_directory, $user_avatar_from_db);
}

update_avatar($user_id, $unique_file_name);

add_flash_message("success", "Профиль успешно обновлен.");
redirect_to("/page_profile.php?user_id={$user_id}");
