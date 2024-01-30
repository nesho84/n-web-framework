<?php

class FilesController extends Controller
{
    private FIlesModel $filesModel;
    private CategoriesModel $categoriesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
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

        // Sanitize query
        $s = isset($_GET['s']) ? trim($_GET['s']) : '';
        $searchTerm = filter_var($s, FILTER_SANITIZE_SPECIAL_CHARS);

        // Search files using ajax GET method
        if (isset($_GET['s']) && trim($_GET['s']) == '') {
            // Return all rows
            $data['rows'] = $this->filesModel->getFiles();
            echo json_encode([
                "status" => "success",
                'rows' => $data['rows'],
            ]);
            exit;
        } else if (!empty($searchTerm)) {
            // Perform the search query
            try {
                $data['rows'] = $this->filesModel->searchFiles($searchTerm);
                echo json_encode([
                    "status" => "success",
                    'rows' => $data['rows'],
                ]);
                exit;
            } catch (Exception $e) {
                // setSessionAlert('error', $e->getMessage());
                // http_response_code(422);
                echo json_encode([
                    "status" => "error",
                    "message" => $e->getMessage()
                ]);
                exit;
            }
        } else {
            // Retrieve all files on page Refresh
            try {
                $data['rows'] = $this->filesModel->getFiles();
                $this->renderAdminView('/admin/files/files', $data);
            } catch (Exception $e) {
                setSessionAlert('error', $e->getMessage());
            }
        }
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
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF();

        $postArray = [
            'userID' => $_SESSION['user']['id'],
            'categoryID' => htmlspecialchars($_POST['categoryID'] ?? ""),
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
                $validator->addError('Upload', $uploadError);
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
                // setSessionAlert('success', 'File added successfully');
                echo json_encode([
                    "status" => "success",
                    'message' => 'File added successfully',
                ]);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    "status" => "error",
                    "message" => $e->getMessage()
                ]);
                exit;
            }
        } else {
            // http_response_code(422);
            echo json_encode([
                "status" => "error",
                "message" => $validator->getErrors()
            ]);
            exit;
        }
    }

    //------------------------------------------------------------
    public function delete(string $id): void
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
            setSessionAlert('success', 'File with the ID: <strong>' . $id . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setSessionAlert('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/files');
    }
}
