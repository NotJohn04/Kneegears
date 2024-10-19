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
  <title>Assign Cleaner - Admin Dashboard</title>
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
    <div class="container-fluid mt--5 pb-6">
      <div class="row mt-2">
        <div class="col-xl-12 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <h3 class="mb-0">Assign Cleaner</h3>
            </div>
            <div class="card-body pb-5">
              <form method="POST" autocomplete="off" action="allothandler.php">
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-control-label" for="input-id">Request ID</label>
                        <input type="text" name="allotId" id="input-id" class="form-control" readonly value="<?php echo isset($_GET['request_id']) ? htmlspecialchars($_GET['request_id']) : ''; ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-control-label" for="input-address">Address</label>
                        <input type="text" name="allotAddress" id="input-address" class="form-control" disabled value="<?php echo isset($_GET['address']) ? htmlspecialchars(urldecode($_GET['address'])) : ''; ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="form-control-label" for="input-time">Time Requested</label>
                        <input type="text" name="allotTime" id="input-time" class="form-control" disabled value="<?php echo isset($_GET['req_time']) ? htmlspecialchars($_GET['req_time']) : ''; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label class="form-control-label" for="input-cleaner">Cleaner<span class="text-danger">*</span></label>
                          <select name="cleanerId" class="form-control" id="input-cleaner" required>
                            <option selected="true" value="" disabled="disabled">Select Cleaner</option>
                            <?php
                            $cleaner_query = "SELECT cleaner_id, name FROM cleaners";
                            $cleaner_result = mysqli_query($db, $cleaner_query);
                            if($cleaner_result && mysqli_num_rows($cleaner_result) > 0){
                              while ($row = mysqli_fetch_assoc($cleaner_result)) {
                                echo "<option value=\"" . htmlspecialchars($row['cleaner_id']) . "\">" . htmlspecialchars($row['name']) . "</option>";
                              }
                            }
                            ?>
                          </select>
                        </div>
                    </div>
                  </div>
                  <button name="allotSubmit" class="btn btn-icon btn-3 btn-primary" type="submit">
                      <span class="btn-inner--text">Assign</span>
                  </button>
                </div>
              </form>
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
