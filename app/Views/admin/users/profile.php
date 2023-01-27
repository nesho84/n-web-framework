<div class="container-lg py-4">

    <?php
    // Extract array values into variables
    extract($data['rows']);

    // Page Header
    pageHeader([
        'title' => 'User Profile',
        'title2' => '<strong>ID: </strong>' . $userID,
    ]);

    $pic = !empty($userPicture) ? '<img width="60" height="60" src="' . $userPicture . '" class="rounded-circle" alt="...">' : '<img width="60" height="60" src="' . APPURL . '/public/images/no_pic.png" class="img-fluid" alt="...">';
    ?>

    <div class="card">
        <div class="card-body">
            <p><?= $pic; ?></p>
            <p class="text-secondary"><span class="fw-bold">UserName:</span> <?= $userName; ?></p>
            <p class="text-secondary"><span class="fw-bold">UserEmail:</span> <?= $userEmail; ?></p>
            <?php echo $userRole == 'admin' ? '<p class="text-secondary"><span class="fw-bold">UserRole:</span> Admin</p>' : '<p class="text-secondary">UserRole: Default</p>'; ?>
            <a class="btn btn-outline-secondary" href="<?= ADMURL . '/users/edit/' . $userID; ?>">
                <i class="far fa-edit"></i> Edit
            </a>
        </div>
    </div>

</div>