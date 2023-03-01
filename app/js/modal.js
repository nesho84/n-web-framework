function showModal(element) {
    // Create a new modal element and set its content
    const modalContainer = document.createElement('div');
    modalContainer.id = "modal-container";
    let modalHTML = `
    <div class="modal fade" id="dynamic-modal" tabindex="-1" aria-labelledby="dynamic-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamic-modal-label"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Modal content goes here... -->
                    <div class="dynamic-content"></div>
                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                </div>
            </div>
        </div>
    </div>
    `;
    modalContainer.insertAdjacentHTML("afterbegin", modalHTML);
    document.body.insertAdjacentElement("afterbegin", modalContainer);

    const modalEl = document.getElementById("dynamic-modal");

    // Add an event listener to the modal instance
    modalEl.addEventListener('show.bs.modal', async function (event) {
        // Get modalHTML elements
        const modalTitle = modalEl.querySelector('.modal-title');
        const modalContent = modalEl.querySelector('.dynamic-content');
        const modalFooter = modalEl.querySelector('.modal-footer');
        // Extract info from data-bs-* attributes
        modalTitle.textContent = element.getAttribute('data-title');
        const actionButton = element.getAttribute('data-submit');
        const actionUrl = element.getAttribute('data-link');

        // Create and show a loading spinner
        let spinner = document.createElement('div');
        spinner.classList.add('spinner-border', 'text-secondary');
        spinner.style.display = 'table';
        spinner.style.margin = '0 auto';
        spinner.setAttribute('role', 'status');
        spinner.innerHTML = '<span class="visually-hidden">Loading...</span>';
        modalContent.appendChild(spinner);

        // Use fetch to load the content of the page
        try {
            let response = await fetch(actionUrl);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            let data = await response.text();
            setTimeout(() => {
                // Set the modal content's HTML
                modalContent.innerHTML = data;
                // Insert submit button if the caller requires
                if (actionButton && actionButton === 'true') {
                    modalFooter.insertAdjacentHTML("afterbegin", `<button type="button" class="btn btn-sm btn-secondary px-3" data-bs-dismiss="modal">CANCEL</button>`);
                    modalFooter.insertAdjacentHTML("afterbegin", `<button type="submit" class="btn btn-sm btn-success px-4" id="submit-btn" name="submit-btn">SAVE</button>`);
                    // Get the form element
                    const form = modalContent.querySelector('form');
                    if (form) {
                        // Add event listener to submit the form
                        modalFooter.querySelector('#submit-btn').addEventListener('click', function () {
                            form.submit();
                        });
                    }
                } else {
                    modalFooter.remove();
                }
            }, 500);
        } catch (error) {
            console.error(error);
            // Show an error message to the user
            modalContent.innerHTML = '<p>Failed to load content.</p>';
        } finally {
            // Remove the loading spinner
            modalContent.addEventListener('DOMContentLoaded', function () {
                spinner.remove();
            });
        }
    });

    // Remove the modal from the DOM once it has been hidden
    modalEl.addEventListener('hidden.bs.modal', () => {
        modalContainer.remove();
    });

    // Initialize the modal component and show it
    const myModal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',
        keyboard: false
    });
    myModal.show();
}
