<?
session_start();

/* PDO */
function create_pdo_instance($table_name)
{
    /*
    @ Parameters:
        $table_name — string

    @ Description: returns pdo instance with specified table name

    @ Return: pdo
    */

    $driver = 'mysql';
    $host = '127.0.0.1';
    $db_name = $table_name;
    $db_user = 'root';
    $db_password = '';
    $charset = 'utf8';

    $dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";

    return new PDO($dsn, $db_user, $db_password);
}

/* Add user */
function add_user($main_info)
{
    /*
    @ Parameters:
        $main_info — array

    @ Description: adds main user info.

    @ Return: string
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');
        $sql = "INSERT INTO users_main_info (email, password) VALUES (:email, :password)";
        $STH = $DBH->prepare($sql);
        $STH->execute($main_info);

        $user_id = $DBH->lastInsertId();
        return $user_id;
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function add_detailed_user_info($detailed_user_info)
{
    /*
    @ Parameters:
        $detailed_user_info — array

    @ Description: adds detailed user info.

    @ Return: null
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');

        $sql = "INSERT INTO users_secondary_info (id, username, workplace, phone, address, status, avatar) VALUES (:id, :username, :workplace, :phone, :address, :status, :avatar)";
        $STH = $DBH->prepare($sql);
        $STH->execute($detailed_user_info);
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function add_socials($socials)
{
    /*
    @ Parameters:
        $socials — array

    @ Description: adds main user info.

    @ Return: null
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');
        $sql = "INSERT INTO users_socials (id, vk, telegram, instagram) VALUES (:id, :vk, :telegram, :instagram)";
        $STH = $DBH->prepare($sql);
        $STH->execute($socials);
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function add_user_id($user_id, $table_name)
{
    /*
    @ Parameters:
        $user_id — string
        $table_name — string

    @ Description: adds user id in the specified table.

    @ Return: null
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');
        $sql = "INSERT INTO {$table_name} (id) VALUES ('$user_id')";
        $DBH->query($sql);
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

/* Update user */
function update_main_user_info($user_id, $main_user_info)
{
    /*
    @ Parameters:
        $user_id — string
        $main_user_info — array

    @ Description: updates main user info.

    @ Return: null
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');
        $sql = "UPDATE users_main_info SET email=:email, password=:password WHERE id='$user_id'";
        $STH = $DBH->prepare($sql);
        $STH->execute($main_user_info);
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function update_detailed_user_info($user_id, $detailed_user_info)
{
    /*
    @ Parameters:
        $user_id — string
        $detailed_user_info — array

    @ Description: updates detailed user info.

    @ Return: null
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');
        $sql = "UPDATE users_secondary_info SET username=:username, workplace=:workplace, phone=:phone, address=:address WHERE id='$user_id'";
        $STH = $DBH->prepare($sql);
        $STH->execute($detailed_user_info);
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function update_avatar($user_id, $avatar)
{
    /*
    @ Parameters:
        $user_id — string
        $avatar — string

    @ Description: updates user avatar.

    @ Return: null
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');
        $sql = "UPDATE users_secondary_info SET avatar='$avatar' WHERE id='$user_id'";
        $DBH->query($sql);
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function update_status($user_id, $status)
{
    /*
    @ Parameters:
        $user_id — string
        $status — string

    @ Description: updates user status.

    @ Return: null
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');
        $sql = "UPDATE users_secondary_info SET status='$status' WHERE id='$user_id'";
        $DBH->query($sql);
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

/* Get user */
function get_user_by_email($email)
{
    /*
    @ Parameters:
        $email — string

    @ Description: get user by its email.

    @ Return: array
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');

        $sql = "SELECT * FROM users_main_info WHERE email=:email LIMIT 1";
        $STH = $DBH->prepare($sql);
        $STH->execute(["email" => $email]);
        $user = $STH->fetch(PDO::FETCH_ASSOC);

        return $user;
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function get_user_by_id($id, $table_name = "users_main_info")
{
    /*
    @ Parameters:
        $id — string
        $table_name(optional) — string

    @ Description: get user by its id from the specified table.

    @ Return: array
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');

        $sql = "SELECT * FROM {$table_name} WHERE id=:id LIMIT 1";
        $STH = $DBH->prepare($sql);
        $STH->execute(["id" => $id]);
        $user = $STH->fetch(PDO::FETCH_ASSOC);

        return $user;
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function get_user_password($user)
{
    /*
    @ Parameters:
        $user — array

    @ Description: get user's password.

    @ Return: string
    */

    return $user["password"];
}

function get_user_email($user)
{
    /*
    @ Parameters:
        $user — array

    @ Description: get user's email.

    @ Return: string
    */

    return $user["email"];
}

function get_user_status($user)
{
    /*
    @ Parameters:
        $user — array

    @ Description: get user's status.

    @ Return: string
    */

    return $user["status"];
}

function get_user_avatar($user)
{
    /*
    @ Parameters:
        $user — array

    @ Description: get user's avatar.

    @ Return: string
    */

    return $user["avatar"];
}

function get_all_users($table_name = "users_main_info")
{
    /*
    @ Parameters:
        $table_name — string

    @ Description: returns all users from the specified table.

    @ Return: array
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');
        $sql = "SELECT * FROM {$table_name}";
        $stmt = $DBH->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function get_authorized_user()
{
    /*
	@ Parameters: null

	@ Description: returns user's main info from $_SESSION["authorized_user"].

	@ Return: array
	*/

    return $_SESSION["authorized_user"];
}

/* Check user */
function users_are_equal($comparable_user, $current_user, $comparable_value = 'id')
{
    /*
	@ Parameters:
            $comparable_user — array
            $current_user — array
            $comparable_value(optional) — string

	@ Description: defines whether the users are equal basing on the comparable value.

	@ Return: boolean
	*/

    return $comparable_user[$comparable_value] === $current_user[$comparable_value];
}

function is_admin($user)
{
    /*
	@ Parameters:
        $user — array

	@ Description: defines whether the user is admin.

	@ Return: boolean
	*/

    return $user["is_admin"];
}

function user_is_authorized()
{
    /*
    @ Parameters:

    @ Description: defines whether the user is authorized.

    @ Return: boolean
    */

    return isset($_SESSION["authorized_user"]);
}

/* Authorize user */
function authorize_user($user)
{
    /*
    @ Parameters:
        $user — array

    @ Description: add user's main info into $_SESSION["authorized_user"].

    @ Return: null
    */

    $_SESSION["authorized_user"] = $user;
}

/* Delete user */
function delete_user($user_id)
{
    /*
    @ Parameters:
        $user_id — string

    @ Description: deletes user from all tables where user's id exists.

    @ Return: null
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');
        $sql = "DELETE from users_main_info WHERE id = '$user_id' LIMIT 1;
        DELETE from users_secondary_info WHERE id = '$user_id' LIMIT 1;
        DELETE from users_socials WHERE id = '$user_id' LIMIT 1";
        $DBH->query($sql);
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function delete_authorized_user()
{
    /*
    @ Parameters: null

    @ Description: deletes authorized user from $_SESSION["authorized_user"].

    @ Return: null
    */

    unset($_SESSION["authorized_user"]);
}

/* Redirect */
function redirect_to($path)
{
    /*
    @ Parameters:
        $path — string

    @ Description: redirects to the specified page and stops script execution.

    @ Return: null
    */

    if ($path === "back") {
        if (!empty($_SERVER['HTTP_REFERER']))
            header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    } else {
        header("Location: {$path}");
        exit;
    }
}

/* Flash message */
function add_flash_message($status, $message)
{
    /*
    @ Parameters:
        $status — string
        $message — string

    @ Description: adds flash message consisting from status and message to the $_SESSION["flash_message_statuses"].

    @ Return: null
    */

    $_SESSION["flash_message_statuses"][$status] = $message;
}

function display_flash_message($status)
{
    /*
    @ Parameters:
        $status — string

    @ Description: displays flash message basing on status and removes it afterwards from the $_SESSION["flash_message_statuses"].

    @ Return: null
    */

    if (isset($_SESSION["flash_message_statuses"][$status])) {
        echo "<div class=\"alert alert-{$status} text-dark\" role\"alert\">{$_SESSION["flash_message_statuses"][$status]}</div>";
        unset($_SESSION["flash_message_statuses"][$status]);
    }
}

/* Statuses */
function get_statutes()
{
    $statuses = array();
    $statuses["online"]         = "Онлайн";
    $statuses["moved_away"]     = "Отошел";
    $statuses["do_not_disturb"] = "Не беспокоить";

    return $statuses;
}

function get_status_key($status_value)
{
    /*
    @ Parameters:
        $status_value — string

    @ Description: returns status value based on status key.
      Example status key: "online"
      Example status value: "Онлайн"
      status key is stored in database
      status value is displayed to user

    @ Return: null
    */

    $statuses = get_statutes();
    foreach ($statuses as $status_key => $value) {
        if ($status_value === $value)
            return $status_key;
    }
}

/* Files */
function is_file_empty($file)
{
    /*
    Parameters:
            $file — array

    Description: defines whether the file is passed.

    Return: boolean
    */

    return empty($file['name']);
}

function is_image($file)
{
    /*
    @ Parameters:
        $file — array

    @ Description: defines whether the file has image type.

    @ Return: boolean
    */

    $allowed_extensions = array("jpg", "jpeg", "gif", "png");
    $file_extension = pathinfo($file['name'])["extension"];
    return in_array($file_extension, $allowed_extensions);
}

function get_unique_image_name($image)
{
    /*
    @ Parameters:
        $image — array

    @ Description: returns unique name for the image.

    @ Return: string
    */

    list($width, $height) = getimagesize($image['tmp_name']);
    return uniqid() . "-size-{$width}-{$height}-{$image['name']}";
}

function upload_file_to_dir($filed_directory, $file, $filename)
{
    /*
    @ Parameters:
        $filed_directory — string
        $file — array
        $filename — string

    @ Description: uploads the file to the specified directory.

    @ Return: null
    */

    move_uploaded_file($file['tmp_name'], $filed_directory . $filename);
}

function delete_file_from_dir($filed_directory, $filename)
{
    /*
    @ Parameters:
        $filed_directory — string
        $filename — string

    @ Description: deletes a file based on it's name from the specified directory.

    @ Return: null
    */

    if (file_exists($filed_directory . $filename))
        unlink($filed_directory . $filename);
}

function get_default_avatar_name()
{
    /*
    @ Parameters: null

    @ Description: return default avatar name

    @ Return: string
    */

    return "default-avatar.png";
}

class Connection
{
    public static function set()
    {
        return 5;
    }
}
