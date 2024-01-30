<?php

class SettingsController extends Controller
{
    private SettingsModel $settingsModel;
    private LanguagesModel $languagesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Load Model
        $this->settingsModel = $this->loadModel("/admin/SettingsModel");

        // Load LanguagesModel
        $this->languagesModel = $this->loadModel("/admin/LanguagesModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Settings';
        $data['rows'] = $this->settingsModel->getSettings();

        $this->renderAdminView('/admin/settings/settings', $data);
    }

    //------------------------------------------------------------
    public function edit_modal(string $id): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Settings';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['languages'] = $this->languagesModel->getLanguages();
        $data['rows'] = $this->settingsModel->getSettingById($id);

        if ($data['rows'] && count($data['rows']) > 0) {
            $this->renderSimpleView('/admin/settings/edit_modal', $data);
        } else {
            http_response_code(404);
        }
    }

    //------------------------------------------------------------
    public function update(string $id): void
    //------------------------------------------------------------
    {
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF(htmlspecialchars($_POST['csrf_token'] ?? ''));

        if (isset($_POST['update_setting'])) {
            $postArray = [
                'settingID' => $id,
                'languageID' => htmlspecialchars(trim($_POST['languageID'] ?? '')),
                'settingTheme' => htmlspecialchars(trim($_POST['settingTheme'])),
            ];

            // Get existing setting from the Model
            $setting = $this->settingsModel->getSettingById($id);
            // Get all existing language ids from the Model
            $languages = $this->languagesModel->getLanguages();
            $valid_ids = array();
            foreach ($languages as $lang) {
                $valid_ids[] = $lang['languageID'];
            }

            // Validate inputs
            $validator = new DataValidator();
            $validator('Theme', $postArray['settingTheme'])->required();
            if (empty($postArray['languageID'])) {
                $validator->addError('languageID', 'Please choose a Language');
            } elseif (!in_array($postArray['languageID'], $valid_ids)) {
                $validator->addError('languageID', 'Please select a valid language');
            }

            if ($validator->isValidated()) {
                // Remove unchanged postArray keys but keep the 'id'
                foreach ($postArray as $key => $value) {
                    if (isset($postArray[$key]) && $setting[$key] == $value && $key !== 'settingID') {
                        unset($postArray[$key]);
                    }
                }
                // remove empty keys
                // $postArray = array_filter($postArray, 'strlen'); => Deprecated
                $postArray = array_filter($postArray ?? [], 'filterNotEmptyOrNull');

                if (count($postArray) > 1) {
                    try {
                        // Update in Database
                        $this->settingsModel->updateSetting($postArray);
                        // Update Settings Session (only for logged in User)
                        if ($postArray['settingID'] === $_SESSION['settings']['settingID']) {
                            $this->updateSessions($postArray);
                        }
                        setSessionAlert('success', 'Settings updated successfully');
                        redirect(ADMURL . '/settings');
                    } catch (Exception $e) {
                        setSessionAlert('error', $e->getMessage());
                        redirect(ADMURL . '/settings');
                    }
                } else {
                    setSessionAlert('warning', 'No fields were changed');
                    redirect(ADMURL . '/settings');
                }
            } else {
                setSessionAlert('error', $validator->getErrors());
                redirect(ADMURL . '/settings');
            }
        }
    }

    //------------------------------------------------------------
    private function updateSessions(array $postArray): void
    //------------------------------------------------------------
    {
        // Set User Settings Session array
        $_SESSION['settings']['languageID'] = $postArray['languageID'];
        $_SESSION['settings']['settingTheme'] = $postArray['settingTheme'];
    }

    //------------------------------------------------------------
    public function dbbackup(): void
    //------------------------------------------------------------
    {
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF();

        try {
            // Insert in Database
            $this->settingsModel->backupDatabase(DB_BACKUPS_PATH);
            // setSessionAlert('success', 'Backup completed successfully');
            echo json_encode([
                "status" => "success",
                'message' => 'Backup completed successfully'
            ]);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
            exit;
        }
    }

    //------------------------------------------------------------
    public function dbbackups_modal(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Database Backups';
        // $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";

        try {
            $directory = DB_BACKUPS_PATH . "/";
            $data['rows'] = FileHandler::get_files_in_directory($directory);
        } catch (Exception $e) {
            setSessionAlert('error', $e->getMessage());
        }

        $this->renderSimpleView('/admin/settings/dbbackups_modal', $data);
    }

    //------------------------------------------------------------
    public function dbbackup_delete(): void
    //------------------------------------------------------------
    {
        // Get the customer ID from the URL query string
        $file = filter_input(INPUT_GET, 'file', FILTER_SANITIZE_SPECIAL_CHARS);

        $directory = DB_BACKUPS_PATH . "/";

        try {
            // Delete the existing files
            FileHandler::remove_files_from_directory($directory, $file);
            setSessionAlert('success', 'File: <strong>' . $file . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setSessionAlert('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/settings');
    }
}
