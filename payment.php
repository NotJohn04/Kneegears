<?php
session_start();
require("db.php");
require("userfunctions.php");

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
              <form method="POST" action="payment.php">
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
                  <button name="paySubmit" class="btn btn-icon btn-3 btn-primary" type="submit">Pay and Book</button>
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
</body>
</html>
