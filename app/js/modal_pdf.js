'use strict';

document.addEventListener("DOMContentLoaded", () => {
    // Get all elements with the class 'd-modal' 
    document.querySelectorAll('.d-modal-pdf').forEach(el => {
        // Add event listener for each element
        el.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            // Show the Modal
            pdfModal(el);
        });
    });
});

function pdfModal(element) {
    // Create a new modal element and set its content
    let modalHTML = `
    <div class="modal fade" id="pdf-modal" tabindex="-1" aria-labelledby="pdf-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdf-modal-label"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <object id="pdf-object" type="application/pdf" width="100%" height="100%" data="" style="min-height: 700px;">
                    </object>
                </div>
                <!--<div class="modal-footer"></div>-->
            </div>
        </div>
    </div>`;

    // <object id="pdf-object" type="application/pdf" width="100%" height="100%" data="" style="min-height: 400px;"></object>
    // or
    // <iframe id="pdf-iframe" src="" frameborder="0" width="100%" height="500"></iframe>

    document.body.insertAdjacentHTML("afterbegin", modalHTML);

    // Get modalHTML elements
    const modalEl = document.getElementById("pdf-modal");
    const modalTitle = modalEl.querySelector('.modal-title');
    modalTitle.textContent = element.getAttribute('data-title');
    const modalBody = modalEl.querySelector('.modal-body');
    const pdfObject = document.getElementById('pdf-object');
    const pdfIframe = document.getElementById('pdf-iframe');
    const modalFooter = modalEl.querySelector('.modal-footer');

    // Add an event listener to the modal instance
    modalEl.addEventListener('show.bs.modal', async function (event) {
        // Create and show a loading spinner
        let spinnerHTML = `
        <div id="modal-spinner" class="position-absolute top-50 start-50 translate-middle mt-1">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>`;
        modalBody.insertAdjacentHTML('afterbegin', spinnerHTML);

        // Get href attribute if anchor tag or data-link if button
        let pdfUrl = '';
        if (element.tagName === 'A') {
            pdfUrl = element.getAttribute('href');
        }
        if (element.tagName === 'BUTTON') {
            pdfUrl = element.getAttribute('data-link');
        }

        // Load the content of the PDF
        try {
            pdfObject.setAttribute('data', pdfUrl);
            // pdfIframe.setAttribute('src', pdfUrl);
        } catch (error) {
            console.error(error);
            modalBody.innerHTML = '<p>Failed to load content.</p>';
        }

        // Remove Loading Spinner
        pdfObject.addEventListener('load', () => {
            const spinner = modalEl.querySelector('#modal-spinner');
            spinner.remove();

            // Set the height of the modal body to match the height of the PDF
            // pdfObject.style.height = document.body.scrollHeight + 'px';
        });
        // pdfIframe.addEventListener('load', () => {
        //     const spinner = modalEl.querySelector('#modal-spinner');
        //     spinner.remove();
        // });

    });

    // Remove the modal from the DOM once it has been hidden
    modalEl.addEventListener('hidden.bs.modal', () => {
        // pdfObject.removeAttribute('data');
        modalEl.remove();
    });

    // Initialize the modal component and show it
    const myModal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',
        keyboard: false
    });
    // Show the modal
    myModal.show();
    // Call handleUpdate to adjust the position of the modal if necessary
    myModal.handleUpdate();
}
