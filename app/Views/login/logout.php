<?php require_once VIEWS_PATH . "/login/includes/header.php"; ?>

<div class="container d-flex flex-column align-items-center justify-content-center text-center vh-100">
    <div class="text-danger border shadow-sm p-5">
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

<?php require_once VIEWS_PATH . "/login/includes/footer.php"; ?>