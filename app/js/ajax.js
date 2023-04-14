'use strict';

// Function to handle both GET and POST requests
async function handleRequest(url, method, data = null) {
    try {
        let options = {
            method: method,
            headers: {
                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        };

        if (method.toLowerCase() === 'post') {
            options.body = data;
        }

        const response = await fetch(url, options);
        const result = await response.json();
        if (response.ok) {
            return result;
        } else {
            throw result.message;
        }
    } catch (error) {
        throw error;
    }
}

// Function to handle form submission
async function handleFormSubmit(event) {
    event.preventDefault();

    const form = event.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const url = form.action;
    const method = form.method;
    const formData = new FormData(form);

    try {
        // Disable submit button
        submitButton.disabled = true;

        const result = await handleRequest(url, method, formData);

        if (result.status === "success") {
            if (result.message) {
                showResponseMessage("bg-success", result.message);
                // Hide toast message or refresh the page after 5 seconds
                setTimeout(() => {
                    // hideResponseMessage();
                    window.location.reload();
                }, 5000);
            }
        } else if (result.status === "error") {
            if (result.message) {
                showResponseMessage("bg-danger", result.message);
            }
            // Enable submit button
            submitButton.disabled = false;
        } else {
            showResponseMessage("bg-danger", "An error occurred. Please try again.");
        }
    } catch (error) {
        console.error(error);
        // Show error message
        showResponseMessage("bg-danger", error);
        // Enable submit button
        submitButton.disabled = false;
    }
}

// Function to show response message in a toast element
function showResponseMessage(className, message) {
    const msg = Array.isArray(message) ? message.map(msg => `<span>${msg}</span>`).join("<br>") : message;
    const alertContainer = document.getElementById("alert-container");
    alertContainer.innerHTML = '';
    const alertElement = document.createElement("div");
    alertElement.innerHTML = `
    <div id="toast-container" class="position-fixed start-50 translate-middle-x p-3">
        <div id="liveToast" class="toast align-items-center text-white ${className} border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="d-flex">
                <div class="toast-body">${msg}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>`;
    alertContainer.prepend(alertElement);
    // Show toast
    const toastContainer = document.getElementById("toast-container");
    const toastElement = document.getElementById("liveToast");
    if (toastElement) {
        toastContainer.style.zIndex = "99999";
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    }
    alertContainer.scrollIntoView(false);
}

// Function to hide response message
function hideResponseMessage() {
    const toastElement = document.getElementById("liveToast");
    if (toastElement) {
        const toast = bootstrap.Toast.getOrCreateInstance(toastElement);
        toast.hide();
    }
}


// Example how to Attach the submit event handler to the form
// const form = document.querySelector("form");
// form.addEventListener("submit", handleFormSubmit);
// or
// form.addEventListener("submit", (event) => {
//     handleFormSubmit(event);
// });