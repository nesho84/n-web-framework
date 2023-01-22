<div class="container-lg py-4">

    <?php
    // Extract array values into variables
    extract($data['rows']);

    // Page Header
    pageHeader([
        'title' => 'Edit Translation',
        'title2' => '<strong>ID: </strong>' . $translationID,
    ]);
    ?>

    <div class="card">
        <div class="card-body">
            <form id="formCategories" action="<?php echo ADMURL . '/categories/update/' . $translationID; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="translationCode" class="form-label fw-bold">Translation Code</label>
                    <input type="text" class="form-control" id="translationCode" name="translationCode" placeholder="Category Type" value="<?php echo $translationCode; ?>">
                </div>
                <div class="mb-3">
                    <label for="languageCode" class="form-label fw-bold">Language Code</label>
                    <input type="text" class="form-control" rows="5" id="languageCode" name="languageCode" placeholder="Category Link" value="<?php echo $languageCode; ?>">
                </div>
                <div class="mb-3">
                    <label for="translationText" class="form-label fw-bold">Translation Text</label>
                    <textarea class="form-control" rows="5" id="translationText" name="translationText" placeholder="Category Description"><?php echo $translationText; ?></textarea>
                </div>
                <div class="d-grid gap-2 d-md-block text-end border-top border-2 py-2">
                    <input type="submit" id="update_category" name="update_category" class="btn btn-primary btn-lg btn-block" value="Save" />
                    <a href="<?php echo ADMURL . "/translations"; ?>" type="button" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>