<?php

class SettingsModel extends Model
{
    //------------------------------------------------------------
    public function getSettings(): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare(
                "SELECT * FROM settings as s
                INNER JOIN users as u ON u.userID = s.userID
                INNER JOIN languages as l ON l.languageID = s.languageID
                ORDER BY settingID ASC"
            );
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getSettingById(int $id): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM settings WHERE settingID = :id");
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getSettingsByUserId(int $id): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM settings WHERE userID = :id");
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function insertSetting(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            // start database transaction
            $this->beginTransaction();

            $stmt = $this->prepareInsert('settings', $postArray);
            $this->bindValues($stmt, $postArray);
            $stmt->execute();

            $lastId = $this->lastInsertId();

            // Commits the transaction and returns true to indicate success
            return $this->commit();
        } catch (PDOException $e) {
            // rollback database transaction
            $this->rollback();
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function updateSetting(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            $stmt = $this->prepareUpdate('settings', 'settingID', $postArray);
            $this->bindValues($stmt, $postArray);
            $stmt->execute();

            // Commits the transaction and returns true to indicate success
            return $this->commit();
        } catch (PDOException $e) {
            // Rolls back the transaction if an error occurs
            $this->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function deleteSetting(int $id): bool|string
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            $stmt = $this->prepare("DELETE FROM settings WHERE settingID = :id");
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();

            // Commits the transaction and returns true to indicate success
            return $this->commit();
        } catch (PDOException $e) {
            // Rolls back the transaction if an error occurs
            $this->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function backupDatabase(string $directory): bool|string
    //------------------------------------------------------------
    {
        // Generate a random file name
        $dumpfile = BACKUPS_PATH . '/' . date('dmY') . '_' . substr(md5(rand()), 0, 10) . '_backup.sql';

        try {
            // MySQL Connection
            $db_host = DB_HOST;
            $db_user = DB_USER;
            $db_password = DB_PASS;
            $db_name = DB_NAME;

            // Build the command to execute mysqldump
            // $command = "mysqldump --host={$db_host} --user={$db_user} --password={$db_password} {$db_name} > {$dumpfile} 2>&1";
            // $command = "mysqldump --host={$db_host} --user={$db_user} --password={$db_password} {$db_name} > {$dumpfile} 2> {$dumpfile}.error";

            $command = "mysqldump --host={$db_host} --user={$db_user} --password={$db_password} $db_name > $dumpfile";

            // Execute the command
            exec($command, $output, $return);

            // Check if the backup file was created
            if ($return === 0 && file_exists($dumpfile) && filesize($dumpfile) > 0) {
                return true;
            } else {
                // Delete the backup file from the server
                if (file_exists($dumpfile)) {
                    unlink($dumpfile);
                }
                // Throw an exception with the error message
                throw new Exception("Backup failed. Please Check Your Database Configuration." . implode("\n", $output), $return);
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
