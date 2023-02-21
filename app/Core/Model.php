<?php

class Model extends Database
{
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
            if (str_starts_with($key, ':')) {
                $placeholder = "$key";
            } else {
                $placeholder = ":$key";
            }

            $stmt->bindValue($placeholder, $value);
        }
    }

    //------------------------------------------------------------
    public function prepareInsert(string $table, array $postArray): PDOStatement
    //------------------------------------------------------------
    {
        $columns = implode(',', array_keys($postArray));
        $placeholders = ':' . implode(',:', array_keys($postArray));
        return $this->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
    }

    //------------------------------------------------------------
    public function prepareUpdate(string $table, string $primaryKey, array $postArray): PDOStatement
    //------------------------------------------------------------
    {
        // Keep all keys to set, except for 'primaryKey'
        $setArray = array_filter($postArray, fn ($key) => $key !== $primaryKey, ARRAY_FILTER_USE_KEY);
        $set = implode(',', array_map(fn ($key) => "$key = :$key", array_keys($setArray)));
        return $this->prepare("UPDATE $table SET $set WHERE $primaryKey = :$primaryKey");
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
}
