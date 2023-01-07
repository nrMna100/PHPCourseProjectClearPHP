<?
session_start();
require "functions.php";

if (!user_is_authorized())
    redirect_to("/page_login.php");

$user_id = $_GET["user_id"];

$user = get_user_by_id($user_id);
$detailed_user_info = get_user_by_id($user_id, "users_secondary_info");
$user_socials = get_user_by_id($user_id, "users_socials");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
</head>

<body class="mod-bg-1 mod-nav-link">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
        <a class="navbar-brand d-flex align-items-center fw-500" href="#"><img alt="logo" class="d-inline-block align-top mr-2" src="img/logo.png"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="users.php">Главная</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Войти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>

    <main id="js-page-content" role="main" class="page-content mt-3">
        <? display_flash_message("success");  ?>

        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-user'></i> <?= $detailed_user_info["username"]; ?>
            </h1>
        </div>

        <div class="row">
            <div class="col-lg-6 col-xl-6 m-auto">
                <!-- profile summary -->
                <div class="card mb-g rounded-top">
                    <div class="row no-gutters row-grid">
                        <div class="col-12">
                            <div class="d-flex flex-column align-items-center justify-content-center p-4">
                                <img src="<?= 'img/avatars/' . $detailed_user_info["avatar"]; ?>" class="rounded-circle shadow-2 img-thumbnail" alt="">
                                <h5 class="mb-0 fw-700 text-center mt-3">
                                    <?= $detailed_user_info["username"]; ?>
                                    <small class="text-muted mb-0"><?= $detailed_user_info["workplace"]; ?></small>
                                </h5>
                                <div class="mt-4 text-center demo">
                                    <? if (!empty($user_socials["instagram"])) : ?>
                                        <a href="<?= $user_socials["instagram"]; ?>" class="fs-xl" style="color:#C13584">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    <? endif; ?>
                                    <? if (!empty($user_socials["vk"])) : ?>
                                        <a href="<?= $user_socials["vk"]; ?>" class="fs-xl" style="color:#4680C2">
                                            <i class="fab fa-vk"></i>
                                        </a>
                                    <? endif; ?>
                                    <? if (!empty($user_socials["telegram"])) : ?>
                                        <a href="<?= $user_socials["telegram"]; ?>" class="fs-xl" style="color:#0088cc">
                                            <i class="fab fa-telegram"></i>
                                        </a>
                                    <? endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 text-center">
                                <a href="tel:<?= $detailed_user_info["phone"]; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> <?= $detailed_user_info["phone"]; ?></a>
                                <a href="mailto:<?= $user["email"]; ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> <?= $user["email"]; ?></a>
                                <address class="fs-sm fw-400 mt-4 text-muted">
                                    <i class="fas fa-map-pin mr-2"></i> <?= $detailed_user_info["address"]; ?>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

<script src="js/vendors.bundle.js"></script>
<script src="js/app.bundle.js"></script>
<script>
    $(document).ready(function() {

    });
</script>

</html>
