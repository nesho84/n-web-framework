'use strict';

// Function to handle both GET and POST requests
//------------------------------------------------------------
async function handleRequest(url, method, data = null)
//------------------------------------------------------------
{
    try {
        let options = {
            method: method,
            headers: {
                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                "Cache-Control": "no-cache"
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
//------------------------------------------------------------
async function handleFormSubmit(event)
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

        const result = await handleRequest(url, method, formData);

        if (result.status === "success") {
            if (result.message) {
                // Hide toast message or refresh the page after 5 seconds
                reloadWithTimeout(submitButton);
                showAlert("bg-success", result.message);
            }
        } else if (result.status === "error") {
            if (result.message) {
                showAlert("bg-danger", result.message);
            }
            // Enable submit button
            submitButton.disabled = false;
        } else if (result.status === "warning") {
            if (result.message) {
                showAlert("bg-warning", result.message);
                // Hide toast message after 5 seconds
                setTimeout(() => hideAlert(), 5000);
            }
            // Enable submit button
            submitButton.disabled = false;
        } else {
            showAlert("bg-danger", "An error occurred. Please try again.");
            // Enable submit button
            submitButton.disabled = false;
        }
    } catch (error) {
        // Show error message
        showAlert("bg-danger", error);
        console.error(error);
        // Enable submit button
        submitButton.disabled = false;
    }
}

// Function to show response message in a toast element
//------------------------------------------------------------
function showAlert(className, message)
//------------------------------------------------------------
{
    let msg = "";

    // Multiple Messages
    if (message.toString().includes("<br>")) {
        msg = Array.isArray(message)
            ? '<ul class="m-0 px-3">' + message.map(msg => `<li>${msg}</li>`).join('') + '</ul>'
            : '<ul class="m-0 px-3">' + message.split("<br>").map(msg => `<li>${msg}</li>`).join('') + '</ul>'
    } else {
        // Single Message
        msg = Array.isArray(message)
            ? message.map(msg => `<span>${msg}</span>`).join('')
            : `<span>${message}</span>`;
    }

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
//------------------------------------------------------------
function hideAlert()
//------------------------------------------------------------
{
    const toastElement = document.getElementById("liveToast");
    if (toastElement) {
        const toast = bootstrap.Toast.getOrCreateInstance(toastElement);
        toast.hide();
    }
}

// Function to update the button every second reload the page after 5 seconds
//------------------------------------------------------------
function reloadWithTimeout(btn)
//------------------------------------------------------------
{
    // Save the original button text
    const originalText = btn.textContent;
    // Set the countdown to 5 seconds
    let countdown = 3;

    const x = setInterval(function () {
        // Update the button text with the remaining time
        btn.textContent = originalText + " (" + countdown + ")";

        // Decrement the countdown
        countdown--;

        // If the countdown is over, enable the button and stop the timer
        if (countdown < 0) {
            clearInterval(x);
            btn.textContent = originalText; // restore the original button text
            // btn.disabled = false;
            // hideAlert();
            // or
            // window.location.reload();
            // or
            window.history.go(-1);
        }
    }, 1000);
}

// Example how to Attach the submit event handler to the form
// const form = document.querySelector("form");
// form.addEventListener("submit", handleFormSubmit);
// or
// form.addEventListener("submit", (event) => {
//     handleFormSubmit(event);
// });