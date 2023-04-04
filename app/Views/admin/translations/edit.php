<?php
$rows = $data['rows'];
if (isset($rows) && is_array($rows) && (count($rows) > 0)) {
    // Convert array keys into variables
    extract($rows);

    // Page Heading
    displayHeader([
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
                        <label for="languageID" class="form-label fw-bold">Language</label>
                        <select id="languageID" name="languageID" class="form-select">
                            <option class="select_hide" disabled selected>Select Language</option>
                            <?php
                            $LangArray = $data['languages'];
                            foreach ($LangArray as $lang) {
                                if ($lang['languageID'] == $languageID) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                echo "<option value='{$lang['languageID']}' $selected>{$lang['languageName']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="translationText" class="form-label fw-bold">Translation Text</label>
                        <textarea class="form-control" rows="5" id="translationText" name="translationText" placeholder="Translation Text"><?php echo $translationText; ?></textarea>
                    </div>
                    <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                        <button type="submit" id="update_translation" name="update_translation" class="btn btn-primary btn-lg me-1">Save</button>
                        <a href="<?php echo ADMURL . "/translations"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
} else {
    displayNoDataBox("No data found", ADMURL . "/translations");
}
?>