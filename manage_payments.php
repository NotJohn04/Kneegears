<?php 
  session_start();
  require("db.php");

  if (!isset($_SESSION['admin_id'])) {
    header("Location: alogin.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Manage Payments - Admin Dashboard</title>
  <?php require("meta.php"); ?>
</head>
<body>
  <!-- Side Navigation -->
  <?php require("allotsidenav.php"); ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-background pb-6 pt-5 pt-md-6">
      <div class="container-fluid">
        <?php require("allotheader.php"); ?>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--5">
      <div class="row mt-2 pb-5">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Payment Records</h3>
            </div>
            <div class="table-responsive">
              <!-- Payments table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Payment ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                    <!-- Add more columns as needed -->
                  </tr>
                </thead>
                <tbody>
                <?php 
                $query = "SELECT * FROM payments";
                $result = mysqli_query($db, $query);
                if($result && mysqli_num_rows($result) > 0){
                  while ($row = mysqli_fetch_assoc($result)) {
                ?>
                  <tr>
                    <td><?php echo htmlspecialchars($row['payment_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['amount']); ?></td>
                    <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo htmlspecialchars($row['payment_date']); ?></td>
                    <!-- Add more data as needed -->
                  </tr>
                <?php
                  }
                } else {
                  echo "<tr><td colspan='6' class='text-center'>No payment records found.</td></tr>";
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
