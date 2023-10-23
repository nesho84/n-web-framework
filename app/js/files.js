'use strict';

console.log("files.js loaded...");

document.addEventListener("DOMContentLoaded", function () {
    // sweetalert2 Confirm Delete Dialog
    document.querySelectorAll(".btn-delete").forEach((link) => {
        link.addEventListener("click", confirmDeleteDialog);
    });

    // Preview Uploaded Images (function in main.js)
    previewUploadedImages("fileLink", "preview_image", "mySpinner");

    // Attach the submit event handler to the form
    const formSearch = document.querySelector("#formSearchFiles");
    if (formSearch) {
        formSearch.addEventListener("submit", handleSearchForm);
    }

    // Attach the submit event handler to the form (ajax.js)
    const formUpload = document.querySelector("#formFiles");
    if (formUpload) {
        formUpload.addEventListener("submit", async (event) => {
            await handleFormSubmit(event);
        });
    }

    // Select with search option (dselect library)
    const selectBox = document.getElementById("categoryID");
    if (selectBox) {
        dselect(selectBox, {
            search: true, // Toggle search feature. Default: false
            creatable: false, // Creatable selection. Default: false
            clearable: false, // Clearable selection. Default: false
            maxHeight: '360px', // Max height for showing scrollbar. Default: 360px
            size: '', // Can be "sm" or "lg". Default ''
        });
    }
});

//------------------------------------------------------------
async function handleSearchForm(event)
//------------------------------------------------------------
{
    event.preventDefault();

    const form = event.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const url = form.action;
    const method = form.method;
    const formData = new FormData(form);

    try {
        // Disable submit button
        submitButton.disabled = true;
        // Convert the form data to an object
        const data = Object.fromEntries(formData);
        // Append the form data to the URL as query parameters
        const queryString = new URLSearchParams(data).toString();
        const requestUrl = `${url}?${queryString}`;
        // Fetch data using ajax Request
        const result = await ajaxRequest(requestUrl, method);

        if (result.status === "success") {
            if (result.rows && result.rows.length > 0) {
                // Render result
                renderAjaxResults(result.rows);
            }
        } else if (result.status === "error") {
            if (result.message) {
                showSwalAlert("bg-danger", result.message);
            }
        } else {
            showSwalAlert("bg-danger", "An error occurred. Please try again.");
            console.log(result);
        }
    } catch (error) {
        // Show error message
        showSwalAlert("bg-danger", error);
        console.error(error);
    } finally {
        // Enable submit button
        submitButton.disabled = false;
    }
}

//------------------------------------------------------------
function renderAjaxResults(data)
//------------------------------------------------------------
{
    const filesContainer = document.getElementById('filesContainer');
    filesContainer.innerHTML = '';
    let icon = '';

    data.forEach(el => {
        // Set icons for the files card
        if (el.fileType == 'jpg') {
            icon = '<i class="far fa-file-image fa-3x mt-3"></i>';
        } else if (el.fileType == 'png') {
            icon = '<i class="fas fa-file-image fa-3x mt-3"></i>';
        } else if (el.fileType == 'pdf') {
            icon = '<i class="far fa-file-pdf fa-3x mt-3"></i>';
        }

        filesContainer.innerHTML += `
        <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 mx-0">
            <div class="card h-100 shadow-sm">
                <div class="card-body position-relative pt-4">
                    <div class="px-2 py-1 m-0 position-absolute top-0 end-0">
                        <a class="link-danger btn-delete" href="${window.location.href}/delete/${el.fileID}">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </div>
                    <p>
                        <a class="d-modal-file" href="${el.fileLink}" data-title="${el.fileName}">${icon}</a>
                    </p>
                </div>
                <div class="card-footer">
                    <small class="text-muted"><a class="link-success" target="_blank" href="${el.fileLink}">${el.fileName}</a></small>
                </div>
            </div>
        </div>
    `;
    });
}