<?php

// Load Model
App::loadModel(MODELS_PATH . '/admin/translations_model.php');

//------------------------------------------------------------
function index(): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    $data['rows'] = getTranslations();
    $data['title'] = 'Translations';

    App::renderAdminView(VIEWS_PATH . '/admin/translations/translations.php', $data);
}

//------------------------------------------------------------
function create(): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    $data['title'] = 'Translations Create';

    App::renderAdminView(VIEWS_PATH . '/admin/translations/create.php', $data);
}

//------------------------------------------------------------
function insert(): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    if (isset($_POST['insert_translation'])) {
        $postArray = [
            'translationCode' => htmlspecialchars(trim($_POST['translationCode'])),
            'languageCode' => htmlspecialchars(trim($_POST['languageCode'])),
            'translationText' => htmlspecialchars(trim($_POST['translationText'])),
        ];

        $_SESSION['inputs'] = [];
        $validated = true;
        $error = '';

        if (empty($postArray['translationCode'])) {
            $validated = false;
            $error .= 'Translation Code can not be empty!<br>';
        }
        if (empty($postArray['languageCode'])) {
            $validated = false;
            $error .= 'Please insert a Language Code!<br>';
        }
        if (empty($postArray['translationText'])) {
            $validated = false;
            $error .= 'Please insert a Translation Text!<br>';
        }

        if ($validated === true) {
            // Insert in Database
            $result = insertTranslation($postArray);
            if ($result === true) {
                setFlashMsg('success', 'Insert completed successfully.');
                unset($_SESSION['inputs']);
                redirect(ADMURL . '/translations');
            } else {
                setFlashMsg('error', $result);
                $_SESSION['inputs'] = $postArray;
                redirect(ADMURL . '/translations/create');
            }
        } else {
            setFlashMsg('error', $error);
            $_SESSION['inputs'] = $postArray;
            redirect(ADMURL . '/translations/create');
        }
    }
}

//------------------------------------------------------------
function edit(int $id): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    $data['rows'] = getTranslationyById($id);
    $data['title'] = 'Translation Edit - ' . $id;

    App::renderAdminView(VIEWS_PATH . '/admin/translations/edit.php', $data);
}

//------------------------------------------------------------
function update(int $id): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    if (isset($_POST['update_translation'])) {
        // $postArray = [
        //     'categoryID' => $id,
        //     'userID' => $_SESSION['user']['id'],
        //     'categoryType' => htmlspecialchars(trim($_POST['categoryType'])),
        //     'categoryLink' => htmlspecialchars(trim($_POST['categoryLink'])),
        //     'categoryName' => htmlspecialchars(trim($_POST['categoryName'])),
        //     'categoryDescription' => htmlspecialchars(trim($_POST['categoryDescription'])),
        // ];

        // $validated = true;
        // $error = '';

        // if (empty($postArray['categoryType'])) {
        //     $validated = false;
        //     $error .= 'Category Type can not be empty!<br>';
        // }
        // if (empty($postArray['categoryLink'])) {
        //     $validated = false;
        //     $error .= 'Please insert a Category Link!<br>';
        // }
        // if (empty($postArray['categoryName'])) {
        //     $validated = false;
        //     $error .= 'Please insert a Category Name!<br>';
        // }
        // // if (empty($postArray['categoryDescription'])) {
        // //     $validated = false;
        // //     $error .= 'Please insert a Category Description!<br>';
        // // }

        // if ($validated === true) {
        //     // Update in Database
        //     $result = updateCategory($postArray);
        //     if ($result === true) {
        //         setFlashMsg('success', 'Update completed successfully.');
        //         redirect(ADMURL . '/categories');
        //     } else {
        //         setFlashMsg('error', $result);
        //         redirect(ADMURL . '/categories/edit/' . $id);
        //     }
        // } else {
        //     setFlashMsg('error', $error);
        //     redirect(ADMURL . '/categories/edit/' . $id);
        // }
    }
}

//------------------------------------------------------------
function delete(int $id): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    // Delete in Database
    $result = deleteTranslation($id);
    if ($result === true) {
        setFlashMsg('success', 'Translation with the ID: <strong>' . $id . '</strong> deleted successfully.');
    } else {
        setFlashMsg('error', $result);
    }

    // Allways redirect back
    redirect(ADMURL . '/translations');
}
