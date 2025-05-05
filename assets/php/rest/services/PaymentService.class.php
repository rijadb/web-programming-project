<?php
require_once __DIR__ . '/../dao/PaymentDao.class.php';

class PaymentService
{
    private $payment_dao;

    public function __construct()
    {
        $this->payment_dao = new PaymentDao();
    }

    // Get all payments
    public function get_all_payments()
    {
        return $this->payment_dao->get_all_payments();
    }

    // Get payment by ID
    public function get_payment($id)
    {
        return $this->payment_dao->get_payment_by_id($id);
    }

    // Add a new payment
    public function add_payment($payment)
    {
        return $this->payment_dao->add_payment($payment);
    }

    // Update an existing payment
    public function update_payment($id, $payment)
    {
        return $this->payment_dao->edit_payment($id, $payment);
    }

    // Delete a payment by ID
    public function delete_payment($id)
    {
        return $this->payment_dao->delete_payment($id);
    }
}
