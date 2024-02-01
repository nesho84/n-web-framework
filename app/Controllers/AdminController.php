<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AdminModel;
use App\Auth\UserPermissions;

class AdminController extends Controller
{
    private AdminModel $adminModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        $this->adminModel = new AdminModel();
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
            "events",
        ]);

        $this->renderAdminView("/admin/index", $data);
    }
}
