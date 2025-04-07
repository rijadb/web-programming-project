<?php

require_once __DIR__ . "/../service/ProductService.class.php";

$payload = $_REQUEST;

$product_service = new ProductService();

$data = $product_service->get_all_products();

echo json_encode([
    "data" => $data
]);
