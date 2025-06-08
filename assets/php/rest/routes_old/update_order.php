<?php
require_once __DIR__ . '/../service/OrderService.class.php';
$order_service = new OrderService();

// Get JSON data from the PUT request body
parse_str(file_get_contents("php://input"), $_PUT);
echo json_encode($order_service->update_order($_GET['id'], $_PUT));
