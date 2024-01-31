<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private string $host = DB_HOST;
    private string $db_user = DB_USER;
    private string $db_password = DB_PASS;
    private string $db_name = DB_NAME;
    private string $db_charset = DB_CHARSET;

    protected PDO $pdo;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Connect to the database
        try {
            $dsn = "mysql:host=$this->host;charset=$this->db_charset";

            $this->pdo = new PDO($dsn, $this->db_user, $this->db_password);

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_COLUMN);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // Define DB constant as Global
            defined("DB") or define("DB", $this->pdo);
        } catch (PDOException $e) {
            die("Connection to <strong>{$this->host}</strong> failed. Please ensure:
                <ul>
                    <li>The PHP MySQL module is installed and enabled.</li>
                    <li>The database is running.</li>
                    <li>The credentials in config.php are valid.</li>
                </ul>");
        }

        // Check for database
        $this->checkDatabase();
        // Check for tables
        $this->checkTables();
        // Check for at least one user
        $this->checkUserAdmin();
    }

    //------------------------------------------------------------
    private function checkDatabase(): void
    //------------------------------------------------------------
    {
        try {
            $db_check = $this->pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$this->db_name'");
            if ($db_check->rowCount() == 0) {
                $this->showDBError("Database <strong> . $this->db_name . </strong> doesn't exist");
            } else {
                $this->pdo->exec("USE `$this->db_name`"); // select database
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage() . "<br>");
        }
    }

    //------------------------------------------------------------
    private function checkTables(): void
    //------------------------------------------------------------
    {
        try {
            $this->pdo->query("SELECT 1 FROM `users` LIMIT 1");
        } catch (PDOException $e) {
            $this->showDBError("Table <strong>users</strong> doesn't exist");
        }
    }

    //------------------------------------------------------------
    private function checkUserAdmin(): void
    //------------------------------------------------------------
    {
        try {
            $user_check = $this->pdo->query("SELECT * FROM `users`");
            if ($user_check->rowCount() == 0) {
                $this->showDBError("Static user <strong>admin@company.com</strong> doesn't exist<br>");
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage() . "<br>");
        }
    }

    //------------------------------------------------------------
    private function showDBError(string $message): void
    //------------------------------------------------------------
    {
        die('<p>' . $message . '</p><p><a href="' . APPURL . '/setup.php">or Setup default configuration...</a></p>');
    }
}
