<?php

//------------------------------------------------------------
function getUsers(): array|string
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare("SELECT * FROM user");
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
    try {
        $sql = DB->prepare("SELECT * FROM user WHERE userID = :id");
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
    try {
        $sql = DB->prepare("SELECT * FROM user WHERE userID != :id");
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
    try {
        $sql = DB->prepare(
            "INSERT INTO user (
            userName,
            userEmail, 
            userPassword, 
            userPicture,
            userRole)
            VALUES (
            :userName, 
            :userEmail, 
            :userPassword,
            :userPicture,
            :userRole)"
        );
        $sql->execute([
            ':userName' => $postArray['userName'],
            ':userEmail' => $postArray['userEmail'],
            ':userPassword' => $postArray['userPassword'],
            ':userPicture' => $postArray['userPicture'],
            ':userRole' => $postArray['userRole'],
        ]);
        // $lastInsertId = DB->lastInsertId();
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

//------------------------------------------------------------
function updateUser(array $postArray): bool|string
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare(
            "UPDATE user 
            SET userName = :userName,
                userEmail = :userEmail,
                userPassword = :userPassword,
                userPicture = :userPicture,
                userRole = :userRole,
                userStatus = :userStatus
            WHERE userID = :userID"
        );
        $sql->execute([
            ':userID' => $postArray['userID'],
            ':userName' => $postArray['userName'],
            ':userEmail' => $postArray['userEmail'],
            ':userPassword' => $postArray['userPassword'],
            ':userPicture' => $postArray['userPicture'],
            ':userRole' => $postArray['userRole'],
            ':userStatus' => $postArray['userStatus'],
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
    try {
        $sql = DB->prepare("DELETE FROM user WHERE userID = :id");
        $sql->execute([':id' => $id]);
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
