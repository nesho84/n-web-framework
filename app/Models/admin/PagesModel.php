<?php

class PagesModel extends Model
{
    //------------------------------------------------------------
    public function getPages(): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare(
                "SELECT * FROM pages AS p
                INNER JOIN (SELECT userID, userName FROM users) as u 
                ON u.userID = p.userID
                WHERE p.pageID IS NOT NULL
                ORDER BY p.pageName ASC"
            );
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    //------------------------------------------------------------
    public function getPageById(int $id): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM pages WHERE pageID = :id");
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    // ....continue here....
    //------------------------------------------------------------
    public function insertPage(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare(
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
            $stmt->execute([
                ':userID' => $postArray['userID'],
                ':pageName' => $postArray['pageName'],
                ':pageTitle' => $postArray['pageTitle'],
                ':pageContent' => $postArray['pageContent'],
                ':pageLanguage' => $postArray['pageLanguage'],
                ':PageMetaTitle' => $postArray['PageMetaTitle'],
                ':PageMetaDescription' => $postArray['PageMetaDescription'],
                ':PageMetaKeywords' => $postArray['PageMetaKeywords'],
            ]);
            // $lastInsertId = $this->lastInsertId();
            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function updatePage(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare(
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
            $stmt->execute([
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
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function deletePage(int $id): bool|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("DELETE FROM pages WHERE pageID = :id");
            $stmt->execute([':id' => $id]);
            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
