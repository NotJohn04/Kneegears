<?php
session_start();
require("db.php");
require("cleanerfunctions.php");

if (!isset($_SESSION['cleaner_id'])) {
  header("Location: clogin.php");
  exit();
}

$cleaner_id = $_SESSION['cleaner_id'];
$feedbacks = getCleanerFeedback($cleaner_id, $db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cleaner Feedback</title>
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
              <h3 class="mb-0">Feedback</h3>
            </div>
            <div class="table-responsive">
              <!-- Feedback table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">User</th>
                    <th scope="col">Service Date</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Time In</th>
                    <th scope="col">Time Out</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                if(count($feedbacks) > 0){
                  foreach($feedbacks as $feedback){
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($feedback['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($feedback['service_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($feedback['rating']) . "</td>";
                    echo "<td>" . htmlspecialchars($feedback['timein']) . "</td>";
                    echo "<td>" . htmlspecialchars($feedback['timeout']) . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='5' class='text-center'>No feedback available.</td></tr>";
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
