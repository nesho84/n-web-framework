<?php
$rows = $data['rows'] ?? [];
if (count($rows) > 0) {
    // Convert array keys into variables
    extract($rows);
?>

    <div class="card">
        <div class="card-body">
            <form id="formSettings" action="<?php echo ADMURL . '/settings/update/' . $settingID; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="settingTheme" class="form-label fw-bold">Theme</label>
                    <select id="settingTheme" name="settingTheme" class="form-select">
                        <?php
                        $themesArray = array('dark', 'light');
                        foreach ($themesArray as $theme) {
                            if ($theme == $settingTheme) {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                            echo "<option value='$theme' $selected>$theme</option>";
                        }
                        ?>
                    </select>
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
                <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" name="csrf_token">
                <input type="hidden" name="update_setting">
            </form>
        </div>
    </div>

<?php
} else {
    displayNoDataBox("No Settings found", ADMURL);
    echo "<br>";
}
?>