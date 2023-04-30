<?php require_once VIEWS_PATH . "/errors/includes/header.php"; ?>

<div class="container d-flex flex-column align-items-center justify-content-center text-center vh-100">
    <h1 class="m-0">JavaScript is off</h1>
    <h1 class="my-2">&#128533;</h1>
    <h6 class="text-muted">JavaScript is not enabled, please check your browser settings and try again.</h6>
</div>

<!-- If Javascript is Enabled then redirect -->
<script>
    window.history.back();
</script>

<?php require_once VIEWS_PATH . "/errors/includes/footer.php"; ?>