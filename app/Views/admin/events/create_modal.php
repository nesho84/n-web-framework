<div class="card">
    <div class="card-body">
        <form id="formEvents" action="<?php echo ADMURL . '/events/insert'; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="eventTitle" class="form-label fw-bold">Title</label>
                <input type="text" class="form-control" id="eventTitle" name="eventTitle" placeholder="Title" value="">
            </div>
            <div class="row mb-3 gx-3 align-items-center">
                <div class="col-sm-6">
                    <label for="eventStart" class="form-label fw-bold">Start Date</label>
                    <input type="date" class="form-control" id="eventStart" name="eventStart" placeholder="Start Date" value="">
                </div>
                <div class="col-sm-6">
                    <label for="endStart" class="form-label fw-bold">End Date</label>
                    <input type="date" class="form-control" id="endStart" name="endStart" placeholder="End Date" value="">
                </div>
            </div>
            <div class="mb-3">
                <label for="categoryDescription" class="form-label fw-bold">Description</label>
                <textarea class="form-control" rows="5" id="categoryDescription" name="categoryDescription" placeholder="Description"></textarea>
            </div>
            <div class="mb-3">
                <label for="eventUrl" class="form-label fw-bold">URL</label>
                <input type="text" class="form-control" id="eventUrl" name="eventUrl" placeholder="URL" value="">
            </div>
            <input type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>" name="csrf_token">
            <input type="hidden" name="create_event">
        </form>
    </div>
</div>

<script>
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        // Attach the submit event handler to the form (ajax.js)
        const form = document.querySelector("#formEvents");
        if (form) {
            form.addEventListener("submit", async (event) => {
                await handleFormSubmit(event);
            });
        }
    });
</script>