<?php

class LoginModel extends Model
{
    //------------------------------------------------------------
    public function findUserByEmail(string $email): array|bool
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM users WHERE userEmail = :email");
            $this->bindValues($stmt, array("email" => $email));
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
