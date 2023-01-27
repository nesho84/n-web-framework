<div class="container-lg py-4">

    <?php
    // Extract array values into variables
    extract($data['rows']);

    // Page Header
    pageHeader([
        'title' => 'Edit User',
        'title2' => '<strong>ID: </strong>' . $userID,
    ]);

    $pic = $userPicture !== "" ? '<img width="60" height="60" src="' . $userPicture . '" class="rounded-circle" alt="...">' : '<img width="60" height="60" src="' . APPURL . '/public/images/no_pic.png" class="img-fluid" alt="...">';
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
                <!-- User Picture -->
                <div class="mb-3">
                    <label for="userPicture" class="form-label fw-bold">Image (jpg", "jpeg", "gif", "png" and max. 150x150 pixels</label>
                    <input class="form-control" type="file" name="userPicture" id="userPicture">
                    <div class="mt-2">
                        <div id="preview_image" class="rounded-circle">
                            <?php echo $pic; ?>
                        </div>
                    </div>
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

<script>
    // Preview Images before Upload START
    document.querySelector('#userPicture').addEventListener("change", function() {
        var preview = document.querySelector('#preview_image');
        if (this.files) {
            preview.innerHTML = "";
            Array.prototype.forEach.call(this.files, function(file) {
                readAndPreviewImage(file, preview);
            });
        }
    });

    function readAndPreviewImage(file, elem) {
        // Make sure `file.name` matches our extensions criteria
        if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
            return alert(file.name + " is not an image");
        }
        var reader = new FileReader();
        reader.addEventListener("load", function() {
            var image = new Image();
            image.height = 100;
            image.width = 100;
            image.style.margin = "5px";
            image.classList.add("rounded-circle");
            image.title = file.name;
            image.src = this.result;
            elem.appendChild(image);
        });
        reader.readAsDataURL(file);
    }
    // Preview Images before Upload END
</script>