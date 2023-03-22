'use strict';

function previewUploadedImages(fileInputId, previewId, spinnerId) {
    // Get the file input element
    var fileInput = document.getElementById(fileInputId);
    // Get the preview div element
    var preview = document.getElementById(previewId);
    // Get the spinner element
    var spinner = document.getElementById(spinnerId);

    // Add a change event listener to the file input element
    fileInput.addEventListener("change", function () {
        // Show the spinner
        spinner.style.display = "block";

        // Clear the preview div
        while (preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }

        // Get the list of files
        var files = fileInput.files;

        // Create a new FileReader object
        var reader = new FileReader();
        var i = 0;

        // Add a load event listener to the FileReader object
        reader.addEventListener("load", function () {
            // Create a new image element
            var image = document.createElement("img");
            // Set the src attribute of the image element to the data URL of the file
            image.src = reader.result;
            image.height = 100;
            image.width = 100;
            image.style.margin = "5px";
            // image.classList.add("rounded-circle");
            // Append the image element to the preview div
            preview.appendChild(image);
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