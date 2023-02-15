<?php

class Model
{
    private Database $db;

    // Initializes the database connection when creating an instance of the model
    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        $this->db = new Database();
    }

    // Reads records from the database table that match the specified conditions
    // Example: 
    // $model = new Model();
    // $users = $model->selectAll('user', ['userStatus' => 1], ['userID', 'userName', 'userEmail']);
    //------------------------------------------------------------
    protected function selectAll(string $table, array $fields = [], array $conditions = [], string $orderBy = '', int $limit = null): array
    //------------------------------------------------------------
    {
        try {
            $fields = empty($fields) ? '*' : implode(', ', $fields);
            $where = empty($conditions) ? '' : ' WHERE ' . implode(' AND ', array_map(fn ($key) => "$key = :$key", array_keys($conditions)));
            $orderBy = empty($orderBy) ? '' : " ORDER BY $orderBy";
            $limit = ($limit === null) ? null : " LIMIT $limit";
            $sql = "SELECT $fields FROM $table$where$orderBy$limit";
            $stmt = $this->db->prepare($sql);
            if (!empty($conditions)) {
                $this->bindParams($stmt, $conditions);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error while fetching data: " . $e->getMessage());
        }
    }

    // Reads records from the database table that match the specified conditions
    // Example: 
    // $model = new Model();
    // $users = $model->selectOne('user', ['userID', 'userName', 'userEmail'], ['userStatus' => 1]);
    //------------------------------------------------------------
    protected function selectOne(string $table, array $fields = [], array $conditions = []): array
    //------------------------------------------------------------
    {
        try {
            $fields = empty($fields) ? '*' : implode(', ', $fields);
            $where = empty($conditions) ? '' : ' WHERE ' . implode(' AND ', array_map(fn ($key) => "$key = :$key", array_keys($conditions)));
            $sql = "SELECT $fields FROM $table$where";
            $stmt = $this->db->prepare($sql);
            if (!empty($conditions)) {
                $this->bindParams($stmt, $conditions);
            }
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error while fetching data: " . $e->getMessage());
        }
    }

    // Creates a new record in the database table
    // Example: 
    // $model = new Model();
    // $data = ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '555-1234'];
    // $model->insert('users', $data);
    //------------------------------------------------------------
    protected function insert(string $table, array $data): bool
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->db->beginTransaction();

            // Constructs an SQL statement for inserting a new record into the table
            $columns = implode(',', array_keys($data));
            $placeholders = ':' . implode(',:', array_keys($data));
            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->db->prepare($sql);

            // Binds the values of the record to the prepared statement and executes the query
            $this->bindParams($stmt, $data);
            $stmt->execute();

            // Commits the transaction and returns true to indicate success
            $this->db->commit();

            // return (int)$this->db->lastInsertId();
            return true;
        } catch (PDOException $e) {
            // Rolls back the transaction if an error occurs and throws an exception with an error message            
            $this->db->rollBack();
            throw new Exception("Error creating record: " . $e->getMessage());
        }
    }

    // Updates records in the database table that match the specified conditions
    // Example: 
    // $model = new Model();
    // $data = ['name' => 'Jane Doe', 'email' => 'jane@example.com'];
    // $conditions = ['id' => 1];
    // $model->update('users', $data, $conditions);
    //------------------------------------------------------------
    protected function update(string $table, array $data, array $conditions): int
    //------------------------------------------------------------
    {
        try {
            $this->db->beginTransaction();

            $set = implode(',', array_map(fn ($key) => "$key = :$key", array_keys($data)));
            $where = implode(' AND ', array_map(fn ($key) => "$key = :$key", array_keys($conditions)));
            $sql = "UPDATE $table SET $set WHERE $where";
            $stmt = $this->db->prepare($sql);
            $this->bindParams($stmt, $data);
            $this->bindParams($stmt, $conditions);
            $stmt->execute();

            $rowCount = $stmt->rowCount();
            $this->db->commit();

            return (int) $rowCount;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw new Exception("Error updating record: " . $e->getMessage());
        }
    }

    // Deletes records in the database table that match the specified conditions
    // Example: 
    // $model = new Model();
    // $conditions = ['id' => 1];
    // $model->delete('users', $conditions);
    //------------------------------------------------------------
    protected function delete(string $table, array $conditions): int
    //------------------------------------------------------------
    {
        try {
            $this->db->beginTransaction();

            $where = implode(' AND ', array_map(fn ($key) => "$key = :$key", array_keys($conditions)));
            $sql = "DELETE FROM $table WHERE $where";
            $stmt = $this->db->prepare($sql);
            $this->bindParams($stmt, $conditions);
            $stmt->execute();

            $rowCount = $stmt->rowCount();
            $this->db->commit();

            return (int) $rowCount;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw new Exception("Error deleting record: " . $e->getMessage());
        }
    }

    //------------------------------------------------------------
    private function bindParams(PDOStatement $stmt, array $params): void
    //------------------------------------------------------------
    {
        foreach ($params as $key => $value) {
            $stmt->bindParam(":$key", $value, PDO::PARAM_STR);
        }
    }
}
