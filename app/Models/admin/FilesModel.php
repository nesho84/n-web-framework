<?php

class FilesModel extends Model
{
    //------------------------------------------------------------
    public function getFiles(): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM files ORDER BY fileDateCreated DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    // //------------------------------------------------------------
    // public function getCategoriesByType(string $ctype): array|string
    // //------------------------------------------------------------
    // {
    //     try {
    //         $stmt = $this->prepare("SELECT * FROM categories WHERE categoryType = :ctype");
    //         $this->bindValues($stmt, ['ctype' => $ctype]);
    //         $stmt->execute();
    //         return $stmt->fetchAll();
    //     } catch (PDOException $e) {
    //         throw new Exception($e->getMessage());
    //     }
    // }

    // //------------------------------------------------------------
    // public function getCategoriesByName(string $cname): array|string
    // //------------------------------------------------------------
    // {
    //     try {
    //         $stmt = $this->prepare("SELECT * FROM categories WHERE categoryName = :cname");
    //         $this->bindValues($stmt, ['cname' => $cname]);
    //         $stmt->execute();
    //         return $stmt->fetchAll();
    //     } catch (PDOException $e) {
    //         throw new Exception($e->getMessage());
    //     }
    // }

    // //------------------------------------------------------------
    // public function getCategoryById(int $id): array|string
    // //------------------------------------------------------------
    // {
    //     try {
    //         $stmt = $this->prepare("SELECT * FROM categories WHERE categoryID = :id");
    //         $this->bindValues($stmt, ['id' => $id]);
    //         $stmt->execute();
    //         return $stmt->fetch();
    //     } catch (PDOException $e) {
    //         throw new Exception($e->getMessage());
    //     }
    // }

    //------------------------------------------------------------
    public function insertFile(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            $stmt = $this->prepareInsert('files', $postArray);
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

    // //------------------------------------------------------------
    // public function updateCategory(array $postArray): bool|string
    // //------------------------------------------------------------
    // {
    //     try {
    //         // Starts a database transaction
    //         $this->beginTransaction();

    //         // $stmt = $this->prepare(
    //         //     "UPDATE categories 
    //         //     SET userID = :userID,
    //         //         categoryType = :categoryType,
    //         //         categoryLink = :categoryLink,
    //         //         categoryName = :categoryName,
    //         //         categoryDescription = :categoryDescription
    //         //     WHERE categoryID = :categoryID"
    //         // );

    //         $stmt = $this->prepareUpdate('categories', 'categoryID', $postArray);
    //         $this->bindValues($stmt, $postArray);
    //         $stmt->execute();

    //         // Commits the transaction and returns true to indicate success
    //         return $this->commit();
    //     } catch (PDOException $e) {
    //         // Rolls back the transaction if an error occurs
    //         $this->rollBack();
    //         throw new Exception($e->getMessage());
    //     }
    // }

    // //------------------------------------------------------------
    // public function deleteCategory(int $id): bool|string
    // //------------------------------------------------------------
    // {
    //     try {
    //         // Starts a database transaction
    //         $this->beginTransaction();

    //         $stmt = $this->prepare("DELETE FROM categories WHERE categoryID = :id");
    //         $this->bindValues($stmt, ['id' => $id]);
    //         $stmt->execute();

    //         // Commits the transaction and returns true to indicate success
    //         return $this->commit();
    //     } catch (PDOException $e) {
    //         // Rolls back the transaction if an error occurs
    //         $this->rollBack();
    //         throw new Exception($e->getMessage());
    //     }
    // }
}
