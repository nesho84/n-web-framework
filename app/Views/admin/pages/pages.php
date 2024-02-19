<!-- Page Header -->
<?php
displayHeader([
    'title' => 'Pages',
    'btnText' => 'Create New +',
    'btnLink' => ADMURL . '/pages/create',
    'btnClass' => 'success',
]);
?>

<div class="container-lg">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-info-circle fa-lg"></i> Info
        </div>
        <div class="card-body">
            <!-- <h5 class="card-title"></h5> -->
            <p class="card-text">Pages can include text, pictures, tables, plain HTML.</p>
        </div>
    </div>

    <div class="table-responsive border-top mt-3">
        <table class="table table-<?php echo $data['sessions']['theme'] ?? 'light'; ?> table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Language</th>
                    <th scope="col">User</th>
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

                        // User Permissions
                        $canEdit = $data['permissions']['canEdit']($d['userID'], $d['userRole']);
                        $canDelete = $data['permissions']['canDelete']($d['userID'], $d['userRole']);

                        $pageStatus = $d['pageStatus'] == 1 ? '<span style="color:#00E676;font-size:1.3em;"><i class="fas fa-circle"></i></span>' : '<span style="color:#dc3545;font-size:1.3em;"><i class="fas fa-circle"></i></span>';

                        $editIcon = $canEdit ? '<a class="btn btn-link" href="' . ADMURL . '/pages/edit/' . $d['pageID'] . '"><i class="far fa-edit"></i></a>' : '<button type="button" class="btn btn-link" disabled><i class="far fa-edit"></i></i></button>';

                        $deleteIcon = $canDelete ? '<a class="btn btn-link btn-delete" href="' . ADMURL . '/pages/delete/' . $d['pageID'] . '"><i class="far fa-trash-alt"></i></a>' : '<button type="button" class="btn btn-link" disabled><i class="far fa-trash-alt btn-delete"></i></button>';

                        echo '<tr>
                            <th scope="row">' . $counter . '</th>
                            <td>' . $d['pageName'] . '</td>
                            <td>' . $d['languageName'] . '</td>
                            <td>' . $d['userName'] . '</td>
                            <td class="text-center">' . $pageStatus . '</td>
                            <td class="text-center">
                                ' . $editIcon . '
                                ' . $deleteIcon . '
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

<?php
// Additional scripts to include in the footer
$additionalScripts = [
    APPURL . '/app/js/pages.js',
];
?>