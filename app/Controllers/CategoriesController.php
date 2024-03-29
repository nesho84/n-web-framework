<?php

namespace App\Controllers;

use Exception;
use App\Core\Controller;
use App\Models\CategoriesModel;
use App\Core\Sessions;
use App\Common\DataValidator;
use App\Auth\UserPermissions;
use App\Models\UsersModel;

class CategoriesController extends Controller
{
    private CategoriesModel $categoriesModel;
    private UsersModel $usersModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        $this->categoriesModel = new CategoriesModel();
        $this->usersModel = new UsersModel();
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Categories';
        $data['rows'] = $this->categoriesModel->getCategories();
        $data['permissions'] = [
            'canEdit' => function ($userID, $userRole) {
                return UserPermissions::canEdit($userID, $userRole);
            },
            'canDelete' => function ($userID, $userRole) {
                return UserPermissions::canDelete($userID, $userRole);
            },
        ];

        $this->renderAdminView('/admin/categories/categories', $data);
    }

    //------------------------------------------------------------
    public function create(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Categories Create';

        $this->renderAdminView('/admin/categories/create', $data);
    }

    //------------------------------------------------------------
    public function insert(): void
    //------------------------------------------------------------
    {
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF();

        $postArray = [
            'userID' => $_SESSION['user']['id'],
            'categoryName' => htmlspecialchars(trim($_POST['categoryName'])),
            'categoryType' => htmlspecialchars(trim($_POST['categoryType'])),
            'categoryLink' => htmlspecialchars(trim($_POST['categoryLink'])),
            'categoryDescription' => htmlspecialchars(trim($_POST['categoryDescription'])),
        ];

        // Validate inputs
        $validator = new DataValidator();

        $validator('Category Name', $postArray['categoryName'])->required()->min(3)->max(20);
        $validator('Category Type', $postArray['categoryType'])->required()->min(3)->max(20);

        if ($validator->isValidated()) {
            try {
                // Insert in Database
                $this->categoriesModel->insertCategory($postArray);
                // setSessionAlert('success', 'Insert completed successfully.');
                echo json_encode([
                    "status" => "success",
                    'message' => 'Category created successfully',
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
        $data['title'] = 'Category Edit - ' . $id;
        $data['rows'] = $this->categoriesModel->getCategoryById($id);

        if ($data['rows'] && count($data['rows']) > 0) {
            // Authorization
            $userId = $data['rows']['userID'];
            $user = $this->usersModel->getUserById($userId);
            if (!UserPermissions::canEdit($userId, $user['userRole'])) {
                setSessionAlert('warning', 'You are not authorized to edit this Category!');
                redirect(ADMURL . '/categories');
            }

            $this->renderAdminView('/admin/categories/edit', $data);
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
            'categoryID' => $id,
            'userID' => $_SESSION['user']['id'],
            'categoryName' => htmlspecialchars(trim($_POST['categoryName'])),
            'categoryType' => htmlspecialchars(trim($_POST['categoryType'])),
            'categoryLink' => htmlspecialchars(trim($_POST['categoryLink'])),
            'categoryDescription' => htmlspecialchars(trim($_POST['categoryDescription'])),
        ];

        // Get existing category from the Model
        $category = $this->categoriesModel->getCategoryById($id);

        // Authorization
        $userId = $category['userID'];
        $user = $this->usersModel->getUserById($userId);
        if (!UserPermissions::canEdit($userId, $user['userRole'])) {
            echo json_encode([
                "status" => "warning",
                "message" => 'You are not authorized to update this Category!'
            ]);
            exit;
        }

        // Validate inputs
        $validator = new DataValidator();

        $validator('Category Name', $postArray['categoryName'])->required()->min(3)->max(20);
        $validator('Category Type', $postArray['categoryType'])->required()->min(3)->max(20);

        if ($validator->isValidated()) {
            // Remove unchanged postArray keys but keep the 'id'
            foreach ($postArray as $key => $value) {
                if (isset($postArray[$key]) && $category[$key] == $value && $key !== 'categoryID') {
                    unset($postArray[$key]);
                }
            }
            // remove empty keys
            // $postArray = array_filter($postArray, 'strlen'); => Deprecated
            $postArray = array_filter($postArray ?? [], 'filterNotEmptyOrNull');

            if (count($postArray) > 1) {
                try {
                    // Update in Database
                    $this->categoriesModel->updateCategory($postArray);
                    // setSessionAlert('success', 'Update completed successfully');
                    echo json_encode([
                        "status" => "success",
                        'message' => 'Category updated successfully',
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
        $category = $this->categoriesModel->getCategoryById($id);
        $userId = $category['userID'];
        $user = $this->usersModel->getUserById($userId);
        if (!UserPermissions::canDelete($userId, $user['userRole'])) {
            setSessionAlert('warning', 'You are not authorized to delete this Category!');
            redirect(ADMURL . '/categories');
        }

        try {
            // Delete in Database
            $this->categoriesModel->deleteCategory($id);
            setSessionAlert('success', 'Category with the ID: <strong>' . $id . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setSessionAlert('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/categories');
    }
}
