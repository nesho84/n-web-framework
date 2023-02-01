<?php
// MySQL Connection
$host = DB_HOST;
$db_name = DB_NAME;
$db_user = DB_USER;
$db_password = DB_PASS;
$db_charset = DB_CHARSET;

$dsn = 'mysql:host=' . $host . ';charset=' . $db_charset;

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

// Check and Connect
try {
    $db = new PDO($dsn, $db_user, $db_password, $options);
    // Define DB Constant as Global
    defined("DB") or define("DB", $db);
} catch (PDOException $e) {
    die("Connection to <strong>{$host}</strong> failed. Please ensure:
        <ul>
            <li>The PHP MySQL module is installed and enabled.</li>
            <li>The database is running.</li>
            <li>The credentials in config.php are valid.</li>
        </ul>");
}

// Check for database
try {
    $db_check = $db->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'");
    if ($db_check->rowCount() == 0) {
        showDBError("Database <strong> . $db_name . </strong> doesn't exist");
    } else {
        $db->exec("USE `$db_name`"); // select database
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "<br>");
}

// Check for tables
try {
    $table_check = $db->query("SELECT 1 FROM `user` LIMIT 1");
} catch (PDOException $e) {
    showDBError("Table <strong>user</strong> doesn't exist");
}

// Check for at least one user
try {
    $user_check = $db->query("SELECT * FROM `user`");
    if ($user_check->rowCount() == 0) {
        showDBError("Static user <strong>admin@company.com</strong> doesn't exist<br>");
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "<br>");
}

function showDBError($message)
{
    die('<div><p>' . $message . '</p><p><a href="' . APPURL . '/install.php">or Install default configuration...</a></p></div>');
}
