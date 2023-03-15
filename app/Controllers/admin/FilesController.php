<?php

class FilesController extends Controller
{
    private FIlesModel $filesModel;
    private CategoriesModel $categoriesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        Sessions::requireLogin();

        // Load Model
        $this->filesModel = $this->loadModel("/admin/FilesModel");

        // Load CategoriesModel
        $this->categoriesModel = $this->loadModel("/admin/CategoriesModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Files';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['rows'] = $this->filesModel->getFiles();

        $this->renderAdminView('/admin/files/files', $data);
    }

    //------------------------------------------------------------
    public function pdf_output(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Files';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['rows'] = $this->filesModel->getFiles();

        $this->renderAdminView('/admin/files/pdf_output', $data);
    }

    //------------------------------------------------------------
    public function create(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Files Create';
        $data['categories'] = $this->categoriesModel->getCategories();

        $this->renderAdminView('/admin/files/create', $data);
    }

    //------------------------------------------------------------
    public function insert(): void
    //------------------------------------------------------------
    {
        if (isset($_POST['insert_file'])) {
            $postArray = [
                'userID' => $_SESSION['user']['id'],
                'categoryID' => htmlspecialchars($_POST['categoryID'] ?? ""),
                // 'fileName' => htmlspecialchars(trim($_POST['fileName'])),
                // 'fileType' => htmlspecialchars(trim($_POST['fileType'])),
                'fileLink' => $_FILES['fileLink'] ?? null,
            ];
            // dd($postArray);

            $_SESSION['inputs'] = [];
            $validated = true;
            $error = '';

            if (empty($postArray['categoryID'])) {
                $validated = false;
                $error .= 'Please insert a File Category!<br>';
            }
            if (empty($postArray['fileLink']['name'])) {
                $validated = false;
                $error .= 'Please insert a File Link!<br>';
            }

            // --- File Upload and Validation START --- //
            if ($validated === true) {
                $category = $this->categoriesModel->getCategoryById((int)$postArray['categoryID']);
                $folder = trim(strtolower($category['categoryName']));
                [$uploadError, $targetPath] = FileUpload::upload($postArray['fileLink'], $folder);
                // First Check if there was an error
                if ($uploadError !== "") {
                    $validated = false;
                    $error .= "$uploadError <br>";
                } else {
                    $postArray['fileName'] = pathinfo($targetPath, PATHINFO_BASENAME);
                    $postArray['fileType'] = pathinfo($targetPath, PATHINFO_EXTENSION);
                    $postArray['fileLink'] = UPLOADURL . '/' . $folder . '/' . $postArray['fileName'];
                }
            }
            // --- File Upload and Validation END --- //

            if ($validated === true) {
                try {
                    // Insert in Database
                    $this->filesModel->insertFile($postArray);
                    setFlashMsg('success', 'Insert completed successfully.');
                    unset($_SESSION['inputs']);
                    redirect(ADMURL . '/files');
                } catch (Exception $e) {
                    setFlashMsg('error', $e->getMessage());
                    // @TODO: remove uploaded files
                    $_SESSION['inputs'] = $postArray;
                    redirect(ADMURL . '/files/create');
                }
            } else {
                setFlashMsg('error', $error);
                $_SESSION['inputs'] = $postArray;
                redirect(ADMURL . '/files/create');
            }
        }
    }

    //------------------------------------------------------------
    public function delete(int $id): void
    //------------------------------------------------------------
    {
        // Get existing file from Model
        $file = $this->filesModel->getFileById($id);
        // Get category Name as folder Name
        $cat = $this->categoriesModel->getCategoryById($file['categoryID']);

        try {
            // Delete in Database
            $this->filesModel->deleteFile($id);
            // Delete the existing files
            FileUpload::removeFiles(strtolower($cat['categoryName']), $file['fileName']);
            setFlashMsg('success', 'File with the ID: <strong>' . $id . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setFlashMsg('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/files');
    }
}
