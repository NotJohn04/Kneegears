<?php 
  session_start();
  require("db.php");

  if (!isset($_SESSION['admin_id'])) {
    header("Location: alogin.php");
    exit();
  }
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
  <title>Register User - Admin Dashboard</title>
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
        <!-- notification message -->
        <?php if (isset($_SESSION['user_registered'])) : ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['user_registered']); unset($_SESSION['user_registered']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif ?>
        <?php require("allotheader.php"); ?>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--5 pb-6">
      <div class="row mt-2">
        <div class="col-xl-12 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <h3 class="mb-0">Register New User</h3>
            </div>
            <div class="card-body pb-5">
              <form method="POST" autocomplete="off" action="allothandler.php">
                <div class="pl-lg-4">
                  <div class="row">
                    <!-- Name -->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="regName" id="input-name" class="form-control" required placeholder="Username" maxlength="100">
                      </div>
                    </div>
                    <!-- Email -->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="regEmail" id="input-email" class="form-control" required placeholder="Email Address" maxlength="100">
                      </div>
                    </div>
                    <!-- Password -->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-password">Password <span class="text-danger">*</span></label>
                        <input type="password" name="regPassword" id="input-password" class="form-control" required placeholder="Password" minlength="8">
                      </div>
                    </div>
                    <!-- Phone -->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-phone">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="regPhone" id="input-phone" class="form-control" required placeholder="Phone Number" maxlength="15">
                      </div>
                    </div>
                    <!-- Address -->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-address">Address <span class="text-danger">*</span></label>
                        <input type="text" name="regAddress" id="input-address" class="form-control" required placeholder="Address" maxlength="255">
                      </div>
                    </div>
                  </div>
                  <button name="regSubmit" class="btn btn-icon btn-3 btn-primary" type="submit">
                    <span class="btn-inner--text">Register</span>
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
