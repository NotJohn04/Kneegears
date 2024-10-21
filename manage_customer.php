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
  <title>Manage Customer - Admin Dashboard</title>
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
              <h3 class="mb-0">Customer Records</h3>
            </div>
            <div class="table-responsive">
              <!-- Customer table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Created At</th>
                    <!-- Add more columns as needed -->
                  </tr>
                </thead>
                <tbody>
                <?php 
                $query = "SELECT * FROM users";
                $result = mysqli_query($db, $query);
                if($result && mysqli_num_rows($result) > 0){
                  while ($row = mysqli_fetch_assoc($result)) {
                ?>
                  <tr>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['password']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <!-- Add more data as needed -->
                  </tr>
                <?php
                  }
                } else {
                  echo "<tr><td colspan='4' class='text-center'>No customer records found.</td></tr>";
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