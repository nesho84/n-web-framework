<?php

class CategoriesController extends Controller
{
    private CategoriesModel $categoriesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        Sessions::requireLogin();

        // Load Model
        $this->categoriesModel = $this->loadModel("/admin/CategoriesModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Categories';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['rows'] = $this->categoriesModel->getCategories();

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
                // setAlert('success', 'Insert completed successfully.');
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
    public function edit(int $id): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Category Edit - ' . $id;
        $data['rows'] = $this->categoriesModel->getCategoryById($id);

        $this->renderAdminView('/admin/categories/edit', $data);
    }

    //------------------------------------------------------------
    public function update(int $id): void
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
            $postArray = array_filter($postArray, 'strlen');

            if (count($postArray) > 1) {
                try {
                    // Update in Database
                    $this->categoriesModel->updateCategory($postArray);
                    // setAlert('success', 'Update completed successfully');
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
                    exit();
                }
            } else {
                // setAlert('warning', 'No fields were changed');
                echo json_encode([
                    "status" => "warning",
                    "message" => 'No fields were changed'
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
        try {
            // Delete in Database
            $this->categoriesModel->deleteCategory($id);
            setAlert('success', 'Category with the ID: <strong>' . $id . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setAlert('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/categories');
    }
}
