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

    public function count_orders_paginated($search)
    {
        $query = "SELECT COUNT(*) AS count
                  FROM `order` 
                  WHERE userId LIKE CONCAT('%', :search, '%')
                  OR paymentId LIKE CONCAT('%', :search, '%');";

        return $this->query_unique($query, ["search" => $search]);
    }

    public function get_orders_paginated($offset, $limit, $search, $order_column, $order_direction)
    {
        $query = "SELECT * 
                  FROM `order` 
                  WHERE userId LIKE CONCAT('%', :search, '%')
                  OR paymentId LIKE CONCAT('%', :search, '%')
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT {$offset}, {$limit};";

        return $this->query($query, ["search" => $search]);
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
