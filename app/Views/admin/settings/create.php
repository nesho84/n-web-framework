<!-- Page Header -->
<?php displayHeader(['title' => 'Create Settings']); ?>

<div class="container-lg">
    <div class="card">
        <div class="card-body">
            <form id="formSettings" action="<?php echo ADMURL . '/settings/insert'; ?>" method="POST" enctype="multipart/form-data">

                <!-- Form inputs... -->

                <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                    <button type="submit" id="insert_settings" name="insert_settings" class="btn btn-primary btn-lg me-1">Save</button>
                    <a href="<?php echo ADMURL . "/settings"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>