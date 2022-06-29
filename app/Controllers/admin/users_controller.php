<?php

// Load Model
App::loadModel(MODELS_PATH . "/admin/users_model.php");

//------------------------------------------------------------
function index(): void
//------------------------------------------------------------
{
    // Require Login
    checkUserLoggedIn();

    $data['rows'] = getUsers();
    $data['title'] = 'Users';

    App::renderAdminView(VIEWS_PATH . '/admin/users/users.php', $data);
}

//------------------------------------------------------------
function create(): void
//------------------------------------------------------------
{
    // Require Login
    checkUserLoggedIn();

    $data['title'] = 'Users Create';

    App::renderAdminView(VIEWS_PATH . '/admin/users/create.php', $data);
}

//------------------------------------------------------------
function insert(): void
//------------------------------------------------------------
{
    // Require Login
    checkUserLoggedIn();

    if (isset($_POST['insert_user'])) {
        $postArray = [
            'userName' => htmlspecialchars(trim($_POST['userName'])),
            'userEmail' => htmlspecialchars(trim($_POST['userEmail'])),
            'userPassword' => htmlspecialchars(trim($_POST['userPassword'])),
            'userRole' => htmlspecialchars(trim(isset($_POST['userRole']))) ? 'admin' : 'default',
        ];

        // Get all users from the Model
        $users = getUsers();

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

        if ($validated === true) {
            // Insert in Database
            $result = insertUser($postArray);
            if ($result === true) {
                setFlashMsg('success', 'Insert completed successfully.');
                unset($_SESSION['inputs']);
                redirect(ADMURL . '/users');
            } else {
                setFlashMsg('error', $result);
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
function edit(int $id): void
//------------------------------------------------------------
{
    // Require Login
    checkUserLoggedIn();

    $data['rows'] = getUserById($id);
    $data['title'] = 'User Edit - ' . $id;

    App::renderAdminView(VIEWS_PATH . '/admin/users/edit.php', $data);
}

//------------------------------------------------------------
function update(int $id): void
//------------------------------------------------------------
{
    // Require Login
    checkUserLoggedIn();

    if (isset($_POST['update_user'])) {
        $postArray = [
            'userID' => $id,
            'userName' => htmlspecialchars(trim($_POST['userName'])),
            'userEmail' => htmlspecialchars(trim($_POST['userEmail'])),
            'userPassword' => htmlspecialchars(trim($_POST['userPassword'])),
            'userRole' => htmlspecialchars(trim(isset($_POST['userRole']))) ? 'admin' : 'default',
        ];

        // Get all users from the Model except this
        $users = getUsersExceptThis($id);
        // Get existing user from the Model
        $user = getUserById($id);

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

        if ($validated === true) {
            // Update in Database
            $result = updateUser($postArray);
            if ($result === true) {
                setFlashMsg('success', 'Update completed successfully.');
                redirect(ADMURL . '/users');
            } else {
                setFlashMsg('error', $result);
                redirect(ADMURL . '/users/edit/' . $id);
            }
        } else {
            setFlashMsg('error', $error);
            redirect(ADMURL . '/users/edit/' . $id);
        }
    }
}

//------------------------------------------------------------
function delete(int $id): void
//------------------------------------------------------------
{
    // Require Login
    checkUserLoggedIn();

    // Delete in Database
    $result = deleteUser($id);
    if ($result === true) {
        setFlashMsg('success', 'User with the ID: <strong>' . $id . '</strong> deleted successfully.');
    } else {
        setFlashMsg('error', $result);
    }

    // Allways redirect back
    redirect(ADMURL . '/users');
}
