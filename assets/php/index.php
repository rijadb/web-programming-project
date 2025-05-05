<?php

require "vendor/autoload.php";

require "rest/routes/user_routes.php";
// require "rest/routes/get_products.php";

Flight::route("GET /hello", function () {
    echo "HELLO";
});

Flight::start();
