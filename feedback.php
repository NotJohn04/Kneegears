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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Feedback Form - User Dashboard</title>
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
          <?php if (isset($_SESSION['feed_sent'])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
              <?php echo $_SESSION['feed_sent']; unset($_SESSION['feed_sent']); ?>
              </span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif ?>
          <?php require("headerstats.php"); ?>
        </div>
      </div>
      <!-- Page content -->
      <div class="container-fluid mt--5 pb-6">
        <div class="row mt-2">
          <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
              <div class="card-header bg-white border-0">
                <h3 class="mb-0">Service Feedback</h3>
              </div>
              <div class="card-body pb-5">
                <form method="POST" autocomplete="off" action="userhandler.php">
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-requestid">Request ID <span class="text-danger">*</span></label>
                          <select name="feedReqid" class="form-control" id="input-requestid" required>
                            <option selected="true" value="" disabled="disabled">Select Option</option>
<?php
// Include database connection
require("db.php");
// Get Request IDs for feedback
$user_id = $_SESSION['user_id'];
$reqids_query = "SELECT sr.request_id, c.name 
                 FROM service_requests sr 
                 INNER JOIN cleaners c ON sr.cleaner_id = c.cleaner_id 
                 WHERE sr.status = 'Assigned' AND sr.user_id = '$user_id'";
$reqids_result = mysqli_query($db, $reqids_query);
if (mysqli_num_rows($reqids_result) > 0) {
  while ($row = mysqli_fetch_assoc($reqids_result)) {
?>
    <option value="<?php echo $row['request_id']; ?>">
      <?php echo $row['request_id'] . " - " . $row['name']; ?>
    </option>
<?php 
  }
} else {
  echo '<option disabled>No pending feedback requests</option>';
}
?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-rating">Rate Service <span class="text-danger">*</span></label>
                          <select name="feedRating" class="form-control" id="input-rating" required>
                            <option selected="true" value="" disabled="disabled">Select Option</option>
                            <option value="1">1 - Poor Service</option>
                            <option value="2">2 - Not Satisfied</option>
                            <option value="3">3 - Satisfactory</option>
                            <option value="4">4 - Good Service</option>
                            <option value="5">5 - Excellent Work</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-timein">Time In <span class="text-danger">*</span></label>
                          <input name="feedTimein" type="time" id="input-timein" class="form-control form-control-alternative" required>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-timeout">Time Out <span class="text-danger">*</span></label>
                          <input name="feedTimeout" type="time" id="input-timeout" class="form-control form-control-alternative" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-suggestions">Suggestions</label>
                          <textarea name="feedSuggestion" class="form-control form-control-alternative" id="input-suggestions" rows="3" placeholder="We'd love to hear some suggestions..."></textarea>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-complaints">Complaints</label>
                          <textarea name="feedComplaints" class="form-control form-control-alternative" id="input-complaints" rows="3" placeholder="Got complaints about our service?"></textarea>
                        </div>
                      </div>
                    </div>
                    <button name="feedSubmit" class="btn btn-icon btn-3 btn-primary" type="submit">
                        <span class="btn-inner--text">Submit</span>
                    </button>
                  </div>
                </form>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    
</body>
</html>
