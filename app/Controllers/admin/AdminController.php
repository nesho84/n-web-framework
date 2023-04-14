<?php

class AdminController extends Controller
{
    private AdminModel $adminModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        Sessions::requireLogin();

        // Load Model
        $this->adminModel = $this->loadModel("/admin/AdminModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data["title"] = "Home";
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['rows'] = $this->adminModel->getTables(DB_NAME, [
            "categories",
            "files",
            "invoices",
            "languages",
            "pages",
            "settings",
            "translations",
            "users",
        ]);

        // dd($data['rows']);

        $this->renderAdminView("/admin/index", $data);
    }
}
