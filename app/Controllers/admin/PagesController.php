<?php

class PagesController extends Controller
{
    private PagesModel $pagesModel;
    private LanguagesModel $languagesModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        Sessions::requireLogin();

        // Load Model
        $this->pagesModel = $this->loadModel("/admin/PagesModel");

        // Load LanguagesModel
        $this->languagesModel = $this->loadModel("/admin/LanguagesModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Pages';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['rows'] = $this->pagesModel->getPages();

        $this->renderAdminView('/admin/pages/pages', $data);
    }

    //------------------------------------------------------------
    public function create(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Pages Create';
        $data['languages'] = $this->languagesModel->getLanguages();

        $this->renderAdminView('/admin/pages/create', $data);
    }

    //------------------------------------------------------------
    public function insert(): void
    //------------------------------------------------------------
    {
        if (isset($_POST['insert_page'])) {
            $postArray = [
                'userID' => $_SESSION['user']['id'],
                'languageID' => htmlspecialchars(trim($_POST['languageID'] ?? '')),
                'pageName' => htmlspecialchars(trim($_POST['pageName'])),
                'pageTitle' => htmlspecialchars(trim($_POST['pageTitle'])),
                'pageContent' => $_POST['pageContent'],
                'PageMetaTitle' => htmlspecialchars(trim($_POST['PageMetaTitle'])),
                'PageMetaDescription' => htmlspecialchars(trim($_POST['PageMetaDescription'])),
                'PageMetaKeywords' => htmlspecialchars(trim($_POST['PageMetaKeywords'])),
            ];

            // Get all existing language ids from the Model
            $languages = $this->languagesModel->getLanguages();
            $valid_ids = array();
            foreach ($languages as $lang) {
                $valid_ids[] = $lang['languageID'];
            }

            // Validate inputs
            $validator = new DataValidator();
            $validator('Page Name', $postArray['pageName'])->required()->min(3)->max(20);
            $validator('Page Title', $postArray['pageTitle'])->required()->min(3)->max(20);
            if (empty($postArray['languageID'])) {
                $validator->addError('languageID', 'Please choose a Language')->setValidated(false);
            } elseif (!in_array($postArray['languageID'], $valid_ids)) {
                $validator->addError('languageID', 'Please select a valid language')->setValidated(false);
            }

            if ($validator->isValidated()) {
                try {
                    // Insert in Database
                    $this->pagesModel->insertPage($postArray);
                    setAlert('success', 'Insert completed successfully.');
                    unset($_SESSION['inputs']);
                    redirect(ADMURL . '/pages');
                } catch (Exception $e) {
                    setAlert('error', $e->getMessage());
                    $_SESSION['inputs'] = $postArray;
                    redirect(ADMURL . '/pages/create');
                }
            } else {
                setAlert('error', $validator->getErrors());
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
        $data['languages'] = $this->languagesModel->getLanguages();

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
                'languageID' => htmlspecialchars(trim($_POST['languageID'])),
                'pageName' => htmlspecialchars(trim($_POST['pageName'])),
                'pageTitle' => htmlspecialchars(trim($_POST['pageTitle'])),
                'PageMetaTitle' => htmlspecialchars(trim($_POST['PageMetaTitle'])),
                'PageMetaDescription' => htmlspecialchars(trim($_POST['PageMetaDescription'])),
                'PageMetaKeywords' => htmlspecialchars(trim($_POST['PageMetaKeywords'])),
                'pageStatus' => isset($_POST['pageStatus']) ? 1 : 0,
                'pageContent' => $_POST['pageContent'],
            ];

            // Get existing page from the Model
            $page = $this->pagesModel->getPageById($id);
            // Get all existing language ids from the Model
            $languages = $this->languagesModel->getLanguages();
            $valid_ids = array();
            foreach ($languages as $lang) {
                $valid_ids[] = $lang['languageID'];
            }

            // Validate inputs
            $validator = new DataValidator();
            $validator('Page Name', $postArray['pageName'])->required()->min(3)->max(20);
            $validator('Page Title', $postArray['pageTitle'])->required()->min(3)->max(20);
            if (empty($postArray['languageID'])) {
                $validator->addError('languageID', 'Please choose a Language')->setValidated(false);
            } elseif (!in_array($postArray['languageID'], $valid_ids)) {
                $validator->addError('languageID', 'Please select a valid language')->setValidated(false);
            }

            if ($validator->isValidated()) {
                // Update only changed fields and skip the 'id'
                foreach ($postArray as $key => $value) {
                    if (isset($postArray[$key]) && $page[$key] == $value && $key !== 'pageID') {
                        unset($postArray[$key]);
                    }
                }

                if (count($postArray) > 1) {
                    try {
                        // Update in Database
                        $this->pagesModel->updatePage($postArray);
                        setAlert('success', 'Update completed successfully');
                        redirect(ADMURL . '/pages');
                    } catch (Exception $e) {
                        setAlert('error', $e->getMessage());
                        redirect(ADMURL . '/pages/edit/' . $id);
                    }
                } else {
                    setAlert('warning', 'No fields were changed');
                    redirect(ADMURL . '/pages/edit/' . $id);
                }
            } else {
                setAlert('error', $validator->getErrors());
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
            setAlert('success', 'Page with the ID: <strong>' . $id . '</strong> deleted successfully.');
        } catch (Exception $e) {
            setAlert('error', $e->getMessage());
        }

        // Allways redirect back
        redirect(ADMURL . '/pages');
    }
}
