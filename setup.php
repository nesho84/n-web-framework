<?php
// Global settings
require_once __DIR__ . "/config/settings.php";

// MySQL Connection
$host = DB_HOST;
$db_user = DB_USER;
$db_password = DB_PASS;
$db_name = DB_NAME;
$db_charset = DB_CHARSET;
$ok = false;
$pdo = null;

//------------------------------------------------------------
// Connect to the database
//------------------------------------------------------------
try {
    $pdo = new PDO("mysql:host=$host", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
} catch (PDOException $e) {
    die("Connection to <strong>{$host}</strong> failed. Please ensure:
        <ul>
            <li>The PHP MySQL module is installed and enabled.</li>
            <li>The database is running.</li>
            <li>The credentials in settings.php are valid.</li>
        </ul>");
}

//------------------------------------------------------------
// Create the database, tables and admin user
//------------------------------------------------------------
try {
    // Start the transaction
    $pdo->beginTransaction();

    // Create the database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name`");
    // Connect to the newly created database
    $pdo->exec("USE `$db_name`");

    // Create tables
    createTables($pdo);

    // Create admin user
    createUser($pdo);

    // Commit the transaction
    $pdo->commit();
    $ok = true;
} catch (PDOException $e) {
    // If an exception is thrown, roll back the transaction
    $pdo->rollBack();
    $ok = false;

    // Handle the exception
    die('<p>Setup failed: ' . $e->getMessage() . '</p><p><a href="' . APPURL . '/setup.php">Try again...</a></p>');
} finally {
    // Close connection
    $pdo = null;

    // This means life is good :) -> // Redirect to Login
    if ($ok === true) {
        header('Location:' . APPURL . '/login');
        exit();
    }
}

//------------------------------------------------------------
function createTables(object $conn): void
//------------------------------------------------------------
{
    $conn->exec("CREATE TABLE IF NOT EXISTS `user` (
    `userID` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `userName` varchar(255) NOT NULL,
    `userEmail` varchar(255) NOT NULL,
    `userPassword` varchar(255) NOT NULL,
    `userPicture` longtext DEFAULT NULL,
    `userRole` varchar(255) NOT NULL DEFAULT 'default',
    `userStatus` int(11) NOT NULL DEFAULT 1,
    `userDateCreated` datetime NOT NULL DEFAULT current_timestamp(),
    `userDateUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

    $conn->exec("CREATE TABLE `settings` (
    `settingID` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `userID` int(11) NOT NULL,
    `languageID` int(11) NOT NULL,
    `settingTheme` varchar(255) NOT NULL,
    `settingStatus` tinyint(1) NOT NULL DEFAULT 1,
    `settingDateCreated` datetime NOT NULL DEFAULT current_timestamp(),
    `settingDateUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

//------------------------------------------------------------
function createUser(object $conn): void
//------------------------------------------------------------
{
    $userName = A_USERNAME;
    $userEmail = A_USER_EMAIL;
    $userRole = A_USER_ROLE;
    $userPassword = A_USER_PASSWORD;

    // Check if User exists first
    $user_exist = $conn->prepare("SELECT * FROM `user` WHERE userName = :userName");
    $user_exist->execute(array(':userName' => $userName));

    // Create if dosen't
    if ($user_exist->rowCount() === 0) {
        $stmt = $conn->prepare("INSERT INTO `user` (`userName`, `userEmail`, `userPassword`, `userRole`) VALUES (:userName, :userEmail, :userPassword, :userRole)");
        $passwordHashed = password_hash($userPassword, PASSWORD_BCRYPT, ['cost' => 10]);
        $stmt->execute([
            ':userName' => $userName,
            ':userEmail' => $userEmail,
            ':userPassword' => $passwordHashed,
            ':userRole' => $userRole,
        ]);
        $lastId = $stmt->lastInsertId();
        // @TODO: create at least one language and get the last inserted id
        // createSettings($conn, $lastId, 111);
    }
}

//------------------------------------------------------------
// @TODO: function to create at least one language required for the settings
//------------------------------------------------------------

//------------------------------------------------------------
function createSettings(object $conn, int $lastUserId, int $lastLanguageId): void
//------------------------------------------------------------
{
    $userId = $lastUserId;
    $languageId = $lastLanguageId;
    $settingTheme = 'light';

    // Check if User exists first
    $user_exist = $conn->prepare("SELECT * FROM `settings`");
    $user_exist->execute();

    // Create if dosen't
    if ($user_exist->rowCount() === 0) {
        $stmt = $conn->prepare("INSERT INTO `settings` (`userID`, `languageID`, `settingTheme`) VALUES (:userID, :languageID, :settingTheme)");
        $stmt->execute([
            ':userID' => $userId,
            ':languageID' => $languageId,
            ':settingTheme' => $settingTheme,
        ]);
    }
}
