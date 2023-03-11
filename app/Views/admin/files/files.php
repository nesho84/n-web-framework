<!-- Page Header -->
<?php
showHeading([
    'title' => 'Files',
    'btnText' => 'Create New +',
    'btnLink' => ADMURL . '/files/create',
    'btnClass' => 'success',
]);
?>

<div class="container-lg">
    <div class="table-responsive border-top mt-3">
        <table class="table table-<?= $data['theme'] ?? 'light' ?> table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">File Name</th>
                    <th scope="col">Type</th>
                    <th scope="col" class='text-center'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rows = $data['rows'];
                if (isset($rows) && is_array($rows) && (count($rows) > 0)) {
                    $counter = 0;
                    foreach ($rows as $d) {
                        $counter += 1;
                        echo '<tr>
                                <th scope="row">' . $counter . '</th>
                                <td>' . $d['fileName'] . '</td>
                                <td>' . $d['fileType'] . '</td>
                                <td class="text-center">
                                    <a class="btn btn-link" href="' . ADMURL . '/categories/edit/' . $d['fileID'] . '">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="btn btn-link btn-delete" href="' . ADMURL . '/categories/delete/' . $d['fileID'] . '">
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