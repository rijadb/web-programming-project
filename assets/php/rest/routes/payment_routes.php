<?php

require_once __DIR__ . '/../services/PaymentService.class.php';

Flight::set('payment_service', new PaymentService());

/**
 * @OA\Tag(
 *     name="payment",
 *     description="Payment management endpoints"
 * )
 */

Flight::group('/payment', function () {

    /**
     * @OA\Get(
     *     path="/payment",
     *     tags={"payment"},
     *     summary="Get all payments",
     *     @OA\Response(
     *         response=200,
     *         description="Array of all payments"
     *     )
     * )
     */
    Flight::route('GET /', function () {
        Flight::json(Flight::get('payment_service')->get_all_payments());
    });

    /**
     * @OA\Get(
     *     path="/payment/{id}",
     *     tags={"payment"},
     *     summary="Get a payment by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment details"
     *     )
     * )
     */
    Flight::route('GET /@id', function ($id) {
        Flight::json(Flight::get('payment_service')->get_payment($id));
    });

    /**
     * @OA\Post(
     *     path="/payment",
     *     tags={"payment"},
     *     summary="Add a new payment",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="shipmentId", type="integer"),
     *                 @OA\Property(property="cardName", type="string"),
     *                 @OA\Property(property="cardNumber", type="string"),
     *                 @OA\Property(property="expirationDate", type="string"),
     *                 @OA\Property(property="ccv", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Payment added successfully"
     *     )
     * )
     */
    Flight::route('POST /', function () {
        $payment = Flight::request()->data->getData();
        Flight::json(Flight::get('payment_service')->add_payment($payment));
    });

    /**
     * @OA\Put(
     *     path="/payment/{id}",
     *     tags={"payment"},
     *     summary="Update an existing payment by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="shipmentId", type="integer"),
     *                 @OA\Property(property="cardName", type="string"),
     *                 @OA\Property(property="cardNumber", type="string"),
     *                 @OA\Property(property="expirationDate", type="string"),
     *                 @OA\Property(property="ccv", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment updated successfully"
     *     )
     * )
     */
    Flight::route('PUT /@id', function ($id) {
        $payment = Flight::request()->data->getData();
        Flight::json(Flight::get('payment_service')->update_payment($id, $payment));
    });

    /**
     * @OA\Delete(
     *     path="/payment/{id}",
     *     tags={"payment"},
     *     summary="Delete a payment by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment deleted successfully"
     *     )
     * )
     */
    Flight::route('DELETE /@id', function ($id) {
        Flight::get('payment_service')->delete_payment($id);
        Flight::json(['message' => 'Payment deleted']);
    });
});
