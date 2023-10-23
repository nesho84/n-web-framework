<!-- Page Header -->
<?php displayHeader(['title' => 'Create User']); ?>

<div class="container-lg">
    <div class="card">
        <div class="card-body">
            <form id="formUsers" action="<?php echo ADMURL . '/users/insert'; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="userName" class="form-label fw-bold">Username</label>
                    <input type="text" class="form-control" id="userName" name="userName" placeholder="Username" value="">
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label fw-bold">Email</label>
                    <input type="text" class="form-control" id="userEmail" name="userEmail" placeholder="Email" value="">
                </div>
                <div class="mb-3">
                    <label for="userPassword" class="form-label fw-bold">Password</label>
                    <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Password" value="" autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <label for="userPassword2" class="form-label fw-bold">Confirm Password</label>
                    <input type="password" class="form-control" id="userPassword2" name="userPassword2" placeholder="Confirm Password" value="">
                </div>
                <!-- User Picture -->
                <div class="mb-3">
                    <label for="userPicture" class="form-label fw-bold">Image <small class="fw-normal">(jpg", "jpeg", "gif", "png" and max. 150x150 pixels)</small></label>
                    <input class="form-control" type="file" name="userPicture" id="userPicture">
                    <div class="mt-2">
                        <div id="preview_image" class="rounded-circle"></div>
                        <div id="mySpinner" class="d-none">Loading...</div>
                    </div>
                </div>
                <!-- User Role -->
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="userRole" name="userRole">
                    <label class="form-check-label fw-bold" for="userRole">Admin (unchecked is default)</label>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 pt-2">
                    <button type="submit" id="insert_user" name="insert_user" class="btn btn-primary btn-lg me-1">Save</button>
                    <a href="<?php echo ADMURL . "/users"; ?>" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Additional scripts to include in the footer
$additionalScripts = [
    APPURL . '/app/js/users.js',
];
?>