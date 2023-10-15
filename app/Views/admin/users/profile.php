<?php
$rows = $data['rows'] ?? [];
if ($rows && count($rows) > 0) {
    // Convert array keys into variables
    extract($rows);

    $pic = !empty($userPicture) ? '<img width="110" height="110" src="' . $userPicture . '" class="rounded-circle" alt="...">' : '<img width="110" height="110" src="' . APPURL . '/public/images/no_pic.png" class="img-fluid" alt="...">';
?>

    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between">
                <div class="">
                    <p><?php echo $pic; ?></p>
                    <p class="text-secondary"><span class="fw-bold">UserName:</span> <?php echo $userName; ?></p>
                    <p class="text-secondary"><span class="fw-bold">UserEmail:</span> <?php echo $userEmail; ?></p>
                    <?php echo $userRole == 'admin' ? '<p class="text-secondary"><span class="fw-bold">UserRole:</span> Admin</p>' : '<p class="text-secondary">UserRole: Default</p>'; ?>
                </div>
                <div class="align-self-start">
                    <a class="btn btn-outline-secondary" href="<?php echo ADMURL . '/users/edit/' . $userID; ?>">
                        <i class="far fa-edit"></i> Edit
                    </a>
                </div>
            </div>

        </div>
    </div>

<?php
} else {
    displayNoDataBox("No data found", ADMURL . "/users");
}
?>