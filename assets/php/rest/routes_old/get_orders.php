<?php

require_once __DIR__ . "/../service/OrderService.class.php";

$payload = $_REQUEST;

$order_service = new OrderService();

$data = $order_service->get_all_orders();

echo json_encode([
    "data" => $data
]);
