<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AdminModel;
use App\Core\Sessions;

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
        // dd($_SESSION);
        $data["title"] = "Home";
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
