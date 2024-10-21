<?php
require 'vendor/autoload.php';
session_start();

\Stripe\Stripe::setApiKey('sk_test_51QCOCIHOXQO4sOt91t8PmELtfQyWLqAn6kGeeSRx18Orf8rhRYmRqZnG6mdiF0R2lDlt2WrDsPGOq3K70V2fho6o00h9ZfPyf5');

header('Content-Type: application/json');

try {
  $checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
      'price_data' => [
        'currency' => 'usd',
        'unit_amount' => 10000, // $100.00 in cents
        'product_data' => [
          'name' => 'Cleaning Service',
        ],
      ],
      'quantity' => 1,
    ]],
    'mode' => 'payment',
    'client_reference_id' => $_SESSION['user_id'],
    'metadata' => [
      'reqDate' => $_SESSION['reqDate'],
      'reqTime' => $_SESSION['reqTime'],
    ],
    'success_url' => 'http://localhost/Cleanning_Management_System/payment_success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => 'http://localhost/Cleanning_Management_System/payment.php',
  ]);

  echo json_encode(['id' => $checkout_session->id]);
} catch (\Stripe\Exception\ApiErrorException $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}
