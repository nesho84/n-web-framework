<?php

class AdminController extends Controller
{
    private AdminModel $adminModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        // $this->requireLogin();

        // Load Model
        $this->adminModel = $this->loadModel("/admin/AdminModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data["title"] = "Home";
        $data['rows'] = $this->adminModel->getTables(DB_NAME);

        $this->renderAdminView("/admin/index", $data);
    }
}
