<?php

//------------------------------------------------------------
function getTables(): array|string
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare("SELECT `table_name`, `table_rows`
                FROM information_schema.tables 
                WHERE table_schema = '" . DB_NAME . "'
                ORDER BY table_name ASC");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
