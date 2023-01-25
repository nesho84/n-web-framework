<div class="container-lg py-4">

    <!-- Page Header -->
    <?php
    pageHeader([
        'title' => 'Users', '',
        'btnText' => 'Create New +',
        'link' => ADMURL . '/users/create',
        'btnColor' => 'success',
    ]);
    ?>

    <div class="table-responsive border-top mt-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="ps-3">User</th>
                    <th scope="col">User Email</th>
                    <th scope="col">User Role</th>
                    <th scope="col" class='text-center'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($data['rows']) && count($data['rows']) > 0) {
                    $counter = 0;
                    foreach ($data['rows'] as $d) {
                        $counter += 1;
                        $pic = $d['userPicture'] !== "" ? '<img width="60" height="60" src="' . $d['userPicture'] . '" class="rounded-circle" alt="...">' : '<img width="60" height="60" src="' . APPURL . '/public/images/no_pic.png" class="img-fluid" alt="...">';
                        echo '<tr>
                                <th scope="row">' . $counter . '</th>
                                <td>' . $pic . '&nbsp;&nbsp;' . $d['userName'] . '</td>
                                <td>' . $d['userEmail'] . '</td>
                                <td>' . $d['userRole'] . '</td>
                                <td class="text-center">
                                    <a class="btn btn-link" href="' . ADMURL . '/users/edit/' . $d['userID'] . '">
                                    <i class="far fa-edit"></i>
                                    </a>
                                    <a class="btn btn-link btn-delete" href="' . ADMURL . '/users/delete/' . $d['userID'] . '">
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
    // Submit Delete
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