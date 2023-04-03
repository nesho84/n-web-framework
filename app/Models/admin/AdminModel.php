<?php

class AdminModel extends Model
{
    //------------------------------------------------------------
    public function getTables(string $db_name): array
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT `table_name`, `table_rows`
                    FROM information_schema.tables 
                    WHERE table_schema = :db_name
                    ORDER BY table_name ASC");
            $this->bindValues($stmt, ['db_name' => $db_name]);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
