<?php 
  session_start();
  require("db.php");
  // require("allotfunctions.php");

  if (!isset($_SESSION['admin_id'])) {
    header("Location: alogin.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Complaints - Admin Dashboard</title>
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
              <h3 class="mb-0">Complaints Record</h3>
            </div>
            <div class="table-responsive">
              <!-- Complaints table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Cleaner</th>
                    <th scope="col">Address</th>
                    <th scope="col">Date</th>
                    <th scope="col">Complaint</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                $info = getComplaints($db);
                if($info && mysqli_num_rows($info) > 0){
                  while ($row = mysqli_fetch_assoc($info)) {
                ?>
                  <tr>
                    <th scope="row">
                      <?php 
                      $numstars = intval($row['rating']);
                      $stars = str_repeat("<i class='fas fa-star fa-xs' style='color:#f1c40f'></i>", $numstars);
                      echo htmlspecialchars($row['name']) . "<br>" . $stars;
                      ?>
                    </th>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td style="max-width: 300px; overflow-wrap: break-word;">
                      <?php echo htmlspecialchars($row['complaint']); ?>
                    </td>
                  </tr>
                <?php
                  }
                } else {
                  echo "<tr><td colspan='4' class='text-center'>No complaints found.</td></tr>";
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

  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/argon.min.js"></script>
</body>
</html>
