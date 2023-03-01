<?php
// Set title
$title = $data['title'] ?? "";
// Set Theme
$baseTheme = $_SESSION['settings']['settingTheme'] ?? "dark";
$navbarTheme = $baseTheme == "dark" ? "dark" : "light";
$menuSpanTheme = $baseTheme == "dark" ? "light" : "dark";
$bodyTheme = $baseTheme == "dark" ? "dark" : "white";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title != "" ? $title : "undefined"; ?></title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/public/css/libs/bootstrap.min.css" />
    <!-- Font awesome icons -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/public/css/libs/fontawesome/css/all.min.css">
    <!-- Custom styles -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/public/css/main.css" />
    <!-- Favicon for All Devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo APPURL; ?>/public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo APPURL; ?>/public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo APPURL; ?>/public/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo APPURL; ?>/public/favicon/site.webmanifest">
</head>

<body class="bg-<?= $bodyTheme ?>">

    <div class="wrapper">

        <header class="sticky-top border-bottom">
            <nav class="navbar shadow-sm navbar-expand-lg navbar-<?= $navbarTheme ?> bg-<?= $navbarTheme ?> py-2">
                <div class="container-lg">
                    <div class="navbar-brand">
                        <!-- <a href="<?php echo ADMURL; ?>/">
                            <img class="py-0 my-0 mr-0" src="<?php echo APPURL; ?>/public/images/logo1.png" height="60px" alt="logo">
                        </a> -->
                        <a class="nav-link p-0" href="<?php echo ADMURL; ?>/">
                            <h3 class="text-info my-0">Dashboard - <?php echo SITE_NAME; ?></h3>
                        </a>
                    </div>
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar bg-<?= $menuSpanTheme ?>"></span>
                        <span class="icon-bar bg-<?= $menuSpanTheme ?>"></span>
                        <span class="icon-bar bg-<?= $menuSpanTheme ?>"></span>
                    </button>

                    <!-- Navigation Menu Links -->
                    <?php require_once VIEWS_PATH . "/admin/includes/menu.php"; ?>

                </div>
            </nav>
        </header>

        <main>
            <!-- Flash Messages from the Session -->
            <?php getFlashMsg(); ?>