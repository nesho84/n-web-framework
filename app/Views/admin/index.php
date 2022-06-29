<div class="container-lg py-4">

    <div class="author">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-1">
                    Welcome back <strong><?php echo $_SESSION['userName']; ?></strong>
                </h3>
                <hr class="mb-3 mt-2">
                <h5 class="card-text text-muted"><strong>Logged in as:</strong> <?php echo $_SESSION['userEmail'] ?? ''; ?></h5>
                <h6 class="card-text">
                    <!-- Show the last user visit -->
                    <?php
                    if (isset($_SESSION['last_login'])) {
                        echo '<small><strong>Last login:</strong> ' . date('d/m/Y H:i:s', $_SESSION['last_login']) . '</small>';
                    } else {
                        echo '<small>Welcome back</small>';
                    }
                    ?>
                </h6>
            </div>
        </div>
    </div>

    <hr>

    <div class="row text-center">
        <?php
        if (isset($data['rows'])) {
            $tableName = "";
            $icon = "";

            foreach ($data['rows'] as $d) {
                if ($d['table_name'] == 'category') {
                    $tableName = 'Categories';
                    $icon = '<i class="fas fa-tasks fa-3x mt-3"></i>';
                }
                if ($d['table_name'] == 'pages') {
                    $tableName = 'Pages';
                    $icon = '<i class="fas fa-archive fa-3x mt-3"></i>';
                }
                if ($d['table_name'] == 'product') {
                    $tableName = 'Product';
                    $icon = '<i class="fas fa-archive fa-3x mt-3"></i>';
                }
                if ($d['table_name'] == 'user') {
                    $tableName = 'Users';
                    $icon = '<i class="fas fa-id-card-alt fa-3x mt-3"></i>';
                }
                echo '<div class="col-md-6 col-lg-4 col-sm-6 mx-0 mb-4">
                    <a href="' . APPURL . '/admin/' . strtolower($tableName) . '" class="text-decoration-none">
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
        } else {
            echo '<div class="col mb-4 text-center alert alert-secondary" role="alert">
                <i class="fas fa-info-circle fa-2x"></i><br/>No Data<br/> Available
            </div>';
        }
        ?>
    </div>

</div>