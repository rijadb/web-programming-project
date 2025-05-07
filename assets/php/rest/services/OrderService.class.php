<?php
require_once __DIR__ . '/../dao/OrderDao.class.php';

class OrderService
{
    private $order_dao;

    public function __construct()
    {
        $this->order_dao = new OrderDao();
    }


    public function get_all_orders()
    {
        return $this->order_dao->get_all_orders();
    }


    public function get_order($id)
    {
        return $this->order_dao->get_order_by_id($id);
    }


    public function add_order($order)
    {
        return $this->order_dao->add_order($order);
    }


    public function update_order($id, $order)
    {
        return $this->order_dao->edit_order($id, $order);
    }


    public function delete_order($id)
    {
        return $this->order_dao->delete_order($id);
    }
}
