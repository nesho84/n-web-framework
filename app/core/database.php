<?php
// MySQL Connection
$host = DB_HOST;
$db_name = DB_NAME;
$db_user = DB_USER;
$db_password = DB_PASS;
$db_charset = DB_CHARSET;

$dsn = 'mysql:host=' . $host . ';charset=' . $db_charset;

//------------------------------------------------------------
// Connect to the database
//------------------------------------------------------------
try {
    $pdo = new PDO($dsn, $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // Define DB constant as Global
    defined("DB") or define("DB", $pdo);
} catch (PDOException $e) {
    die("Connection to <strong>{$host}</strong> failed. Please ensure:
        <ul>
            <li>The PHP MySQL module is installed and enabled.</li>
            <li>The database is running.</li>
            <li>The credentials in settings.php are valid.</li>
        </ul>");
}

//------------------------------------------------------------
// Check for database
//------------------------------------------------------------
try {
    $db_check = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'");
    if ($db_check->rowCount() == 0) {
        showDBError("Database <strong> . $db_name . </strong> doesn't exist");
    } else {
        $pdo->exec("USE `$db_name`"); // select database
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "<br>");
}

//------------------------------------------------------------
// Check for tables
//------------------------------------------------------------
try {
    $table_check = $pdo->query("SELECT 1 FROM `user` LIMIT 1");
} catch (PDOException $e) {
    showDBError("Table <strong>user</strong> doesn't exist");
}

//------------------------------------------------------------
// Check for at least one user
//------------------------------------------------------------
try {
    $user_check = $pdo->query("SELECT * FROM `user`");
    if ($user_check->rowCount() == 0) {
        showDBError("Static user <strong>admin@company.com</strong> doesn't exist<br>");
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "<br>");
}

function showDBError($message)
{
    die('<p>' . $message . '</p><p><a href="' . APPURL . '/setup.php">or Setup default configuration...</a></p>');
}
