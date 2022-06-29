<div class="container-lg py-4">

    <?php
    // Extract array values into variables
    extract($data['rows']);

    // Page Header
    pageHeader([
        'title' => 'Edit User',
        'title2' => '<strong>ID: </strong>' . $userID,
    ]);
    ?>

    <div class="card">
        <div class="card-body">
            <form id="formUsers" action="<?php echo ADMURL . '/users/update/' . $userID ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="userName" class="form-label fw-bold">Username</label>
                    <input type="text" class="form-control" id="userName" name="userName" placeholder="Username" value="<?php echo $userName; ?>">
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label fw-bold">Email</label>
                    <input type="text" class="form-control" id="userEmail" name="userEmail" placeholder="Email" value="<?php echo $userEmail; ?>">
                </div>
                <div class="mb-3">
                    <label for="userOldPassword" class="form-label fw-bold">Old Password</label>
                    <input type="password" class="form-control" id="userOldPassword" name="userOldPassword" placeholder="Password" value="" autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <label for="userNewPassword" class="form-label fw-bold">New Password</label>
                    <input type="password" class="form-control" id="userNewPassword" name="userNewPassword" placeholder="Password" value="" autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <label for="userNewPassword2" class="form-label fw-bold">Confirm New Password</label>
                    <input type="password" class="form-control" id="userNewPassword2" name="userNewPassword2" placeholder="Confirm Password" value="">
                </div>
                <!-- User Role -->
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="userRole" name="userRole" <?php echo $userRole == "admin" ? " checked" : "" ?>>
                    <label class="form-check-label fw-bold" for="userRole">Admin (unchecked is default)</label>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                    <input type="submit" id="update_user" name="update_user" class="btn btn-primary btn-lg" value="Save" />
                    <a href="<?php echo ADMURL . "/users"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>