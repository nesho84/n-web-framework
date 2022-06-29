//------------------------------------------------------------
// Show and hide the scroll to Top Button
//------------------------------------------------------------
(function () {
  const scrollTopBtn = document.getElementById("scrollTopBtn");
  // On window scroll
  window.onscroll = function () {
    // console.log(document.documentElement.scrollTop);
    if (document.body.scrollTop > 350 || document.documentElement.scrollTop > 350) {
      // Check for "cookieinfo popup" to push the button up
      if (document.querySelector(".cookieinfo")) {
        scrollTopBtn.style.bottom = document.querySelector(".cookieinfo").clientHeight + 10 + "px";
      } else {
        scrollTopBtn.style.bottom = "10px";
      }
      // Show button
      scrollTopBtn.style.display = "block";
    } else {
      // Hide button
      scrollTopBtn.style.display = "none";
    }
  };
  // On button click
  scrollTopBtn.addEventListener('click', () => {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  })
})();

//------------------------------------------------------------
// W3schools Image Preview Modal
//------------------------------------------------------------
(function () {
  // Get the modal
  let modal = document.getElementById("imagePreviewModal");
  let img = document.querySelectorAll(".galleryImg");
  let modalImg = document.getElementById("modalImg");
  let captionText = document.getElementById("caption");
  let spinner = document.querySelector("#img-preview-spinner");

  img.forEach(el => {
    el.addEventListener("click", (e) => {
      // if the image is sorounded with anchor tag
      e.preventDefault();

      // Display Spinner
      spinner.classList.add("display");

      modal.style.display = "block";
      captionText.innerHTML = el.alt;
      modalImg.src = el.src;
      document.body.style.overflow = 'hidden';

      document.getElementById("scrollTopBtn").style.display = "none";
    });
  });

  // Hide Spinner when Image is fully loaded
  modalImg.addEventListener('load', function () {
    spinner.classList.remove("display")
  })

  // Get the <span> element that closes the modal
  let xBtn = document.querySelector(".closeModal");
  // When the user clicks on <span> (x), close the modal
  xBtn.addEventListener("click", () => {
    document.body.style.overflow = 'auto';
    modal.style.display = "none";
  });
  // Close with ESC key
  document.addEventListener("keydown", (e) => {
    e = e || window.e;
    if (e.key == 'Escape') {
      document.body.style.overflow = 'auto';
      modal.style.display = "none";
    }
  });
})();