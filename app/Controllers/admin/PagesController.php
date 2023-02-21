<?php

class PagesController extends Controller
{
    private PagesModel $pagesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        $this->requireLogin();

        // Load Model
        $this->pagesModel = $this->loadModel("/admin/PagesModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Pages';
        $data['rows'] = $this->pagesModel->getPages();

        $this->renderAdminView('/admin/pages/pages', $data);
    }

    //------------------------------------------------------------
    public function create(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Pages Create';

        $this->renderAdminView('/admin/pages/create', $data);
    }

    //------------------------------------------------------------
    public function insert(): void
    //------------------------------------------------------------
    {
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

            if ($validated === true) {
                try {
                    // Insert in Database
                    $this->pagesModel->insertPage($postArray);
                    setFlashMsg('success', 'Insert completed successfully.');
                    unset($_SESSION['inputs']);
                    redirect(ADMURL . '/pages');
                } catch (Exception $e) {
                    setFlashMsg('error', $e->getMessage());
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
    public function edit(int $id): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Pages Edit - ' . $id;
        $data['rows'] = $this->pagesModel->getPageById($id);

        $this->renderAdminView('/admin/pages/edit', $data);
    }

    //------------------------------------------------------------
    public function update(int $id): void
    //------------------------------------------------------------
    {
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

            if ($validated === true) {
                try {
                    // Update in Database
                    $this->pagesModel->updatePage($postArray);
                    setFlashMsg('success', 'Update completed successfully.');
                    redirect(ADMURL . '/pages');
                } catch (Exception $e) {
                    setFlashMsg('error', $e->getMessage());
                    redirect(ADMURL . '/pages/edit/' . $id);
                }
            } else {
                setFlashMsg('error', $error);
                redirect(ADMURL . '/pages/edit/' . $id);
            }
        }
    }

    //------------------------------------------------------------
    public function delete(int $id): void
    //------------------------------------------------------------
    {
        try {
            // Delete in Database
            $this->pagesModel->deletePage($id);
            setFlashMsg('success', 'Page with the ID: <strong>' . $id . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setFlashMsg('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/pages');
    }
}
