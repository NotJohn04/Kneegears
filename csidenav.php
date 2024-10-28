<?php
// session_start();
require("db.php");

if (!isset($_SESSION['cleaner_id'])) {
  header("Location: clogin.php");
  exit();
}
if (isset($_GET['logout'])) {
  unset($_SESSION['cleaner_id']);
  unset($_SESSION['cleaner_name']);
  unset($_SESSION['cleaner_email']); // Added to clean up all cleaner session variables
  session_destroy();
  mysqli_close($db);
  header("Location: clogin.php");
  exit();
}
$cleaner_name = $_SESSION['cleaner_name'];

?>
<!-- SideNav -->
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
  <div class="container-fluid">
    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
      aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Brand -->
    <a class="navbar-brand pt-4" href="cdashboard.php">
    <h2><?php echo $_SESSION['cleaner_name']; ?></h2>
    </a>
    <!-- User -->
    <ul class="nav align-items-center d-md-none">
      <li class="nav-item dropdown">
        <a class="nav-link" href="cdashboard.php?logout='1'" role="button">
          <i class="ni ni-user-run"></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>
    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="sidenav-collapse-main">
      <!-- Navigation -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="cdashboard.php">
            <i class="ni ni-tv-2"></i>Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cfeedback.php">
            <i class="ni ni-archive-2"></i>Feedback
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="csuggestions.php">
            <i class="ni ni-bulb-61"></i>Suggestions
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cdashboard.php?logout='1'">
            <i class="ni ni-user-run"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
