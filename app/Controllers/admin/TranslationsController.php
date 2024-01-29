<?php

class TranslationsController extends Controller
{
    private TranslationsModel $translationsModel;
    private LanguagesModel $languagesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        Sessions::requireLogin();

        // Load Model
        $this->translationsModel = $this->loadModel("/admin/TranslationsModel");

        // Load LanguagesModel
        $this->languagesModel = $this->loadModel("/admin/LanguagesModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Translations';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['rows'] = $this->translationsModel->getTranslations();

        $this->renderAdminView('/admin/translations/translations', $data);

        // // Render multiple pages example
        // $this->renderAdminView([
        //     '/admin/translations/create.php',
        //     '/admin/translations/translations'
        // ], $data);
    }

    //------------------------------------------------------------
    public function create(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Translations Create';
        $data['languages'] = $this->languagesModel->getLanguages();

        $this->renderAdminView('/admin/translations/create', $data);
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
            'translationCode' => htmlspecialchars(trim($_POST['translationCode'])),
            'translationText' => htmlspecialchars(trim($_POST['translationText'])),
        ];

        // Get all existing language ids from the Model
        $languages = $this->languagesModel->getLanguages();
        $valid_ids = array();
        foreach ($languages as $lang) {
            $valid_ids[] = $lang['languageID'];
        }

        // Validate inputs
        $validator = new DataValidator();
        $validator('Translation Code', $postArray['translationCode'])->required()->number();
        if (empty($postArray['languageID'])) {
            $validator->addError('languageID', 'Please choose a Language')->setValidated(false);
        } elseif (!in_array($postArray['languageID'], $valid_ids)) {
            $validator->addError('languageID', 'Please select a valid language')->setValidated(false);
        }
        $validator('Translation Text', $postArray['translationText'])->required()->min(3)->max(50);

        if ($validator->isValidated()) {
            try {
                // Insert in Database
                $this->translationsModel->insertTranslation($postArray);
                // setSessionAlert('success', 'Translation created successfully.');
                echo json_encode([
                    "status" => "success",
                    'message' => 'Translation created successfully',
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
        $data['title'] = 'Translation Edit - ' . $id;
        $data['rows'] = $this->translationsModel->getTranslationById($id);
        $data['languages'] = $this->languagesModel->getLanguages();

        if ($data['rows'] && count($data['rows']) > 0) {
            $this->renderAdminView('/admin/translations/edit', $data);
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
            'translationID' => $id,
            'userID' => $_SESSION['user']['id'],
            'languageID' => htmlspecialchars(trim($_POST['languageID'])),
            'translationCode' => htmlspecialchars(trim($_POST['translationCode'])),
            'translationText' => htmlspecialchars(trim($_POST['translationText'])),
        ];

        // Get existing category from the Model
        $translation = $this->translationsModel->getTranslationById($id);
        // Get all existing language ids from the Model
        $languages = $this->languagesModel->getLanguages();
        $valid_ids = array();
        foreach ($languages as $lang) {
            $valid_ids[] = $lang['languageID'];
        }

        // Validate inputs
        $validator = new DataValidator();
        $validator('Translation Code', $postArray['translationCode'])->required()->number();
        if (empty($postArray['languageID'])) {
            $validator->addError('languageID', 'Please choose a Language')->setValidated(false);
        } elseif (!in_array($postArray['languageID'], $valid_ids)) {
            $validator->addError('languageID', 'Please select a valid language')->setValidated(false);
        }
        $validator('Translation Text', $postArray['translationText'])->required()->min(3)->max(50);

        if ($validator->isValidated()) {
            // Remove unchanged postArray keys but keep the 'id'
            foreach ($postArray as $key => $value) {
                if (isset($postArray[$key]) && $translation[$key] == $value && $key !== 'translationID') {
                    unset($postArray[$key]);
                }
            }
            // remove empty keys
            $postArray = array_filter($postArray, 'strlen');

            if (count($postArray) > 1) {
                try {
                    // Update in Database
                    $this->translationsModel->updateTranslation($postArray);
                    // setSessionAlert('success', 'Translation updated successfully');
                    echo json_encode([
                        "status" => "success",
                        'message' => 'Translation updated successfully',
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
            $this->translationsModel->deleteTranslation($id);
            setSessionAlert('success', 'Translation with the ID: <strong>' . $id . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setSessionAlert('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/translations');
    }
}
