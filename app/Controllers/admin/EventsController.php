<?php

class EventsController extends Controller
{
    private EventsModel $eventsModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        Sessions::requireLogin();

        // Load Model
        $this->eventsModel = $this->loadModel("/admin/EventsModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Events';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['rows'] = $this->eventsModel->getEvents();

        $this->renderAdminView('/admin/events/events', $data);
    }

    //------------------------------------------------------------
    public function create_modal(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Event Create';

        $this->renderSimpleView('/admin/events/create_modal', $data);
    }

    // //------------------------------------------------------------
    // public function insert(): void
    // //------------------------------------------------------------
    // {
    //     // Set Security Headers and Require CSRF_TOKEN
    //     Sessions::setHeaders()->requireCSRF();

    //     $postArray = [
    //         'userID' => $_SESSION['user']['id'],
    //         'categoryName' => htmlspecialchars(trim($_POST['categoryName'])),
    //         'categoryType' => htmlspecialchars(trim($_POST['categoryType'])),
    //         'categoryLink' => htmlspecialchars(trim($_POST['categoryLink'])),
    //         'categoryDescription' => htmlspecialchars(trim($_POST['categoryDescription'])),
    //     ];

    // **
    // Example for formating dates for the mySQL date fields
    // **
    // // Get the input dates from the form
    // $start_date = $_POST['eventStart'];
    // $end_date = $_POST['endStart'];
    // // Format the dates for MySQL
    // $formatted_start_date = date('Y-m-d', strtotime($start_date));
    // $formatted_end_date = date('Y-m-d', strtotime($end_date));


    //     // Validate inputs
    //     $validator = new DataValidator();

    //     $validator('Category Name', $postArray['categoryName'])->required()->min(3)->max(20);
    //     $validator('Category Type', $postArray['categoryType'])->required()->min(3)->max(20);

    //     if ($validator->isValidated()) {
    //         try {
    //             // Insert in Database
    //             $this->eventsModel->insertCategory($postArray);
    //             // setSessionAlert('success', 'Insert completed successfully.');
    //             echo json_encode([
    //                 "status" => "success",
    //                 'message' => 'Category created successfully',
    //             ]);
    //         } catch (Exception $e) {
    //             http_response_code(500);
    //             echo json_encode([
    //                 "status" => "error",
    //                 "message" => $e->getMessage()
    //             ]);
    //             exit();
    //         }
    //     } else {
    //         // http_response_code(422);
    //         echo json_encode([
    //             "status" => "error",
    //             "message" => $validator->getErrors()
    //         ]);
    //         exit();
    //     }
    // }

    // //------------------------------------------------------------
    // public function edit(int $id): void
    // //------------------------------------------------------------
    // {
    //     $data['title'] = 'Category Edit - ' . $id;
    //     $data['rows'] = $this->eventsModel->getCategoryById($id);

    //     $this->renderAdminView('/admin/categories/edit', $data);
    // }

    // //------------------------------------------------------------
    // public function update(int $id): void
    // //------------------------------------------------------------
    // {
    //     // Set Security Headers and Require CSRF_TOKEN
    //     Sessions::setHeaders()->requireCSRF();

    //     $postArray = [
    //         'categoryID' => $id,
    //         'userID' => $_SESSION['user']['id'],
    //         'categoryName' => htmlspecialchars(trim($_POST['categoryName'])),
    //         'categoryType' => htmlspecialchars(trim($_POST['categoryType'])),
    //         'categoryLink' => htmlspecialchars(trim($_POST['categoryLink'])),
    //         'categoryDescription' => htmlspecialchars(trim($_POST['categoryDescription'])),
    //     ];

    //     // Get existing category from the Model
    //     $category = $this->eventsModel->getCategoryById($id);

    //     // Validate inputs
    //     $validator = new DataValidator();

    //     $validator('Category Name', $postArray['categoryName'])->required()->min(3)->max(20);
    //     $validator('Category Type', $postArray['categoryType'])->required()->min(3)->max(20);

    //     if ($validator->isValidated()) {
    //         // Remove unchanged postArray keys but keep the 'id'
    //         foreach ($postArray as $key => $value) {
    //             if (isset($postArray[$key]) && $category[$key] == $value && $key !== 'categoryID') {
    //                 unset($postArray[$key]);
    //             }
    //         }
    //         // remove empty keys
    //         $postArray = array_filter($postArray, 'strlen');

    //         if (count($postArray) > 1) {
    //             try {
    //                 // Update in Database
    //                 $this->eventsModel->updateCategory($postArray);
    //                 // setSessionAlert('success', 'Update completed successfully');
    //                 echo json_encode([
    //                     "status" => "success",
    //                     'message' => 'Category updated successfully',
    //                 ]);
    //             } catch (Exception $e) {
    //                 http_response_code(500);
    //                 echo json_encode([
    //                     "status" => "error",
    //                     "message" => $e->getMessage()
    //                 ]);
    //                 exit();
    //             }
    //         } else {
    //             // setSessionAlert('warning', 'No fields were changed');
    //             echo json_encode([
    //                 "status" => "warning",
    //                 "message" => 'No fields were changed'
    //             ]);
    //             exit();
    //         }
    //     } else {
    //         // http_response_code(422);
    //         echo json_encode([
    //             "status" => "error",
    //             "message" => $validator->getErrors()
    //         ]);
    //         exit();
    //     }
    // }

    // //------------------------------------------------------------
    // public function delete(int $id): void
    // //------------------------------------------------------------
    // {
    //     try {
    //         // Delete in Database
    //         $this->eventsModel->deleteCategory($id);
    //         setSessionAlert('success', 'Category with the ID: <strong>' . $id . '</strong> deleted successfully.');
    //     } catch (Exception $e) {
    //         setSessionAlert('error', $e->getMessage());
    //     }

    //     // Allways redirect back
    //     redirect(ADMURL . '/categories');
    // }
}
