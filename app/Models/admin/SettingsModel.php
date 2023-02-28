<?php

class SettingsModel extends Model
{
    //------------------------------------------------------------
    public function getUsers(): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM users");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getUserById(int $id): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM users WHERE userID = :id");
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getSettingsByUserId(int $id): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM settings WHERE userID = :id");
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getUsersExceptThis(int $id): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM users WHERE userID != :id");
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function insertUser(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            // start database transaction
            $this->beginTransaction();

            $stmt = $this->prepareInsert('users', $postArray);
            $this->bindValues($stmt, $postArray);
            $stmt->execute();

            // Commits the transaction and returns true to indicate success
            return $this->commit();
        } catch (PDOException $e) {
            // rollback database transaction
            $this->rollback();
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function updateUser(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            $stmt = $this->prepareUpdate('users', 'userID', $postArray);
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
    public function deleteUser(int $id): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            $stmt = $this->prepare("DELETE FROM users WHERE userID = :id");
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
