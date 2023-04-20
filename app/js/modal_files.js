'use strict';

document.addEventListener("DOMContentLoaded", () => {
    // Get all elements with the class 'd-modal-file' 
    document.querySelectorAll('.d-modal-file').forEach(link => {
        // Add click event listener to each element
        link.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            // Show the modal for the clicked element
            showFilesModal(link);
        });
    });
});

//------------------------------------------------------------
function showFilesModal(element)
//------------------------------------------------------------
{
    const modalEl = createFileModal();
    const pdfUrl = getPdfUrl(element);

    // Get modalHTML elements
    const modalBody = modalEl.querySelector('.modal-body');
    const modalTitle = modalEl.querySelector('.modal-title');
    const pdfObject = document.getElementById('file-object');

    // Add an event listener to the modal instance
    modalEl.addEventListener('show.bs.modal', async function (event) {
        // Show a loading spinner
        isLoading(true);

        // Load the PDF content
        try {
            pdfObject.setAttribute('data', pdfUrl);
            // Set the modal's title
            modalTitle.textContent = element.getAttribute('data-title');
        } catch (error) {
            console.error(error);
            modalBody.innerHTML = '<p>Failed to load content.</p>';
        }

        // Remove loading spinner when PDF has finished loading
        pdfObject.addEventListener('load', () => {
            isLoading(false);
        });

    });

    // Remove the modal from the DOM once it has been hidden
    modalEl.addEventListener('hidden.bs.modal', () => {
        modalEl.remove();
    });

    // Initialize the modal component and show it
    const dModal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',
        keyboard: false
    });
    dModal.show();
    // Call handleUpdate to adjust the position of the modal if necessary
    dModal.handleUpdate();
}

//------------------------------------------------------------
function createFileModal()
//------------------------------------------------------------
{
    let modalHTML = `
    <div class="modal fade" id="pdf-modal" tabindex="-1" aria-labelledby="pdf-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdf-modal-label"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body align-items-center justify-content-center p-0">
                    <object id="file-object" type="application/pdf" width="100%" height="100%" data="" style="min-height: 700px;">
                    </object>
                </div>
                <!--<div class="modal-footer"></div>-->
            </div>
        </div>
    </div>`;
    document.body.insertAdjacentHTML("afterbegin", modalHTML);
    return document.getElementById("pdf-modal");
}

//------------------------------------------------------------
function getPdfUrl(element)
//------------------------------------------------------------
{
    if (element.tagName === 'A') {
        return element.getAttribute('href');
    } else if (element.tagName === 'BUTTON') {
        return element.getAttribute('data-link');
    } else {
        return '';
    }
}

//------------------------------------------------------------
function isLoading(show)
//------------------------------------------------------------
{
    let spinnerHTML = `
    <div id="modal-spinner" class="position-absolute top-50 start-50 translate-middle mt-1">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>`;

    const modalBody = document.querySelector('.modal-body');
    const spinner = modalBody.querySelector('#modal-spinner');

    if (show === true) {
        modalBody.insertAdjacentHTML('afterbegin', spinnerHTML);
    } else {
        if (spinner) spinner.remove();
    }
}
