<?php

class CategoriesModel extends Model
{
    //------------------------------------------------------------
    public function getCategories(): array|string
    //------------------------------------------------------------
    {
        try {
            return $this->selectAll(
                table: 'category',
                orderBy: 'categoryDateCreated DESC',
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //------------------------------------------------------------
    public function getCategoriesByType(string $ctype): array|string
    //------------------------------------------------------------
    {
        // try {
        //     $sql = DB->prepare("SELECT * FROM category WHERE categoryType = :ctype");
        //     $sql->execute(['ctype' => $ctype]);
        //     return $sql->fetchAll(PDO::FETCH_ASSOC);
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }

    //------------------------------------------------------------
    public function getCategoriesByName(string $cname): array|string
    //------------------------------------------------------------
    {
        // try {
        //     $sql = DB->prepare("SELECT * FROM category WHERE categoryName = :cname");
        //     $sql->execute(['cname' => $cname]);
        //     return $sql->fetchAll(PDO::FETCH_ASSOC);
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }

    //------------------------------------------------------------
    public function getCategoryById(int $id): array|string
    //------------------------------------------------------------
    {
        try {
            return $this->selectOne(
                table: 'category',
                conditions: ['categoryID' => $id]
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //------------------------------------------------------------
    public function insertCategory(array $postArray): bool|string
    //------------------------------------------------------------
    {
        // try {

        //     $sql = DB->prepare(
        //         "INSERT INTO category (
        //     userID,
        //     categoryType, 
        //     categoryLink, 
        //     categoryName, 
        //     categoryDescription)
        //     VALUES (
        //     :userID, 
        //     :categoryType, 
        //     :categoryLink, 
        //     :categoryName,  
        //     :categoryDescription)"
        //     );
        //     $sql->execute([
        //         ':userID' => $postArray['userID'],
        //         ':categoryType' => $postArray['categoryType'],
        //         ':categoryLink' => $postArray['categoryLink'],
        //         ':categoryName' => $postArray['categoryName'],
        //         ':categoryDescription' => $postArray['categoryDescription'],
        //     ]);

        //     // $lastInsertId = DB->lastInsertId();

        //     return true;
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }

    //------------------------------------------------------------
    public function updateCategory(array $postArray): bool|string
    //------------------------------------------------------------
    {
        // try {
        //     $sql = DB->prepare(
        //         "UPDATE category 
        //     SET userID = :userID,
        //         categoryType = :categoryType,
        //         categoryLink = :categoryLink,
        //         categoryName = :categoryName,
        //         categoryDescription = :categoryDescription
        //     WHERE categoryID = :categoryID"
        //     );
        //     $sql->execute([
        //         ':categoryID' => $postArray['categoryID'],
        //         ':userID' => $postArray['userID'],
        //         ':categoryType' => $postArray['categoryType'],
        //         ':categoryLink' => $postArray['categoryLink'],
        //         ':categoryName' => $postArray['categoryName'],
        //         ':categoryDescription' => $postArray['categoryDescription'],
        //     ]);
        //     return true;
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }

    //------------------------------------------------------------
    public function deleteCategory(int $id): bool|string
    //------------------------------------------------------------
    {
        // try {
        //     $sql = DB->prepare("DELETE FROM category WHERE categoryID = :id");
        //     $sql->execute([':id' => $id]);
        //     return true;
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }
}
