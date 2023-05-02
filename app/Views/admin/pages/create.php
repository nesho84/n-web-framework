<!-- Page Header -->
<?php displayHeader(['title' => 'Create Page']); ?>

<div class="container-lg">
    <div class="card">
        <div class="card-body">
            <form id="formPages" action="<?php echo ADMURL . '/pages/insert'; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="pageName" class="form-label fw-bold">Page Name</label>
                    <input type="text" class="form-control" id="pageName" name="pageName" placeholder="Name" value="">
                </div>
                <div class="mb-3">
                    <label for="pageTitle" class="form-label fw-bold">Title</label>
                    <input type="text" class="form-control" rows="5" id="pageTitle" name="pageTitle" placeholder="Title" value="">
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
                <div class="mb-3 border border-2 p-3">
                    <div class="mb-3">
                        <label for="PageMetaTitle" class="form-label fw-bold">Meta Title <small>(optional)</small></label>
                        <input type="text" class="form-control" rows="5" id="PageMetaTitle" name="PageMetaTitle" placeholder="Meta Title" value="">
                    </div>
                    <div class="mb-3">
                        <label for="PageMetaDescription" class="form-label fw-bold">Meta Description <small>(optional)</small></label>
                        <input type="text" class="form-control" rows="5" id="PageMetaDescription" name="PageMetaDescription" placeholder="Meta Description" value="">
                    </div>
                    <div class="mb-3">
                        <label for="PageMetaKeywords" class="form-label fw-bold">Meta Keywords <small>(optional -> separated with commas)</small></label>
                        <input type="text" class="form-control" rows="5" id="PageMetaKeywords" name="PageMetaKeywords" placeholder="Meta Keywords" value="">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="pageContent" class="form-label fw-bold">Content <small>(optional)</small></label>
                    <textarea class="form-control" rows="10" id="pageContent" name="pageContent" placeholder="Content"></textarea>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                    <button type="submit" id="insert_page" name="insert_page" class="btn btn-primary btn-lg me-1">Save</button>
                    <a href="<?php echo ADMURL . "/pages"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ckeditor 4 -->
<script src="<?php echo APPURL; ?>/app/Library/ckeditor/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    CKEDITOR.replace('pageContent', {
        height: "350px",
        cloudServices_tokenUrl: '<?php echo APPURL; ?>',
        exportPdf_tokenUrl: '<?php echo APPURL; ?>',
        uploadUrl: '<?php echo APPURL; ?>/public/uploads',
    });
    // Update PageContent before submit (because ckEditor dosen't fire change event itself)
    async function updateCKEDITOR() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Attach the submit event handler to the form (ajax.js)
        const form = document.querySelector("#formPages");
        if (form) {
            form.addEventListener("submit", async (event) => {
                await updateCKEDITOR();
                await handleFormSubmit(event);
            });
        }
    });
</script>