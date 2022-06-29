<?php

//------------------------------------------------------------
function getActivePage(string $pageName): array|string
//------------------------------------------------------------
{
    global $db;

    try {
        $sql = $db->prepare(
            "SELECT * FROM pages 
            WHERE pageName = :pageName
            AND pageStatus = 1"
        );
        $sql->execute(['pageName' => $pageName]);

        if ($sql->rowCount() > 0) {
            return $sql->fetch(PDO::FETCH_ASSOC);
        } else {
            return [
                'pageTitle' => '',
                'pageContent' =>
                '<div class="container py-5">
                    <h2>Sorry, this content isn\'t available right now</h2>
                    <hr class="mt-0" />
                    The link you opened may expired, or the page isn\'t active yet.
                 </div>',
                'PageMetaTitle' => '',
                'PageMetaDescription' => '',
                'PageMetaKeywords' => '',
            ];
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
