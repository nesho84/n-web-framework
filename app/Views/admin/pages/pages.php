<!-- Page Header -->
<?php
showHeading([
    'title' => 'Pages',
    'btnText' => 'Create New +',
    'btnLink' => ADMURL . '/pages/create',
    'btnClass' => 'success',
]);
?>

<div class="container-lg">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-info-circle fa-lg"></i> Info
        </div>
        <div class="card-body">
            <!-- <h5 class="card-title"></h5> -->
            <p class="card-text">Pages can include text, pictures, tables, plain HTML.</p>
        </div>
    </div>

    <div class="table-responsive border-top mt-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col" class='text-center'>Status</th>
                    <th scope="col" class='text-center'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($data['rows']) && (count($data['rows']) > 0)) {
                    $counter = 0;
                    foreach ($data['rows'] as $d) {
                        $counter += 1;

                        $pageStatus = $d['pageStatus'] == 1 ? '<span style="color:#00E676;font-size:1.3em;"><i class="fas fa-circle"></i></span>' : '<span style="color:#dc3545;font-size:1.3em;"><i class="fas fa-circle"></i></span>';

                        echo '<tr>
                            <th scope="row">' . $counter . '</th>
                            <td>' . $d['pageName'] . '</td>
                            <td class="text-center">' . $pageStatus . '</td>
                            <td class="text-center">
                                <a class="btn btn-link" href="' . ADMURL . '/pages/edit/' . $d['pageID'] . '">
                                <i class="far fa-edit"></i>
                                </a>
                                <a class="btn btn-link btn-delete" href="' . ADMURL . '/pages/delete/' . $d['pageID'] . '">
                                <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>';
                    }
                } else {
                    echo '<tr>
                        <td colspan="7"><h1 class="text-info text-center">No Records</h1></td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
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
</script>