<?php

namespace App\Controllers;

use Exception;
use App\Core\Controller;
use App\Models\PagesModel;
use App\Models\LanguagesModel;
use App\Core\Sessions;
use App\Common\DataValidator;
use App\Auth\UserPermissions;
use App\Models\UsersModel;

class PagesController extends Controller
{
    private PagesModel $pagesModel;
    private UsersModel $usersModel;
    private LanguagesModel $languagesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        $this->pagesModel = new PagesModel();
        $this->usersModel = new UsersModel();
        $this->languagesModel = new LanguagesModel();
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Pages';
        $data['rows'] = $this->pagesModel->getPages();
        $data['permissions'] = [
            'canEdit' => function ($userID, $userRole) {
                return UserPermissions::canEdit($userID, $userRole);
            },
            'canDelete' => function ($userID, $userRole) {
                return UserPermissions::canDelete($userID, $userRole);
            },
        ];

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
            // Authorization
            $userId = $data['rows']['userID'];
            $user = $this->usersModel->getUserById($userId);
            if (!UserPermissions::canEdit($userId, $user['userRole'])) {
                setSessionAlert('warning', 'You are not authorized to edit this Page!');
                redirect(ADMURL . '/pages');
            }

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

        // Authorization
        $userId = $page['userID'];
        $user = $this->usersModel->getUserById($userId);
        if (!UserPermissions::canEdit($userId, $user['userRole'])) {
            echo json_encode([
                "status" => "warning",
                "message" => 'You are not authorized to update this Page!'
            ]);
            exit;
        }

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
        // Authorization
        $page = $this->pagesModel->getPageById($id);
        $userId = $page['userID'];
        $user = $this->usersModel->getUserById($userId);
        if (!UserPermissions::canDelete($userId, $user['userRole'])) {
            setSessionAlert('warning', 'You are not authorized to delete this Page!');
            redirect(ADMURL . '/pages');
        }

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
