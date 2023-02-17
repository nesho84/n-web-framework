<?php

class AdminController extends Controller
{
    private AdminModel $adminModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Load Model
        $this->adminModel = $this->loadModel("/admin/AdminModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        // Require Login
        IsUserLoggedIn();

        $data["title"] = "Home";

        $result = $this->adminModel->getTables(DB_NAME);
        if (is_array($result)) {
            $data['rows'] = $result;
        } else {
            setFlashMsg('error', $result);
        }

        $this->renderAdminView("/admin/index", $data);
    }
}
