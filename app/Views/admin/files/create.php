<!-- Page Header -->
<?php displayHeader(['title' => 'Create/Upload File']); ?>

<div class="container-lg">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-info-circle fa-lg"></i> Info
        </div>
        <div class="card-body">
            <!-- <h5 class="card-title"></h5> -->
            <p class="card-text">Allowed file formats: "jpg", "jpeg", "gif", "png", "pdf"</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="formFiles" action="<?php echo ADMURL . '/files/insert'; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="categoryID" class="form-label fw-bold">File Category</label>
                    <select id="categoryID" name="categoryID" class="form-select">
                        <option class="select_hide" disabled selected>Select Category</option>
                        <?php
                        $categoryArray = $data['categories'];
                        foreach ($categoryArray as $cat) {
                            echo "<option value='{$cat['categoryID']}'>{$cat['categoryName']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- <div class="mb-3">
                    <label for="fileName" class="form-label fw-bold">File Name</label>
                    <input type="text" class="form-control" id="fileName" name="fileName" placeholder="File Name" value="">
                </div>
                <div class="mb-3">
                    <label for="fileType" class="form-label fw-bold">File Type</label>
                    <input type="text" class="form-control" id="fileType" name="fileType" placeholder="File Type" value="">
                </div> -->
                <!-- File Link -> Upload -->
                <div class="mb-3">
                    <label for="fileLink" class="form-label fw-bold">Choose File</label>
                    <input class="form-control" type="file" name="fileLink" id="fileLink">
                    <div class="mt-2">
                        <div id="preview_image"></div>
                        <div id="mySpinner" class="d-none">Loading...</div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 pt-2">
                    <button type="submit" id="insert_file" name="insert_file" class="btn btn-primary btn-lg me-1">Save</button>
                    <a href="<?php echo ADMURL . "/files"; ?>" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    'use strict';

    document.addEventListener("DOMContentLoaded", function() {
        // Preview Uploaded Images (function in main.js)
        previewUploadedImages("fileLink", "preview_image", "mySpinner");

        // Attach the submit event handler to the form (ajax.js)
        const form = document.querySelector("#formFiles");
        if (form) {
            form.addEventListener("submit", async (event) => {
                await handleFormSubmit(event);
            });
        }

        // Select with search option (dselect library)
        const selectBox = document.getElementById("categoryID");
        dselect(selectBox, {
            search: true, // Toggle search feature. Default: false
            creatable: false, // Creatable selection. Default: false
            clearable: false, // Clearable selection. Default: false
            maxHeight: '360px', // Max height for showing scrollbar. Default: 360px
            size: '', // Can be "sm" or "lg". Default ''
        });
    });
</script>