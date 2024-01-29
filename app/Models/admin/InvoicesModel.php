<?php

class InvoicesModel extends Model
{
    //------------------------------------------------------------
    public function getInvoices(): array
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
    public function getCompanies(): array
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

    //------------------------------------------------------------
    public function getInvoiceById(string $id): array|bool
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare(
                "SELECT * FROM invoices AS i
                INNER JOIN companies AS c ON c.companyID = i.companyID
                WHERE i.invoiceID = :id"
            );
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function getServicesByInvoiceId(string $id): array
    //------------------------------------------------------------
    {
        try {
            $stmt = $this->prepare(
                "SELECT * FROM services
                WHERE invoiceID = :id"
            );
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //------------------------------------------------------------
    public function insertInvoice(array $postArray): bool
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
    // public function updateInvoice(array $postArray): bool
    // //------------------------------------------------------------
    // {
    //     try {
    //         // Starts a database transaction
    //         $this->beginTransaction();

    //         $stmt = $this->prepareUpdate('invoices', 'invoiceID', $postArray);
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

    //------------------------------------------------------------
    public function deleteInvoice(string $id): bool
    //------------------------------------------------------------
    {
        try {
            // Starts a database transaction
            $this->beginTransaction();

            // Delete Invoice
            $stmt = $this->prepare("DELETE FROM invoices WHERE invoiceID = :id");
            $this->bindValues($stmt, ['id' => $id]);
            $stmt->execute();

            // Delete all Services related to this Invoice
            $stmt = $this->prepare("DELETE FROM services WHERE invoiceID = :id");
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
}
