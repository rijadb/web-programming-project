<?php
require_once __DIR__ . '/../service/PaymentService.class.php';

header('Content-Type: application/json');

// Get data from PUT body
$data = json_decode(file_get_contents('php://input'), true);

$payment_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$payment_id || !$data) {
    echo json_encode(["status" => "error", "message" => "Payment ID and data are required"]);
    exit;
}

$payment_service = new PaymentService();

try {
    $payment = [
        "shipmentId" => $data['shipmentId'],
        "cardName" => $data['cardName'],
        "cardNumber" => $data['cardNumber'],
        "expirationDate" => $data['expirationDate'],
        "ccv" => $data['ccv']
    ];

    $payment_service->update_payment($payment_id, $payment);
    echo json_encode(["status" => "success", "message" => "Payment updated successfully"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
