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
        if (isset($_POST['insert_file'])) {
            $postArray = [
                'userID' => $_SESSION['user']['id'],
                'categoryID' => htmlspecialchars($_POST['categoryID'] ?? ""),
                // 'fileName' => htmlspecialchars(trim($_POST['fileName'])),
                // 'fileType' => htmlspecialchars(trim($_POST['fileType'])),
                'filePath' => $_FILES['filePath'] ?? null,
            ];
            // dd($postArray);

            $_SESSION['inputs'] = [];
            $validated = true;
            $error = '';

            if (empty($postArray['categoryID'])) {
                $validated = false;
                $error .= 'Please insert a File Category!<br>';
            }
            if (empty($postArray['filePath']['name'])) {
                $validated = false;
                $error .= 'Please insert a File Link!<br>';
            }

            // --- File Upload and Validation START --- //
            if ($validated === true) {
                $category = $this->categoriesModel->getCategoryById((int)$postArray['categoryID']);
                [$uploadError, $targetPath] = FileUpload::upload($postArray['filePath'], strtolower($category['categoryName']));
                // First Check if there was an error
                if ($uploadError !== "") {
                    $validated = false;
                    $error .= "$uploadError <br>";
                } else {
                    setFlashMsg('success', 'Upload completed successfully.<br>');
                    $postArray['fileName'] = pathinfo($targetPath, PATHINFO_BASENAME);
                    $postArray['fileType'] = pathinfo($targetPath, PATHINFO_EXTENSION);
                    $postArray['filePath'] = $targetPath;
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

    // //------------------------------------------------------------
    // public function edit(int $id): void
    // //------------------------------------------------------------
    // {
    //     $data['title'] = 'Category Edit - ' . $id;
    //     $data['rows'] = $this->categoriesModel->getCategoryById($id);

    //     $this->renderAdminView('/admin/categories/edit', $data);
    // }

    // //------------------------------------------------------------
    // public function update(int $id): void
    // //------------------------------------------------------------
    // {
    //     if (isset($_POST['update_category'])) {
    //         $postArray = [
    //             'categoryID' => $id,
    //             'userID' => $_SESSION['user']['id'],
    //             'categoryName' => htmlspecialchars(trim($_POST['categoryName'])),
    //             'categoryType' => htmlspecialchars(trim($_POST['categoryType'])),
    //             'categoryLink' => htmlspecialchars(trim($_POST['categoryLink'])),
    //             'categoryDescription' => htmlspecialchars(trim($_POST['categoryDescription'])),
    //         ];

    //         $validated = true;
    //         $error = '';

    //         if (empty($postArray['categoryName'])) {
    //             $validated = false;
    //             $error .= 'Please insert a Category Name!<br>';
    //         }
    //         if (empty($postArray['categoryType'])) {
    //             $validated = false;
    //             $error .= 'Category Type can not be empty!<br>';
    //         }
    //         // if (empty($postArray['categoryLink'])) {
    //         //     $validated = false;
    //         //     $error .= 'Please insert a Category Link!<br>';
    //         // }

    //         if ($validated === true) {
    //             try {
    //                 // Update in Database
    //                 $this->categoriesModel->updateCategory($postArray);
    //                 setFlashMsg('success', 'Update completed successfully');
    //                 redirect(ADMURL . '/categories');
    //             } catch (Exception $e) {
    //                 setFlashMsg('error', $e->getMessage());
    //                 redirect(ADMURL . '/categories/edit/' . $id);
    //             }
    //         } else {
    //             setFlashMsg('error', $error);
    //             redirect(ADMURL . '/categories/edit/' . $id);
    //         }
    //     }
    // }

    // //------------------------------------------------------------
    // public function delete(int $id): void
    // //------------------------------------------------------------
    // {
    //     try {
    //         // Delete in Database
    //         $this->categoriesModel->deleteCategory($id);
    //         setFlashMsg('success', 'Category with the ID: <strong>' . $id . '</strong> deleted successfully.');
    //     } catch (Exception $e) {
    //         setFlashMsg('error', $e->getMessage());
    //     }

    //     // Allways redirect back
    //     redirect(ADMURL . '/categories');
    // }
}
