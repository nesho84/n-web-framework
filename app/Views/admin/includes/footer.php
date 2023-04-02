</main> <!-- main end -->

<?php
// Set Dashboard Footer Theme
$footerTheme = $_SESSION['settings']['settingTheme'] ?? "dark";
$textTheme = $footerTheme === "dark" ? "light" : "dark";
?>

<footer class="bg-<?= $footerTheme ?> text-<?= $textTheme ?> border-top mt-3">
    <!-- App Version -->
    <p class="mt-3">Version <strong><?php echo APP_VERSION; ?></strong></p>
</footer>

</div> <!-- wrapper end -->

<!-- Bootstrap core JS -->
<script src="<?php echo APPURL; ?>/public/js/libs/bootstrap.bundle.min.js"></script>
<!-- sweetalert2 -->
<script src="<?php echo APPURL; ?>/public/js/libs/sweetalert2.all.min.js"></script>
<!-- My Scripts -->
<script src="<?php echo APPURL; ?>/app/js/ajax.js"></script>
<script src="<?php echo APPURL; ?>/app/js/main.js"></script>
<script src="<?php echo APPURL; ?>/app/js/modal.js"></script>
<script src="<?php echo APPURL; ?>/app/js/modal_pdf.js"></script>

</body>

</html>