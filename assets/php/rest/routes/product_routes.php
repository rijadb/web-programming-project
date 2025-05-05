<?php

require_once __DIR__ . '/../services/ProductService.class.php';

Flight::set('product_service', new ProductService());

/**
 * @OA\Tag(
 *     name="products",
 *     description="Product management endpoints"
 * )
 */

Flight::group('/products', function () {

    /**
     * @OA\Get(
     *     path="/products",
     *     tags={"products"},
     *     summary="Get all products",
     *     @OA\Response(
     *         response=200,
     *         description="List of all products"
     *     )
     * )
     */
    Flight::route('GET /', function () {
        Flight::json(Flight::get('product_service')->get_all_products());
    });

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     tags={"products"},
     *     summary="Get product by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product data"
     *     )
     * )
     */
    Flight::route('GET /@id', function ($id) {
        Flight::json(Flight::get('product_service')->get_product_by_id($id));
    });

    /**
     * @OA\Post(
     *     path="/products",
     *     tags={"products"},
     *     summary="Add a new product",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","brand","description","gender","category","rating","price"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="brand", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="gender", type="string"),
     *             @OA\Property(property="category", type="string"),
     *             @OA\Property(property="rating", type="number", format="float"),
     *             @OA\Property(property="price", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product added successfully"
     *     )
     * )
     */
    Flight::route('POST /', function () {
        $data = Flight::request()->data->getData();
        Flight::json(Flight::get('product_service')->add_product($data));
    });

    /**
     * @OA\Put(
     *     path="/products/{id}",
     *     tags={"products"},
     *     summary="Update a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","brand","description","gender","category","rating","price"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="brand", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="gender", type="string"),
     *             @OA\Property(property="category", type="string"),
     *             @OA\Property(property="rating", type="number", format="float"),
     *             @OA\Property(property="price", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully"
     *     )
     * )
     */
    Flight::route('PUT /@id', function ($id) {
        $product = Flight::request()->data->getData();
        $product['id'] = $id;
        Flight::json(Flight::get('product_service')->edit_product($product));
    });

    /**
     * @OA\Delete(
     *     path="/products/{id}",
     *     tags={"products"},
     *     summary="Delete a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted successfully"
     *     )
     * )
     */
    Flight::route('DELETE /@id', function ($id) {
        Flight::get('product_service')->delete_product($id);
        Flight::json(['message' => 'Product deleted']);
    });
});
