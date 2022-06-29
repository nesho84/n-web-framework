<?php

//------------------------------------------------------------
function findUserByEmail($email): array|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = "SELECT * FROM user WHERE userEmail = :email";
        $result = $db->prepare($sql);
        $result->bindParam(":email", $email);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
