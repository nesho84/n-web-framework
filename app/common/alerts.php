<?php

/**
 * Save success, error or warning message in the SESSION
 * @param string $status
 * @param string $msg
 * @return void
 */
//------------------------------------------------------------
function setSessionAlert(string $status, string $msg): void
//------------------------------------------------------------
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
 * @return void
 */
//------------------------------------------------------------
function showSessionAlert(): void
//------------------------------------------------------------
{
    $status = '';
    $msg = '';

    // Success Messages
    if (isset($_SESSION['success'])) {
        $status = 'success';
        $msg = $_SESSION['success'];
        unset($_SESSION['success']);
    }

    // Error Messages
    if (isset($_SESSION['error'])) {
        $status = 'error';
        $msg = $_SESSION['error'];
        unset($_SESSION['error']);
    }

    // Info Messages
    if (isset($_SESSION['info'])) {
        $status = 'info';
        $msg = $_SESSION['info'];
        unset($_SESSION['info']);
    }

    // Warning Messages
    if (isset($_SESSION['warning'])) {
        $status = 'warning';
        $msg = $_SESSION['warning'];
        unset($_SESSION['warning']);
    }

    // Use the following JavaScript to trigger our sweetalert2 toast element
    echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                let status = "' . $status . '";
                let msg = "' . $msg . '";

                const Toast = Swal.mixin({
                    toast: true,
                    position: "top",
                    showConfirmButton: false,
                    timer: status === "error" ? 0 : 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer)
                        toast.addEventListener("mouseleave", Swal.resumeTimer)
                    }
                });

                if (status !== "" && msg !== "") {
                    Toast.fire({
                        // background: "#fff",
                        // color: "",
                        icon: status,
                        title: "",
                        html: msg
                    });
                }
            });
        </script>';
}
