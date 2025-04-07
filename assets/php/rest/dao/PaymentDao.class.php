<?php

require_once __DIR__ . '/BaseDao.class.php';

class PaymentDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('payment'); // TABLE NAME PAYMENT in the database
    }

    // Add a new payment
    public function add_payment($payment)
    {
        return $this->insert("payment", $payment);
    }

    // Get all payments
    public function get_all_payments()
    {
        $query = "SELECT * FROM payment;";
        return $this->query($query, []);
    }

    // Get payment by ID
    public function get_payment_by_id($payment_id)
    {
        return $this->query_unique("SELECT * FROM payment WHERE id = :id", ["id" => $payment_id]);
    }

    // Edit an existing payment
    public function edit_payment($id, $payment)
    {
        $query = "UPDATE payment SET
                  shipmentId = :shipmentId,
                  cardName = :cardName,
                  cardNumber = :cardNumber,
                  expirationDate = :expirationDate,
                  ccv = :ccv
                  WHERE id = :id;";

        $this->execute(
            $query,
            [
                "shipmentId" => $payment["shipmentId"],
                "cardName" => $payment["cardName"],
                "cardNumber" => $payment["cardNumber"],
                "expirationDate" => $payment["expirationDate"],
                "ccv" => $payment["ccv"],
                "id" => $id
            ]
        );
    }

    // Delete a payment by ID
    public function delete_payment($id)
    {
        $query = "DELETE FROM payment WHERE id = :id";
        $this->execute($query, ["id" => $id]);
    }
}
