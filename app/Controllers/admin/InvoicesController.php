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
        $data['companies'] = $this->invoicesModel->getCompanies();

        $this->renderAdminView('/admin/invoices/create', $data);
    }

    //------------------------------------------------------------
    public function insert(): void
    //------------------------------------------------------------
    {
        if (isset($_POST['insert_invoice'])) {
            $_SESSION['inputs'] = [];
            $validated = true;
            $error = '';

            // Get Company Information and validate data
            $companyType = htmlspecialchars(trim($_POST['company-type']));
            $companyID = "";
            $companyArray = [];
            if ($companyType === 'existing') {
                $companyID = isset($_POST['companyID']) ? htmlspecialchars(trim($_POST['companyID'])) : "";
                if (empty($companyID)) {
                    $validated = false;
                    $error .= 'Please choose Company or create a new!<br>';
                }
            }
            if ($companyType === 'new') {
                $companyArray = [
                    'userID' => $_SESSION['user']['id'],
                    'companyName' => htmlspecialchars(trim($_POST['companyName'])),
                    'companyAddress' => htmlspecialchars(trim($_POST['companyAddress'])),
                    'companyCity' => htmlspecialchars(trim($_POST['companyCity'])),
                    'companyState' => htmlspecialchars(trim($_POST['companyState'])),
                    'companyZip' => htmlspecialchars(trim($_POST['companyZip'])),
                    'companyPhone' => htmlspecialchars(trim($_POST['companyPhone'])),
                    'companyEmail' => htmlspecialchars(trim($_POST['companyEmail'])),
                ];
                if (empty($companyArray['companyName'])) {
                    $validated = false;
                    $error .= 'Please insert a Company Name!<br>';
                }
                if (empty($companyArray['companyAddress'])) {
                    $validated = false;
                    $error .= 'Please insert a Company Address!<br>';
                }
                if (empty($companyArray['companyEmail'])) {
                    $validated = false;
                    $error .= 'Please insert a Company Email!<br>';
                }
            }

            // Secure services POST Array and Validate
            $servicesArray = $_POST['services'];
            $errorServices = 0;
            foreach ($servicesArray as $key => $service) {
                foreach ($service as $innerKey => $innerValue) {
                    $servicesArray[$key][$innerKey] = htmlspecialchars($innerValue);
                    // Validate values
                    if (empty($servicesArray[$key][$innerKey])) {
                        $errorServices++;
                    }
                }
            }
            if ($errorServices > 0) {
                $validated = false;
                $error .= 'Services fields can not be empty!<br>';
            }

            $postArray = [
                'company' => $companyArray,
                'invoice' => [
                    'userID' => $_SESSION['user']['id'],
                    'companyID' => $companyID,
                    'invoiceTotalPrice' => htmlspecialchars(trim($_POST['invoiceTotalPrice'])),

                ],
                'services' => $servicesArray
            ];

            if ($validated === true) {
                try {
                    // Insert in Database
                    $this->invoicesModel->insertInvoice($postArray);
                    setFlashMsg('success', 'Insert completed successfully.');
                    unset($_SESSION['inputs']);
                    redirect(ADMURL . '/invoices');
                } catch (Exception $e) {
                    setFlashMsg('error', $e->getMessage());
                    $_SESSION['inputs'] = $postArray;
                    redirect(ADMURL . '/invoices/create');
                }
            } else {
                setFlashMsg('error', $error);
                $_SESSION['inputs'] = $postArray;
                redirect(ADMURL . '/invoices/create');
            }
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
    //         $this->invoicesModel->deleteInvoice($id);
    //         setFlashMsg('success', 'Invoice with the ID: <strong>' . $id . '</strong> deleted successfully.');
    //     } catch (Exception $e) {
    //         setFlashMsg('error', $e->getMessage());
    //     }

    //     // Allways redirect back
    //     redirect(ADMURL . '/invoices');
    // }
}
