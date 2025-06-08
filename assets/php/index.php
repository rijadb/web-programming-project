<?php

require "vendor/autoload.php";


require "rest/routes/middleware_routes.php";

require "rest/routes/auth_routes.php";
require "rest/routes/user_routes.php";
require "rest/routes/cart_routes.php";
require "rest/routes/payment_routes.php";
require "rest/routes/product_routes.php";
require "rest/routes/order_routes.php";

// require "rest/routes/get_products.php";

Flight::route("GET /hello", function () {
    echo "HELLO";
});



Flight::route('OPTIONS *', function () {
    header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    Flight::halt(200);
});


Flight::before('start', function (&$params, &$output) {
    header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
});


Flight::start();
