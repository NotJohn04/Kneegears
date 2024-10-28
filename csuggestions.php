<?php
session_start();
require("db.php");
require("cleanerfunctions.php");

if (!isset($_SESSION['cleaner_id'])) {
  header("Location: clogin.php");
  exit();
}

$cleaner_id = $_SESSION['cleaner_id'];
$suggestions = getCleanerSuggestions($cleaner_id, $db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cleaner Suggestions</title>
  <?php require("meta.php"); ?>
</head>
<body>
  <!-- Side Navigation -->
  <?php require("csidenav.php"); ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-background pb-6 pt-5 pt-md-6">
      <div class="container-fluid">
        <?php require("cheaderstats.php"); ?>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--5">
      <div class="row mt-2 pb-5">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3 class="mb-0">Suggestions</h3>
            </div>
            <div class="table-responsive">
              <!-- Suggestions table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">User</th>
                    <th scope="col">Service Date</th>
                    <th scope="col">Suggestion</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                if(count($suggestions) > 0){
                  foreach($suggestions as $suggestion){
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($suggestion['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($suggestion['service_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($suggestion['suggestion']) . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='3' class='text-center'>No suggestions available.</td></tr>";
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
