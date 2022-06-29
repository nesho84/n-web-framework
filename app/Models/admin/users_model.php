<?php

//------------------------------------------------------------
function getUsers(): array|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare("SELECT * FROM user");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

//------------------------------------------------------------
function getUserById(int $id): array|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare("SELECT * FROM user WHERE userID = :id");
        $sql->execute(['id' => $id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

//------------------------------------------------------------
function getUsersExceptThis(int $id): array|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare("SELECT * FROM user WHERE userID != :id");
        $sql->execute(['id' => $id]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

//------------------------------------------------------------
function insertUser(array $postArray): bool|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare(
            "INSERT INTO user (
            userName,
            userEmail, 
            userPassword, 
            userRole)
            VALUES (
            :userName, 
            :userEmail, 
            :userPassword, 
            :userRole)"
        );
        $sql->execute([
            ':userName' => $postArray['userName'],
            ':userEmail' => $postArray['userEmail'],
            ':userPassword' => $postArray['userPassword'],
            ':userRole' => $postArray['userRole'],
        ]);
        // $lastInsertId = $db->lastInsertId();
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

//------------------------------------------------------------
function updateUser(array $postArray): bool|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare(
            "UPDATE user 
            SET userName = :userName,
                userEmail = :userEmail,
                userPassword = :userPassword,
                userRole = :userRole
            WHERE userID = :userID"
        );
        $sql->execute([
            ':userID' => $postArray['userID'],
            ':userName' => $postArray['userName'],
            ':userEmail' => $postArray['userEmail'],
            ':userPassword' => $postArray['userPassword'],
            ':userRole' => $postArray['userRole'],
        ]);
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

//------------------------------------------------------------
function deleteUser(int $id): bool|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare("DELETE FROM user WHERE userID = :id");
        $sql->execute([':id' => $id]);
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
