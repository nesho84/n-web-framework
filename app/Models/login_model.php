<?php

//------------------------------------------------------------
function findUserByEmail(string $email): array|string
//------------------------------------------------------------
{
    // Connect to the database
    global $db;

    try {
        // Prepare the select statement
        $sql = "SELECT * FROM user WHERE userEmail = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the result
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        // If a PDO query doesn't find any results, the PDOStatement::fetch() method will return false. The fetch() method is used to retrieve a single row from the result set.
        if ($results === false) {
            return "No account found with this email address.";
        } else {
            return $results;
        }
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}
