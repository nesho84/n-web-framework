</main> <!-- main end -->

<?php
// Set Dashboard Footer Theme
$footerTheme = $_SESSION['settings']['settingTheme'] ?? "dark";
$textTheme = $footerTheme === "dark" ? "light" : "dark";
?>

<footer class="bg-<?php echo $footerTheme; ?> text-<?php echo $textTheme; ?> border-top">
    <!-- App Version -->
    <p class="my-2">Version <strong><?php echo APP_VERSION; ?></strong></p>
</footer>

</div> <!-- wrapper end -->

<!-- Bootstrap v5.1.3 core JS -->
<script src="<?php echo APPURL; ?>/public/js/libs/bootstrap.bundle.min.js"></script>
<!-- sweetalert2 v11.7.3 -->
<script src="<?php echo APPURL; ?>/public/js/libs/sweetalert2.all.min.js"></script>
<!-- dselectjs v1.0.4 -->
<script src="<?php echo APPURL; ?>/public/js/libs/dselect/dselect.min.js"></script>
<!-- fullcalendar v6.1.6 -->
<script src="<?php echo APPURL; ?>/public/js/libs/fullcalendar/index.global.min.js"></script>
<!-- My Scripts -->
<script src="<?php echo APPURL; ?>/app/js/ajax.js"></script>
<script src="<?php echo APPURL; ?>/app/js/main.js"></script>
<script src="<?php echo APPURL; ?>/app/js/modal.js"></script>
<script src="<?php echo APPURL; ?>/app/js/modal_files.js"></script>

</body>

</html>