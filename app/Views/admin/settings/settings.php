<!-- Page Header -->
<?php displayHeader(['title' => 'Settings']); ?>

<div class="container-lg">
    <!-- Database Backup -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-2">
                <h5 class="card-title m-0">Database Backup</h5>
                <!-- Backups Modal -->
                <a href="<?php echo APPURL . '/admin/settings/dbbackups_modal'; ?>" class="d-modal btn btn-sm btn-outline-secondary" data-title="Database Backups">
                    <i class="far fa-list-alt"></i> All Backups
                </a>
            </div>
            <p class="card-text text-muted"><small>Backup is the process of creating, managing, and storing copies of data <br> in case it's lost, corrupted, or damaged.</small></p>
            <!-- Backup Form -->
            <form id="formBackup" action="<?php echo ADMURL . '/settings/dbbackup'; ?>" method="POST" enctype="multipart/form-data">
                <button type="submit" id="dbbackup" name="dbbackup" class="btn btn-outline-dark">
                    Backup <i class="fas fa-file-export ms-1"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Themes and Languages -->
    <div class="card mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-2">
                <h5 class="card-title m-0">Theme and Language</h5>
                <!-- Backups Modal -->
                <a href="<?php echo APPURL . '/admin/languages'; ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-archive"></i> Languages
                </a>
            </div>
            <div class="table-responsive border-top mt-3">
                <table class="table table-<?php echo $data['theme'] ?? 'light'; ?> table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="ps-3">User</th>
                            <th scope="col">Language</th>
                            <th scope="col">Theme</th>
                            <th scope="col" class='text-center'>Status</th>
                            <th scope="col" class='text-center'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rows = $data['rows'] ?? [];
                        if ($rows && count($rows) > 0) {
                            $counter = 0;
                            foreach ($rows as $d) {
                                $counter += 1;

                                $settingStatus = $d['settingStatus'] == 1 ? '<span style="color:#00E676;font-size:1.3em;"><i class="fas fa-circle"></i></span>' : '<span style="color:#dc3545;font-size:1.3em;"><i class="fas fa-circle"></i></span>';

                                $editIcon = ($d['userName'] === 'admin' && $_SESSION['user']['name'] !== 'admin') ? '<button type="button" class="btn btn-link" disabled><i class="far fa-edit"></i></button>' : '<a class="d-modal btn btn-link" href="' . ADMURL . '/settings/edit_modal/' . $d['settingID'] . '" data-title="User: ' . $d['userName'] . '" data-submit="true"><i class="far fa-edit"></i></a>';

                                echo '<tr>
                                <th scope="row">' . $counter . '</th>
                                <td>' . $d['userName'] . '</td>
                                <td>' . $d['languageName'] . '</td>
                                <td>' . $d['settingTheme'] . '</td>
                                <td class="text-center">' . $settingStatus . '</td>
                                <td class="text-center">' . $editIcon . '</td>
                            </tr>';
                            }
                        } else {
                            echo '<tr>
                            <td colspan="7"><h1 class="text-info text-center">No Records</h1></td>
                        </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
// Additional scripts to include in the footer
$additionalScripts = [
    APPURL . '/app/js/settings.js',
];
?>