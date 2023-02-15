<?php

class AdminController extends Controller
{
    private AdminModel $adminModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Load Model
        $this->adminModel = $this->loadModel(MODELS_PATH . "/admin/AdminModel.php");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        // Require Login
        IsUserLoggedIn();

        $data['rows'] = $this->adminModel->getTables();
        $data["title"] = "Home";

        $this->renderAdminView(VIEWS_PATH . "/admin/index.php", $data);
    }
}
