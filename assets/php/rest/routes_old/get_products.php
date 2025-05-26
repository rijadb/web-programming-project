<?php
/**
 * @OA\Get(
 *      path="/get_products.php",
 *      tags={"products"},
 *      summary="Get all products",
 *      security={
 *          {"ApiKey":{}}
 *      },
 *      @OA\Response(
 *           response=200,
 *           description="Get all products"
 *      )
 * )
 */
require_once __DIR__ . "/../service/ProductService.class.php";

$payload = $_REQUEST;

$product_service = new ProductService();

$data = $product_service->get_all_products();

echo json_encode([
    "data" => $data
]);
