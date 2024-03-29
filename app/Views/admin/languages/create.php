<!-- Page Header -->
<?php displayHeader(['title' => 'Create Language']); ?>

<div class="container-lg">
    <div class="card">
        <div class="card-body">
            <form id="formLanguages" action="<?php echo ADMURL . '/languages/insert'; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="languageName" class="form-label fw-bold">Language Name</label>
                    <input type="text" class="form-control" id="languageName" name="languageName" placeholder="Language Name" value="">
                </div>
                <div class="mb-3">
                    <label for="languageCode" class="form-label fw-bold">Language Code</label>
                    <input type="text" class="form-control" id="languageCode" name="languageCode" placeholder="Language Code" value="">
                </div>
                <!-- Language Flag -->
                <div class="mb-3">
                    <label for="languageFlag" class="form-label fw-bold">Flag <small class="fw-normal">(jpg", "jpeg", "gif", "png" and max. 150x150 pixels)</small></label>
                    <input class="form-control" type="file" name="languageFlag" id="languageFlag">
                    <div class="mt-2">
                        <div id="preview_image"></div>
                        <div id="mySpinner" class="d-none">Loading...</div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 pt-2">
                    <button type="submit" id="insert_language" name="insert_language" class="btn btn-primary btn-lg me-1">Save</button>
                    <a href="<?php echo ADMURL . "/languages"; ?>" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Additional scripts to include in the footer
$additionalScripts = [
    APPURL . '/app/js/languages.js',
];
?>