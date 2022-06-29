<div class="container-lg py-4">

    <!-- Page Header -->
    <?php pageHeader(['title' => 'Create User']); ?>

    <div class="card">
        <div class="card-body">
            <form id="formUsers" action="<?php echo ADMURL . '/users/insert'; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="userName" class="form-label fw-bold">Username</label>
                    <input type="text" class="form-control" id="userName" name="userName" placeholder="Username" value="<?php echo $_SESSION['inputs']['userName'] ?? ""; ?>">
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label fw-bold">Email</label>
                    <input type="text" class="form-control" id="userEmail" name="userEmail" placeholder="Email" value="<?php echo $_SESSION['inputs']['userEmail'] ?? ""; ?>">
                </div>
                <div class="mb-3">
                    <label for="userPassword" class="form-label fw-bold">Password</label>
                    <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Password" value="" autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <label for="userPassword2" class="form-label fw-bold">Confirm Password</label>
                    <input type="password" class="form-control" id="userPassword2" name="userPassword2" placeholder="Confirm Password" value="">
                </div>
                <!-- User Role -->
                <div class="form-check mb-3">
                    <?php
                    $checked = (isset($_SESSION['inputs']['userRole']) && $_SESSION['inputs']['userRole'] === "admin") ? " checked" : "";
                    ?>
                    <input type="checkbox" class="form-check-input" id="userRole" name="userRole" <?php echo $checked; ?>>
                    <label class="form-check-label fw-bold" for="userRole">Admin (unchecked is default)</label>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                    <input type="submit" id="insert_user" name="insert_user" class="btn btn-primary btn-lg" value="Save" />
                    <a href="<?php echo ADMURL . "/users"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>