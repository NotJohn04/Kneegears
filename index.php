<?php 
  session_start();
  require("db.php");
  require("userfunctions.php");

  if (!isset($_SESSION['user_id'])) {
  	header("Location: login.php");
  	exit();
  }
  if (isset($_GET['logout'])) {
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    session_destroy();
    mysqli_close($db);
  	header("Location: login.php");
  	exit();
  }

  // Fetch user data
  $user = getUser($_SESSION['user_id'], $db);

  // Fetch counts
  $requestCount = getRequestCount($_SESSION['user_id'], $db);
  $complaintCount = getComplaintCount($_SESSION['user_id'], $db);
  $suggestionCount = getSuggestionCount($_SESSION['user_id'], $db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>User Dashboard</title>
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
        <!-- notification message -->
        <?php if (isset($_SESSION['req_sent'])) : ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
            <?php echo $_SESSION['req_sent']; unset($_SESSION['req_sent']); ?>
            </span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif ?>

        <!-- notification message -->
        <?php if (isset($_SESSION['req_failed'])) : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['req_failed']; unset($_SESSION['req_failed']); ?>
            </span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif ?>

        <?php 
        require("headerstats.php"); ?>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--5">
      <div class="row mt-2 pb-5">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Housekeeping</h3>
                </div>
                <div class="col text-right">
                  <a href="request.php" class="btn btn-sm btn-primary">Send Request</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Housekeeper</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time Requested</th>
                    <th scope="col">Time In</th>
                    <th scope="col">Time Out</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $requestrows = getServiceRequests($_SESSION['user_id'], $db);
                    if (mysqli_num_rows($requestrows) > 0) {
                        while ($row = mysqli_fetch_assoc($requestrows)) {
                    ?>
                            <tr>
                                <th scope="row">
                                    <?php
                                    if ($row['cleaner_name'] === NULL && $row['status'] == 'Pending') {
                                        echo "<span class='text-warning'>Not Assigned</span> - " . $row['request_id'];
                                    } elseif ($row['cleaner_name'] !== NULL && $row['status'] == 'Assigned') {
                                        echo $row['cleaner_name'] . " - <span class='text-info'>Assigned</span> - " . $row['request_id'];
                                    } elseif ($row['cleaner_name'] !== NULL && $row['status'] == 'Completed') {
                                        echo $row['cleaner_name'] . " - <span class='text-success'>Completed</span> - " . $row['request_id'];
                                    }
                                    ?>
                                </th>
                                <td><?php echo htmlspecialchars($row['service_date']); ?></td>
                                <td><?php echo date('h:i a', strtotime($row['service_time'])); ?></td>
                                <td>
                                    <?php
                                    echo empty($row['timein']) ? "<span class='text-warning'>--</span>" : date('h:i a', strtotime($row['timein']));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo empty($row['timeout']) ? "<span class='text-warning'>--</span>" : date('h:i a', strtotime($row['timeout']));
                                    ?>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='5'>No service requests found.</td></tr>";
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
