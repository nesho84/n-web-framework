    <?php
    $rows = $data['rows'];
    if (isset($rows) && is_array($rows) && (count($rows) > 0)) {
        // Convert array keys into variables
        extract($rows);

        // Page Heading
        displayHeader([
            'title' => 'Edit User',
            'title2' => '<strong>ID: </strong>' . $userID,
        ]);

        $pic = !empty($userPicture) ? '<img width="60" height="60" src="' . $userPicture . '" class="rounded-circle" alt="...">' : '<img width="60" height="60" src="' . APPURL . '/public/images/no_pic.png" class="img-fluid" alt="...">';
    ?>

        <div class="container-lg">
            <div class="card">
                <div class="card-body">
                    <form id="formUsers" action="<?php echo ADMURL . '/users/update/' . $userID ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="userName" class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control" id="userName" name="userName" placeholder="Username" value="<?php echo $userName; ?>" <?php echo $userName == 'admin' ? "readonly" : "" ?>>
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
                        <!-- User Picture -->
                        <div class="mb-3">
                            <label for="userPicture" class="form-label fw-bold">Image (jpg", "jpeg", "gif", "png" and max. 150x150 pixels</label>
                            <input class="form-control" type="file" name="userPicture" id="userPicture">
                            <div class="mt-2">
                                <div id="preview_image" class="rounded-circle">
                                    <?php echo $pic; ?>
                                </div>
                                <div id="mySpinner" class="d-none">Loading...</div>
                            </div>
                        </div>
                        <hr>
                        <!-- User Role -->
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="userRole" name="userRole" <?php echo $userRole == "admin" ? " checked" : "" ?> <?php echo $userName == 'admin' ? ' disabled' : '' ?>>
                            <input type="hidden" name="userRoleHidden" id="userRoleHidden" value="<?php echo $userRole ?>">
                            <label class="form-check-label fw-bold" for="userRole">Admin (unchecked is default)</label>
                        </div>
                        <hr>
                        <!-- User Status-->
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="userStatus" name="userStatus" <?php echo $userStatus == 1 ? " checked" : "" ?> <?php echo $userName == 'admin' ? ' disabled' : '' ?>>
                            <input type="hidden" name="userStatusHidden" id="userStatusHidden" value="<?php echo $userStatus ?>">
                            <label class="form-check-label fw-bold" for="userStatus">User Status <?php echo $userStatus == 1 ? '<span class="badge bg-success fw-normal">active</span>' : '<span class="badge bg-danger">inactive</span>'; ?></label>
                        </div>
                        <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                            <button type="submit" id="update_user" name="update_user" class="btn btn-primary btn-lg me-1">Save</button>
                            <a href="<?php echo ADMURL . "/users"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // Preview Uploaded Images
                previewUploadedImages("userPicture", "preview_image", "mySpinner");

                // Checkbox userStatus change
                const userStatusCheckbox = document.querySelector('input[name="userStatus"]');
                const userStatusHiddenInput = document.querySelector('#userStatusHidden');
                userStatusCheckbox.addEventListener('change', (event) => {
                    if (event.target.checked) {
                        userStatusHiddenInput.value = '1';
                    } else {
                        userStatusHiddenInput.value = '0';
                    }
                });

                // Checkbox userRole change
                const userRoleCheckbox = document.querySelector('input[name="userRole"]');
                const userRoleHiddenInput = document.querySelector('#userRoleHidden');
                userRoleCheckbox.addEventListener('change', (event) => {
                    if (event.target.checked) {
                        userRoleHiddenInput.value = 'admin';
                    } else {
                        userRoleHiddenInput.value = 'default';
                    }
                });
            });
        </script>

    <?php
    } else {
        displayNoDataBox("No data found", ADMURL . "/users");
    }
    ?>