<!-- Page Header -->
<?php
displayHeader([
    'title' => 'Translations',
    'btnText' => 'Create New +',
    'btnLink' => ADMURL . '/translations/create',
    'btnClass' => 'success',
]);
?>

<div class="container-lg">
    <div class="table-responsive border-top mt-3">
        <table class="table table-<?php echo $data['theme'] ?? 'light'; ?> table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Translation Code</th>
                    <th scope="col">Language</th>
                    <th scope="col">Translation Text</th>
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
                        $translationText = strlen($d['translationText']) > 38 ? substr($d['translationText'], 0, 38) . '...' : $d['translationText'];
                        echo '<tr>
                                <th scope="row">' . $counter . '</th>
                                <td>' . $d['translationCode'] . '</td>
                                <td>' . $d['languageName'] . '</td>
                                <td>' . $translationText . '</td>
                                <td class="text-center">
                                    <a class="btn btn-link" href="' . ADMURL . '/translations/edit/' . $d['translationID'] . '">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="btn btn-link btn-delete" href="' . ADMURL . '/translations/delete/' . $d['translationID'] . '">
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
        // sweetalert2 Confirm Delete Dialog
        document.querySelectorAll(".btn-delete").forEach((link) => {
            link.addEventListener("click", confirmDeleteDialog);
        });
    });
</script>