<!-- Page Header -->
<?php showHeading(['title' => 'Create Translation']); ?>

<div class="container-lg">
    <div class="card">
        <div class="card-body">
            <form id="formTranslations" action="<?php echo ADMURL . '/translations/insert'; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="translationCode" class="form-label fw-bold">Translation Code</label>
                    <input type="text" class="form-control" id="translationCode" name="translationCode" placeholder="Translation Code" value="<?php echo $_SESSION['inputs']['translationCode'] ?? ""; ?>">
                </div>
                <div class="mb-3">
                    <label for="languageCode" class="form-label fw-bold">Language Code</label>
                    <input type="text" class="form-control" id="languageCode" name="languageCode" placeholder="Language Code" value="<?php echo $_SESSION['inputs']['languageCode'] ?? ""; ?>">
                </div>
                <div class=" mb-3">
                    <label for="translationText" class="form-label fw-bold">Translation Text</label>
                    <textarea class="form-control" rows="5" id="translationText" name="translationText" placeholder="Translation Text"><?php echo $_SESSION['inputs']['translationText'] ?? ""; ?></textarea>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                    <input type="submit" id="insert_translation" name="insert_translation" class="btn btn-primary btn-lg" value="Save" />
                    <a href="<?php echo ADMURL . "/translations"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>