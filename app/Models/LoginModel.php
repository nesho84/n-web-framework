<?php

class LoginModel extends Model
{
    //------------------------------------------------------------
    public function findUserByEmail(string $email): array|string
    //------------------------------------------------------------
    {
        try {
            // Prepare the select statement
            $stmt = $this->prepare("SELECT * FROM users WHERE userEmail = :email");
            $this->bindValues($stmt, array("email" => $email));
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetch();
            // If a PDO query doesn't find any results, the PDOStatement::fetch() method will return false.
            return !$result ? "No account found with this email address." : $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
