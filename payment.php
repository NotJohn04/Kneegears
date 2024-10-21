<?php
session_start();
require("db.php");
require("userfunctions.php");
require 'vendor/autoload.php'; // Add this line for Stripe

// Initialize Stripe
\Stripe\Stripe::setApiKey('sk_test_51QCOCIHOXQO4sOt91t8PmELtfQyWLqAn6kGeeSRx18Orf8rhRYmRqZnG6mdiF0R2lDlt2WrDsPGOq3K70V2fho6o00h9ZfPyf5');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['reqDate']) || !isset($_SESSION['reqTime'])) {
  // If the required data is not available, redirect back to request page
  header("Location: request.php");
  exit();
}

// Handle payment form submission
if (isset($_POST['paySubmit'])) {
  $user_id = $_SESSION['user_id'];
  $reqDate = $_SESSION['reqDate'];
  $reqTime = $_SESSION['reqTime'];

  $payment_method = mysqli_real_escape_string($db, $_POST['payment_method']);
  $amount = 100.00; // Set your service amount

  // Format Date Before Submission
  $reqdate = date('Y-m-d', strtotime($reqDate));

  if ($payment_method === 'PayPal') {
    // Process PayPal payment
    // Since PayPal payment is handled via JavaScript, you can assume payment is successful
    // Insert service request into the database
    $insert_request_query = "INSERT INTO service_requests(user_id, service_date, service_time, status) 
                             VALUES ('$user_id', '$reqdate', '$reqTime', 'Pending')";
    if (mysqli_query($db, $insert_request_query)) {
      $request_id = mysqli_insert_id($db);

      // Insert payment record
      $insert_payment_query = "INSERT INTO payments(request_id, user_id, amount, payment_method, status) 
                               VALUES ('$request_id', '$user_id', '$amount', '$payment_method', 'Completed')";
      if (mysqli_query($db, $insert_payment_query)) {
        // Payment and service request successful
        $_SESSION['req_sent'] = "Service booked for $reqdate at $reqTime";
        // Clear session variables
        unset($_SESSION['reqDate']);
        unset($_SESSION['reqTime']);
        // Redirect to index or confirmation page
        header("Location: index.php");
        exit();
      } else {
        $_SESSION['req_failed'] = "Payment failed. Please try again.";
      }
    } else {
      $_SESSION['req_failed'] = "Failed to create service request. Please try again.";
    }
  } else if ($payment_method === 'Credit Card') {
    // For Stripe payments, the processing is handled in payment_success.php
    // So you don't need to do anything here
    // However, you might want to create a Stripe Checkout session here
    // try {
    //   $session = \Stripe\Checkout\Session::create([
    //     'payment_method_types' => ['card'],
    //     'line_items' => [[
    //       'price_data' => [
    //         'currency' => 'usd',
    //         'unit_amount' => $amount * 100, // Stripe expects amount in cents
    //         'product_data' => [
    //           'name' => 'Cleaning Service',
    //         ],
    //       ],
    //       'quantity' => 1,
    //     ]],
    //     'mode' => 'payment',
    //     'success_url' => 'https://yourdomain.com/payment_success.php',
    //     'cancel_url' => 'https://yourdomain.com/payment.php',
    //   ]);
    // } catch (\Stripe\Exception\CardException $e) {
    //   // Handle Stripe errors
    //   $_SESSION['req_failed'] = "Payment failed. Please try again.";
    // }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Payment - User Dashboard</title>
  <?php require("meta.php"); ?>
</head>
<body>
  <!-- Side Navigation -->
  <?php require("sidenav.php"); ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-background pb-6 pt-5 pt-md-6">
      <div class="container-fluid">
        <?php require("headerstats.php"); ?>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--5 pb-5">
      <div class="row mt-2">
        <div class="col-xl-12 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <h3 class="mb-0">Payment</h3>
            </div>
            <div class="card-body pb-5">
              <form method="POST" action="payment.php" id="payment-form">
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Service Details</label>
                        <p>Date: <?php echo htmlspecialchars($_SESSION['reqDate']); ?></p>
                        <p>Time: <?php echo htmlspecialchars($_SESSION['reqTime']); ?></p>
                        <p>Amount: $100.00</p>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label" for="payment_method">Payment Method <span class="text-danger">*</span></label>
                    <select name="payment_method" class="form-control" id="payment_method" required>
                      <option selected="true" value="" disabled="disabled">Select Payment Method</option>
                      <option value="Credit Card">Credit Card</option>
                      <option value="PayPal">PayPal</option>
                    </select>
                  </div>
                  <button name="paySubmit" id="submit-btn" class="btn btn-icon btn-3 btn-primary" type="submit">Pay and Book</button>
                  <div id="paypal-button-container" style="display: none;"></div>
                </div>
              </form>
              <!-- Handle error messages -->
              <?php if (isset($_SESSION['req_failed'])) : ?>
                <div class="alert alert-danger mt-3" role="alert">
                  <?php echo $_SESSION['req_failed']; unset($_SESSION['req_failed']); ?>
                </div>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/argon.min.js"></script>
  <script src="https://sandbox.paypal.com/sdk/js?client-id=AQCHjsKVftRQc1--yIpcn7kY5w32F7Kp5NS31HsmsVPtmHlmoUxfr-ajTrO6qrisTa_ZtTorXQto0n9r"></script>
  <script src="https://js.stripe.com/v3/"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const paymentMethod = document.getElementById('payment_method');
      const submitBtn = document.getElementById('submit-btn');
      const paypalContainer = document.getElementById('paypal-button-container');
      const form = document.getElementById('payment-form');

      paymentMethod.addEventListener('change', function() {
        if (this.value === 'PayPal') {
          submitBtn.style.display = 'none';
          paypalContainer.style.display = 'block';
        } else {
          submitBtn.style.display = 'block';
          paypalContainer.style.display = 'none';
        }
      });

      paypal.Buttons({
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '100.00'
              }
            }]
          });
        },
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
            // Set the payment method to PayPal
            paymentMethod.value = 'PayPal';
            // Submit the form
            form.submit();
          });
        }
      }).render('#paypal-button-container');

      // Add Stripe payment handling
      const stripe = Stripe('pk_test_51QCOCIHOXQO4sOt9LkNEHjCQPHgXMvrMzXacTIcLsO6pKBHW3vKLBFMvtynHVhXcx6twtZttf2DsrXFyo09E8k6c00Mo2wb48a');

      form.addEventListener('submit', function(event) {
        if (paymentMethod.value === 'Credit Card') {
          event.preventDefault();
          submitBtn.disabled = true;

          // Fetch the Stripe Checkout Session ID
          fetch('create_stripe_session.php', {
            method: 'POST',
          })
          .then(function(response) {
            return response.json();
          })
          .then(function(session) {
            return stripe.redirectToCheckout({ sessionId: session.id });
          })
          .then(function(result) {
            if (result.error) {
              alert(result.error.message);
              submitBtn.disabled = false;
            }
          })
          .catch(function(error) {
            console.error('Error:', error);
            submitBtn.disabled = false;
          });
        }
      });
    });
  </script>
</body>
</html>
