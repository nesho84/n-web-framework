<?php

//------------------------------------------------------------
function getPages(): array|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare(
            "SELECT * FROM pages AS p
            INNER JOIN (SELECT userID, userName FROM user) as u 
            ON u.userID = p.userID
            WHERE p.pageID IS NOT NULL
            ORDER BY p.pageName ASC"
        );
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

//------------------------------------------------------------
function getPageById(int $id): array|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare("SELECT * FROM pages WHERE pageID = :id");
        $sql->execute(['id' => $id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

//------------------------------------------------------------
function insertPage(array $postArray): bool|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare(
            "INSERT INTO pages (
            userID,
            pageName, 
            pageTitle, 
            pageContent, 
            pageLanguage,
            PageMetaTitle,
            PageMetaDescription,
            PageMetaKeywords)
            VALUES (
            :userID, 
            :pageName, 
            :pageTitle, 
            :pageContent, 
            :pageLanguage,
            :PageMetaTitle,
            :PageMetaDescription,
            :PageMetaKeywords)"
        );
        $sql->execute([
            ':userID' => $postArray['userID'],
            ':pageName' => $postArray['pageName'],
            ':pageTitle' => $postArray['pageTitle'],
            ':pageContent' => $postArray['pageContent'],
            ':pageLanguage' => $postArray['pageLanguage'],
            ':PageMetaTitle' => $postArray['PageMetaTitle'],
            ':PageMetaDescription' => $postArray['PageMetaDescription'],
            ':PageMetaKeywords' => $postArray['PageMetaKeywords'],
        ]);
        // $lastInsertId = $db->lastInsertId();
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

//------------------------------------------------------------
function updatePage(array $postArray): bool|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare(
            "UPDATE pages 
            SET pageName = :pageName,
                userID = :userID,
                pageTitle = :pageTitle,
                pageLanguage = :pageLanguage,
                PageMetaTitle = :PageMetaTitle,
                PageMetaDescription = :PageMetaDescription,
                PageMetaKeywords = :PageMetaKeywords,
                pageStatus = :pageStatus,
                pageContent = :pageContent
            WHERE pageID = :pageID"
        );
        $sql->execute([
            ':pageID' => $postArray['pageID'],
            ':userID' => $postArray['userID'],
            ':pageName' => $postArray['pageName'],
            ':pageTitle' => $postArray['pageTitle'],
            ':pageLanguage' => $postArray['pageLanguage'],
            ':PageMetaTitle' => $postArray['PageMetaTitle'],
            ':PageMetaDescription' => $postArray['PageMetaDescription'],
            ':PageMetaKeywords' => $postArray['PageMetaKeywords'],
            ':pageStatus' => $postArray['pageStatus'],
            ':pageContent' => $postArray['pageContent'],
        ]);
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

//------------------------------------------------------------
function deletePage(int $id): bool|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare("DELETE FROM pages WHERE pageID = :id");
        $sql->execute([':id' => $id]);
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
