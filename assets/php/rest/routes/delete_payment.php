<?php
require_once __DIR__ . '/../service/PaymentService.class.php';

header('Content-Type: application/json');

// Get payment ID from query parameters
$payment_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$payment_id) {
    echo json_encode(["status" => "error", "message" => "Payment ID is required"]);
    exit;
}

$payment_service = new PaymentService();

try {
    $payment_service->delete_payment($payment_id);
    echo json_encode(["status" => "success", "message" => "Payment deleted successfully"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
