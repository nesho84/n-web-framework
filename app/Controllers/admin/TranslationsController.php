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
        if (isset($_POST['insert_translation'])) {
            $postArray = [
                'userID' => $_SESSION['user']['id'],
                'languageID' => htmlspecialchars(trim($_POST['languageID'] ?? '')),
                'translationCode' => htmlspecialchars(trim($_POST['translationCode'])),
                'translationText' => htmlspecialchars(trim($_POST['translationText'])),
            ];

            $_SESSION['inputs'] = [];
            $validated = true;
            $error = '';

            if (empty($postArray['translationCode'])) {
                $validated = false;
                $error .= 'Translation Code can not be empty!<br>';
            }
            if (empty($postArray['languageID'])) {
                $validated = false;
                $error .= 'Please select a Language!<br>';
            }
            if (empty($postArray['translationText'])) {
                $validated = false;
                $error .= 'Please insert a Translation Text!<br>';
            }

            if ($validated === true) {
                try {
                    // Insert in Database
                    $this->translationsModel->insertTranslation($postArray);
                    setAlert('success', 'Insert completed successfully.');
                    unset($_SESSION['inputs']);
                    redirect(ADMURL . '/translations');
                } catch (Exception $e) {
                    setAlert('error', $e->getMessage());
                    $_SESSION['inputs'] = $postArray;
                    redirect(ADMURL . '/translations/create');
                }
            } else {
                setAlert('error', $error);
                $_SESSION['inputs'] = $postArray;
                redirect(ADMURL . '/translations/create');
            }
        }
    }

    //------------------------------------------------------------
    public function edit(int $id): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Translation Edit - ' . $id;
        $data['rows'] = $this->translationsModel->getTranslationById($id);
        $data['languages'] = $this->languagesModel->getLanguages();

        $this->renderAdminView('/admin/translations/edit', $data);
    }

    //------------------------------------------------------------
    public function update(int $id): void
    //------------------------------------------------------------
    {
        if (isset($_POST['update_translation'])) {
            $postArray = [
                'translationID' => $id,
                'userID' => $_SESSION['user']['id'],
                'languageID' => htmlspecialchars(trim($_POST['languageID'])),
                'translationCode' => htmlspecialchars(trim($_POST['translationCode'])),
                'translationText' => htmlspecialchars(trim($_POST['translationText'])),
            ];

            // Get existing category from the Model
            $translation = $this->translationsModel->getTranslationById($id);

            $validated = true;
            $error = '';

            if (empty($postArray['translationCode'])) {
                $validated = false;
                $error .= 'Translation Code can not be empty!<br>';
            }
            if (empty($postArray['languageID'])) {
                $validated = false;
                $error .= 'Please select a Language!<br>';
            }
            if (empty($postArray['translationText'])) {
                $validated = false;
                $error .= 'Please insert a translationText!<br>';
            }

            if ($validated === true) {
                // Remove unchanged postArray keys but keep the 'id'
                foreach ($postArray as $key => $value) {
                    if (isset($postArray[$key]) && $translation[$key] == $value && $key !== 'translationID') {
                        unset($postArray[$key]);
                    }
                }

                if (count($postArray) > 1) {
                    try {
                        // Update in Database
                        $this->translationsModel->updateTranslation($postArray);
                        setAlert('success', 'Update completed successfully');
                        redirect(ADMURL . '/translations');
                    } catch (Exception $e) {
                        setAlert('error', $e->getMessage());
                        redirect(ADMURL . '/translations/edit/' . $id);
                    }
                } else {
                    setAlert('warning', 'No fields were changed');
                    redirect(ADMURL . '/translations/edit/' . $id);
                }
            } else {
                setAlert('error', $error);
                redirect(ADMURL . '/translations/edit/' . $id);
            }
        }
    }

    //------------------------------------------------------------
    public function delete(int $id): void
    //------------------------------------------------------------
    {
        try {
            // Delete in Database
            $this->translationsModel->deleteTranslation($id);
            setAlert('success', 'Translation with the ID: <strong>' . $id . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setAlert('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/translations');
    }
}
