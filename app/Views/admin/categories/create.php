<div class="container-lg py-4">

    <!-- Page Header -->
    <?php pageHeader(['title' => 'Create Category']); ?>

    <div class="card">
        <div class="card-body">
            <form id="formCategories" action="<?php echo ADMURL . '/categories/insert'; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="categoryType" class="form-label fw-bold">Category Type</label>
                    <input type="text" class="form-control" id="categoryType" name="categoryType" placeholder="Category Type" value="<?php echo $_SESSION['inputs']['categoryType'] ?? ""; ?>">
                </div>
                <div class="mb-3">
                    <label for="categoryLink" class="form-label fw-bold">Category Link</label>
                    <input type="text" class="form-control" id="categoryLink" name="categoryLink" placeholder="Category Link" value="<?php echo $_SESSION['inputs']['categoryLink'] ?? ""; ?>">
                </div>
                <div class="mb-3">
                    <label for="categoryName" class="form-label fw-bold">Category Name</label>
                    <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Category Name" value="<?php echo $_SESSION['inputs']['categoryName'] ?? ""; ?>">
                </div>
                <div class=" mb-3">
                    <label for="categoryDescription" class="form-label fw-bold">Category Description (optional)</label>
                    <textarea class="form-control" rows="5" id="categoryDescription" name="categoryDescription" placeholder="Category Description"><?php echo $_SESSION['inputs']['categoryDescription'] ?? ""; ?></textarea>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                    <input type="submit" id="insert_category" name="insert_category" class="btn btn-primary btn-lg" value="Save" />
                    <a href="<?php echo ADMURL . "/categories"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- <script src="<?= SCRIPTS_PATH . '/' ?>demo.js"></script> -->

<?php
$content = "";
$js = SCRIPTS_PATH . '/demo.js';

if (file_exists($js)) {
    $content = file_get_contents($js);
    echo "<script>\n$content\n</script>";
}

echo "\n";
?>