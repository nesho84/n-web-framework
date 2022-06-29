<?php

$host = DB_HOST;
$db_name = DB_NAME;
$db_user = DB_USER;
$db_password = DB_PASS;
$db_charset = DB_CHARSET;
$dsn = 'mysql:host=' . $host . ';dbname=' . $db_name . ';charset=' . $db_charset;

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $db = new PDO($dsn, $db_user, $db_password, $options);
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
