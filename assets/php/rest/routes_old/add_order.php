<?php

require_once __DIR__ . '/../service/OrderService.class.php';
$order_service = new OrderService();

// Get JSON data from the POST request body
$order_data = json_decode(file_get_contents("php://input"), true);
echo json_encode($order_service->add_order($order_data));
