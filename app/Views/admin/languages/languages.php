<!-- Page Header -->
<?php
displayHeader([
    'title' => 'Languages',
    'btnText' => 'Create New +',
    'btnLink' => ADMURL . '/languages/create',
    'btnClass' => 'success',
]);
?>

<div class="container-lg">
    <div class="table-responsive border-top mt-3">
        <table class="table table-<?php echo $data['sessions']['theme'] ?? 'light'; ?> table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
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

                        $flag = !empty($d['languageFlag']) ? '<img src="' . $d['languageFlag'] . '" alt="...">' : '<img src="' . APPURL . '/public/images/no_pic.png" class="img-fluid" alt="...">';

                        echo '<tr>
                                <th scope="row">' . $counter . '</th>
                                <td>' . $flag . '&nbsp;&nbsp;' . $d['languageName'] . '</td>
                                <td>' . $d['languageCode']  . '</td>
                                <td class="text-center">
                                    <a class="btn btn-link" href="' . ADMURL . '/languages/edit/' . $d['languageID'] . '">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="btn btn-link btn-delete" href="' . ADMURL . '/languages/delete/' . $d['languageID'] . '">
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

<?php
// Additional scripts to include in the footer
$additionalScripts = [
    APPURL . '/app/js/languages.js',
];
?>