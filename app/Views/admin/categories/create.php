<!-- Page Header -->
<?php displayHeader(['title' => 'Create Category']); ?>

<div class="container-lg">
    <div class="card">
        <div class="card-body">
            <form id="formCategories" action="<?php echo ADMURL . '/categories/insert'; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="categoryName" class="form-label fw-bold">Category Name</label>
                    <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Category Name" value="<?php echo $_SESSION['inputs']['categoryName'] ?? ""; ?>">
                </div>
                <div class="mb-3">
                    <label for="categoryType" class="form-label fw-bold">Category Type</label>
                    <input type="text" class="form-control" id="categoryType" name="categoryType" placeholder="Category Type" value="<?php echo $_SESSION['inputs']['categoryType'] ?? ""; ?>">
                </div>
                <div class="mb-3">
                    <label for="categoryLink" class="form-label fw-bold">Category Link</label>
                    <input type="text" class="form-control" id="categoryLink" name="categoryLink" placeholder="Category Link" value="<?php echo $_SESSION['inputs']['categoryLink'] ?? ""; ?>">
                </div>
                <div class="mb-3">
                    <label for="categoryDescription" class="form-label fw-bold">Category Description (optional)</label>
                    <textarea class="form-control" rows="5" id="categoryDescription" name="categoryDescription" placeholder="Category Description"><?php echo $_SESSION['inputs']['categoryDescription'] ?? ""; ?></textarea>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                    <button type="submit" id="insert_category" name="insert_category" class="btn btn-primary btn-lg me-1">Save</button>
                    <a href="<?php echo ADMURL . "/categories"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        // Attach the submit event handler to the form (ajax.js)
        const form = document.querySelector("#formCategories");
        if (form) {
            form.addEventListener("submit", async (event) => {
                await handleFormSubmit(event);
            });
        }
    });
</script>