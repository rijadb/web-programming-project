<?php

require_once __DIR__ . '/../services/CartService.class.php';

Flight::set('cart_service', new CartService());

/**
 * @OA\Tag(
 *     name="cart",
 *     description="Cart management endpoints"
 * )
 */

Flight::group('/cart', function () {

    /**
     * @OA\Get(
     *     path="/cart",
     *     tags={"cart"},
     *     summary="Get all carts",
     *     @OA\Response(
     *         response=200,
     *         description="Array of all carts"
     *     )
     * )
     */
    Flight::route('GET /', function () {
        Flight::json(Flight::get('cart_service')->get_all_carts());
    });

    /**
     * @OA\Get(
     *     path="/cart/products/{cartId}",
     *     tags={"cart"},
     *     summary="Get all products in a cart by cart ID",
     *     @OA\Parameter(
     *         name="cartId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of cart products"
     *     )
     * )
     */
    Flight::route('GET /products/@cartId', function ($cartId) {
        Flight::json(Flight::get('cart_service')->get_cart_products($cartId));
    });

    /**
     * @OA\Get(
     *     path="/cart/user/{userId}",
     *     tags={"cart"},
     *     summary="Get all products in a cart by user ID",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of cart products for the user"
     *     )
     * )
     */
    Flight::route('GET /user/@userId', function ($userId) {
        Flight::json(Flight::get('cart_service')->get_user_cart_products($userId));
    });

    /**
     * @OA\Delete(
     *     path="/cart/product/{id}",
     *     tags={"cart"},
     *     summary="Delete a product from the cart by cartProduct ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted from cart"
     *     )
     * )
     */
    Flight::route('DELETE /product/@id', function ($id) {
        Flight::get('cart_service')->delete_cart_product($id);
        Flight::json(['message' => 'Cart product deleted']);
    });
});
