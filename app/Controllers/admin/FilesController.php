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
        // Require CSRF_TOKEN
        Sessions::requireCSRF();

        $postArray = [
            'userID' => $_SESSION['user']['id'],
            'categoryID' => htmlspecialchars($_POST['categoryID'] ?? ""),
            // 'fileName' => htmlspecialchars(trim($_POST['fileName'])),
            // 'fileType' => htmlspecialchars(trim($_POST['fileType'])),
            'fileLink' => $_FILES['fileLink'] ?? null,
        ];

        // Validate inputs
        $validator = new DataValidator();

        $validator('File Category', $postArray['categoryID'])->required()->number();
        $validator('File Link', $postArray['fileLink']['name'])->required();

        // --- File Upload and Validation START --- //
        if ($validator->isValidated()) {
            $category = $this->categoriesModel->getCategoryById((int)$postArray['categoryID']);
            $folder = trim(strtolower($category['categoryName']));
            [$uploadError, $targetPath] = FileHandler::upload($postArray['fileLink'], $folder);
            // First Check if there was an error
            if ($uploadError !== "") {
                $validator->addError('Upload', $uploadError)->setValidated(false);
            } else {
                $postArray['fileName'] = pathinfo($targetPath, PATHINFO_BASENAME);
                $postArray['fileType'] = pathinfo($targetPath, PATHINFO_EXTENSION);
                $postArray['fileLink'] = UPLOADURL . '/' . $folder . '/' . $postArray['fileName'];
            }
        }
        // --- File Upload and Validation END --- //

        if ($validator->isValidated()) {
            try {
                // Insert in Database
                $this->filesModel->insertFile($postArray);
                // setAlert('success', 'File created successfully');
                echo json_encode([
                    "status" => "success",
                    'message' => 'File created successfully',
                ]);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    "status" => "error",
                    "message" => $e->getMessage()
                ]);
                exit();
            }
        } else {
            // http_response_code(422);
            echo json_encode([
                "status" => "error",
                "message" => $validator->getErrors()
            ]);
            exit();
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
            FileHandler::removeUploadedFiles(strtolower($cat['categoryName']), $file['fileName']);
            setAlert('success', 'File with the ID: <strong>' . $id . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setAlert('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/files');
    }
}
