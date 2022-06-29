//------------------------------------------------------------
// AJAX Contact Form Handler
//------------------------------------------------------------
(function () {
    document.getElementById("contactForm").addEventListener("submit", function (e) {
        e.preventDefault();

        const contact_result = document.getElementById("contact_result");
        const contact_action = this.getAttribute("action");
        const contactFormData = new FormData(this);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", contact_action, true);
        xhr.onload = () => {
            if (xhr.status >= 200 && xhr.status < 400) {
                xhr.addEventListener("loadend", () => {
                    if (xhr.responseText.trim() == "success") {
                        document.body.scrollTop = 0;
                        document.documentElement.scrollTop = 0;
                        document.getElementById("success").innerHTML = `
                        <div class='col mt-3 h-100'>
                            <h3 class='text-success text-center py-3'>Danke, dass Sie uns kontaktiert haben!</h3>
                            <p class='text-center'>Wir danken Ihnen bestens für Ihr Interesse und werden uns umgehend mit Ihnen in Verbindung setzten.</p>
                        </div>`;
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        // Focus (scroll) on a div
                        document.getElementById('focus-div').scrollIntoView();
                        contact_result.innerHTML = `<div class="alert alert-danger" role="alert">${xhr.response}</div>`;
                    }
                });
            } else {
                console.log("error: ", xhr.response);
            }
        };
        xhr.send(contactFormData);
    });
})();