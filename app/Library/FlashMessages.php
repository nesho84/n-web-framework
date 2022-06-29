<?php

/**
 * Save success, error or warning message in the SESSION
 *
 * @param string $status
 * @param string $msg
 * @return void
 */
# -----------------------------------------------------------
function setFlashMsg(string $status, string $msg)
# -----------------------------------------------------------
{
    switch ($status) {
        case 'success':
            $_SESSION['success'] = $msg;
            break;
        case 'error':
            $_SESSION['error'] = $msg;
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
function getFlashMsg()
# -----------------------------------------------------------
{
    // Success Messages
    if (isset($_SESSION['success'])) {
        echo '<div class="container" style="margin-bottom:-20px;">
                <div class="alert alert-success alert-dismissible fade show rounded-0" role="alert">
                    ' . $_SESSION['success'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>';
        unset($_SESSION['success']);
    }
    // Error Messages
    if (isset($_SESSION['error'])) {
        echo '<div class="container" style="margin-bottom:-20px;">
                <div class="alert alert-danger alert-dismissible fade show rounded-0" role="alert">
                    ' . $_SESSION['error'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>';
        unset($_SESSION['error']);
    }
    // Warning Messages
    if (isset($_SESSION['warning'])) {
        echo '<div class="container" style="margin-bottom:-20px;">
                <div class="alert alert-warning alert-dismissible fade show rounded-0" role="alert">
                    ' . $_SESSION['warning'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>';
        unset($_SESSION['warning']);
    }
}
