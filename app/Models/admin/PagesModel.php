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

    //------------------------------------------------------------
    public function insertPage(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            $columns = implode(',', array_keys($postArray));
            $placeholders = ':' . implode(',:', array_keys($postArray));
            $stmt = $this->prepare("INSERT INTO pages ($columns) VALUES ($placeholders)");
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
    public function updatePage(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            // Keep all keys to set, except for 'pageID'
            $setArray = array_filter($postArray, fn ($key) => $key !== 'pageID', ARRAY_FILTER_USE_KEY);
            $set = implode(',', array_map(fn ($key) => "$key = :$key", array_keys($setArray)));
            $stmt = $this->prepare("UPDATE pages SET $set WHERE pageID = :pageID");
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
    public function deletePage(int $id): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            $stmt = $this->prepare("DELETE FROM pages WHERE pageID = :id");
            $this->bindValues($stmt, [':id' => $id]);
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
