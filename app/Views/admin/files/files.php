<!-- Page Header -->
<?php
displayHeader([
    'title' => 'Files',
    'btnText' => 'Add New +',
    'btnLink' => ADMURL . '/files/create',
    'btnClass' => 'success',
]);
?>

<div class="container-lg">
    <div class="card mb-3">
        <!-- <div class="card-header">
            <i class="fas fa-info-circle fa-lg"></i> Search Files...
        </div> -->
        <div class="card-body p-2">
            <form id="formSearchFiles" action="" method="GET" enctype="multipart/form-data">
                <div class="input-group">
                    <input type="text" name="s" id="s" class="form-control form-control-sm" placeholder="Search Files..." aria-label="Search Files..." aria-describedby="search_file" value="<?php echo $_SESSION['searchTerm'] ?? ""; ?>">
                    <button type="submit" class="btn btn-primary me-1">Search</button>
                    <a href="<?php echo ADMURL . "/files"; ?>" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div id="filesContainer" class="row row-cols-1 row-cols-md-3 g-3 text-center">
        <?php
        // Clear search input value
        unset($_SESSION['searchTerm']);

        $rows = $data['rows'] ?? [];
        if (isset($rows) && is_array($rows) && (count($rows) > 0)) {
            $icon = "";

            foreach ($rows as $d) {
                $ft = $d['fileType'];
                if ($ft == 'jpg') {
                    $icon = '<i class="far fa-file-image fa-3x mt-3"></i>';
                } elseif ($ft == 'png') {
                    $icon = '<i class="fas fa-file-image fa-3x mt-3"></i>';
                } elseif ($ft == 'pdf') {
                    $icon = '<i class="far fa-file-pdf fa-3x mt-3"></i>';
                }

                echo '<div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 mx-0">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body position-relative pt-4">
                                <div class="px-2 py-1 m-0 position-absolute top-0 end-0">
                                    <a class="link-danger btn-delete" href="' . ADMURL . '/files/delete/' . $d['fileID'] . '">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </div>
                                <p>
                                    <a class="d-modal-file" href="' . $d['fileLink'] . '" data-title="' . $d['fileName'] . '">' . $icon . '</a>
                                </p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted"><a class="link-success" target="_blank" href="' . $d['fileLink'] . '">' . $d['fileName'] . '</a></small>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo '<div class="col p-3 w-100 text-center">
                    <h1 class="text-info text-center">No Records found</h1>
                </div>';
        }
        ?>
    </div>
</div>

<script>
    'use strict';

    document.addEventListener("DOMContentLoaded", function() {
        // Confirm Delete
        document.querySelectorAll(".btn-delete").forEach((link) => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();

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
                    // console.log(result)
                    if (result.isConfirmed) {
                        // Proccess delete
                        window.location.href = link.href;
                    }
                });
            });
        });

        // Handle search form
        const form = document.querySelector("#formSearchFiles");
        if (form) {
            form.addEventListener("submit", async (event) => {
                event.preventDefault();

                const form = event.target;
                const submitButton = form.querySelector('button[type="submit"]');
                const url = form.action;
                const method = form.method;
                const formData = new FormData(form);

                try {
                    // Disable submit button
                    submitButton.disabled = true;

                    // Convert the form data to an object
                    const data = Object.fromEntries(formData);
                    // Append the form data to the URL as query parameters
                    const queryString = new URLSearchParams(data).toString();
                    const requestUrl = `${url}?${queryString}`;
                    // Fetch data using ajax Request
                    const result = await ajaxRequest(requestUrl, method);

                    if (result.status === "success") {
                        if (result.rows && result.rows.length > 0) {
                            // Render result
                            renderAjaxResults(result.rows);
                        }
                    } else if (result.status === "error") {
                        if (result.message) {
                            showAlert("bg-danger", result.message);
                        }
                    } else {
                        showAlert("bg-danger", "An error occurred. Please try again.");
                        console.log(result);
                    }
                } catch (error) {
                    // Show error message
                    showAlert("bg-danger", error);
                    console.error(error);
                } finally {
                    // Enable submit button
                    submitButton.disabled = false;
                }
            });
        }
    });

    function renderAjaxResults(data) {
        const filesContainer = document.getElementById('filesContainer');
        filesContainer.innerHTML = '';
        let icon = '';

        data.forEach(el => {
            if (el.fileType == 'jpg') {
                icon = '<i class="far fa-file-image fa-3x mt-3"></i>';
            } else if (el.fileType == 'png') {
                icon = '<i class="fas fa-file-image fa-3x mt-3"></i>';
            } else if (el.fileType == 'pdf') {
                icon = '<i class="far fa-file-pdf fa-3x mt-3"></i>';
            }

            filesContainer.innerHTML += `
            <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 mx-0">
                <div class="card h-100 shadow-sm">
                    <div class="card-body position-relative pt-4">
                        <div class="px-2 py-1 m-0 position-absolute top-0 end-0">
                            <a class="link-danger btn-delete" href="<?php echo ADMURL; ?>/files/delete/${el.fileID}">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>
                        <p>
                            <a class="d-modal-file" href="${el.fileLink}" data-title="${el.fileName}">${icon}</a>
                        </p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><a class="link-success" target="_blank" href="${el.fileLink}">${el.fileName}</a></small>
                    </div>
                </div>
            </div>
        `;
        });
    }
</script>