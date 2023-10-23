'use strict';

console.log("translations.js loaded...");

document.addEventListener("DOMContentLoaded", function () {
    // sweetalert2 Confirm Delete Dialog
    document.querySelectorAll(".btn-delete").forEach((link) => {
        link.addEventListener("click", confirmDeleteDialog);
    });

    // Attach the submit event handler to the form (ajax.js)
    const form = document.querySelector("#formTranslations");
    if (form) {
        form.addEventListener("submit", async (event) => {
            await handleFormSubmit(event);
        });
    }

    // Select with search option (dselect library)
    const selectBox = document.getElementById("languageID");
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