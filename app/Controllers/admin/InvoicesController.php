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
    public function invoice_pdf(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'PDF Invoice';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";

        // Get the customer ID from the URL query string
        $data['id'] = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $data['invoice'] = $this->invoicesModel->getInvoiceById((int)$data['id']);
        $data['services'] = $this->invoicesModel->getServicesByInvoiceId((int)$data['id']);

        if ($data['invoice'] && count($data['invoice']) > 0) {
            $this->renderSimpleView('/admin/invoices/invoice_pdf', $data);
        } else {
            http_response_code(404);
        }
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
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF();

        // Validate inputs
        $validator = new DataValidator();

        // Get Company Information and validate data
        $companyType = htmlspecialchars(trim($_POST['company-type']));
        $companyID = "";
        $companyArray = [];
        if ($companyType === 'existing') {
            $companyID = isset($_POST['companyID']) ? htmlspecialchars(trim($_POST['companyID'])) : "";
            if (empty($companyID)) {
                $validator->addError('Company', 'Please choose Company or create a new')
                    ->setValidated(false);
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
            $validator('Company Name', $companyArray['companyName'])->required()->min(3)->max(20);
            $validator('Company Address', $companyArray['companyAddress'])->required()->min(3)->max(20);
            $validator('Company Email', $companyArray['companyEmail'])->required()->min(3)->max(20);
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
            $validator->addError('Services', 'Service fields can not be empty')->setValidated(false);
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

        if ($validator->isValidated()) {
            try {
                // Insert in Database
                $this->invoicesModel->insertInvoice($postArray);
                // setSessionAlert('success', 'Invoice created successfully');
                echo json_encode([
                    "status" => "success",
                    'message' => 'Invoice created successfully',
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

    // //------------------------------------------------------------
    // public function edit(string $id): void
    // //------------------------------------------------------------
    // {
    //     $data['title'] = 'Category Edit - ' . $id;
    //     $data['rows'] = $this->invoicesModel->getCategoryById($id);

    //     $this->renderAdminView('/admin/categories/edit', $data);
    // }

    // //------------------------------------------------------------
    // public function update(string $id): void
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
    //                 setSessionAlert('success', 'Update completed successfully');
    //                 redirect(ADMURL . '/categories');
    //             } catch (Exception $e) {
    //                 setSessionAlert('error', $e->getMessage());
    //                 redirect(ADMURL . '/categories/edit/' . $id);
    //             }
    //         } else {
    //             setSessionAlert('error', $error);
    //             redirect(ADMURL . '/categories/edit/' . $id);
    //         }
    //     }
    // }

    //------------------------------------------------------------
    public function delete(string $id): void
    //------------------------------------------------------------
    {
        try {
            // Delete in Database
            $this->invoicesModel->deleteInvoice($id);
            setSessionAlert('success', 'Invoice with the ID: <strong>' . $id . '</strong> and it\'s services deleted successfully.');
        } catch (Exception $e) {
            setSessionAlert('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/invoices');
    }
}
