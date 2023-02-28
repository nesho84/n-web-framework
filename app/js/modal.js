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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    `;
    modalContainer.insertAdjacentHTML("afterbegin", modalHTML);
    document.body.insertAdjacentElement("afterbegin", modalContainer);

    modalEl = document.getElementById("dynamic-modal");

    // Add an event listener to the modal instance
    modalEl.addEventListener('show.bs.modal', async function (event) {
        // Extract info from data-bs-* attributes
        let modalTitle = modalEl.querySelector('.modal-title');
        modalTitle.textContent = element.getAttribute('data-title');

        let modalContent = modalEl.querySelector('.dynamic-content');

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
            let response = await fetch(element.getAttribute('data-link'));
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            let data = await response.text();
            setTimeout(() => {
                modalContent.innerHTML = data;
            }, 500);
        } catch (error) {
            console.error(error);
            // Show an error message to the user
            modalContent.innerHTML = '<p>Failed to load content.</p>';
        } finally {
            // Remove the loading spinner
            modalContent.addEventListener('load', function () {
                spinner.remove();
            });
        }
        // continue... why we cant select the form
        let form = modalContent.querySelector('form');
        console.log(form);
        let modalFooter = modalEl.querySelector('.modal-footer');
        // Action button
        let actionButtons = element.getAttribute('data-buttons');
        // Insert submit button if the caller requires
        if (actionButtons && actionButtons === 'true') {
            if (form) {
                modalFooter.insertAdjacentHTML("afterbegin", `<button type="submit" class="btn btn-success px-4" id="action-btn" name="action-btn">Save</button>`);
            }
        } else {
            modalFooter.remove();
        }
    });

    // Remove the modal from the DOM once it has been hidden
    modalEl.addEventListener('hidden.bs.modal', () => {
        modalContainer.remove();
    });

    // Initialize the modal component and show it
    let myModal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',
        keyboard: false
    });
    myModal.show();
}
