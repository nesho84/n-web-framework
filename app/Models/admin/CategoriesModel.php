<?php

class CategoriesModel extends Model
{
    //------------------------------------------------------------
    public function getCategories(): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM categories ORDER BY categoryDateCreated DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getCategoriesByType(string $ctype): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM categories WHERE categoryType = :ctype");
            $this->bindValues($stmt, ['ctype' => $ctype]);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getCategoriesByName(string $cname): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM categories WHERE categoryName = :cname");
            $this->bindValues($stmt, ['cname' => $cname]);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getCategoryById(int $id): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM categories WHERE categoryID = :id");
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function insertCategory(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            // $stmt = $this->prepare(
            //     "INSERT INTO categories (userID, categoryType, categoryLink, categoryName,categoryDescription) 
            //     VALUES (
            //     :userID, 
            //     :categoryType, 
            //     :categoryLink, 
            //     :categoryName,  
            //     :categoryDescription)"
            // );

            $columns = implode(',', array_keys($postArray));
            $placeholders = ':' . implode(',:', array_keys($postArray));
            $stmt = $this->prepare("INSERT INTO categories ($columns) VALUES ($placeholders)");
            $this->bindValues($stmt, $postArray);
            $stmt->execute();

            // Commits the transaction and returns true to indicate success
            return $this->commit();
        } catch (PDOException $e) {
            // Rolls back the transaction if an error occurs
            $this->rollBack();

            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function updateCategory(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            // $stmt = $this->prepare(
            //     "UPDATE categories 
            //     SET userID = :userID,
            //         categoryType = :categoryType,
            //         categoryLink = :categoryLink,
            //         categoryName = :categoryName,
            //         categoryDescription = :categoryDescription
            //     WHERE categoryID = :categoryID"
            // );

            // Keep all keys to set, except for 'categoryID'
            $setArray = array_filter($postArray, fn ($key) => $key !== 'categoryID', ARRAY_FILTER_USE_KEY);
            $set = implode(',', array_map(fn ($key) => "$key = :$key", array_keys($setArray)));
            $stmt = $this->prepare("UPDATE categories SET $set WHERE categoryID = :categoryID");
            $this->bindValues($stmt, $postArray);
            $stmt->execute();

            // Commits the transaction and returns true to indicate success
            return $this->commit();
        } catch (PDOException $e) {
            // Rolls back the transaction if an error occurs
            $this->rollBack();

            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function deleteCategory(int $id): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            $stmt = $this->prepare("DELETE FROM categories WHERE categoryID = :id");
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();

            // Commits the transaction and returns true to indicate success
            return $this->commit();
        } catch (PDOException $e) {
            // Rolls back the transaction if an error occurs
            $this->rollBack();

            throw new Exception($e->getMessage());
        }
    }
}
