<?php

class Database
{
    // MySQL Connection
    private $host = DB_HOST;
    private $db_user = DB_USER;
    private $db_password = DB_PASS;
    private $db_name = DB_NAME;
    private $db_charset = DB_CHARSET;
    private $pdo;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Connect to the database
        try {
            $dsn = 'mysql:host=' . $this->host . ';charset=' . $this->db_charset;
            $this->pdo = new PDO($dsn, $this->db_user, $this->db_password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            // Define DB constant as Global
            defined("DB") or define("DB", $this->pdo);
        } catch (PDOException $e) {
            die("Connection to <strong>{$this->host}</strong> failed. Please ensure:
                <ul>
                    <li>The PHP MySQL module is installed and enabled.</li>
                    <li>The database is running.</li>
                    <li>The credentials in settings.php are valid.</li>
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
            $this->pdo->query("SELECT 1 FROM `user` LIMIT 1");
        } catch (PDOException $e) {
            $this->showDBError("Table <strong>user</strong> doesn't exist");
        }
    }

    //------------------------------------------------------------
    private function checkUserAdmin(): void
    //------------------------------------------------------------
    {
        try {
            $user_check = $this->pdo->query("SELECT * FROM `user`");
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

    //------------------------------------------------------------
    public function query(string $query)
    //------------------------------------------------------------
    {
        return $this->pdo->query($query);
    }

    //------------------------------------------------------------
    public function prepare(string $query)
    //------------------------------------------------------------
    {
        return $this->pdo->prepare($query);
    }

    //------------------------------------------------------------
    public function lastInsertId(): int
    //------------------------------------------------------------
    {
        return $this->pdo->lastInsertId();
    }

    //------------------------------------------------------------
    public function beginTransaction()
    //------------------------------------------------------------
    {
        return $this->pdo->beginTransaction();
    }

    //------------------------------------------------------------
    public function commit()
    //------------------------------------------------------------
    {
        return $this->pdo->commit();
    }

    //------------------------------------------------------------
    public function rollback()
    //------------------------------------------------------------
    {
        return $this->pdo->rollBack();
    }
}
