<?php

require_once __DIR__ . "/../service/UserService.class.php";

$user_id = $_GET["id"] ?? null;

if ($user_id == null || $user_id == "") {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(["error" => "Missing or invalid user ID"]);
    exit;
}

$user_service = new UserService();
$user = $user_service->get_user_by_id($user_id);

if (!$user) {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["error" => "User not found"]);
    exit;
}

echo json_encode($user);
