<!-- Page Header -->
<?php
displayHeader([
    'title' => 'Invoices',
    'btnText' => 'Create New +',
    'btnLink' => ADMURL . '/invoices/create',
    'btnClass' => 'success',
]);
?>

<div class="container-lg">
    <div class="table-responsive border-top mt-3">
        <table class="table table-<?php echo $data['theme'] ?? 'light'; ?> table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col">Company</th>
                    <th scope="col">Date</th>
                    <th scope="col" class='text-center'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rows = $data['rows'] ?? [];
                if ($rows && count($rows) > 0) {
                    $counter = 0;
                    foreach ($rows as $d) {
                        $counter += 1;
                        $date = date_create($d['invoiceDateCreated']);
                        echo '<tr>
                                <th scope="row">' . $counter . '</th>
                                <td>' . $d['userName'] . '</td>
                                <td>' . $d['companyName'] . '</td>
                                <td>' . date_format($date, 'd.m.Y') . '</td>
                                <td class="text-center">
                                    <a class="d-modal-file btn btn-link" href="' . ADMURL . '/invoices/pdf_output?id=' . $d['invoiceID'] . '" data-title="Customer: ' . $d['companyName'] . '">
                                        <i class="far fa-file-pdf"></i>
                                    </a>
                                    <!-- <a class="btn btn-link" href="' . ADMURL . '/invoices/edit/' . $d['invoiceID'] . '">
                                        <i class="far fa-edit"></i>
                                    </a> -->
                                    <a class="btn btn-link btn-delete" href="' . ADMURL . '/invoices/delete/' . $d['invoiceID'] . '">
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
    'use strict';

    document.addEventListener("DOMContentLoaded", function() {
        // Confirm Delete
        document.querySelectorAll(".btn-delete").forEach((link) => {
            // sweetalert2 Confirm Delete Dialog
            document.querySelectorAll(".btn-delete").forEach((link) => {
                link.addEventListener("click", confirmDeleteDialog);
            });
        });
    });
</script>