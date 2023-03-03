<?php

class PublicModel extends Model
{
    //------------------------------------------------------------
    public function getActivePage(string $pageName): array|string
    //------------------------------------------------------------
    {
        // @TODO: test
        // $_SESSION["language"] = "al";
        $_SESSION["languageID"] = 2;
        // unset($_SESSION["language"]);

        try {
            $stmt = $this->prepare(
                "SELECT * FROM pages 
                WHERE pageName = :pageName
                AND pageStatus = 1"
            );
            $this->bindValues($stmt, ['pageName' => $pageName]);
            $stmt->execute();

            $row = $stmt->fetch();

            // @TODO: test
            $pageContentTranslated = $this->getLanguage($_SESSION["languageID"], 111);

            if ($stmt->rowCount() > 0) {
                return [
                    'pageTitle' => $row['pageTitle'],
                    'pageContent' => isset($_SESSION["languageID"]) ? $pageContentTranslated : $row['pageContent'],
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
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getLanguage(string $languageID, int $translationCode): string|null
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare(
                "SELECT * FROM translations 
                WHERE languageID = :languageID
                AND translationCode = :translationCode"
            );
            $this->bindValues($stmt, [
                'languageID' => $languageID,
                'translationCode' => $translationCode
            ]);
            $stmt->execute();
            $row = $stmt->fetch();

            if ($stmt->rowCount() === 0) {
                return 'No translation found.';
            }

            return $row['translationText'];
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
