<div class="table-responsive border-top">
    <table class="table table-<?php echo $data['theme'] ?? 'light'; ?> table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Date</th>
                <th scope="col">Size</th>
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
                            <td>' . $d['fileCreatedAt'] . '</td>
                            <td>' . $d['fileSize'] . '</td>
                            <td class="text-center">
                                <a class="btn btn-link" target="_blank" href="' . DB_BACKUPURL . '/' . $d['fileName'] . '" download>
                                    <i class="fas fa-download"></i>
                                </a>
                                <a class="btn btn-link btn-delete" href="' . ADMURL . '/settings/dbbackup_delete?file=' . $d['fileName'] . '">
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