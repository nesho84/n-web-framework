<!-- Page Header -->
<?php
displayHeader([
    'title' => 'Categories',
    'btnText' => 'Create New +',
    'btnLink' => ADMURL . '/categories/create',
    'btnClass' => 'success',
]);
?>

<div class="container-lg">
    <div class="table-responsive border-top mt-3">
        <table class="table table-<?php echo $data['theme'] ?? 'light'; ?> table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">User</th>
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

                        $isOwner = $data['isOwnerFunc']($d['userID']);

                        $editIcon = $isOwner ? '<a class="btn btn-link" href="' . ADMURL . '/categories/edit/' . $d['categoryID'] . '"><i class="far fa-edit"></i></a>' : '<button type="button" class="btn btn-link" disabled><i class="far fa-edit"></i></i></button>';

                        $deleteIcon = $isOwner ? '<a class="btn btn-link btn-delete" href="' . ADMURL . '/categories/delete/' . $d['categoryID'] . '"><i class="far fa-trash-alt"></i></a>' : '<button type="button" class="btn btn-link" disabled><i class="far fa-trash-alt btn-delete"></i></button>';

                        echo '<tr>
                                <th scope="row">' . $counter . '</th>
                                <td>' . $d['categoryName'] . '</td>
                                <td>' . $d['categoryType'] . '</td>
                                <td>' . $d['userName'] . '</td>
                                <td class="text-center">
                                    ' . $editIcon . '
                                    ' . $deleteIcon . '
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

<?php
// Additional scripts to include in the footer
$additionalScripts = [
    APPURL . '/app/js/categories.js',
];
?>