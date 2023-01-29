<?php
$servername = "localhost";
$dbname = "nwf_db";
$username = "root";
$password = "123456";

try {
    $conn = new PDO("mysql:host=$servername;", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if database exists
    $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'";
    $result = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        // Create database
        $conn->beginTransaction();
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        $conn->exec($sql);
        $conn->commit();
        echo "Database created successfully<br>";
    } else {
        echo "Database already exists<br>";
    }

    // Connect to database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if users table exists
    $sql = "SHOW TABLES LIKE 'user'";
    $result = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        // Create user table
        $conn->beginTransaction();
        $sql = "CREATE TABLE IF NOT EXISTS user (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(50)
        )";
        $conn->exec($sql);

        // Insert static user
        $passwordHash = password_hash("password", PASSWORD_BCRYPT);
        $sql = "INSERT INTO user (username, password, email)
        VALUES ('staticuser', '$passwordHash', 'staticuser@example.com')";
        $conn->exec($sql);

        $conn->commit();

        echo "Table user created successfully<br>";
        echo "Static user created successfully<br>";
    } else {
        echo "Table user already exists<br>";
    }
} catch (PDOException $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
$conn = null;
