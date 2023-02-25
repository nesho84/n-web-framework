<?php

class TranslationsModel extends Model
{
    //------------------------------------------------------------
    public function getTranslations(): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare(
                "SELECT * FROM translations as t
                INNER JOIN languages as l
                ON l.languageID = t.languageID
                ORDER BY translationCode DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getTranslationById(int $id): array|string
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

            $stmt = $this->prepareInsert('translations', $postArray);
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

            $stmt = $this->prepareUpdate('translations', 'translationID', $postArray);
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
