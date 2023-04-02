<?php

/**
 * Save success, error or warning message in the SESSION
 *
 * @param string $status
 * @param string $msg
 * @return void
 */
# -----------------------------------------------------------
function setFlashMsg(string $status, string $msg): void
# -----------------------------------------------------------
{
    switch ($status) {
        case 'success':
            $_SESSION['success'] = $msg;
            break;
        case 'error':
            $_SESSION['error'] = $msg;
            break;
        case 'info':
            $_SESSION['info'] = $msg;
            break;
        case 'warning':
            $_SESSION['warning'] = $msg;
            break;
        default:
            # code...
            break;
    }
}

/**
 * Get's the success, error and warning message from SESSION
 *
 * @return void
 */
# -----------------------------------------------------------
function getFlashMsg(): void
# -----------------------------------------------------------
{
    // data-bs-autohide="false" => to disable autohide
    // data-bs-delay="5000" => delay for autohide

    // Success Messages
    if (isset($_SESSION['success'])) {
        echo '<div id="toast-container" class="position-fixed start-50 translate-middle-x p-3">
                <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                    <div class="d-flex">
                        <div class="toast-body">' . $_SESSION['success'] . '</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>';
        unset($_SESSION['success']);
    }

    // Error Messages
    if (isset($_SESSION['error'])) {
        echo '<div id="toast-container" class="position-fixed start-50 translate-middle-x p-3">
                <div id="liveToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                    <div class="d-flex">
                        <div class="toast-body p-3">' . $_SESSION['error'] . '</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>';
        unset($_SESSION['error']);
    }

    // Info Messages
    if (isset($_SESSION['info'])) {
        echo '<div id="toast-container" class="position-fixed start-50 translate-middle-x p-3">
                <div id="liveToast" class="toast align-items-center text-white bg-info border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                    <div class="d-flex">
                        <div class="toast-body">' . $_SESSION['info'] . '</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>';
        unset($_SESSION['info']);
    }

    // Warning Messages
    if (isset($_SESSION['warning'])) {
        echo '<div id="toast-container" class="position-fixed start-50 translate-middle-x p-3">
                <div id="liveToast" class="toast align-items-center text-white bg-warning border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                    <div class="d-flex">
                        <div class="toast-body">' . $_SESSION['warning'] . '</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>';
        unset($_SESSION['warning']);
    }

    // Use the following JavaScript to trigger our live toast:
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                const toastContainer = document.getElementById("toast-container");
                const toastElement = document.getElementById("liveToast");
                if (toastElement) {
                    toastContainer.style.zIndex = "99999";
                    const toast = new bootstrap.Toast(toastElement);
                    toast.show();
                }
            });
        </script>';

    // // Alternative - Using Alerts without Javascript
    // if (isset($_SESSION['success'])) {
    //     echo '<div class="container" style="margin-bottom:-20px;">
    //             <div class="alert alert-success alert-dismissible fade show rounded-0" role="alert">
    //                 ' . $_SESSION['success'] . '
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //             </div>
    //         </div>';
    //     unset($_SESSION['success']);
    // }

}
