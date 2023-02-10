<?php
if ($data['rows'] > 0) {
    // Convert array keys into variables
    extract($data['rows']);

    // Page Heading
    showHeading([
        'title' => 'User Profile',
        'title2' => '<strong>ID: </strong>' . $userID,
    ]);

    $pic = !empty($userPicture) ? '<img width="110" height="110" src="' . $userPicture . '" class="rounded-circle" alt="...">' : '<img width="110" height="110" src="' . APPURL . '/public/images/no_pic.png" class="img-fluid" alt="...">';
?>

    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <div class="">
                        <p><?= $pic; ?></p>
                        <p class="text-secondary"><span class="fw-bold">UserName:</span> <?= $userName; ?></p>
                        <p class="text-secondary"><span class="fw-bold">UserEmail:</span> <?= $userEmail; ?></p>
                        <?php echo $userRole == 'admin' ? '<p class="text-secondary"><span class="fw-bold">UserRole:</span> Admin</p>' : '<p class="text-secondary">UserRole: Default</p>'; ?>
                    </div>
                    <div class="align-self-start">
                        <a class="btn btn-outline-secondary" href="<?= ADMURL . '/users/edit/' . $userID; ?>">
                            <i class="far fa-edit"></i> Edit
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php
} else {
    showNoDataBox("No data found", ADMURL . "/users");
}
?>