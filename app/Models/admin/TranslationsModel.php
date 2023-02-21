<?php

class TranslationsModel extends Model
{
    //------------------------------------------------------------
    public function getTranslations(): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM translations ORDER BY translationDateCreated DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getTranslationyById(int $id): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM translations WHERE translationID = :id");
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function insertTranslation(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            $columns = implode(',', array_keys($postArray));
            $placeholders = ':' . implode(',:', array_keys($postArray));
            $stmt = $this->prepare("INSERT INTO translations ($columns) VALUES ($placeholders)");
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
    public function updateTranslation(array $postArray): bool|string
    //------------------------------------------------------------
    {

        try {
            // Starts a database transaction
            $this->beginTransaction();

            // Keep all keys to set, except for 'pageID'
            $setArray = array_filter($postArray, fn ($key) => $key !== 'translationID', ARRAY_FILTER_USE_KEY);
            $set = implode(',', array_map(fn ($key) => "$key = :$key", array_keys($setArray)));
            $stmt = $this->prepare("UPDATE translations SET $set WHERE translationID = :translationID");
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
    public function deleteTranslation(int $id): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            $stmt = $this->prepare("DELETE FROM translations WHERE translationID = :id");
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
