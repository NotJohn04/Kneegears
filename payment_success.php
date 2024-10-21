
<?php
session_start();
require("db.php");
require("userfunctions.php");
require 'vendor/autoload.php';

if (isset($_GET['session_id'])) {
  $session_id = $_GET['session_id'];
  
  \Stripe\Stripe::setApiKey('sk_test_51QCOCIHOXQO4sOt91t8PmELtfQyWLqAn6kGeeSRx18Orf8rhRYmRqZnG6mdiF0R2lDlt2WrDsPGOq3K70V2fho6o00h9ZfPyf5');

  try {
    $session = \Stripe\Checkout\Session::retrieve($session_id);

    // Verify payment status
    if ($session->payment_status == 'paid') {
      $user_id = $session->client_reference_id;
      $reqDate = $session->metadata['reqDate'];
      $reqTime = $session->metadata['reqTime'];
      $amount = 100.00;

      $reqdate = date('Y-m-d', strtotime($reqDate));

      // Insert service request into the database
      $insert_request_query = "INSERT INTO service_requests(user_id, service_date, service_time, status) 
                               VALUES ('$user_id', '$reqdate', '$reqTime', 'Pending')";
      if (mysqli_query($db, $insert_request_query)) {
        $request_id = mysqli_insert_id($db);

        // Insert payment record
        $insert_payment_query = "INSERT INTO payments(request_id, user_id, amount, payment_method, status) 
                                 VALUES ('$request_id', '$user_id', '$amount', 'Credit Card', 'Completed')";
        if (mysqli_query($db, $insert_payment_query)) {
          $_SESSION['req_sent'] = "Service booked for $reqdate at $reqTime";
          header("Location: index.php");
          exit();
        } else {
          $_SESSION['req_failed'] = "Payment recorded but failed to update service request. Please contact support.";
        }
      } else {
        $_SESSION['req_failed'] = "Failed to create service request. Please contact support.";
      }
    } else {
      $_SESSION['req_failed'] = "Payment not completed. Please try again.";
    }
  } catch (\Stripe\Exception\ApiErrorException $e) {
    $_SESSION['req_failed'] = "Error retrieving payment details: " . $e->getMessage();
  }
} else {
  $_SESSION['req_failed'] = "Invalid payment session. Please try again.";
}

header("Location: payment.php");
exit();
?>
