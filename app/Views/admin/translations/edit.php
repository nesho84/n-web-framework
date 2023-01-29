<?php
if ($data['rows'] > 0) {
    // Convert array keys into variables
    extract($data['rows']);

    // Page Heading
    showHeading([
        'title' => 'Edit Translation',
        'title2' => '<strong>ID: </strong>' . $translationID,
    ]);
?>

    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <form id="formTranslations" action="<?php echo ADMURL . '/translations/update/' . $translationID; ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="translationCode" class="form-label fw-bold">Translation Code</label>
                        <input type="text" class="form-control" id="translationCode" name="translationCode" placeholder="Translation Code" value="<?php echo $translationCode; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="languageCode" class="form-label fw-bold">Language Code</label>
                        <input type="text" class="form-control" rows="5" id="languageCode" name="languageCode" placeholder="Language Code" value="<?php echo $languageCode; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="translationText" class="form-label fw-bold">Translation Text</label>
                        <textarea class="form-control" rows="5" id="translationText" name="translationText" placeholder="Translation Text"><?php echo $translationText; ?></textarea>
                    </div>
                    <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                        <input type="submit" id="update_translation" name="update_translation" class="btn btn-primary btn-lg btn-block" value="Save" />
                        <a href="<?php echo ADMURL . "/translations"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
} else {
    showNoDataBox("No data found", ADMURL . "/translations");
}
?>