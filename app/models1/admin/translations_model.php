<?php

//------------------------------------------------------------
function getTranslations(): array|string
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare("SELECT * FROM translations ORDER BY translationDateCreated DESC");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

//------------------------------------------------------------
function getTranslationyById(int $id): array|string
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare("SELECT * FROM translations WHERE translationID = :id");
        $sql->execute(['id' => $id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

//------------------------------------------------------------
function insertTranslation(array $postArray): bool|string
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare(
            "INSERT INTO translations (
            userID,
            translationCode, 
            languageCode, 
            translationText)
            VALUES (
            :userID, 
            :translationCode, 
            :languageCode,  
            :translationText)"
        );
        $sql->execute([
            ':userID' => $postArray['userID'],
            ':translationCode' => $postArray['translationCode'],
            ':languageCode' => $postArray['languageCode'],
            ':translationText' => $postArray['translationText'],
        ]);
        // $lastInsertId = DB->lastInsertId();
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

//------------------------------------------------------------
function updateTranslation(array $postArray): bool|string
//------------------------------------------------------------
{

    try {
        $sql = DB->prepare(
            "UPDATE translations 
            SET userID = :userID,
                translationCode = :translationCode,
                languageCode = :languageCode,
                translationText = :translationText
            WHERE translationID = :translationID"
        );
        $sql->execute([
            ':translationID' => $postArray['translationID'],
            ':userID' => $postArray['userID'],
            ':translationCode' => $postArray['translationCode'],
            ':languageCode' => $postArray['languageCode'],
            ':translationText' => $postArray['translationText'],
        ]);
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

//------------------------------------------------------------
function deleteTranslation(int $id): bool|string
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare("DELETE FROM translations WHERE translationID = :id");
        $sql->execute([':id' => $id]);
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
