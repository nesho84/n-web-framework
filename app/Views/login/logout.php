<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME . ' - ' . $data["title"] ?? SITE_NAME . " - Logout"; ?></title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/public/css/libs/bootstrap.min.css" />
    <!-- Custom styles -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/public/css/login.css" />
    <!-- Favicon for All Devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo APPURL; ?>/public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo APPURL; ?>/public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo APPURL; ?>/public/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo APPURL; ?>/public/favicon/site.webmanifest">
</head>

<body class="text-center">
    <div class="container h-100">
        <div class="d-flex justify-content-center align-items-center">
            <div class="row">
                <div class="col mx-auto">
                    <div class="jumbotron text-center text-danger border shadow-sm p-5">
                        <div class="text-center">
                            <img class="mb-4" src="<?php echo APPURL; ?>/public/images/logo1.png" alt="" height="72">
                            <h5 class="text-success">You have successfully logged out.</h5>
                        </div>

                        <?php
                        // Direct logout if session expired or with Timeout
                        $expire = filter_input(INPUT_GET, 'expire', FILTER_VALIDATE_INT);
                        if (isset($expire) && $expire === 1) {
                            redirect(APPURL . '/login');
                        } else {
                            echo '<script>
                                    setTimeout(function() {
                                        window.location.replace("' . APPURL . '/login");
                                    }, 1500);
                                </script>';
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>