<?php

class Model extends Database
{
    // Initializes the database connection when creating an instance of the model
    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        parent::__construct();
    }

    //------------------------------------------------------------
    public function query(string $query): PDOStatement
    //------------------------------------------------------------
    {
        return $this->pdo->query($query);
    }

    //------------------------------------------------------------
    public function prepare(string $query): PDOStatement
    //------------------------------------------------------------
    {
        return $this->pdo->prepare($query);
    }

    //------------------------------------------------------------
    public function lastInsertId(string $name = null): int
    //------------------------------------------------------------
    {
        return $this->pdo->lastInsertId($name);
    }

    //------------------------------------------------------------
    public function beginTransaction(): bool
    //------------------------------------------------------------
    {
        return $this->pdo->beginTransaction();
    }

    //------------------------------------------------------------
    public function commit(): bool
    //------------------------------------------------------------
    {
        return $this->pdo->commit();
    }

    //------------------------------------------------------------
    public function rollback(): bool
    //------------------------------------------------------------
    {
        return $this->pdo->rollBack();
    }

    /**
     * Binds the array keys with values
     * * Example: 
     * * $model = new Model();
     * * $params = ['id' => $id];
     * * $model->bindValues($stmt, ['id' => $id]);
     * @param PDOStatement $stmt
     * @param array $bindArray
     * @return void
     */
    //------------------------------------------------------------
    public function bindValues(PDOStatement $stmt, array $bindArray): void
    //------------------------------------------------------------
    {
        foreach ($bindArray as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
    }
}
