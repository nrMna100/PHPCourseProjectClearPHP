<?
session_start();

/* PDO */
function create_pdo_instance($table_name)
{
    /*
    Parameters:
            $table_name — string

    Description: return pdo instance based on table name

    Return value: pdo
    */

    $driver = 'mysql';
    $host = 'localhost';
    $db_name = $table_name;
    $db_user = 'root';
    $db_password = '';
    $charset = 'utf8';

    $dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";

    return new PDO($dsn, $db_user, $db_password);
}

/* User */
function get_user_by_email($email)
{
    /*
    Parameters:
            $email — string

    Description: get user data from database by email

    Return value: array
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');

        $sql = "SELECT * FROM users_main_data WHERE email=:emailTag";
        $STH = $DBH->prepare($sql);
        $STH->bindParam(':emailTag', $email);
        $STH->execute();
        $user = $STH->fetch(PDO::FETCH_ASSOC);

        return $user;
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function add_user_to_db($data_to_upload, $data_type)
{
    /*
    Parameters:
            $data_to_upload — array
            $data_type — string

    Description: add stroke to users table depending on data type that can be whether "main"(email and password) or "full"(email, password, ...)

    Return value: null
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');

        if ($data_type === "main") {
            $sql = "INSERT INTO users_main_data (email, password) VALUES (:email, :password)";
        } elseif ($data_type === "full") {
            $sql = "INSERT INTO users_main_data (email, password, username, avatar, workplace, phone, address, status, vk_social_link, tg_social_link, inst_social_link) VALUES (:email, :password, :username, :avatar, :workplace, :phone, :address, :status, :vk_social_link, :tg_social_link, :inst_social_link)";
        }

        $STH = $DBH->prepare($sql);
        $STH->execute($data_to_upload);
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function set_avatar()
{
}

function set_status()
{
}

function set_detailed_user_info()
{
    // try {
    //     $DBH = create_pdo_instance('clear_php_project');

    //     if ($data_type === "main") {
    //         $sql = "INSERT INTO users_main_data (email, password) VALUES (:email, :password)";
    //     } elseif ($data_type === "full") {
    //         $sql = "INSERT INTO users_main_data (email, password, username, avatar, workplace, phone, address, status, vk_social_link, tg_social_link, inst_social_link) VALUES (:email, :password, :username, :avatar, :workplace, :phone, :address, :status, :vk_social_link, :tg_social_link, :inst_social_link)";
    //     }

    //     $STH = $DBH->prepare($sql);
    //     $STH->execute($data_to_upload);
    // } catch (PDOException $error) {
    //     echo $error->getMessage();
    // };
}

function get_user_password($user)
{
    /*
    Parameters:
            $user — array

    Description: get user's password from database

    Return value: stroke
    */

    return $user["password"];
}

function record_user($email, $password, $is_admin, $id)
{
    /*
    Parameters:
            $email — string
            $password — string

    Description: record user's data(email, password) into $_SESSION["logged_user_data"]

    Return value: null
    */

    $_SESSION["logged_user_data"] = ["email" => $email, "password" => password_hash($password, PASSWORD_DEFAULT), "is_admin" => $is_admin, "id" => $id];
}

function is_user_logged()
{
    /*
    Parameters:

    Description: defines whether the user is logged

    Return value: boolean
    */

    return isset($_SESSION["logged_user_data"]);
}

function is_admin($user)
{
    /*
	Parameters: array

	Description: defines whether the user is admin

	Return value: boolean
	*/

    return $user["is_admin"];
}

function get_logged_user()
{
    /*
	Parameters:

	Description: returns logged user recorded in $_SESSION

	Return value: array
	*/

    return $_SESSION["logged_user_data"];
}

function get_all_users()
{
    /*
    Parameters:

    Description: return all users from users table

    Return value: array
    */

    try {
        $DBH = create_pdo_instance('clear_php_project');
        $sql = "SELECT * FROM users_main_data";
        $stmt = $DBH->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo $error->getMessage();
    };
}

function are_users_equal($comparable_user, $current_user)
{
    /*
	Parameters:
            $comparable_user — array
            $current_user — array

	Description: defines whether the users are equal by their id

	Return value: boolean
	*/

    return $comparable_user["id"] === $current_user["id"];
}

/* Flash message */
function set_flash_message($status, $message)
{
    /*
    Parameters:
            $status — string
            $message — string

    Description: set flash message data(status and message) into $_SESSION

    Return value: null
    */

    $_SESSION[$status] = $message;
}

function display_flash_message($status)
{
    /*
    Parameters:
            $status — string

    Description: display flash message and remove it immediately if $_SESSION[$status] is set

    Return value: null
    */

    if (isset($_SESSION[$status])) {
        echo "<div class=\"alert alert-{$status} text-dark\" role\"alert\">{$_SESSION[$status]}</div>";
        unset($_SESSION[$status]);
    }
}

/* Redirect */
function redirect_to($path)
{
    /*
    Parameters:
            $path — string

    Description: redirect to the specific page

    Return value: null
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

/* Files */
function is_file_empty($file)
{
    /*
    Parameters:
            $file — array

    Description: defines whether file is passed

    Return value: boolean
    */

    return empty($file['name']);
}

function is_image($file)
{
    /*
    Parameters:
            $file — array

    Description: defines whether file has image type

    Return value: boolean
    */

    $allowed_extensions = array("jpg", "jpeg", "gif", "png");
    $file_extension = pathinfo($file['name'])["extension"];
    return in_array($file_extension, $allowed_extensions);
}

function get_unique_image_name($file)
{
    /*
    Parameters:
            $file — array

    Description: returns unique name for image

    Return value: string
    */

    list($width, $height) = getimagesize($file['tmp_name']);
    return uniqid() . "-size-{$width}-{$height}-{$file['name']}";
}

function upload_image_to_dir($filed_directory, $file, $filename)
{
    /*
    Parameters:
            $filed_directory — string
            $file — array
            $filename — string

    Description: uploads image to the specific directory

    Return value: null
    */

    move_uploaded_file($file['tmp_name'], $filed_directory . $filename);
}
