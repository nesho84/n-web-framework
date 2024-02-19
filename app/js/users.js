'use strict';

console.log("users.js loaded...");

document.addEventListener("DOMContentLoaded", function () {
    // sweetalert2 Confirm Delete Dialog
    document.querySelectorAll(".btn-delete").forEach((link) => {
        link.addEventListener("click", confirmDeleteDialog);
    });

    // Preview Uploaded Images (function in main.js)
    previewUploadedImages("userPicture", "preview_image", "mySpinner");

    // Attach the submit event handler to the form (ajax.js)
    const form = document.querySelector("#formUsers");
    if (form) {
        form.addEventListener("submit", async (event) => {
            await handleFormSubmit(event);
        });
    }

    // Checkbox userStatus change
    const userStatusCheckbox = document.querySelector('input[name="userStatus"]');
    const userStatusHiddenInput = document.querySelector('#userStatusHidden');
    if (userStatusCheckbox) {
        userStatusCheckbox.addEventListener('change', (event) => {
            if (event.target.checked) {
                userStatusHiddenInput.value = '1';
            } else {
                userStatusHiddenInput.value = '0';
            }
        });
    }

    // Checkbox userRole change
    const userRoleCheckbox = document.querySelector('input[name="userRole"]');
    const userRoleHiddenInput = document.querySelector('#userRoleHidden');
    if (userRoleCheckbox && userRoleHiddenInput) {
        userRoleCheckbox.addEventListener('change', (event) => {
            if (event.target.checked) {
                userRoleHiddenInput.value = 'admin';
            } else {
                userRoleHiddenInput.value = 'default';
            }
        });
    }
});