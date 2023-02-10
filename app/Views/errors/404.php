<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page not found</title>
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

<body class="d-flex min-vh-100 align-items-center">

    <div class="container">
        <div class="d-flex justify-content-center align-items-center">
            <div class="row">
                <div class="col-md-12">
                    <div class="error-template">
                        <h1>Oops!</h1>
                        <h2>404 Not Found</h2>
                        <div class="error-details">
                            Sorry, an error has occured, Requested page not found!
                        </div>
                        <div class="error-actions">
                            <a href="<?php echo APPURL; ?>" class="btn btn-primary btn-lg mb-3">
                                <i class="fas fa-home"></i> Take Me Home
                            </a>
                            <a href="mailto:ademi.neshat@gmail.com" class="btn btn-outline-secondary btn-lg mb-3">
                                <i class="fas fa-envelope"></i> Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>