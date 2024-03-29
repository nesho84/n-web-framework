<?php

namespace App\Controllers;

use Exception;
use App\Core\Controller;
use App\Models\UsersModel;
use App\Models\SettingsModel;
use App\Core\Sessions;
use App\Common\DataValidator;
use App\Auth\UserPermissions;

class UsersController extends Controller
{
    private UsersModel $usersModel;
    private SettingsModel $settingsModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        $this->usersModel = new UsersModel();
        $this->settingsModel = new SettingsModel();
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Users';
        $data['rows'] = $this->usersModel->getUsers();
        $data['permissions'] = [
            'canEdit' => function ($userID, $userRole) {
                return UserPermissions::canEdit($userID, $userRole);
            },
            'canDelete' => function ($userID, $userRole) {
                return UserPermissions::canDelete($userID, $userRole);
            },
        ];

        $this->renderAdminView('/admin/users/users', $data);
    }

    //------------------------------------------------------------
    public function profile(string $id): void
    //------------------------------------------------------------
    {
        $data['title'] = 'User Profile - ' . $id;
        $data['rows'] = $this->usersModel->getUserById($id);

        if ($data['rows'] && count($data['rows']) > 0) {
            // Authorization
            $userId = $data['rows']['userID'];
            $userRole = $data['rows']['userRole'];
            if (!UserPermissions::canEdit($userId, $userRole)) {
                echo 'You are not authorized to view this User!';
                exit;
            }

            $this->renderSimpleView('/admin/users/profile', $data);
        } else {
            http_response_code(404);
            $this->renderAdminView('/errors/404a.php', $data);
        }
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
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF();

        $postArray = [
            'userName' => htmlspecialchars(trim($_POST['userName'])),
            'userEmail' => htmlspecialchars(trim($_POST['userEmail'])),
            'userPassword' => htmlspecialchars(trim($_POST['userPassword'])),
            'userPicture' => $_FILES['userPicture'] ?? null,
            'userRole' => htmlspecialchars(trim(isset($_POST['userRole']))) ? 'admin' : 'default',
        ];

        // Get all users from the Model
        $users = $this->usersModel->getUsers();

        // Validate inputs
        $validator = new DataValidator();
        $validator('Username', $postArray['userName'])->required()->min(3)->max(20);
        // Username exist Validation
        foreach ($users as $u) {
            if ($u['userName'] == $postArray['userName']) {
                $validator->addError('Username', 'Username already exists!');
            }
        }

        // E-mail validation
        $validator('Email', $postArray['userEmail'])->required();
        if (!empty($postArray['userEmail'])) {
            if (filter_var($postArray['userEmail'], FILTER_VALIDATE_EMAIL) === false) {
                $validator->addError('userEmail', 'The email you entered was not valid!');
            }
            // Email exist Validation
            foreach ($users as $u) {
                if ($u['userEmail'] == $postArray['userEmail']) {
                    $validator->addError('userEmail', 'Email already exists!');
                }
            }
        }

        $validator('Password', $postArray['userPassword'])->required()->min(6)->max(20);
        if ($postArray['userPassword'] !== $_POST['userPassword2']) {
            $validator->addError('userPassword', 'Passwords do not match!');
        } else {
            // Hash the password
            $options = ['cost' => 10];
            $postArray['userPassword'] = password_hash($postArray['userPassword'], PASSWORD_BCRYPT, $options);
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
                $validator->addError('userPicture', 'Only images with max. 150x150 pixels are allowed.');
            }
            // Make sure `file.name` matches our extensions criteria
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");
            $extension = pathinfo($postArray['userPicture']['name'], PATHINFO_EXTENSION);
            if (!in_array($extension, $allowed_extensions)) {
                $validator->addError('userPicture', 'Only jpeg, png, and gif images are allowed.');
            }
            // Set Image only if validation passed
            if ($validator->isValidated()) {
                $image = file_get_contents($file);
                $image = base64_encode($image);
                $postArray['userPicture'] = 'data:image/png;base64,' . $image;
            }
        }

        if ($validator->isValidated()) {
            try {
                // Insert in Database
                $lastInsertId = $this->usersModel->insertUser($postArray);

                // Insert default User Settings
                // @TODO: change the hardcoded languageID value
                $this->settingsModel->insertSetting([
                    'userID' => $lastInsertId,
                    'languageID' => 2,
                    'settingTheme' => 'light'
                ]);
                // setSessionAlert('success', 'User created successfully.');
                echo json_encode([
                    "status" => "success",
                    'message' => 'User created successfully',
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
        $data['title'] = 'User Edit - ' . $id;
        $data['rows'] = $this->usersModel->getUserById($id);

        if ($data['rows'] && count($data['rows']) > 0) {
            // Authorization
            if (!UserPermissions::canEdit($id, $data['rows']['userRole'])) {
                setSessionAlert('warning', 'You are not authorized to edit this User!');
                redirect(ADMURL . '/users');
            }

            $this->renderAdminView('/admin/users/edit', $data);
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

        // Authorization
        $userId = $user['userID'];
        if (!UserPermissions::canEdit($userId, $user['userRole'])) {
            echo json_encode([
                "status" => "warning",
                "message" => 'You are not authorized to update this User!'
            ]);
            exit;
        }

        // Validate inputs
        $validator = new DataValidator();
        $validator('Username', $postArray['userName'])->required()->min(3)->max(20);
        // Username exist Validation
        foreach ($users as $u) {
            if ($u['userName'] == $postArray['userName']) {
                $validator->addError('Username', 'Username already exists!');
            }
        }

        if (filter_var($postArray['userEmail'], FILTER_VALIDATE_EMAIL) === false) {
            $validator->addError('userEmail', 'The email you entered was not valid!');
        } else {
            // Email exist Validation
            foreach ($users as $u) {
                if ($u['userEmail'] == $postArray['userEmail']) {
                    $validator->addError('userEmail', 'Email already exists!');
                }
            }
        }

        // Username 'admin' Validations
        if ($user['userName'] == 'admin') {
            // 'admin' Username can not be changed Validation
            if ($postArray['userName'] != $user['userName']) {
                $validator->addError('userName', 'Admin Username can not be changed!');
            }
            // 'admin' Role can not be changed Validation
            if ($postArray['userRole'] == 'default' && isset($_POST['userRoleHidden'])) {
                $postArray['userRole'] = htmlspecialchars($_POST['userRoleHidden']);
                if ($postArray['userRole'] != $user['userRole']) {
                    $validator->addError('userRole', 'Admin Role can not be changed!');
                }
            }
            // 'admin' Status can not be changed Validation
            if ($postArray['userStatus'] == 0 && isset($_POST['userStatusHidden'])) {
                $postArray['userStatus'] = (int) $_POST['userStatusHidden'];
                if ($postArray['userStatus'] != $user['userStatus']) {
                    $validator->addError('userStatus', 'Admin Status can not be changed!');
                }
            }
        }

        // Password change Validation - If the new password is set
        if ($_POST['userOldPassword'] !== "" || $_POST['userNewPassword'] !== "" || $_POST['userNewPassword2'] !== "") {
            if (!password_verify($_POST['userOldPassword'], $user["userPassword"])) {
                $validator->addError('userOldPassword', 'The old Password is wrong!');
            } else {
                $validator('New Password', $_POST['userNewPassword'])->required()->min(6)->max(20);
                if ($_POST['userNewPassword'] !== $_POST['userNewPassword2']) {
                    $validator->addError('userOldPassword', 'New Passwords do not match!');
                } else {
                    // Hash the password
                    $options = ['cost' => 10];
                    $postArray['userPassword'] = password_hash($_POST['userNewPassword'], PASSWORD_BCRYPT, $options);
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
                $validator->addError('userPicture', 'Only images with max. 150x150 pixels are allowed.');
            }
            // Make sure `file.name` matches our extensions criteria
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");
            $extension = pathinfo($postArray['userPicture']['name'], PATHINFO_EXTENSION);
            if (!in_array($extension, $allowed_extensions)) {
                $validator->addError('userPicture', 'Only jpeg, png, and gif images are allowed.');
            }
            // Set Image only if validation passed
            if ($validator->isValidated()) {
                $image = file_get_contents($file);
                $image = base64_encode($image);
                $postArray['userPicture'] = 'data:image/png;base64,' . $image;
                // Set it also in the session(to refresh userPicture in the top menu)
                if ($user['userID'] === $_SESSION['user']['id']) {
                    $_SESSION['user']['pic'] = $postArray['userPicture'];
                }
            }
        }

        if ($validator->isValidated()) {
            // Remove unchanged postArray keys but keep the 'id'
            foreach ($postArray as $key => $value) {
                if (isset($postArray[$key]) && $user[$key] == $value && $key !== 'userID') {
                    unset($postArray[$key]);
                }
            }
            // remove empty keys
            // $postArray = array_filter($postArray, 'strlen'); => Deprecated
            $postArray = array_filter($postArray ?? [], 'filterNotEmptyOrNull');

            if (count($postArray) > 1) {
                try {
                    // Update in Database
                    $this->usersModel->updateUser($postArray);
                    // setSessionAlert('success', 'User Updated successfully');
                    echo json_encode([
                        "status" => "success",
                        'message' => 'User updated successfully',
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
        // Get existing user from the Model
        $user = $this->usersModel->getUserById($id);
        // Get existing setting from the SettingsModel
        $setting = $this->settingsModel->getSettingsByUserId($id);

        // Authorization
        if (!UserPermissions::canDelete($user['userID'], $user['userRole'])) {
            setSessionAlert('warning', 'You are not authorized to delete this User!');
            redirect(ADMURL . '/users');
        }

        // Validate inputs
        $validator = new DataValidator();

        // 'super_admin' can not be deleted Validation
        if ($user['userName'] == 'admin') {
            $validator->addError('userName', 'super_admin can not be deleted!<br>');
        }

        if ($validator->isValidated()) {
            try {
                // Delete User in Database
                $this->usersModel->deleteUser($id);
                // Delete User Settings in Database
                $this->settingsModel->deleteSetting($setting['settingID']);
                setSessionAlert('success', 'User with the ID: <strong>' . $id . '</strong> and settings deleted successfully.');
            } catch (Exception $e) {
                setSessionAlert('error', $e->getMessage());
            }
        } else {
            setSessionAlert('error', $validator->getErrors());
            redirect(ADMURL . '/users');
        }

        // Allways redirect back
        redirect(ADMURL . '/users');
    }
}
