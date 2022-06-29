<div class="container-lg py-4">

    <?php
    // Extract array values into variables
    extract($data['rows']);

    // Page Header
    pageHeader([
        'title' => 'Edit Category',
        'title2' => '<strong>ID: </strong>' . $categoryID,
    ]);
    ?>

    <div class="card">
        <div class="card-body">
            <form id="formCategories" action="<?php echo ADMURL . '/categories/update/' . $categoryID; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="categoryType" class="form-label fw-bold">Category Type</label>
                    <input type="text" class="form-control" id="categoryType" name="categoryType" placeholder="Category Type" value="<?php echo $categoryType; ?>">
                </div>
                <div class="mb-3">
                    <label for="categoryLink" class="form-label fw-bold">Category Link</label>
                    <input type="text" class="form-control" rows="5" id="categoryLink" name="categoryLink" placeholder="Category Link" value="<?php echo $categoryLink; ?>">
                </div>
                <div class="mb-3">
                    <label for="categoryName" class="form-label fw-bold">Category Name</label>
                    <input type="text" class="form-control" rows="5" id="categoryName" name="categoryName" placeholder="Category Name" value="<?php echo $categoryName; ?>">
                </div>
                <div class="mb-3">
                    <label for="pageName" class="form-label fw-bold">Category Description (optional)</label>
                    <textarea class="form-control" rows="5" id="categoryDescription" name="categoryDescription" placeholder="Category Description"><?php echo $categoryDescription; ?></textarea>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                    <input type="submit" id="update_category" name="update_category" class="btn btn-primary btn-lg btn-block" value="Save" />
                    <a href="<?php echo ADMURL . "/categories"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>