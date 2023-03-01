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
        $userId = $_SESSION['user']['id'];

        $data['title'] = 'Users';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['languages'] = $this->languagesModel->getLanguages();
        $data['rows'] = $this->settingsModel->getSettingsByUserId($userId);

        $this->renderSimpleView('/admin/settings/settings', $data);
    }

    //------------------------------------------------------------
    public function update(int $id): void
    //------------------------------------------------------------
    {
        if (isset($_POST['update_setting'])) {
            $postArray = [
                'settingID' => $id,
                'languageID' => htmlspecialchars(trim($_POST['languageID'])),
                'settingTheme' => htmlspecialchars(trim($_POST['settingTheme'])),
            ];

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
                try {
                    // Update in Database
                    $this->settingsModel->updateSetting($postArray);
                    // Update Settings Session
                    $this->updateSessions($postArray);
                    setFlashMsg('success', 'Update completed successfully.');
                    redirect(ADMURL);
                } catch (Exception $e) {
                    setFlashMsg('error', $e->getMessage());
                    redirect(ADMURL);
                }
            } else {
                setFlashMsg('error', $error);
                redirect(ADMURL);
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
}
