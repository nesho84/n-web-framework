<div class="container-lg py-4">

    <div class="card">
        <div class="card-body">
            <h3 class="card-title mb-1">
                Welcome back <strong><?php echo $_SESSION['user']['name'] ?? ""; ?></strong>
            </h3>
            <hr class="mb-3 mt-2">
            <h5 class="card-text text-muted"><strong>Logged in as:</strong> <?php echo $_SESSION['user']['email'] ?? ''; ?></h5>
            <h6 class="card-text">
                <!-- Show the last user visit -->
                <?php
                if (isset($_SESSION['user']['last_login'])) {
                    echo '<small><strong>Last login:</strong> ' . date('d/m/Y H:i:s', $_SESSION['user']['last_login']) . '</small>';
                } else {
                    echo '<small>Welcome back</small>';
                }
                // echo "<p class='mt-2'><strong>Session token:</strong> " . $_SESSION['user']['session_token'] . '</p>';
                ?>
            </h6>
        </div>
    </div>

    <hr>

    <?php
    $rows = $data['rows'];
    if (isset($rows) && is_array($rows) && (count($rows) > 0)) {
        echo '<div class="row text-center g-3">';

        $tableName = "";
        $icon = "";

        $isDisabled = false;
        $disabledStyle = 'style="pointer-events: none; color:#b9b8b8"';

        $isModal = false;
        $modalParams = '';

        foreach ($rows as $d) {
            if ($d['table_name'] == 'categories') {
                $tableName = 'Categories';
                $icon = '<i class="fas fa-tasks fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }
            if ($d['table_name'] == 'pages') {
                $tableName = 'Pages';
                $icon = '<i class="fas fa-archive fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }
            if ($d['table_name'] == 'languages') {
                $tableName = 'Languages';
                $icon = '<i class="fas fa-archive fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }
            if ($d['table_name'] == 'settings') {
                $tableName = 'Settings';
                $icon = '<i class="fas fa-archive fa-3x mt-3"></i>';
                $isDisabled = false;
                // $isModal = true;
                // $modalParams = ' d-modal="true" data-submit="true" data-title="Settings"';
            }
            if ($d['table_name'] == 'translations') {
                $tableName = 'Translations';
                $icon = '<i class="fas fa-archive fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }
            if ($d['table_name'] == 'users') {
                $tableName = 'Users';
                $icon = '<i class="fas fa-id-card-alt fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }
            if ($d['table_name'] == 'files') {
                $tableName = 'Files';
                $icon = '<i class="fas fa-id-card-alt fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }

            echo '<div class="col-md-6 col-lg-4 col-sm-6 mx-0">
                    <a href="' . APPURL . '/admin/' . strtolower($tableName) . '" class="text-decoration-none" ' . ($isDisabled ? $disabledStyle : "") . ($isModal ? $modalParams : "") . '>
                        <div class="card shadow-sm">
                            <div class="card-body pb-5">
                                <p class="display-3">' . $d['table_rows'] . '</p>
                                <h4 class="card-text">' . strtoupper($tableName) . '</h4>
                                ' . $icon . '
                            </div>
                        </div>
                    </a>
                </div>';
        }
        echo '</div>'; // row end
    } else {
        showNoDataBox("No data found");
    }
    ?>

</div>