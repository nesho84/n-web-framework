<?php

namespace App\Models;

use App\Core\Model;
use PDOException;
use Exception;

class UsersModel extends Model
{
    //------------------------------------------------------------
    public function getUsers(): array
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
    public function getUserById(string $id): array|bool
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
    public function getUsersExceptThis(string $id): array
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
    public function insertUser(array $postArray): int
    //------------------------------------------------------------
    {
        try {
            // start database transaction
            $this->beginTransaction();

            $stmt = $this->prepareInsert('users', $postArray);
            $this->bindValues($stmt, $postArray);
            $stmt->execute();

            $lastId = $this->lastInsertId();

            // Commits the transaction and returns true to indicate success
            $this->commit();

            return $lastId;
        } catch (PDOException $e) {
            // rollback database transaction
            $this->rollback();
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function updateUser(array $postArray): bool
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
    public function deleteUser(string $id): bool
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
