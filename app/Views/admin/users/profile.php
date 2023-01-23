<div class="container-lg py-4">

    <?php
    // Extract array values into variables
    extract($data['rows']);

    // Page Header
    pageHeader([
        'title' => 'User Profile',
        'title2' => '<strong>ID: </strong>' . $userID,
    ]);

    $pic = $userPicture !== "" ? '<img width="60" height="60" src="' . $userPicture . '" class="rounded-circle" alt="...">' : '<img width="60" height="60" src="' . APPURL . '/public/images/no_pic.png" class="img-fluid" alt="...">';
    ?>

    <div class="card">
        <div class="card-body">
            <?php echo '<p>' . $pic . '</p>'; ?>
            <?php echo '<p class="text-secondary">UserName: ' . $userName . '</p>'; ?>
            <?php echo '<p class="text-secondary">UserEmail: ' . $userEmail . '</p>'; ?>
            <?php echo $userRole == 'admin' ? '<p class="text-secondary">UserRole: Admin</p>' : '<p class="text-secondary">UserRole: Default</p>'; ?>
        </div>
    </div>

</div>