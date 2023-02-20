<?php

//------------------------------------------------------------
function getUsers(): array|string
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare("SELECT * FROM users");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

//------------------------------------------------------------
function getUserById(int $id): array|string
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare("SELECT * FROM users WHERE userID = :id");
        $sql->execute(['id' => $id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

//------------------------------------------------------------
function getUsersExceptThis(int $id): array|string
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare("SELECT * FROM users WHERE userID != :id");
        $sql->execute(['id' => $id]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}

//------------------------------------------------------------
function insertUser(array $postArray): bool|string
//------------------------------------------------------------
{
    try {
        // start database transaction
        DB->beginTransaction();

        $sql = DB->prepare(
            "INSERT INTO users (
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

        // commit database transaction
        DB->commit();

        // $lastInsertId = DB->lastInsertId();
        return true;
    } catch (PDOException $e) {
        // rollback database transaction
        DB->rollback();

        throw new Exception($e->getMessage());
    }
}

//------------------------------------------------------------
function updateUser(array $postArray): bool|string
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare(
            "UPDATE users 
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
        throw new Exception($e->getMessage());
    }
}

//------------------------------------------------------------
function deleteUser(int $id): bool|string
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare("DELETE FROM users WHERE userID = :id");
        $sql->execute([':id' => $id]);
        return true;
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
}
