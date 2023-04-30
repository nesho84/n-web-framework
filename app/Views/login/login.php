<?php require_once VIEWS_PATH . "/login/includes/header.php"; ?>

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
                const result = JSON.parse(xhr.response);
                const message = result.message;
                // Check for cookies first
                if (navigator.cookieEnabled == false) {
                    login_result.innerHTML = "<p class='text-danger fw-bold bg-light rounded border p-3 mb-4'>Please enable Cookies and try again to Continue.</p>";
                    return false;
                } else {
                    console.log(result);
                    // Success
                    if (message.trim() === 'success') {
                        window.location.reload();
                    } else {
                        login_result.innerHTML = "<div class='text-danger bg-light rounded border p-3 mb-4'>" + message + "</div>";
                    }
                }
            } else {
                // Failed
                console.log('error: ', message);
            }
        };
        xhr.send(formLogin);
    });
</script>
<!-- Login Ajax END -->

<?php require_once VIEWS_PATH . "/login/includes/footer.php"; ?>