<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME . ' - ' . $data["title"] ?? SITE_NAME . " - Login"; ?></title>
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
    <main class="form-signin">
        <form id="formLogin" method="POST">
            <div class="text-center">
                <img class="mb-4" src="<?php echo APPURL; ?>/public/images/logo1.png" alt="" height="72">
                <h4 class="mb-3">Please sign in</h4>
                <!-- Show the last user visit -->
                <?php
                if (isset($_COOKIE['last_login'])) {
                    echo '<small><strong>Last login:</strong> ' . date('d/m/Y H:i:s', $_COOKIE['last_login']) . '</small>';
                } else {
                    echo '<small>Welcome back</small>';
                }
                ?>
                <hr class="mt-2">
            </div>
            <div class="form-floating mb-1">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo isset($_COOKIE["email"]) ? $_COOKIE["email"] : "" ?>" required>
                <label for="email">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="" required>
                <label for="password">Password</label>
            </div>
            <div class="checkbox my-3">
                <label>
                    <input type="checkbox" class="custom-control-input" name="loginRemember" id="loginRemember" <?php echo isset($_COOKIE["email"]) ? "checked" : "" ?>> Remember me
                </label>
            </div>
            <button type="submit" id="btnLogin" name="btnLogin" class="w-100 btn btn-primary btn-lg">Login</button>

            <!-- Output login_results -->
            <div id="login_result" class="mt-3"></div>

            <p class="text-center mt-4"><a href="<?php echo APPURL; ?>">← Go back to <?php echo SITE_NAME; ?></a></p>
        </form>
    </main>

    <!-- Login Ajax START -->
    <script>
        document.getElementById("formLogin").addEventListener("submit", (e) => {
            e.preventDefault();
            const login_result = document.getElementById("login_result");
            const formLogin = new FormData(document.getElementById("formLogin"));
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'login/validate', true);
            xhr.onload = () => {
                // Process our return data
                if (xhr.status >= 200 && xhr.status < 400) {
                    console.log(xhr.responseText);
                    // Check for cookies first
                    if (navigator.cookieEnabled == false) {
                        login_result.innerHTML = "<p class='text-danger fw-bold bg-light rounded border p-3 mb-4'>Please enable Cookies and try again to Continue.</p>";
                        return false;
                    } else {
                        // Success
                        if (xhr.responseText.trim() === 'success') {
                            window.location.replace("<?php echo $data["last_page"]; ?>");
                        } else {
                            login_result.innerHTML = "<div class='text-danger bg-light rounded border p-3 mb-4'>" + xhr.responseText + "</div>";
                        }
                    }
                } else {
                    // Failed
                    console.log('error: ', xhr);
                }
            };
            xhr.send(formLogin);
        });
    </script>
    <!-- Login Ajax END -->

</body>

</html>