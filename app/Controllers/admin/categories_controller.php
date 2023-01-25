<?php

// Load Model
App::loadModel(MODELS_PATH . '/admin/categories_model.php');

//------------------------------------------------------------
function index(): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    $data['rows'] = getCategories();
    $data['title'] = 'Categories';

    App::renderAdminView(VIEWS_PATH . '/admin/categories/categories.php', $data);
}

//------------------------------------------------------------
function create(): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    $data['title'] = 'Categories Create';

    App::renderAdminView(VIEWS_PATH . '/admin/categories/create.php', $data);
}

//------------------------------------------------------------
function insert(): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    if (isset($_POST['insert_category'])) {
        $postArray = [
            'userID' => $_SESSION['user']['id'],
            'categoryType' => htmlspecialchars(trim($_POST['categoryType'])),
            'categoryLink' => htmlspecialchars(trim($_POST['categoryLink'])),
            'categoryName' => htmlspecialchars(trim($_POST['categoryName'])),
            'categoryDescription' => htmlspecialchars(trim($_POST['categoryDescription'])),
        ];

        $_SESSION['inputs'] = [];
        $validated = true;
        $error = '';

        if (empty($postArray['categoryType'])) {
            $validated = false;
            $error .= 'Category Type can not be empty!<br>';
        }
        if (empty($postArray['categoryLink'])) {
            $validated = false;
            $error .= 'Please insert a Category Link!<br>';
        }
        if (empty($postArray['categoryName'])) {
            $validated = false;
            $error .= 'Please insert a Category Name!<br>';
        }
        // if (empty($postArray['categoryDescription'])) {
        //     $validated = false;
        //     $error .= 'Please insert a Category Description!<br>';
        // }

        if ($validated === true) {
            // Insert in Database
            $result = insertCategory($postArray);
            if ($result === true) {
                setFlashMsg('success', 'Insert completed successfully.');
                unset($_SESSION['inputs']);
                redirect(ADMURL . '/categories');
            } else {
                setFlashMsg('error', $result);
                $_SESSION['inputs'] = $postArray;
                redirect(ADMURL . '/categories/create');
            }
        } else {
            setFlashMsg('error', $error);
            $_SESSION['inputs'] = $postArray;
            redirect(ADMURL . '/categories/create');
        }
    }
}

//------------------------------------------------------------
function edit(int $id): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    $data['rows'] = getCategoryById($id);
    $data['title'] = 'Category Edit - ' . $id;

    App::renderAdminView(VIEWS_PATH . '/admin/categories/edit.php', $data);
}

//------------------------------------------------------------
function update(int $id): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    if (isset($_POST['update_category'])) {
        $postArray = [
            'categoryID' => $id,
            'userID' => $_SESSION['user']['id'],
            'categoryType' => htmlspecialchars(trim($_POST['categoryType'])),
            'categoryLink' => htmlspecialchars(trim($_POST['categoryLink'])),
            'categoryName' => htmlspecialchars(trim($_POST['categoryName'])),
            'categoryDescription' => htmlspecialchars(trim($_POST['categoryDescription'])),
        ];

        $validated = true;
        $error = '';

        if (empty($postArray['categoryType'])) {
            $validated = false;
            $error .= 'Category Type can not be empty!<br>';
        }
        if (empty($postArray['categoryLink'])) {
            $validated = false;
            $error .= 'Please insert a Category Link!<br>';
        }
        if (empty($postArray['categoryName'])) {
            $validated = false;
            $error .= 'Please insert a Category Name!<br>';
        }
        // if (empty($postArray['categoryDescription'])) {
        //     $validated = false;
        //     $error .= 'Please insert a Category Description!<br>';
        // }

        if ($validated === true) {
            // Update in Database
            $result = updateCategory($postArray);
            if ($result === true) {
                setFlashMsg('success', 'Update completed successfully.');
                redirect(ADMURL . '/categories');
            } else {
                setFlashMsg('error', $result);
                redirect(ADMURL . '/categories/edit/' . $id);
            }
        } else {
            setFlashMsg('error', $error);
            redirect(ADMURL . '/categories/edit/' . $id);
        }
    }
}

//------------------------------------------------------------
function delete(int $id): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    // Delete in Database
    $result = deleteCategory($id);
    if ($result === true) {
        setFlashMsg('success', 'Category with the ID: <strong>' . $id . '</strong> deleted successfully.');
    } else {
        setFlashMsg('error', $result);
    }

    // Allways redirect back
    redirect(ADMURL . '/categories');
}
