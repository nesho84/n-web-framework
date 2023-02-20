<?php

// Load Model
Router::loadModel(MODELS_PATH . '/admin/TranslationsModel.php');

//------------------------------------------------------------
function index(): void
//------------------------------------------------------------
{
    // Require Login
    $this->requireLogin();

    $data['title'] = 'Translations';
    $data['rows'] = getTranslations();

    Router::renderAdminView(VIEWS_PATH . '/admin/translations/translations.php', $data);
}

//------------------------------------------------------------
function create(): void
//------------------------------------------------------------
{
    // Require Login
    $this->requireLogin();

    $data['title'] = 'Translations Create';

    Router::renderAdminView(VIEWS_PATH . '/admin/translations/create.php', $data);
}

//------------------------------------------------------------
function insert(): void
//------------------------------------------------------------
{
    // Require Login
    $this->requireLogin();

    if (isset($_POST['insert_translation'])) {
        $postArray = [
            'userID' => $_SESSION['user']['id'],
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
    $this->requireLogin();

    $data['rows'] = getTranslationyById($id);
    $data['title'] = 'Translation Edit - ' . $id;

    Router::renderAdminView(VIEWS_PATH . '/admin/translations/edit.php', $data);
}

//------------------------------------------------------------
function update(int $id): void
//------------------------------------------------------------
{
    // Require Login
    $this->requireLogin();

    if (isset($_POST['update_translation'])) {
        $postArray = [
            'translationID' => $id,
            'userID' => $_SESSION['user']['id'],
            'translationCode' => htmlspecialchars(trim($_POST['translationCode'])),
            'languageCode' => htmlspecialchars(trim($_POST['languageCode'])),
            'translationText' => htmlspecialchars(trim($_POST['translationText'])),
        ];

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
            $error .= 'Please insert a translationText!<br>';
        }

        if ($validated === true) {
            // Update in Database
            $result = updateTranslation($postArray);
            if ($result === true) {
                setFlashMsg('success', 'Update completed successfully.');
                redirect(ADMURL . '/translations');
            } else {
                setFlashMsg('error', $result);
                redirect(ADMURL . '/translations/edit/' . $id);
            }
        } else {
            setFlashMsg('error', $error);
            redirect(ADMURL . '/translations/edit/' . $id);
        }
    }
}

//------------------------------------------------------------
function delete(int $id): void
//------------------------------------------------------------
{
    // Require Login
    $this->requireLogin();

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
