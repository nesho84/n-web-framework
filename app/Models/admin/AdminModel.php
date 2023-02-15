<?php

class AdminModel extends Model
{
    //------------------------------------------------------------
    public function getTables(): array|string
    //------------------------------------------------------------
    {
        try {
            return $this->selectAll(
                'information_schema.tables',
                ['table_schema' => DB_NAME,],
                ['table_name', 'table_rows'],
                'table_name ASC',
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
