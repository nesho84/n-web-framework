<!-- Settings Modal -->
<div class="modal fade" id="settingsModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="settingsModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="settingsModalLabel1"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card text-center">
                    <div class="card-img-top">
                        <img id="product-img" src="<?php echo APPURL ?>/public/images/no-image-icon.png" alt="Settings Image" style="width: 50%; height: 50%; object-fit: cover; object-position: 50% 50%;">
                    </div>
                    <div class="card-body">
                        <!-- Loading Spinner -->
                        <div id="modal1-spinner" class="loading-spinner"></div>
                        <h2 id="title" class="mt-0"></h2>
                        <p id="desc" class="mt-3"></p>
                        <!-- <div id="pdf-buttons" class="d-grid gap-2 d-md-block justify-content-md-center my-3 py-2"></div> -->
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>

<script>
    var settingsModal = document.getElementById('settingsModal')
    settingsModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        var titleParam = button.getAttribute('data-bs-title');
        var pageParam = button.getAttribute('data-bs-page');

        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Get the title and content from the link data attributes
        var modalTitle = settingsModal.querySelector('.modal-title');
        var bodyTitle = settingsModal.querySelector('#title');
        var bodyDesc = settingsModal.querySelector('#desc');

        modalTitle.textContent = titleParam;
        bodyTitle.textContent = pageParam;
        bodyDesc.textContent = pageParam;
    })
</script>