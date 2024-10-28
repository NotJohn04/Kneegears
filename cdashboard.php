<?php
session_start();
require("db.php");
require("cleanerfunctions.php");

if (!isset($_SESSION['cleaner_id'])) {
  header("Location: clogin.php");
  exit();
}

$cleaner_id = $_SESSION['cleaner_id'];
$cleaner_name = $_SESSION['cleaner_name'];

// Get assigned service requests
$service_requests = getCleanerServiceRequests($cleaner_id, $db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cleaner Dashboard</title>
  <?php require("meta.php"); ?>
</head>
<body>
  <!-- Side Navigation -->
  <?php require("csidenav.php"); ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-background pb-6 pt-5 pt-md-6">
      <div class="container-fluid">
        <?php require("cheaderstats.php"); ?>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--5">
      <div class="row mt-2 pb-5">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Assigned Service Requests</h3>
            </div>
            <div class="table-responsive">
              <!-- Service Requests table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Request ID</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Service Date</th>
                    <th scope="col">Service Time</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                if(count($service_requests) > 0){
                  foreach($service_requests as $request){
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($request['request_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($request['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($request['address']) . "</td>";
                    echo "<td>" . htmlspecialchars($request['service_date']) . "</td>";
                    echo "<td>" . date('h:i a', strtotime($request['service_time'])) . "</td>";
                    echo "<td>" . htmlspecialchars($request['status']) . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='6' class='text-center'>No assigned service requests.</td></tr>";
                }
                ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Include JS files -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/argon.min.js"></script>
</body>
</html>
