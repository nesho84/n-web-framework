<?php
$rows = $data['rows'];
if (isset($rows) && is_array($rows)) {
    // Convert array keys into variables
    extract($rows);

    $pic = !empty($userPicture) ? '<img width="110" height="110" src="' . $userPicture . '" class="rounded-circle" alt="...">' : '<img width="110" height="110" src="' . APPURL . '/public/images/no_pic.png" class="img-fluid" alt="...">';
?>

    <div class="card">
        <div class="card-body">
            <p>settings form...</p>
        </div>
    </div>

<?php
} else {
?>

    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <p>n settings found for this user...</p>
                <button class="btn btn-success">create settings</button>
                <form action="" method="post"></form>
            </div>
        </div>
    </div>

<?php
}
?>