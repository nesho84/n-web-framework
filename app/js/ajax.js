'use strict';

// Function to handle both GET and POST requests
async function handleRequest(url, method, data) {
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: data
        });
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
    const url = form.action;
    const method = form.method;
    const formData = new FormData(form);
    try {
        const result = await handleRequest(url, method, formData);
        if (result.status === "success") {
            // showResponseMessage("bg-success", "Operation was successful.");
            // form.reset();
            // or
            window.location.reload();
        } else {
            if (result.message) {
                showResponseMessage("bg-danger", result.message);
            } else {
                showResponseMessage("bg-danger", "An error occurred. Please try again.");
            }
        }
    } catch (error) {
        console.error(error);
        // Show error message
        showResponseMessage("bg-danger", error);
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


// Example how to Attach the submit event handler to the form
// const form = document.querySelector("form");
// form.addEventListener("submit", handleFormSubmit);
// or
// form.addEventListener("submit", (event) => {
//     handleFormSubmit(event);
// });