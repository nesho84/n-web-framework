(function () {
    document.addEventListener("DOMContentLoaded", () => {
        // Get all elements with the class 'd-modal' 
        document.querySelectorAll('.d-modal').forEach(el => {
            // Add event listener for each element
            el.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                // Show the Modal
                dynamicModal(el);
            });
        });

        // Get all elements with the attribute 'd-modal="true"' 
        document.querySelectorAll("[d-modal='true']").forEach(el => {
            // Add event listener for each element
            el.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                // Show the Modal
                dynamicModal(el);
            });
        });
    });
})();

function dynamicModal(element) {
    // Create a new modal element and set its content
    let modalHTML = `
    <div class="modal fade" id="dynamic-modal" tabindex="-1" aria-labelledby="dynamic-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamic-modal-label"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="min-height:100px;"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>`;
    document.body.insertAdjacentHTML("afterbegin", modalHTML);

    const modalEl = document.getElementById("dynamic-modal");

    // Add an event listener to the modal instance
    modalEl.addEventListener('show.bs.modal', async function (event) {
        // Get modalHTML elements
        const modalTitle = modalEl.querySelector('.modal-title');
        modalTitle.textContent = element.getAttribute('data-title');
        const modalBody = modalEl.querySelector('.modal-body');
        const modalFooter = modalEl.querySelector('.modal-footer');

        // Create and show a loading spinner
        let spinnerHTML = `
        <div id="modal-spinner" class="position-absolute top-50 start-50 translate-middle mt-1">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>`;
        modalBody.insertAdjacentHTML('afterbegin', spinnerHTML);

        // Get href attribute if anchor tag or data-link if button
        let actionUrl = '';
        if (element.tagName === 'A') {
            actionUrl = element.getAttribute('href');
        }
        if (element.tagName === 'BUTTON') {
            actionUrl = element.getAttribute('data-link');
        }

        // Use fetch to load the content of the page
        try {
            let response = await fetch(actionUrl);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            let data = await response.text();
            setTimeout(() => {
                // Replace the modal content's HTML(spinner will be removed)
                modalBody.innerHTML = data;

                // Insert submit button if the caller requires
                const actionButton = element.getAttribute('data-submit');
                if (actionButton && actionButton === 'true') {
                    modalFooter.insertAdjacentHTML("afterbegin", `<button type="submit" class="btn btn-sm btn-success d-flex align-items-center px-4" id="submit-btn">SAVE</button>`);
                    modalFooter.insertAdjacentHTML("afterbegin", `<button type="button" class="btn btn-sm btn-secondary px-3" data-bs-dismiss="modal">CANCEL</button>`);
                    // Get the form and button element
                    const form = modalBody.querySelector('form');
                    const submitBtn = modalFooter.querySelector('#submit-btn');
                    if (form) {
                        // Add event listener to submit the form
                        submitBtn.addEventListener('click', function () {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...`;
                            // Simulate timeout
                            setTimeout(() => {
                                // Submit the form
                                form.submit();
                            }, 500);
                        });
                    }
                } else {
                    modalFooter.remove();
                }
            }, 500);
        } catch (error) {
            console.error(error);
            // Show an error message to the user
            modalBody.innerHTML = '<p>Failed to load content.</p>';
        } finally { }
    });

    // Remove the modal from the DOM once it has been hidden
    modalEl.addEventListener('hidden.bs.modal', () => {
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
