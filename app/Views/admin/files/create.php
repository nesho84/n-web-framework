<!-- Page Header -->
<?php displayHeader(['title' => 'Create/Upload File']); ?>

<div class="container-lg">
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
                            if ($cat['categoryID'] == ($_SESSION['inputs']['categoryID'] ?? "")) {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                            echo "<option value='{$cat['categoryID']}' $selected>{$cat['categoryName']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- <div class="mb-3">
                    <label for="fileName" class="form-label fw-bold">File Name</label>
                    <input type="text" class="form-control" id="fileName" name="fileName" placeholder="File Name" value="<?php echo $_SESSION['inputs']['fileName'] ?? ""; ?>">
                </div>
                <div class="mb-3">
                    <label for="fileType" class="form-label fw-bold">File Type</label>
                    <input type="text" class="form-control" id="fileType" name="fileType" placeholder="File Type" value="<?php echo $_SESSION['inputs']['fileType'] ?? ""; ?>">
                </div> -->
                <!-- File Link -> Upload -->
                <div class="mb-3">
                    <label for="fileLink" class="form-label fw-bold">Choose File</label>
                    <input class="form-control" type="file" name="fileLink" id="fileLink">
                    <!-- <input class="form-control" type="file" name="fileLink[]" id="fileLink" multiple> -->
                    <div class="mt-2">
                        <div id="preview_image"></div>
                        <div id="mySpinner" class="d-none">Loading...</div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                    <button type="submit" id="insert_file" name="insert_file" class="btn btn-primary btn-lg me-1">Save</button>
                    <a href="<?php echo ADMURL . "/files"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    'use strict';

    // Preview Uploaded Images (function in main.js)
    document.addEventListener("DOMContentLoaded", () => {
        previewUploadedImages("fileLink", "preview_image", "mySpinner");

        // Attach the submit event handler to the form (ajax.js)
        const form = document.querySelector("#formFiles");
        if (form) {
            form.addEventListener("submit", async (event) => {
                await handleFormSubmit(event);
            });
        }
    });
</script>