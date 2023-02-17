<?php

class CategoriesModel extends Model
{
    //------------------------------------------------------------
    public function getCategories(): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM category ORDER BY categoryDateCreated DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //------------------------------------------------------------
    public function getCategoriesByType(string $ctype): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM category WHERE categoryType = :ctype");
            $this->bindValues($stmt, ['ctype' => $ctype]);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //------------------------------------------------------------
    public function getCategoriesByName(string $cname): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM category WHERE categoryName = :cname");
            $this->bindValues($stmt, ['cname' => $cname]);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //------------------------------------------------------------
    public function getCategoryById(int $id): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM category WHERE categoryID = :id");
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //------------------------------------------------------------
    public function insertCategory(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare(
                "INSERT INTO category (
                userID,
                categoryType, 
                categoryLink, 
                categoryName, 
                categoryDescription)
                VALUES (
                :userID, 
                :categoryType, 
                :categoryLink, 
                :categoryName,  
                :categoryDescription)"
            );
            $this->bindValues($stmt, $postArray);
            return $stmt->execute();
            // // $lastInsertId = $this->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //------------------------------------------------------------
    public function updateCategory(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare(
                "UPDATE category 
                SET userID = :userID,
                    categoryType = :categoryType,
                    categoryLink = :categoryLink,
                    categoryName = :categoryName,
                    categoryDescription = :categoryDescription
                WHERE categoryID = :categoryID"
            );
            $this->bindValues($stmt, $postArray);
            return $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //------------------------------------------------------------
    public function deleteCategory(int $id): bool|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("DELETE FROM category WHERE categoryID = :id");
            $this->bindValues($stmt, ['id' => $id]);
            return $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
