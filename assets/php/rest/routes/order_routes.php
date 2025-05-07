<?php

require_once __DIR__ . "/../services/OrderService.class.php";

Flight::set('order_service', new OrderService());

Flight::group("/orders", function () {

    /**
     * @OA\Get(
     *      path="/orders",
     *      tags={"orders"},
     *      summary="Get all orders",
     *      security={{"ApiKey":{}}},
     *      @OA\Response(response=200, description="Get all orders")
     * )
     */
    Flight::route("GET /", function () {
        $data = Flight::get("order_service")->get_all_orders();
        Flight::json($data);
    });

    /**
     * @OA\Get(
     *      path="/orders/{id}",
     *      tags={"orders"},
     *      summary="Get order by ID",
     *      security={{"ApiKey":{}}},
     *      @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", required=true),
     *      @OA\Response(response=200, description="Order data")
     * )
     */
    Flight::route("GET /@id", function ($id) {
        Flight::json(Flight::get("order_service")->get_order($id));
    });

    /**
     * @OA\Post(
     *      path="/orders",
     *      tags={"orders"},
     *      summary="Add new order",
     *      security={{"ApiKey":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"userId", "paymentId", "total"},
     *              @OA\Property(property="userId", type="integer", example=1),
     *              @OA\Property(property="paymentId", type="integer", example=5),
     *              @OA\Property(property="total", type="number", format="float", example=99.99)
     *          )
     *      ),
     *      @OA\Response(response=200, description="Order added")
     * )
     */
    Flight::route("POST /", function () {
        $payload = Flight::request()->data->getData();

        if (!isset($payload["userId"], $payload["paymentId"], $payload["total"])) {
            Flight::halt(400, "Missing required fields.");
        }

        if (!is_numeric($payload["total"]) || $payload["total"] <= 0) {
            Flight::halt(400, "Invalid total amount.");
        }

        $order = Flight::get("order_service")->add_order($payload);
        Flight::json(["message" => "Order created successfully", "data" => $order]);
    });

    /**
     * @OA\Put(
     *      path="/orders/{id}",
     *      tags={"orders"},
     *      summary="Update order by ID",
     *      security={{"ApiKey":{}}},
     *      @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", required=true),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="userId", type="integer", example=1),
     *              @OA\Property(property="paymentId", type="integer", example=5),
     *              @OA\Property(property="total", type="number", format="float", example=149.50)
     *          )
     *      ),
     *      @OA\Response(response=200, description="Order updated")
     * )
     */
    Flight::route("PUT /@id", function ($id) {
        $payload = Flight::request()->data->getData();

        if (!isset($payload["userId"], $payload["paymentId"], $payload["total"])) {
            Flight::halt(400, "Missing required fields.");
        }

        if (!is_numeric($payload["total"]) || $payload["total"] <= 0) {
            Flight::halt(400, "Invalid total amount.");
        }

        Flight::get("order_service")->update_order($id, $payload);
        Flight::json(["message" => "Order updated successfully"]);
    });

    /**
     * @OA\Delete(
     *      path="/orders/{id}",
     *      tags={"orders"},
     *      summary="Delete order by ID",
     *      security={{"ApiKey":{}}},
     *      @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", required=true),
     *      @OA\Response(response=200, description="Order deleted")
     * )
     */
    Flight::route("DELETE /@id", function ($id) {
        Flight::get("order_service")->delete_order($id);
        Flight::json(["message" => "Order deleted successfully"]);
    });
});
