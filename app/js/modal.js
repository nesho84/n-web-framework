'use strict';

document.addEventListener("DOMContentLoaded", () => {
    // Get all elements with the class 'd-modal' 
    document.querySelectorAll('.d-modal').forEach(element => {
        // Add click event listener to each element
        element.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            // Show the modal for the clicked element
            showDynamicModal(element);
        });
    });

    // Get all elements with the attribute 'd-modal="true"' 
    document.querySelectorAll("[d-modal='true']").forEach(element => {
        // Add click event listener to each element
        element.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            // Show the modal for the clicked element
            showDynamicModal(element);
        });
    });
});

//------------------------------------------------------------
function showDynamicModal(element)
//------------------------------------------------------------
{
    const modalEl = createDynamicModal();
    const actionUrl = getActionUrl(element);

    // Get modalHTML elements
    const modalBody = modalEl.querySelector('.modal-body');
    const modalTitle = modalEl.querySelector('.modal-title');
    const modalFooter = modalEl.querySelector('.modal-footer');

    // Add an event listener to the modal instance
    modalEl.addEventListener('show.bs.modal', async function (event) {
        // Show a loading spinner
        isLoading(true);

        // Use fetch to load the content of the page
        try {
            let response = await fetch(actionUrl);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            let data = await response.text();

            // Simulate timeout
            setTimeout(() => {
                // Replace the modal content's HTML(spinner will be removed)
                modalBody.innerHTML = data;
                // Set the modal's title
                modalTitle.textContent = element.getAttribute('data-title');

                // Insert submit button if the caller requires
                const actionButton = element.getAttribute('data-submit');
                if (actionButton && actionButton === 'true') {
                    // Create buttons for the Modal
                    createModalButtons(modalFooter);
                    // Get the form and the submit button
                    const form = modalBody.querySelector('form');
                    const submitBtn = modalFooter.querySelector('#submit-btn');
                    if (form) {
                        // Add event listener to submit the form
                        submitBtn.addEventListener('click', function () {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...`;
                            // Simulate timeout
                            setTimeout(() => {
                                form.submit();
                            }, 500);
                        });
                    } else {
                        console.error("Failed to load the form.");
                    }
                } else {
                    modalFooter.remove();
                }
            }, 500);
        } catch (error) {
            console.error(error);
            // Show an error message to the user
            modalBody.innerHTML = '<p>Failed to load content.</p>';
        }
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
function createDynamicModal()
//------------------------------------------------------------
{
    let modalHTML = `
    <div class="modal fade" id="dynamic-modal" tabindex="-1" aria-labelledby="dynamic-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamic-modal-label"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="min-height:100px;"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>`;
    document.body.insertAdjacentHTML("afterbegin", modalHTML);
    return document.getElementById("dynamic-modal");
}

//------------------------------------------------------------
function getActionUrl(element)
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

//------------------------------------------------------------
function createModalButtons(modalFooter)
//------------------------------------------------------------
{
    modalFooter.insertAdjacentHTML("afterbegin", `<button type="submit" class="btn btn-sm btn-success d-flex align-items-center px-4" id="submit-btn">SAVE</button>`);
    modalFooter.insertAdjacentHTML("afterbegin", `<button type="button" class="btn btn-sm btn-secondary px-3" data-bs-dismiss="modal">CANCEL</button>`);
}
