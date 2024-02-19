<?php

namespace App\Controllers;

use Exception;
use App\Core\Controller;
use App\Models\LanguagesModel;
use App\Core\Sessions;
use App\Common\DataValidator;

class LanguagesController extends Controller
{
    private LanguagesModel $languagesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        $this->languagesModel = new LanguagesModel();
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Languages';
        $data['rows'] = $this->languagesModel->getLanguages();

        // TODO: here should be languages section
        $this->renderAdminView('/admin/languages/languages', $data);
    }

    //------------------------------------------------------------
    public function create(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Languages Create';

        $this->renderAdminView('/admin/languages/create', $data);
    }

    //------------------------------------------------------------
    public function insert(): void
    //------------------------------------------------------------
    {
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF();

        $postArray = [
            'userID' => $_SESSION['user']['id'],
            'languageName' => htmlspecialchars(trim($_POST['languageName'])),
            'languageCode' => htmlspecialchars(trim($_POST['languageCode'])),
            'languageFlag' => $_FILES['languageFlag'] ?? null,
        ];

        // Validate inputs
        $validator = new DataValidator();

        $validator('Language Name', $postArray['languageName'])->required()->min(3)->max(20);
        $validator('Language Code', $postArray['languageCode'])->required()->min(2)->max(20);

        // base64 Image Logic and Validation
        if (empty($postArray['languageFlag']['name'])) {
            // If it is empty then replace with null
            $postArray['languageFlag'] = null;
        } else {
            $file = $postArray['languageFlag']['tmp_name'];
            // Get the width and height of the image
            [$width, $height] = getimagesize($file);
            if ($width > 150 || $height > 150) {
                $validator->addError('LanguageFlag', 'Only images with max. 150x150 pixels are allowed.');
            }
            // Make sure `file.name` matches our extensions criteria
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");
            $extension = pathinfo($postArray['languageFlag']['name'], PATHINFO_EXTENSION);
            if (!in_array($extension, $allowed_extensions)) {
                $validator->addError('LanguageFlag', 'Only jpeg, png, and gif images are allowed.');
            }
            // Set Image only if validation passed
            if ($validator->isValidated()) {
                $image = file_get_contents($file);
                $image = base64_encode($image);
                $postArray['languageFlag'] = 'data:image/png;base64,' . $image;
            }
        }

        if ($validator->isValidated()) {
            try {
                // Insert in Database
                $this->languagesModel->insertLanguage($postArray);
                // setSessionAlert('success', 'Language created successfully');
                echo json_encode([
                    "status" => "success",
                    'message' => 'Language created successfully',
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
        $data['title'] = 'Language Edit - ' . $id;
        $data['rows'] = $this->languagesModel->getLanguageById($id);

        if ($data['rows'] && count($data['rows']) > 0) {
            $this->renderAdminView('/admin/languages/edit', $data);
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
            'languageID' => $id,
            'userID' => $_SESSION['user']['id'],
            'languageName' => htmlspecialchars(trim($_POST['languageName'])),
            'languageCode' => htmlspecialchars(trim($_POST['languageCode'])),
            'languageFlag' => $_FILES['languageFlag'] ?? null,
        ];

        // Get existing language from the Model
        $language = $this->languagesModel->getLanguageById($id);

        // Validate inputs
        $validator = new DataValidator();

        $validator('Language Name', $postArray['languageName'])->required()->min(3)->max(20);
        $validator('Language Code', $postArray['languageCode'])->required()->min(2)->max(20);

        // base64 Image Logic and Validation
        if (empty($postArray['languageFlag']['name'])) {
            // If it was not changed then replace with existing
            $postArray['languageFlag'] = $language['languageFlag'];
        } else {
            $file = $postArray['languageFlag']['tmp_name'];
            // Get the width and height of the image
            [$width, $height] = getimagesize($file);
            if ($width > 150 || $height > 150) {
                $validator->addError('LanguageFlag', 'Only images with max. 150x150 pixels are allowed.');
            }
            // Make sure `file.name` matches our extensions criteria
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");
            $extension = pathinfo($postArray['languageFlag']['name'], PATHINFO_EXTENSION);
            if (!in_array($extension, $allowed_extensions)) {
                $validator->addError('LanguageFlag', 'Only jpeg, png, and gif images are allowed.');
            }
            // Set Image only if validation passed
            if ($validator->isValidated()) {
                $image = file_get_contents($file);
                $image = base64_encode($image);
                $postArray['languageFlag'] = 'data:image/png;base64,' . $image;
            }
        }

        if ($validator->isValidated()) {
            // Remove unchanged postArray keys but keep the 'id'
            foreach ($postArray as $key => $value) {
                if (isset($postArray[$key]) && $language[$key] == $value && $key !== 'languageID') {
                    unset($postArray[$key]);
                }
            }
            // remove empty keys
            // $postArray = array_filter($postArray, 'strlen'); => Deprecated
            $postArray = array_filter($postArray ?? [], 'filterNotEmptyOrNull');

            if (count($postArray) > 1) {
                try {
                    // Update in Database
                    $this->languagesModel->updateLanguage($postArray);
                    // setSessionAlert('success', 'Language Updated successfully');
                    echo json_encode([
                        "status" => "success",
                        'message' => 'Language updated successfully',
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
            $this->languagesModel->deleteLanguage($id);
            setSessionAlert('success', 'Language with the ID: <strong>' . $id . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setSessionAlert('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/languages');
    }
}
