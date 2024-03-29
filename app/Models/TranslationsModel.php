<?php

namespace App\Models;

use App\Core\Model;
use PDOException;
use Exception;

class TranslationsModel extends Model
{
    //------------------------------------------------------------
    public function getTranslations(): array
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
    public function getTranslationById(string $id): array|bool
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
    public function insertTranslation(array $postArray): bool
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
    public function updateTranslation(array $postArray): bool
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
    public function deleteTranslation(string $id): bool
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
