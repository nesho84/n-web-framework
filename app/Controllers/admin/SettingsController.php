<?php

class SettingsController extends Controller
{
    private SettingsModel $settingsModel;
    private LanguagesModel $languagesModel;
    private UsersModel $usersModel;

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
        // Load UsersModel
        $this->usersModel = $this->loadModel("/admin/UsersModel");
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
        $userId = $_SESSION['user']['id'];

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
                'languageID' => htmlspecialchars(trim($_POST['languageID'])),
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
}
