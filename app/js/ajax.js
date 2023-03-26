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

// Function to show response message in an alert element
function showResponseMessage(className, message) {
    const msg = Array.isArray(message) ? message.map(msg => `<span>${msg}</span>`).join("<br>") : message;
    const alertContainer = document.getElementById("alert-container");
    alertContainer.innerHTML = '';
    const alertElement = document.createElement("div");
    alertElement.innerHTML = `
    <div class="container" style="margin-bottom:-20px;">
        <div class="alert alert-success alert-dismissible fade show rounded-0 ${className}" role="alert">
            ${msg}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>`;
    alertContainer.prepend(alertElement);
    alertContainer.scrollIntoView(false);
}

// Function to handle form submission
async function handleSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const url = form.action;
    const method = form.method;
    const formData = new FormData(form);
    try {
        const result = await handleRequest(url, method, formData);
        if (result.status === "success") {
            // showResponseMessage("alert-success", "Operation was successful.");
            // form.reset();
            // or
            window.location.reload();
        } else {
            if (result.message) {
                showResponseMessage("alert-danger", result.message);
            } else {
                showResponseMessage("alert-danger", "Something wernt wrong.");
            }
        }
    } catch (error) {
        console.error(error);
        // Show error message
        showResponseMessage("alert-danger", "An error occurred. Please try again.");
    }
}


// Example how to Attach the submit event handler to the form
// const form = document.querySelector("form");
// form.addEventListener("submit", handleSubmit);
// or
// form.addEventListener("submit", (event) => {
//     handleSubmit(event);
// });