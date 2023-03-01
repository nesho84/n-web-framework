<?php

class UsersController extends Controller
{
    private UsersModel $usersModel;
    private SettingsModel $settingsModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        Sessions::requireLogin();

        // Load Model
        $this->usersModel = $this->loadModel("/admin/UsersModel");

        // Load SettingsModel
        $this->settingsModel = $this->loadModel("/admin/SettingsModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Users';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['rows'] = $this->usersModel->getUsers();

        $this->renderAdminView('/admin/users/users', $data);
    }

    //------------------------------------------------------------
    public function profile(int $id): void
    //------------------------------------------------------------
    {
        $data['title'] = 'User Profile - ' . $id;
        $data['rows'] = $this->usersModel->getUserById($id);

        $this->renderSimpleView('/admin/users/profile', $data);
    }

    //------------------------------------------------------------
    public function create(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Users Create';

        $this->renderAdminView('/admin/users/create', $data);
    }

    //------------------------------------------------------------
    public function insert(): void
    //------------------------------------------------------------
    {
        if (isset($_POST['insert_user'])) {
            $postArray = [
                'userName' => htmlspecialchars(trim($_POST['userName'])),
                'userEmail' => htmlspecialchars(trim($_POST['userEmail'])),
                'userPassword' => htmlspecialchars(trim($_POST['userPassword'])),
                'userPicture' => $_FILES['userPicture'] ?? null,
                'userRole' => htmlspecialchars(trim(isset($_POST['userRole']))) ? 'admin' : 'default',
            ];

            // Get all users from the Model
            $users = $this->usersModel->getUsers();

            $_SESSION['inputs'] = [];
            $validated = true;
            $error = '';

            if (empty($postArray['userName'])) {
                $validated = false;
                $error .= 'Username can not be empty!<br>';
            } else {
                // Username exist Validation
                foreach ($users as $u) {
                    if ($u['userName'] == $postArray['userName']) {
                        $validated = false;
                        $error .= "Username already exists!<br>";
                    }
                }
            }
            if (filter_var($postArray['userEmail'], FILTER_VALIDATE_EMAIL) === false) {
                $validated = false;
                $error .= "The email you entered was not valid!<br>";
            } else {
                // Email exist Validation
                foreach ($users as $u) {
                    if ($u['userEmail'] == $postArray['userEmail']) {
                        $validated = false;
                        $error .= "Email already exists!<br>";
                    }
                }
            }
            if (empty($postArray['userPassword'])) {
                $validated = false;
                $error .= 'Password can not be empty!<br>';
            } else {
                if (strlen($postArray['userPassword']) < 6) {
                    $validated = false;
                    $error .= "The password must have at least 6 characters!<br>";
                } elseif ($postArray['userPassword'] !== $_POST['userPassword2']) {
                    $validated = false;
                    $error .= "Passwords do not match!<br>";
                } else {
                    // Hash the password
                    $options = ['cost' => 10];
                    $postArray['userPassword'] = password_hash($postArray['userPassword'], PASSWORD_BCRYPT, $options);
                }
            }

            // base64 Image Logic and Validation
            if (empty($postArray['userPicture']['name'])) {
                // If it is empty then replace with null
                $postArray['userPicture'] = null;
            } else {
                $file = $postArray['userPicture']['tmp_name'];
                // Get the width and height of the image
                [$width, $height] = getimagesize($file);
                if ($width > 150 || $height > 150) {
                    $validated = false;
                    $error .= "Only images with max. 150x150 pixels are allowed.";
                }
                // Make sure `file.name` matches our extensions criteria
                $allowed_extensions = array("jpg", "jpeg", "png", "gif");
                $extension = pathinfo($postArray['userPicture']['name'], PATHINFO_EXTENSION);
                if (!in_array($extension, $allowed_extensions)) {
                    $validated = false;
                    $error .= "Only jpeg, png, and gif images are allowed.";
                }
                // Set Image only if validation passed
                if ($validated) {
                    $image = file_get_contents($file);
                    $image = base64_encode($image);
                    $postArray['userPicture'] = 'data:image/png;base64,' . $image;
                }
            }

            if ($validated === true) {
                try {
                    // Insert in Database
                    $lastInsertId = $this->usersModel->insertUser($postArray);

                    // Insert default User Settings
                    $this->settingsModel->insertSettings([
                        'userID' => $lastInsertId,
                        'languageID' => 2,
                        'settingTheme' => 'light'
                    ]);

                    setFlashMsg('success', 'Insert completed successfully.');
                    unset($_SESSION['inputs']);
                    redirect(ADMURL . '/users');
                } catch (Exception $e) {
                    setFlashMsg('error', $e->getMessage());
                    $_SESSION['inputs'] = $postArray;
                    redirect(ADMURL . '/users/create');
                }
            } else {
                setFlashMsg('error', $error);
                $_SESSION['inputs'] = $postArray;
                redirect(ADMURL . '/users/create');
            }
        }
    }

    //------------------------------------------------------------
    public function edit(int $id): void
    //------------------------------------------------------------
    {
        $data['title'] = 'User Edit - ' . $id;
        $data['rows'] = $this->usersModel->getUserById($id);

        $this->renderAdminView('/admin/users/edit', $data);
    }

    //------------------------------------------------------------
    public function update(int $id): void
    //------------------------------------------------------------
    {
        if (isset($_POST['update_user'])) {
            $postArray = [
                'userID' => $id,
                'userName' => htmlspecialchars(trim($_POST['userName'])),
                'userEmail' => htmlspecialchars(trim($_POST['userEmail'])),
                'userPassword' => '',
                'userPicture' => $_FILES['userPicture'] ?? null,
                'userRole' => htmlspecialchars(trim(isset($_POST['userRole']))) ? 'admin' : 'default',
                'userStatus' => htmlspecialchars(trim(isset($_POST['userStatus']))) ? 1 : 0,
            ];

            // Get all users from the Model except this
            $users = $this->usersModel->getUsersExceptThis($id);
            // Get existing user from the Model
            $user = $this->usersModel->getUserById($id);

            $validated = true;
            $error = '';

            if (empty($postArray['userName'])) {
                $validated = false;
                $error .= 'Username can not be empty!<br>';
            }
            // Username 'admin' Validations
            if ($user['userName'] == 'admin') {
                // 'admin' Username can not be changed Validation
                if ($postArray['userName'] != $user['userName']) {
                    $validated = false;
                    $error .= 'Admin Username can not be changed!<br>';
                }
                // 'admin' Role can not be changed Validation
                if ($postArray['userRole'] == 'default' && isset($_POST['userRoleHidden'])) {
                    $postArray['userRole'] = htmlspecialchars($_POST['userRoleHidden']);
                    if ($postArray['userRole'] != $user['userRole']) {
                        $validated = false;
                        $error .= 'Admin Role can not be changed!<br>';
                    }
                }
                // 'admin' Status can not be changed Validation
                if ($postArray['userStatus'] == 0 && isset($_POST['userStatusHidden'])) {
                    $postArray['userStatus'] = (int) $_POST['userStatusHidden'];
                    if ($postArray['userStatus'] != $user['userStatus']) {
                        $validated = false;
                        $error .= 'Admin Status can not be changed!<br>';
                    }
                }
            }
            // Username exist Validation
            foreach ($users as $u) {
                if ($u['userName'] == $postArray['userName']) {
                    $validated = false;
                    $error .= "Username already exists!<br>";
                }
            }
            if (filter_var($postArray['userEmail'], FILTER_VALIDATE_EMAIL) === false) {
                $validated = false;
                $error .= "The email you entered was not valid!<br>";
            } else {
                // Email exist Validation
                foreach ($users as $u) {
                    if ($u['userEmail'] == $postArray['userEmail']) {
                        $validated = false;
                        $error .= "Email already exists!<br>";
                    }
                }
            }

            // Password change Validation - If the new password is set
            if ($_POST['userOldPassword'] !== "" || $_POST['userNewPassword'] !== "" || $_POST['userNewPassword2'] !== "") {
                if (!password_verify($_POST['userOldPassword'], $user["userPassword"])) {
                    $validated = false;
                    $error .= "The old Password is wrong!<br>";
                } else {
                    if (empty($_POST['userNewPassword'])) {
                        $validated = false;
                        $error .= 'New Password can not be empty!<br>';
                    } else {
                        if (strlen($_POST['userNewPassword']) < 6) {
                            $validated = false;
                            $error .= "The new password must have at least 6 characters!<br>";
                        } elseif ($_POST['userNewPassword'] !== $_POST['userNewPassword2']) {
                            $validated = false;
                            $error .= "New Passwords do not match!<br>";
                        } else {
                            // Hash the password
                            $options = ['cost' => 10];
                            $postArray['userPassword'] = password_hash($_POST['userNewPassword'], PASSWORD_BCRYPT, $options);
                        }
                    }
                }
            } else {
                // else replace the existing
                $postArray['userPassword'] = $user['userPassword'];
            }

            // base64 Image Logic and Validation
            if (empty($postArray['userPicture']['name'])) {
                // If it was not changed then replace with existing
                $postArray['userPicture'] = $user['userPicture'];
            } else {
                $file = $postArray['userPicture']['tmp_name'];
                // Get the width and height of the image
                [$width, $height] = getimagesize($file);
                if ($width > 150 || $height > 150) {
                    $validated = false;
                    $error .= "Only images with max. 150x150 pixels are allowed.";
                }
                // Make sure `file.name` matches our extensions criteria
                $allowed_extensions = array("jpg", "jpeg", "png", "gif");
                $extension = pathinfo($postArray['userPicture']['name'], PATHINFO_EXTENSION);
                if (!in_array($extension, $allowed_extensions)) {
                    $validated = false;
                    $error .= "Only jpeg, png, and gif images are allowed.";
                }
                // Set Image only if validation passed
                if ($validated) {
                    $image = file_get_contents($file);
                    $image = base64_encode($image);
                    $postArray['userPicture'] = 'data:image/png;base64,' . $image;
                    // Set it also in the session(to refresh userPicture in the top menu)
                    if ($user['userID'] === $_SESSION['user']['id']) {
                        $_SESSION['user']['pic'] = $postArray['userPicture'];
                    }
                }
            }

            if ($validated === true) {
                try {
                    // Update in Database
                    $this->usersModel->updateUser($postArray);
                    setFlashMsg('success', 'Update completed successfully.');
                    redirect(ADMURL . '/users');
                } catch (Exception $e) {
                    setFlashMsg('error', $e->getMessage());
                    redirect(ADMURL . '/users/edit/' . $id);
                }
            } else {
                setFlashMsg('error', $error);
                redirect(ADMURL . '/users/edit/' . $id);
            }
        }
    }

    //------------------------------------------------------------
    public function delete(int $id): void
    //------------------------------------------------------------
    {
        // Get existing user from the Model
        $user = $this->usersModel->getUserById($id);

        $validated = true;
        $error = '';

        // 'admin' can not be deleted Validation
        if ($user['userName'] == 'admin') {
            $validated = false;
            $error .= 'Admin can not be deleted!<br>';
        }

        if ($validated === true) {
            try {
                // Delete User in Database
                $this->usersModel->deleteUser($id);
                // Delete User Settings in Database
                $this->settingsModel->deleteSettings($id);
                setFlashMsg('success', 'User with the ID: <strong>' . $id . '</strong> and settings deleted successfully.');
            } catch (Exception $e) {
                setFlashMsg('error', $e->getMessage());
            }
        } else {
            setFlashMsg('error', $error);
            redirect(ADMURL . '/users');
        }

        // Allways redirect back
        redirect(ADMURL . '/users');
    }
}
