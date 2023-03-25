<?php

class InvoicesModel extends Model
{
    //------------------------------------------------------------
    public function getInvoices(): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare(
                "SELECT * FROM invoices AS i
                INNER JOIN users as u ON u.userID = i.userID
                INNER JOIN companies as co ON co.companyID = i.companyID
                ORDER BY i.invoiceDateCreated DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getCompanies(): array|string
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare("SELECT * FROM companies ORDER BY companyName ASC");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    // //------------------------------------------------------------
    // public function getCategoryById(int $id): array|string
    // //------------------------------------------------------------
    // {
    //     try {
    //         $stmt = $this->prepare("SELECT * FROM categories WHERE categoryID = :id");
    //         $this->bindValues($stmt, ['id' => $id]);
    //         $stmt->execute();
    //         return $stmt->fetch();
    //     } catch (PDOException $e) {
    //         throw new Exception($e->getMessage());
    //     }
    // }

    //------------------------------------------------------------
    public function insertInvoice(array $postArray): bool|string
    //------------------------------------------------------------
    {
        try {
            // start database transaction 
            $this->beginTransaction();

            // If companyArray is not empty Insert data into company table
            // ... and set $postArray['invoice']['companyID'] with lastInsertId
            if (!empty($postArray['company'])) {
                $stmt = $this->prepareInsert('companies', $postArray['company']);
                $this->bindValues($stmt, $postArray['company']);
                $stmt->execute();
                // Get the last inserted ID from the invoices table                
                $companyId = $this->lastInsertId();

                $postArray['invoice']['companyID'] = $companyId;
            }

            // Insert data into invoices table
            // get companyID if is not empty, or get the last insertedID of new company
            $stmt = $this->prepareInsert('invoices', $postArray['invoice']);
            $this->bindValues($stmt, $postArray['invoice']);
            $stmt->execute();
            // Get the last inserted ID from the invoices table
            $invoiceId = $this->lastInsertId();

            // Insert data into services table
            foreach ($postArray['services'] as $service) {
                $service['invoiceID'] = $invoiceId;
                $service['userID'] = $postArray['invoice']['userID'];
                $stmt = $this->prepareInsert('services', $service);
                $this->bindValues($stmt, $service);
                $stmt->execute();
            }

            // Commits the transaction and returns true to indicate success 
            return $this->commit();
        } catch (PDOException $e) {
            // rollback database transaction 
            $this->rollback();
            throw new Exception($e->getMessage());
        }
    }

    // //------------------------------------------------------------
    // public function updateCategory(array $postArray): bool|string
    // //------------------------------------------------------------
    // {
    //     try {
    //         // Starts a database transaction
    //         $this->beginTransaction();

    //         // $stmt = $this->prepare(
    //         //     "UPDATE categories 
    //         //     SET userID = :userID,
    //         //         categoryType = :categoryType,
    //         //         categoryLink = :categoryLink,
    //         //         categoryName = :categoryName,
    //         //         categoryDescription = :categoryDescription
    //         //     WHERE categoryID = :categoryID"
    //         // );

    //         $stmt = $this->prepareUpdate('categories', 'categoryID', $postArray);
    //         $this->bindValues($stmt, $postArray);
    //         $stmt->execute();

    //         // Commits the transaction and returns true to indicate success
    //         return $this->commit();
    //     } catch (PDOException $e) {
    //         // Rolls back the transaction if an error occurs
    //         $this->rollBack();
    //         throw new Exception($e->getMessage());
    //     }
    // }

    // //------------------------------------------------------------
    // public function deleteInvoice(int $id): bool|string
    // //------------------------------------------------------------
    // {
    //     try {
    //         // Starts a database transaction
    //         $this->beginTransaction();

    //         $stmt = $this->prepare("DELETE FROM invoices WHERE invoiceID = :id");
    //         $this->bindValues($stmt, ['id' => $id]);
    //         $stmt->execute();

    //          // @TODO: also delete services related to this invoice

    //         // Commits the transaction and returns true to indicate success
    //         return $this->commit();
    //     } catch (PDOException $e) {
    //         // Rolls back the transaction if an error occurs
    //         $this->rollBack();
    //         throw new Exception($e->getMessage());
    //     }
    // }
}
