<?php

//------------------------------------------------------------
function getTranslations(): array|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare("SELECT * FROM translations ORDER BY translationDateCreated DESC");
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
    global $db;

    try {
        $sql = $db->prepare("SELECT * FROM translations WHERE translationID = :id");
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
    global $db;

    try {
        $sql = $db->prepare(
            "INSERT INTO translations (
            translationCode, 
            languageCode, 
            translationText)
            VALUES (
            :translationCode, 
            :languageCode,  
            :translationText)"
        );
        $sql->execute([
            ':translationCode' => $postArray['translationCode'],
            ':languageCode' => $postArray['languageCode'],
            ':translationText' => $postArray['translationText'],
        ]);
        // $lastInsertId = $db->lastInsertId();
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

//------------------------------------------------------------
// function updateCategory(array $postArray): bool|string
// //------------------------------------------------------------
// {
//     global $db;

//     try {
//         $sql = $db->prepare(
//             "UPDATE category 
//             SET userID = :userID,
//                 categoryType = :categoryType,
//                 categoryLink = :categoryLink,
//                 categoryName = :categoryName,
//                 categoryDescription = :categoryDescription
//             WHERE categoryID = :categoryID"
//         );
//         $sql->execute([
//             ':categoryID' => $postArray['categoryID'],
//             ':userID' => $postArray['userID'],
//             ':categoryType' => $postArray['categoryType'],
//             ':categoryLink' => $postArray['categoryLink'],
//             ':categoryName' => $postArray['categoryName'],
//             ':categoryDescription' => $postArray['categoryDescription'],
//         ]);
//         return true;
//     } catch (PDOException $e) {
//         return $e->getMessage();
//     }
// }

//------------------------------------------------------------
function deleteTranslation(int $id): bool|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare("DELETE FROM translations WHERE translationID = :id");
        $sql->execute([':id' => $id]);
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
