<?php

require_once __DIR__ . '/BaseDao.class.php';

class OrderDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('order'); // TABLE NAME 'order' in database
    }

    public function add_order($order)
    {
        return $this->insert("order", $order);  // Insert order
    }

    public function delete_order($id)
    {
        $query = "DELETE FROM `order` WHERE id = :id";
        $this->execute($query, ["id" => $id]);
    }

    public function get_order_by_id($order_id)
    {
        return $this->query_unique("SELECT * FROM `order` WHERE id = :id", ["id" => $order_id]);
    }

    public function edit_order($id, $order)
    {
        $query = "UPDATE `order` SET
         userId = :userId,
         paymentId = :paymentId,
         total = :total
        WHERE id = :id;";

        $this->execute(
            $query,
            [
                "userId" => $order["userId"],
                "paymentId" => $order["paymentId"],
                "total" => $order["total"],
                "id" => $id
            ]
        );
    }

    public function get_all_orders()
    {
        $query = "SELECT * FROM `order`;";
        return $this->query($query, []);
    }
}
