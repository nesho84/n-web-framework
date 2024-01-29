<?php

class PagesController extends Controller
{
    private PagesModel $pagesModel;
    private LanguagesModel $languagesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        Sessions::requireLogin();

        // Load Model
        $this->pagesModel = $this->loadModel("/admin/PagesModel");

        // Load LanguagesModel
        $this->languagesModel = $this->loadModel("/admin/LanguagesModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Pages';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['rows'] = $this->pagesModel->getPages();

        $this->renderAdminView('/admin/pages/pages', $data);
    }

    //------------------------------------------------------------
    public function create(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Pages Create';
        $data['languages'] = $this->languagesModel->getLanguages();

        $this->renderAdminView('/admin/pages/create', $data);
    }

    //------------------------------------------------------------
    public function insert(): void
    //------------------------------------------------------------
    {
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF();

        $postArray = [
            'userID' => $_SESSION['user']['id'],
            'languageID' => htmlspecialchars(trim($_POST['languageID'] ?? '')),
            'pageName' => htmlspecialchars(trim($_POST['pageName'])),
            'pageTitle' => htmlspecialchars(trim($_POST['pageTitle'])),
            'pageContent' => $_POST['pageContent'],
            'PageMetaTitle' => htmlspecialchars(trim($_POST['PageMetaTitle'])),
            'PageMetaDescription' => htmlspecialchars(trim($_POST['PageMetaDescription'])),
            'PageMetaKeywords' => htmlspecialchars(trim($_POST['PageMetaKeywords'])),
        ];

        // Get all existing language ids from the Model
        $languages = $this->languagesModel->getLanguages();
        $valid_ids = array();
        foreach ($languages as $lang) {
            $valid_ids[] = $lang['languageID'];
        }

        // Validate inputs
        $validator = new DataValidator();

        $validator('Page Name', $postArray['pageName'])->required()->min(3)->max(20);
        $validator('Page Title', $postArray['pageTitle'])->required()->min(3)->max(20);
        if (empty($postArray['languageID'])) {
            $validator->addError('languageID', 'Please choose a Language');
        } elseif (!in_array($postArray['languageID'], $valid_ids)) {
            $validator->addError('languageID', 'Please select a valid language');
        }

        if ($validator->isValidated()) {
            try {
                // Insert in Database
                $this->pagesModel->insertPage($postArray);
                // setSessionAlert('success', 'Page created successfully.');
                echo json_encode([
                    "status" => "success",
                    'message' => 'Page created successfully',
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
    public function edit(string $id): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Pages Edit - ' . $id;
        $data['rows'] = $this->pagesModel->getPageById($id);
        $data['languages'] = $this->languagesModel->getLanguages();

        if ($data['rows'] && count($data['rows']) > 0) {
            $this->renderAdminView('/admin/pages/edit', $data);
        } else {
            http_response_code(404);
            $this->renderAdminView('/errors/404a.php', $data);
        }
    }

    //------------------------------------------------------------
    public function update(string $id): void
    //------------------------------------------------------------
    {
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF();

        $postArray = [
            'pageID' => $id,
            'userID' => $_SESSION['user']['id'],
            'languageID' => htmlspecialchars(trim($_POST['languageID'])),
            'pageName' => htmlspecialchars(trim($_POST['pageName'])),
            'pageTitle' => htmlspecialchars(trim($_POST['pageTitle'])),
            'PageMetaTitle' => htmlspecialchars(trim($_POST['PageMetaTitle'])),
            'PageMetaDescription' => htmlspecialchars(trim($_POST['PageMetaDescription'])),
            'PageMetaKeywords' => htmlspecialchars(trim($_POST['PageMetaKeywords'])),
            'pageStatus' => isset($_POST['pageStatus']) ? 1 : 0,
            'pageContent' => $_POST['pageContent'],
        ];

        // Get existing page from the Model
        $page = $this->pagesModel->getPageById($id);
        // Get all existing language ids from the Model
        $languages = $this->languagesModel->getLanguages();
        $valid_ids = array();
        foreach ($languages as $lang) {
            $valid_ids[] = $lang['languageID'];
        }

        // Validate inputs
        $validator = new DataValidator();

        $validator('Page Name', $postArray['pageName'])->required()->min(3)->max(20);
        $validator('Page Title', $postArray['pageTitle'])->required()->min(3)->max(20);
        if (empty($postArray['languageID'])) {
            $validator->addError('languageID', 'Please choose a Language');
        } elseif (!in_array($postArray['languageID'], $valid_ids)) {
            $validator->addError('languageID', 'Please select a valid language');
        }

        if ($validator->isValidated()) {
            // Update only changed fields and skip the 'id'
            foreach ($postArray as $key => $value) {
                if (isset($postArray[$key]) && $page[$key] == $value && $key !== 'pageID') {
                    unset($postArray[$key]);
                }
            }
            // remove empty keys
            // $postArray = array_filter($postArray, 'strlen'); => Deprecated
            $postArray = array_filter($postArray ?? [], 'filterNotEmptyOrNull');

            if (count($postArray) > 1) {
                try {
                    // Update in Database
                    $this->pagesModel->updatePage($postArray);
                    // setSessionAlert('success', 'Update completed successfully');
                    echo json_encode([
                        "status" => "success",
                        'message' => 'Page updated successfully',
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
                // setSessionAlert('warning', 'No fields were changed');
                echo json_encode([
                    "status" => "warning",
                    "message" => 'No fields were changed'
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
        try {
            // Delete in Database
            $this->pagesModel->deletePage($id);
            setSessionAlert('success', 'Page with the ID: <strong>' . $id . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setSessionAlert('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/pages');
    }
}
