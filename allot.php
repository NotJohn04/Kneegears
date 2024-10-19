<?php 
  session_start();
  require("db.php");
  // require("allotfunctions.php");

  // Check if admin is logged in
  if (!isset($_SESSION['admin_id'])) {
    header("Location: alogin.php");
    exit();
  }

  // Handle logout
  if (isset($_GET['logout'])) {
    unset($_SESSION['username']);
    unset($_SESSION['admin_id']);
    session_destroy();
    header("Location: alogin.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Dashboard</title>
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
        <!-- Notification messages -->
        <?php if (isset($_SESSION['admin_logged'])) : ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
            <strong>Welcome to the Cleaning Service Admin Portal.</strong>
            <?php echo htmlspecialchars($_SESSION['admin_logged']); unset($_SESSION['admin_logged']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif ?>

        <?php if (isset($_SESSION['worker_alloted'])) : ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
            <strong><?php echo htmlspecialchars($_SESSION['worker_alloted']); ?></strong>
            <?php unset($_SESSION['worker_alloted']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif ?>

        <?php require("allotheader.php"); ?>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--5">
      <div class="row mt-2 pb-5">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Cleaning Services</h3>
            </div>
            <div class="table-responsive">
              <!-- Service Requests table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Cleaner</th>
                    <th scope="col">Address</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time Requested</th>
                    <th scope="col">Time In</th>
                    <th scope="col">Time Out</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                $info = getRequests($db);
                if(mysqli_num_rows($info) > 0){
                  while ($row = mysqli_fetch_assoc($info)) {
                ?>
                  <tr>
                    <th scope="row">
                    <?php 
                    // Check the status and display appropriate information
                    if($row['wid'] == NULL && $row['req_status'] == 'Pending'){
                      // If no cleaner assigned yet, show 'Assign Cleaner' button
                      echo "<a href='allotworker.php?request_id=". htmlspecialchars($row['request_id']) ."&address=".urlencode($row['address'])."&req_time=".date('h:i a', strtotime($row['cleaningtime']))."' class='btn btn-sm btn-primary'>Assign Cleaner</a>";
                    } else if ($row['wid'] != NULL && $row['req_status'] == 'Assigned'){
                      // If cleaner assigned but not completed
                      echo htmlspecialchars($row['name']) . " - Assigned";
                    } else if ($row['wid'] != NULL && $row['req_status'] == 'Completed'){
                      // If service is completed, show cleaner's name and rating
                      $numstars = intval($row['rating']);
                      $str = str_repeat("<i class='fas fa-star fa-xs' style='color:#f1c40f'></i>", $numstars);
                      echo htmlspecialchars($row['name']) ."<br>". $str;
                    }
                    ?>
                    </th>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo date('h:i a', strtotime($row['cleaningtime'])); ?></td>
                    <td><?php echo ($row['timein'] === NULL) ? "--" : date('h:i a', strtotime($row['timein'])); ?></td>
                    <td><?php echo ($row['timeout'] === NULL) ? "--" : date('h:i a', strtotime($row['timeout'])); ?></td>
                  </tr>
                <?php
                  }
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

  <!-- Include necessary scripts -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/argon.min.js"></script>
</body>
</html>
