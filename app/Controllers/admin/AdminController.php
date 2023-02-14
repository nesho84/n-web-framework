<?php

class AdminController extends Controller
{
    private $model;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Load Model
        $this->model = $this->loadModel(MODELS_PATH . "/admin/AdminModel.php", 'AdminModel');
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        // Require Login
        IsUserLoggedIn();

        $data['rows'] = $this->model->getTables();
        $data["title"] = "Home";

        $this->renderAdminView(VIEWS_PATH . "/admin/index.php", $data);
    }
}
