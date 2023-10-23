'use strict';

console.log("settings.js loaded...");

document.addEventListener('DOMContentLoaded', function () {
    // Attach the submit event handler to the form (ajax.js)
    const form = document.querySelector("#formBackup");
    if (form) {
        form.addEventListener("submit", async (event) => {
            await handleFormSubmit(event);
        });
    }
});