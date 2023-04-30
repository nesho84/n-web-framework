<?php
$PageMetaTitle = $data['page']["PageMetaTitle"] ?? "";
$PageMetaDescription = $data['page']["PageMetaDescription"] ?? "";
$PageMetaKeywords = $data['page']["PageMetaKeywords"] ?? "";
$pageTitle = $data['page']["pageTitle"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="<?php echo $PageMetaTitle != "" ? $PageMetaTitle : 'undefined'; ?>">
    <meta name="description" content="<?php echo $PageMetaDescription != "" ? $PageMetaDescription : 'undefined'; ?>">
    <meta name="keywords" content="<?php echo $PageMetaKeywords != "" ? $PageMetaKeywords : 'undefined'; ?>">
    <meta name="copyright" content="Copyright © <?php echo SITE_NAME; ?>">
    <meta name="designer" content="nademi.com">
    <meta name="robots" content="index, follow, archive" />
    <meta name="googlebot" content="index, follow">
    <meta name="robots" content="NOODP">
    <meta name="robots" content="NOYDIR">
    <meta name="Revisit-after" content="31 Days">
    <meta name="Rating" content="General">
    <meta name="Distribution" content="">
    <meta name="language" content="German">
    <meta name="author" content="Neshat Ademi">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <noscript>
        <meta http-equiv="refresh" runat="server" id="mtaJSCheck" content="0; <?php echo APPURL; ?>/noscript">
    </noscript>
    <title><?php echo $pageTitle != "" ? $pageTitle . " - " . SITE_NAME : 'undefined'; ?></title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/public/css/libs/bootstrap.min.css" />
    <!-- Font awesome icons -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/public/css/libs/fontawesome/css/all.min.css">
    <!-- Custom styles -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/public/css/main.css" />
    <!--  W3Schools Modal Image -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/public/css/popup.css" />
    <!-- Favicon for All Devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo APPURL; ?>/public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo APPURL; ?>/public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo APPURL; ?>/public/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo APPURL; ?>/public/favicon/site.webmanifest">
</head>

<body>
    <!-- Button to go on TOP -->
    <span id="scrollTopBtn" title=""><i class="fas fa-arrow-up fa-5x"></i></span>

    <div class="wrapper">

        <header class="sticky-top">
            <nav class="navbar shadow-sm navbar-expand-lg navbar-light bg-light py-2">
                <div class="container-lg">
                    <a class="navbar-brand py-0 mr-2" href="<?php echo APPURL; ?>/">
                        <img class="py-0 my-0" src="<?php echo APPURL; ?>/public/images/logo1.png" width="171px" height="58px" alt="logo">
                    </a>
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Navigation Menu Links -->
                    <?php require_once VIEWS_PATH . "/public/includes/menu.php"; ?>

                </div>
            </nav>
        </header>

        <main>

            <!-- The Image Preview Modal -->
            <div id="imagePreviewModal" class="image-modal">
                <span class="closeModal">
                    <button type="button" class="btn-close btn-close-white" aria-label="Close"></button>
                </span>
                <div id="caption"></div>
                <img class="image-modal-content" id="modalImg" alt="Image Preview">
                <!-- Loading Spinner -->
                <div id="img-preview-spinner" class="loading-spinner"></div>
            </div>