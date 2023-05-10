'use strict';

//------------------------------------------------------------
function previewUploadedImages(fileInputId, previewId, spinnerId)
//------------------------------------------------------------
{
    // Get the file input element
    const fileInput = document.getElementById(fileInputId);
    // Get the preview div element
    const preview = document.getElementById(previewId);
    // Get the spinner element
    const spinner = document.getElementById(spinnerId);

    // Add a change event listener to the file input element
    fileInput.addEventListener("change", function () {
        // Show the spinner
        spinner.style.display = "block";

        // Clear the preview div
        while (preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }

        // Get the list of files
        const files = fileInput.files;

        // Create a new FileReader object
        const reader = new FileReader();
        let i = 0;

        // Add a load event listener to the FileReader object
        reader.addEventListener("load", function () {
            const fileType = files[i].type;

            if (fileType === 'image/jpeg' || fileType === 'image/png') {
                // Create a new image element
                const image = document.createElement("img");
                // Set the src attribute of the image element to the data URL of the file
                image.src = reader.result;
                image.height = 100;
                image.width = 100;
                image.style.margin = "5px";
                // image.classList.add("rounded-circle");
                // Append the image element to the preview div
                preview.appendChild(image);
            } else if (fileType === 'application/pdf') {
                // Create a new pdf Icon element
                const pdfIcon = document.createElement("div");
                pdfIcon.innerHTML = `<i class="fas fa-file-pdf fa-5x"></i>`;
                pdfIcon.style.margin = "5px";
                preview.appendChild(pdfIcon);
            } else {
                // unsupported file type
                console.log('Unsupported file type');
            }

            i++;

            // If all images were processed
            if (i >= files.length) {
                // Hide the spinner
                spinner.style.display = "none";
            }
            else {
                // Read the next image
                reader.readAsDataURL(files[i]);
            }
        });

        // Read the first image
        reader.readAsDataURL(files[0]);
    });
}

//------------------------------------------------------------
function confirmDeleteDialog(event)
//------------------------------------------------------------
{
    event.preventDefault();
    event.stopPropagation();

    const link = event.currentTarget;

    // Show Confirm Dialog
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes",
    }).then(async (result) => {
        if (result.isConfirmed) {
            // Proccess delete
            window.location.href = link.href;
        }
    });
}