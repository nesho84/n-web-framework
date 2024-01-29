<?php

class CategoriesModel extends Model
{
    //------------------------------------------------------------
    public function getCategories(): array
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
    public function getCategoriesByType(string $ctype): array
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
    public function getCategoriesByName(string $cname): array
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
    public function getCategoryById(string $id): array|bool
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
    public function insertCategory(array $postArray): bool
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

            $stmt = $this->prepareInsert('categories', $postArray);
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
    public function updateCategory(array $postArray): bool
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

            $stmt = $this->prepareUpdate('categories', 'categoryID', $postArray);
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
    public function deleteCategory(string $id): bool
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
