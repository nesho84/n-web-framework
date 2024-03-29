<?php
// Convert array keys into variables
extract($data['rows']);

// Page Heading
displayHeader([
    'title' => 'Edit Page',
    'title2' => '<strong>ID: </strong>' . $pageID,
]);
?>

<div class="container-lg">
    <div class="card">
        <div class="card-body">
            <form id="formPages" action="<?php echo ADMURL . "/pages/update/" . $pageID; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="pageName" class="form-label fw-bold">Page Name</label>
                    <input type="text" class="form-control" id="pageName" name="pageName" placeholder="Name" value="<?php echo $pageName; ?>">
                </div>
                <div class="mb-3">
                    <label for="pageName" class="form-label fw-bold">Title</label>
                    <input type="text" class="form-control" rows="5" id="pageTitle" name="pageTitle" placeholder="Title" value="<?php echo $pageTitle; ?>">
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
                <div class="mb-3 border border-2 p-3">
                    <div class="mb-3">
                        <label for="PageMetaTitle" class="form-label fw-bold">Meta Title <small>(optional)</small></label>
                        <input type="text" class="form-control" rows="5" id="PageMetaTitle" name="PageMetaTitle" placeholder="Meta Title" value="<?php echo $PageMetaTitle; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="PageMetaDescription" class="form-label fw-bold">Meta Description <small>(optional)</small></label>
                        <input type="text" class="form-control" rows="5" id="PageMetaDescription" name="PageMetaDescription" placeholder="Meta Description" value="<?php echo $PageMetaDescription; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="PageMetaKeywords" class="form-label fw-bold">Meta Keywords <small>(optional -> separated with commas)</small></label>
                        <input type="text" class="form-control" rows="5" id="PageMetaKeywords" name="PageMetaKeywords" placeholder="Meta Keywords" value="<?php echo $PageMetaKeywords; ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="pageContent" class="form-label fw-bold">Content <small>(optional)</small></label>
                    <textarea class="form-control" rows="15" id="pageContent" name="pageContent" placeholder="Content"><?php echo $pageContent; ?></textarea>
                </div>
                <hr>
                <!-- Page Status-->
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="pageStatus" name="pageStatus" <?php echo $pageStatus == 1 ? " checked" : ""; ?>>
                    <label class="form-check-label fw-bold" for="pageStatus">Page Status <?php echo $pageStatus == 1 ? '<span class="badge bg-success fw-normal">active</span>' : '<span class="badge bg-danger">inactive</span>'; ?></label>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 pt-2">
                    <button type="submit" id="update_page" name="update_page" class="btn btn-primary btn-lg me-1">Save</button>
                    <a href="<?php echo ADMURL . "/pages"; ?>" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Additional scripts to include in the footer
$additionalScripts = [
    // ckeditor 4
    APPURL . '/app/Library/ckeditor/ckeditor.js',
    APPURL . '/app/js/pages.js'
];
?>