<?php
require_once __DIR__ . '/../service/OrderService.class.php';
$order_service = new OrderService();
echo json_encode($order_service->get_order($_GET['id']));
