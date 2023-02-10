<?php

// Load Model
Router::loadModel(MODELS_PATH . "/admin/admin_model.php");

//------------------------------------------------------------
function index(): void
//------------------------------------------------------------
{
    // Require Login
    IsUserLoggedIn();

    $data['rows'] = getTables();
    $data["title"] = "Home";

    Router::renderAdminView(VIEWS_PATH . "/admin/index.php", $data);
}
