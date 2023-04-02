<!-- Page Header -->
<?php
showHeading(['title' => 'Settings']);
?>

<div class="container-lg">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Database Backup</h5>
            <p class="card-text">This will backup the Database and store it in a file.</p>
            <!-- <a href="#" class="btn btn-success"><i class="far fa-save"></i> Backup</a> -->
            <form id="formBackup" action="<?php echo ADMURL . '/settings/db_backup'; ?>" method="POST" enctype="multipart/form-data">
                <button type="submit" id="backup_db" name="backup_db" class="btn btn-success"><i class="far fa-save"></i> Backup</button>
            </form>

            <br>

            <!-- Modal -->
            <a href="<?php echo APPURL . '/admin/settings/db_list_backups/'; ?>" class="d-modal btn btn-info" data-title="Database Backups">See Backups</a>
        </div>
    </div>

    <div class="table-responsive border-top mt-3">
        <table class="table table-<?= $data['theme'] ?? 'light' ?> table-hover">
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
                $rows = $data['rows'];
                if (isset($rows) && is_array($rows) && (count($rows) > 0)) {
                    $counter = 0;
                    foreach ($rows as $d) {
                        $counter += 1;

                        $settingStatus = $d['settingStatus'] == 1 ? '<span style="color:#00E676;font-size:1.3em;"><i class="fas fa-circle"></i></span>' : '<span style="color:#dc3545;font-size:1.3em;"><i class="fas fa-circle"></i></span>';

                        $editIcon = ($d['userName'] === 'admin' && $_SESSION['user']['name'] !== 'admin') ? '<button type="button" class="btn btn-link" disabled><i class="far fa-edit"></i></button>' : '<a class="d-modal btn btn-link" href="' . ADMURL . '/settings/edit_modal/' . $d['settingID'] . '" data-title="Settings - ' . $d['userName'] . '" data-submit="true"><i class="far fa-edit"></i></a>';

                        echo '<tr>
                                <th scope="row">' . $counter . '</th>
                                <td>' . $d['userName'] . '</td>
                                <td>' . $d['languageName'] . '</td>
                                <td>' . $d['settingTheme'] . '</td>
                                <td class="text-center">' . $settingStatus . '</td>
                                <td class="text-center">
                                ' . $editIcon . '
                                </td>
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

<script>
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        // Attach the submit event handler to the form (ajax.js)
        const form = document.querySelector("#formBackup");
        if (form) {
            form.addEventListener("submit", (event) => {
                handleFormSubmit(event);
            });
        }
    });
</script>