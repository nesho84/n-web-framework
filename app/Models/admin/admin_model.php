<?php

//------------------------------------------------------------
function getTables(): array|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = "SELECT table_name, table_rows
                FROM information_schema.tables 
                WHERE table_schema = '" . DB_NAME . "'
                ORDER BY table_name ASC";
        $result = $db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
