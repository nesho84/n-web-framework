'use strict';

console.log("languages.js loaded...");

document.addEventListener("DOMContentLoaded", function () {
    // sweetalert2 Confirm Delete Dialog
    document.querySelectorAll(".btn-delete").forEach((link) => {
        link.addEventListener("click", confirmDeleteDialog);
    });

    // Preview Uploaded Images (function in main.js)
    previewUploadedImages("languageFlag", "preview_image", "mySpinner");

    // Attach the submit event handler to the form (ajax.js)
    const form = document.querySelector("#formLanguages");
    if (form) {
        form.addEventListener("submit", async (event) => {
            await handleFormSubmit(event);
        });
    }
});