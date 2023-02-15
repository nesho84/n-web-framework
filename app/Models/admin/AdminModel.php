<?php

class AdminModel extends Model
{
    //------------------------------------------------------------
    public function getTables(): array|string
    //------------------------------------------------------------
    {
        try {
            return $this->selectAll(
                table: 'information_schema.tables',
                fields: ['table_name', 'table_rows'],
                conditions: ['table_schema' => DB_NAME,],
                orderBy: 'table_name ASC',
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
