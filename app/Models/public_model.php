<?php

//------------------------------------------------------------
function getActivePage(string $pageName): array|string
//------------------------------------------------------------
{
    // TODO: test
    $_SESSION["language"] = "al";
    // unset($_SESSION["language"]);

    try {
        $sql = DB->prepare(
            "SELECT * FROM pages 
            WHERE pageName = :pageName
            AND pageStatus = 1"
        );
        $sql->execute(['pageName' => $pageName]);

        $row = $sql->fetch(PDO::FETCH_ASSOC);

        // TODO: test
        $pageContentTranslated = getLanguage($_SESSION["language"], 111);

        if ($sql->rowCount() > 0) {
            return [
                'pageTitle' => $row['pageTitle'],
                'pageContent' => isset($_SESSION["language"]) ? $pageContentTranslated : $row['pageContent'],
                'PageMetaTitle' => $row['PageMetaTitle'],
                'PageMetaDescription' => $row['PageMetaDescription'],
                'PageMetaKeywords' => $row['PageMetaKeywords'],
            ];
        } else {
            $pageContent = '<div class="container py-5">
                                <h2>Sorry, this content isn\'t available right now</h2>
                                <hr class="mt-0" />
                                The link you opened may expired, or the page isn\'t active yet.
                            </div>';
            return [
                'pageTitle' => '',
                'pageContent' => $pageContent,
                'PageMetaTitle' => '',
                'PageMetaDescription' => '',
                'PageMetaKeywords' => '',
            ];
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

//------------------------------------------------------------
function getLanguage(string $languageCode, int $translationCode): string|null
//------------------------------------------------------------
{
    try {
        $sql = DB->prepare(
            "SELECT * FROM translations 
            WHERE languageCode = :languageCode
            AND translationCode = :translationCode"
        );
        $sql->execute([
            'languageCode' => $languageCode,
            'translationCode' => $translationCode
        ]);

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch(PDO::FETCH_ASSOC);

            return $row['translationText'];
        } else {
            return 'No translation found.';
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
