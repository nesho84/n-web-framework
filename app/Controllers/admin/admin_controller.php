<?php

// Load Model
App::loadModel(MODELS_PATH . "/admin/admin_model.php");

//------------------------------------------------------------
function index(): void
//------------------------------------------------------------
{
    // Require Login
    checkUserLoggedIn();

    $data['rows'] = getTables();
    $data["title"] = "Home";

    App::renderAdminView(VIEWS_PATH . "/admin/index.php", $data);
}
