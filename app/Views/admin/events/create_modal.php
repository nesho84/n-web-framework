<div class="card">
    <div class="card-body">
        <form id="formEvents" action="<?php echo ADMURL . '/events/insert'; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label fw-bold">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="">
            </div>
            <div class="row mb-3 gx-3 align-items-center">
                <div class="col-sm-6">
                    <label for="start" class="form-label fw-bold">Start</label>
                    <input type="date" class="form-control" id="start" name="start" placeholder="Start Date" value="">
                </div>
                <div class="col-sm-6  mt-3 mt-sm-0">
                    <label for="end" class="form-label fw-bold">End</label>
                    <input type="date" class="form-control" id="end" name="end" placeholder="End Date" value="">
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label fw-bold">Description</label>
                <textarea class="form-control" rows="3" id="description" name="description" placeholder="Description"></textarea>
            </div>
            <div class="mb-3">
                <label for="url" class="form-label fw-bold">URL</label>
                <input type="text" class="form-control" id="url" name="url" placeholder="URL" value="">
            </div>
            <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" name="csrf_token">
            <input type="hidden" name="create_event">
        </form>
    </div>
</div>