<?php

class AdminModel extends Model
{
    //------------------------------------------------------------
    public function getTables(string $db_name): array|string
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
            return $e->getMessage();
        }
    }
}
