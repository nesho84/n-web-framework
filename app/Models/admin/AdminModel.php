<?php

class AdminModel extends Model
{
    //------------------------------------------------------------
    public function getTables(string $db_name, array $tables): array
    //------------------------------------------------------------
    {
        // Step 2: Construct the SQL query with named placeholders
        // $sql = "SHOW TABLES IN $db_name WHERE Tables_in_$db_name IN (:table1, :table2, :table3)";
        $placeholders = ':' . implode(',:', array_keys($tables));

        try {
            $stmt = $this->prepare(
                "SHOW TABLE STATUS FROM $db_name 
                WHERE Name IN ($placeholders)"
            );
            $this->bindValues($stmt, $tables);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
