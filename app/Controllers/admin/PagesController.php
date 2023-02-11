<?php

// Load Model
Router::loadModel(MODELS_PATH . '/admin/PagesModel.php');

//------------------------------------------------------------
function index(): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    $data['rows'] = getPages();
    $data['title'] = 'Pages';

    Router::renderAdminView(VIEWS_PATH . '/admin/pages/pages.php', $data);
}

//------------------------------------------------------------
function create(): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    $data['title'] = 'Pages Create';

    Router::renderAdminView(VIEWS_PATH . '/admin/pages/create.php', $data);
}

//------------------------------------------------------------
function insert(): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    if (isset($_POST['insert_page'])) {
        $postArray = [
            'userID' => $_SESSION['user']['id'],
            'pageName' => htmlspecialchars(trim($_POST['pageName'])),
            'pageTitle' => htmlspecialchars(trim($_POST['pageTitle'])),
            'pageContent' => $_POST['pageContent'],
            'pageLanguage' => htmlspecialchars(trim($_POST['pageLanguage'])),
            'PageMetaTitle' => htmlspecialchars(trim($_POST['PageMetaTitle'])),
            'PageMetaDescription' => htmlspecialchars(trim($_POST['PageMetaDescription'])),
            'PageMetaKeywords' => htmlspecialchars(trim($_POST['PageMetaKeywords'])),
        ];

        $_SESSION['inputs'] = [];
        $validated = true;
        $error = '';

        if (empty($postArray['pageName'])) {
            $validated = false;
            $error .= 'Page Name can not be empty!<br>';
        }
        if (empty($postArray['pageTitle'])) {
            $validated = false;
            $error .= 'Please insert a Page Title!<br>';
        }
        if (empty($postArray['pageLanguage'])) {
            $validated = false;
            $error .= 'Please choose a Language!<br>';
        }
        // if (empty($postArray['pageContent'])) {
        //     $validated = false;
        //     $error .= 'Please insert a Page Content!<br>';
        // }

        if ($validated === true) {
            // Insert in Database
            $result = insertPage($postArray);
            if ($result === true) {
                setFlashMsg('success', 'Insert completed successfully.');
                unset($_SESSION['inputs']);
                redirect(ADMURL . '/pages');
            } else {
                setFlashMsg('error', $result);
                $_SESSION['inputs'] = $postArray;
                redirect(ADMURL . '/pages/create');
            }
        } else {
            setFlashMsg('error', $error);
            $_SESSION['inputs'] = $postArray;
            redirect(ADMURL . '/pages/create');
        }
    }
}

//------------------------------------------------------------
function edit(int $id): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    $data['rows'] = getPageById($id);
    $data['title'] = 'Pages Edit - ' . $id;

    Router::renderAdminView(VIEWS_PATH . '/admin/pages/edit.php', $data);
}

//------------------------------------------------------------
function update(int $id): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    if (isset($_POST['update_page'])) {
        $postArray = [
            'pageID' => $id,
            'userID' => $_SESSION['user']['id'],
            'pageName' => htmlspecialchars(trim($_POST['pageName'])),
            'pageTitle' => htmlspecialchars(trim($_POST['pageTitle'])),
            'pageLanguage' => htmlspecialchars(trim($_POST['pageLanguage'])),
            'PageMetaTitle' => htmlspecialchars(trim($_POST['PageMetaTitle'])),
            'PageMetaDescription' => htmlspecialchars(trim($_POST['PageMetaDescription'])),
            'PageMetaKeywords' => htmlspecialchars(trim($_POST['PageMetaKeywords'])),
            'pageStatus' => isset($_POST['pageStatus']) ? 1 : 0,
            'pageContent' => $_POST['pageContent'],
        ];

        $validated = true;
        $error = '';

        if (empty($postArray['pageName'])) {
            $validated = false;
            $error .= 'Page Name can not be empty!<br>';
        }
        if (empty($postArray['pageTitle'])) {
            $validated = false;
            $error .= 'Please insert a Page Title!<br>';
        }
        if (empty($postArray['pageLanguage'])) {
            $validated = false;
            $error .= 'Please choose a Language!<br>';
        }
        // if (empty($postArray['pageContent'])) {
        //     $validated = false;
        //     $error .= 'Please insert a Page Content!<br>';
        // }

        if ($validated === true) {
            // Update in Database
            $result = updatePage($postArray);
            if ($result === true) {
                setFlashMsg('success', 'Update completed successfully.');
                redirect(ADMURL . '/pages');
            } else {
                setFlashMsg('error', $result);
                redirect(ADMURL . '/pages/edit/' . $id);
            }
        } else {
            setFlashMsg('error', $error);
            redirect(ADMURL . '/pages/edit/' . $id);
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
    $result = deletePage($id);
    if ($result === true) {
        setFlashMsg('success', 'Page with the ID: <strong>' . $id . '</strong> deleted successfully.');
    } else {
        setFlashMsg('error', $result);
    }

    // Allways redirect back
    redirect(ADMURL . '/pages');
}
