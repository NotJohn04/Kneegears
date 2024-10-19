<?php 
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
  require("db.php");
  // require('userfunctions.php');

  $requestCount = getRequestCount($_SESSION['user_id'], $db);
  $complaintCount = getComplaintCount($_SESSION['user_id'], $db);
  $suggestionCount = getSuggestionCount($_SESSION['user_id'], $db);
?>
<div class="header-body">
  <!-- Card stats -->
  <div class="row">
    <!-- Service Requests Card -->
    <div class="col-lg-4 col-md-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Service Requests</h5>
              <span class="h2 font-weight-bold mb-0"><?php echo $requestCount; ?></span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                <i class="fas fa-chart-bar"></i>
              </div>
            </div>
          </div>
          <p class="mt-3 mb-0 text-muted text-sm">
            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?php echo $requestCount; ?></span>
            <span class="text-nowrap">Since last week</span>
          </p>
        </div>
      </div>
    </div>
    <!-- Suggestions Card -->
    <div class="col-lg-4 col-md-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Suggestions</h5>
              <span class="h2 font-weight-bold mb-0"><?php echo $suggestionCount; ?></span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                <i class="far fa-file-alt"></i>
              </div>
            </div>
          </div>
          <p class="mt-3 mb-0 text-muted text-sm">
            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?php echo $suggestionCount; ?></span>
            <span class="text-nowrap">Since last week</span>
          </p>
        </div>
      </div>
    </div>
    <!-- Complaints Card -->
    <div class="col-lg-4 col-md-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Complaints</h5>
              <span class="h2 font-weight-bold mb-0"><?php echo $complaintCount; ?></span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                <i class="fas fa-chart-pie"></i>
              </div>
            </div>
          </div>
          <p class="mt-3 mb-0 text-muted text-sm">
            <span class="text-danger mr-2"><i class="fas fa-arrow-up"></i> <?php echo $complaintCount; ?></span>
            <span class="text-nowrap">Since last month</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
