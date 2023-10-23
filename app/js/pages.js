'use strict';

console.log("pages.js loaded...");

let pagesUrl = window.location.href;

document.addEventListener("DOMContentLoaded", function () {
    // sweetalert2 Confirm Delete Dialog
    document.querySelectorAll(".btn-delete").forEach((link) => {
        link.addEventListener("click", confirmDeleteDialog);
    });

    // Attach the submit event handler to the form (ajax.js)
    const form = document.querySelector("#formPages");
    if (form) {
        form.addEventListener("submit", async (event) => {
            event.preventDefault();
            await updateCKEDITOR();
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

    // Initialize CKEditor
    if (typeof CKEDITOR != "undefined") {
        CKEDITOR.replace('pageContent', {
            height: "350px",
            cloudServices_tokenUrl: pagesUrl,
            exportPdf_tokenUrl: pagesUrl,
            uploadUrl: pagesUrl,
        });
    }
});

//------------------------------------------------------------
async function updateCKEDITOR()
//------------------------------------------------------------
{
    // Update PageContent before submit (because ckEditor dosen't fire change event itself)
    for (let instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}