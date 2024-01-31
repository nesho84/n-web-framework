<!-- Page Header -->
<?php
displayHeader([
    'title' => 'Users',
    'btnText' => 'Create New +',
    'btnLink' => ADMURL . '/users/create',
    'btnClass' => 'success',
]);
?>

<div class="container-lg">
    <div class="table-responsive border-top mt-3">
        <table class="table table-<?php echo $data['theme'] ?? 'light'; ?> table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="ps-3">User</th>
                    <th scope="col">User Email</th>
                    <th scope="col">User Role</th>
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

                        $isOwner = App\Auth\UserPermissions::isOwner($d['userID']);

                        $userStatus = $d['userStatus'] == 1 ? '<span style="color:#00E676;font-size:1.3em;"><i class="fas fa-circle"></i></span>' : '<span style="color:#dc3545;font-size:1.3em;"><i class="fas fa-circle"></i></span>';

                        $editIcon = $isOwner ? '<a class="btn btn-link" href="' . ADMURL . '/users/edit/' . $d['userID'] . '"><i class="far fa-edit"></i></a>' : '<button type="button" class="btn btn-link" disabled><i class="far fa-edit"></i></i></button>';

                        $deleteIcon = $isOwner && $d['userName'] !== 'admin' ? '<a class="btn btn-link btn-delete" href="' . ADMURL . '/users/delete/' . $d['userID'] . '"><i class="far fa-trash-alt"></i></a>' : '<button type="button" class="btn btn-link" disabled><i class="far fa-trash-alt btn-delete"></i></button>';

                        $pic = !empty($d['userPicture']) ? '<img width="60" height="60" src="' . $d['userPicture'] . '" class="rounded-circle" alt="...">' : '<img width="60" height="60" src="' . APPURL . '/public/images/no_pic.png" class="img-fluid" alt="...">';

                        echo '<tr>
                                <th scope="row">' . $counter . '</th>
                                <td>' . $pic . '&nbsp;&nbsp;' . $d['userName'] . '</td>
                                <td>' . $d['userEmail'] . '</td>
                                <td>' . $d['userRole'] . '</td>
                                <td class="text-center">' . $userStatus . '</td>
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
    APPURL . '/app/js/users.js',
];
?>