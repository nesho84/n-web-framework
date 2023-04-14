<?php

class LanguagesController extends Controller
{
    private LanguagesModel $languagesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        Sessions::requireLogin();

        // Load Model
        $this->languagesModel = $this->loadModel("/admin/LanguagesModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Languages';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
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
        if (isset($_POST['insert_language'])) {
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
                    $validator->addError('LanguageFlag', 'Only images with max. 150x150 pixels are allowed.')->setValidated(false);
                }
                // Make sure `file.name` matches our extensions criteria
                $allowed_extensions = array("jpg", "jpeg", "png", "gif");
                $extension = pathinfo($postArray['languageFlag']['name'], PATHINFO_EXTENSION);
                if (!in_array($extension, $allowed_extensions)) {
                    $validator->addError('LanguageFlag', 'Only jpeg, png, and gif images are allowed.')->setValidated(false);
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
                    setAlert('success', 'Insert completed successfully.');
                    unset($_SESSION['inputs']);
                    redirect(ADMURL . '/languages');
                } catch (Exception $e) {
                    setAlert('error', $e->getMessage());
                    $_SESSION['inputs'] = $postArray;
                    redirect(ADMURL . '/languages/create');
                }
            } else {
                setAlert('error', $validator->getErrors());
                $_SESSION['inputs'] = $postArray;
                redirect(ADMURL . '/languages/create');
            }
        }
    }

    //------------------------------------------------------------
    public function edit(int $id): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Language Edit - ' . $id;
        $data['rows'] = $this->languagesModel->getLanguageById($id);

        $this->renderAdminView('/admin/languages/edit', $data);
    }

    //------------------------------------------------------------
    public function update(int $id): void
    //------------------------------------------------------------
    {
        if (isset($_POST['update_language'])) {
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
                    $validator->addError('LanguageFlag', 'Only images with max. 150x150 pixels are allowed.')->setValidated(false);
                }
                // Make sure `file.name` matches our extensions criteria
                $allowed_extensions = array("jpg", "jpeg", "png", "gif");
                $extension = pathinfo($postArray['languageFlag']['name'], PATHINFO_EXTENSION);
                if (!in_array($extension, $allowed_extensions)) {
                    $validator->addError('LanguageFlag', 'Only jpeg, png, and gif images are allowed.')->setValidated(false);
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

                if (count($postArray) > 1) {
                    try {
                        // Update in Database
                        $this->languagesModel->updateLanguage($postArray);
                        setAlert('success', 'Update completed successfully');
                        redirect(ADMURL . '/languages');
                    } catch (Exception $e) {
                        setAlert('error', $e->getMessage());
                        redirect(ADMURL . '/languages/edit/' . $id);
                    }
                } else {
                    setAlert('warning', 'No fields were changed');
                    redirect(ADMURL . '/languages/edit/' . $id);
                }
            } else {
                setAlert('error', $validator->getErrors());
                redirect(ADMURL . '/languages/edit/' . $id);
            }
        }
    }

    //------------------------------------------------------------
    public function delete(int $id): void
    //------------------------------------------------------------
    {
        try {
            // Delete in Database
            $this->languagesModel->deleteLanguage($id);
            setAlert('success', 'Language with the ID: <strong>' . $id . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setAlert('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/languages');
    }
}
