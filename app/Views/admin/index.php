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

    <hr class="mb-2">

    <?php
    $rows = $data['rows'];
    if (isset($rows) && is_array($rows) && (count($rows) > 0)) {
        echo '<div class="row text-center g-3">';

        $icon = "";

        $isDisabled = false;
        $disabledStyle = 'style="pointer-events: none; color:#b9b8b8"';

        $isModal = false;
        $modalParams = '';

        foreach ($rows as $d) {
            if ($d['Name'] == 'categories') {
                $icon = '<i class="fas fa-tasks fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }
            if ($d['Name'] == 'pages') {
                $icon = '<i class="fas fa-newspaper fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }
            if ($d['Name'] == 'languages') {
                $icon = '<i class="fas fa-globe fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }
            if ($d['Name'] == 'settings') {
                $icon = '<i class="fas fa-cogs fa-3x mt-3"></i>';
                $isDisabled = false;
                // $isModal = true;
                // $modalParams = ' d-modal="true" data-submit="true" data-title="Settings"';
            }
            if ($d['Name'] == 'translations') {
                $icon = '<i class="fas fa-language fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }
            if ($d['Name'] == 'users') {
                $icon = '<i class="fas fa-id-card-alt fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }
            if ($d['Name'] == 'files') {
                $icon = '<i class="fas fa-folder-open fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }
            if ($d['Name'] == 'invoices') {
                $icon = '<i class="fas fa-file-invoice fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }
            if ($d['Name'] == 'events') {
                $icon = '<i class="fas fa-calendar-alt fa-3x mt-3"></i>';
                $isDisabled = false;
                $isModal = false;
            }

            echo '<div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 mx-0">
                    <a href="' . APPURL . '/admin/' . strtolower($d['Name']) . '" class="text-decoration-none" ' . ($isDisabled ? $disabledStyle : "") . ($isModal ? $modalParams : "") . '>
                        <div class="card h-100 shadow-sm">
                            <div class="card-body position-relative pb-5">
                                <p class="display-3">' . $d['Rows'] . '</p>
                                <span class="badge bg-light text-muted m-2 position-absolute top-0 end-0">' . convertBytes($d['Data_length'], "KB") . '</span>
                                <h4 class="card-text">' . strtoupper($d['Name']) . '</h4>
                                ' . $icon . '
                            </div>
                        </div>
                    </a>
                </div>';
        }
        echo '</div>'; // row end
    } else {
        displayNoDataBox("No data found");
    }
    ?>

</div>