<?php
require_once __DIR__ . '/../service/PaymentService.class.php';

header('Content-Type: application/json');

// Get data from POST body
$data = json_decode(file_get_contents('php://input'), true);

$payment_service = new PaymentService();

try {
    $payment = [
        "shipmentId" => $data['shipmentId'],
        "cardName" => $data['cardName'],
        "cardNumber" => $data['cardNumber'],
        "expirationDate" => $data['expirationDate'],
        "ccv" => $data['ccv']
    ];

    $result = $payment_service->add_payment($payment);
    echo json_encode(["status" => "success", "data" => $result]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
