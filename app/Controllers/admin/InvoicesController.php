<?php

class InvoicesController extends Controller
{
    private InvoicesModel $invoicesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        Sessions::requireLogin();

        // Load Model
        $this->invoicesModel = $this->loadModel("/admin/InvoicesModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Invoices';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['rows'] = $this->invoicesModel->getInvoices();

        $this->renderAdminView('/admin/invoices/invoices', $data);
    }

    //------------------------------------------------------------
    public function create(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Invoices Create';

        $this->renderAdminView('/admin/invoices/create', $data);
    }

    //------------------------------------------------------------
    public function insert(): void
    //------------------------------------------------------------
    {
        if (isset($_POST['insert_invoice'])) {

            foreach ($_POST['services'] as $service) {
                echo $service['serviceName'] . '<br>';
            }
            dd($_POST);

            // $postArray = [
            //     'userID' => $_SESSION['user']['id'],
            //     'categoryName' => htmlspecialchars(trim($_POST['categoryName'])),
            //     'categoryType' => htmlspecialchars(trim($_POST['categoryType'])),
            //     'categoryLink' => htmlspecialchars(trim($_POST['categoryLink'])),
            //     'categoryDescription' => htmlspecialchars(trim($_POST['categoryDescription'])),
            // ];

            // $_SESSION['inputs'] = [];
            // $validated = true;
            // $error = '';

            // if (empty($postArray['categoryName'])) {
            //     $validated = false;
            //     $error .= 'Please insert a Category Name!<br>';
            // }
            // if (empty($postArray['categoryType'])) {
            //     $validated = false;
            //     $error .= 'Category Type can not be empty!<br>';
            // }
            // // if (empty($postArray['categoryLink'])) {
            // //     $validated = false;
            // //     $error .= 'Please insert a Category Link!<br>';
            // // }

            // if ($validated === true) {
            //     try {
            //         // Insert in Database
            //         $this->invoicesModel->insertCategory($postArray);
            //         setFlashMsg('success', 'Insert completed successfully.');
            //         unset($_SESSION['inputs']);
            //         redirect(ADMURL . '/categories');
            //     } catch (Exception $e) {
            //         setFlashMsg('error', $e->getMessage());
            //         $_SESSION['inputs'] = $postArray;
            //         redirect(ADMURL . '/categories/create');
            //     }
            // } else {
            //     setFlashMsg('error', $error);
            //     $_SESSION['inputs'] = $postArray;
            //     redirect(ADMURL . '/categories/create');
            // }
        }
    }

    // //------------------------------------------------------------
    // public function edit(int $id): void
    // //------------------------------------------------------------
    // {
    //     $data['title'] = 'Category Edit - ' . $id;
    //     $data['rows'] = $this->invoicesModel->getCategoryById($id);

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
    //                 $this->invoicesModel->updateCategory($postArray);
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
    //         $this->invoicesModel->deleteCategory($id);
    //         setFlashMsg('success', 'Category with the ID: <strong>' . $id . '</strong> deleted successfully.');
    //     } catch (Exception $e) {
    //         setFlashMsg('error', $e->getMessage());
    //     }

    //     // Allways redirect back
    //     redirect(ADMURL . '/categories');
    // }
}
