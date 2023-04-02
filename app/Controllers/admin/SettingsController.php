<?php

class SettingsController extends Controller
{
    private SettingsModel $settingsModel;
    private LanguagesModel $languagesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        Sessions::requireLogin();

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
    public function edit_modal(int $id): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Settings';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['languages'] = $this->languagesModel->getLanguages();
        $data['rows'] = $this->settingsModel->getSettingById($id);

        $this->renderSimpleView('/admin/settings/edit_modal', $data);
    }

    //------------------------------------------------------------
    public function update(int $id): void
    //------------------------------------------------------------
    {
        if (isset($_POST['update_setting'])) {
            $postArray = [
                'settingID' => $id,
                'languageID' => htmlspecialchars(trim($_POST['languageID'] ?? '')),
                'settingTheme' => htmlspecialchars(trim($_POST['settingTheme'])),
            ];

            // Get existing setting from the Model
            $setting = $this->settingsModel->getSettingById($id);

            $validated = true;
            $error = '';

            if (empty($postArray['languageID'])) {
                $validated = false;
                $error .= 'Language can not be empty!<br>';
            }
            if (empty($postArray['settingTheme'])) {
                $validated = false;
                $error .= 'Theme can not be empty!<br>';
            }

            if ($validated === true) {
                // Remove unchanged postArray keys but keep the 'id'
                foreach ($postArray as $key => $value) {
                    if (isset($postArray[$key]) && $setting[$key] == $value && $key !== 'settingID') {
                        unset($postArray[$key]);
                    }
                }

                if (count($postArray) > 1) {
                    try {
                        // Update in Database
                        $this->settingsModel->updateSetting($postArray);
                        // Update Settings Session (only for logged in User)
                        if ($postArray['settingID'] === $_SESSION['settings']['settingID']) {
                            $this->updateSessions($postArray);
                        }
                        setFlashMsg('success', 'Update completed successfully');
                        redirect(ADMURL . '/settings');
                    } catch (Exception $e) {
                        setFlashMsg('error', $e->getMessage());
                        redirect(ADMURL . '/settings');
                    }
                } else {
                    setFlashMsg('warning', 'No fields were changed');
                    redirect(ADMURL . '/settings');
                }
            } else {
                setFlashMsg('error', $error);
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
    public function db_backup(): void
    //------------------------------------------------------------
    {
        header("Content-Type: application/json");
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: DENY");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: same-origin");
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

        // Validate CSRF token
        $csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if ($csrfToken !== $_SESSION['csrf_token']) {
            http_response_code(419);
            echo json_encode(['message' => 'Invalid CSRF token']);
            exit();
        }

        try {
            // Insert in Database
            $this->settingsModel->backupDatabase(BACKUPS_PATH);
            setFlashMsg('success', 'Backup completed successfully.');
            echo json_encode(["status" => "success"]);
            exit();
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
            exit();
        }
    }

    //------------------------------------------------------------
    public function db_list_backups(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Database Backups';
        // $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";

        try {
            $directory = BACKUPS_PATH . "/";
            $data['rows'] = FileHandler::get_files_in_directory($directory);
        } catch (Exception $e) {
            setFlashMsg('error', $e->getMessage());
        }

        $this->renderSimpleView('/admin/settings/db_list_backups_modal', $data);
    }

    //------------------------------------------------------------
    public function db_backup_delete(): void
    //------------------------------------------------------------
    {
        // Get the customer ID from the URL query string
        $file = filter_input(INPUT_GET, 'file', FILTER_SANITIZE_URL);

        $directory = BACKUPS_PATH . "/";

        try {
            // Delete the existing files
            FileHandler::remove_files_from_directory($directory, $file);
            setFlashMsg('success', 'File: <strong>' . $file . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setFlashMsg('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/settings');
    }
}
