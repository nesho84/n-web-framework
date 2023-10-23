<!-- Page Header -->
<?php displayHeader(['title' => 'Create Translation']); ?>

<div class="container-lg">
    <div class="card">
        <div class="card-body">
            <form id="formTranslations" action="<?php echo ADMURL . '/translations/insert'; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="translationCode" class="form-label fw-bold">Translation Code</label>
                    <input type="text" class="form-control" id="translationCode" name="translationCode" placeholder="Translation Code" value="">
                </div>
                <div class="mb-3">
                    <label for="languageID" class="form-label fw-bold">Language</label>
                    <select id="languageID" name="languageID" class="form-select">
                        <option class="select_hide" disabled selected>Select Language</option>
                        <?php
                        $LangArray = $data['languages'];
                        foreach ($LangArray as $lang) {
                            echo "<option value='{$lang['languageID']}'>{$lang['languageName']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="translationText" class="form-label fw-bold">Translation Text</label>
                    <textarea class="form-control" rows="5" id="translationText" name="translationText" placeholder="Translation Text"></textarea>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 pt-2">
                    <button type="submit" id="insert_translation" name="insert_translation" class="btn btn-primary btn-lg me-1">Save</button>
                    <a href="<?php echo ADMURL . "/translations"; ?>" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Additional scripts to include in the footer
$additionalScripts = [
    APPURL . '/app/js/translations.js',
];
?>