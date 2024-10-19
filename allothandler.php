<?php
  session_start();
  require("db.php");

  // Check if admin is logged in
  if (!isset($_SESSION['admin_id'])) {
    header("Location: alogin.php");
    exit();
  }

  // ================== Assign Cleaner Handler =================== //
  if(isset($_POST['allotSubmit'])){
    // Validate and sanitize inputs
    $reqId = filter_input(INPUT_POST, 'allotId', FILTER_VALIDATE_INT);
    $cleanerId = filter_input(INPUT_POST, 'cleanerId', FILTER_VALIDATE_INT);

    if($reqId === false || $cleanerId === false) {
      $_SESSION['allotment_failed'] = "Invalid input data.";
      header("Location: allot.php");
      exit();
    }

    // Use prepared statement to prevent SQL injection
    $allot_query = "UPDATE service_requests SET cleaner_id = ?, status = 'Assigned' WHERE request_id = ?";
    $stmt = mysqli_prepare($db, $allot_query);
    
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "ii", $cleanerId, $reqId);
      $allot_result = mysqli_stmt_execute($stmt);

      if ($allot_result) {
        $_SESSION['worker_alloted'] = "Cleaner successfully assigned.";
      } else {
        $_SESSION['allotment_failed'] = "Failed to assign cleaner. Error: " . mysqli_stmt_error($stmt);
      }

      mysqli_stmt_close($stmt);
    } else {
      $_SESSION['allotment_failed'] = "Failed to prepare statement. Error: " . mysqli_error($db);
    }

    header("Location: allot.php");
    exit();
  }

  // ================== Register Cleaner Handler =================== //
  elseif(isset($_POST['regKeeperSubmit'])){
    // Validate and sanitize inputs
    $name = filter_input(INPUT_POST, 'regName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'regEmail', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'regPhone', FILTER_SANITIZE_STRING);

    if(!$name || !$email || !$phone) {
      $_SESSION['worker_registered'] = "Invalid input data.";
      header("Location: registercleaner.php");
      exit();
    }

    // Use prepared statement to prevent SQL injection
    $reg_query = "INSERT INTO cleaners (name, email, phone) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($db, $reg_query);

    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);
      $reg_result = mysqli_stmt_execute($stmt);

      if ($reg_result) {
        $_SESSION['worker_registered'] = 'New Cleaner Registered.';
      } else {
        $_SESSION['worker_registered'] = 'Registration Failed. Error: ' . mysqli_stmt_error($stmt);
      }

      mysqli_stmt_close($stmt);
    } else {
      $_SESSION['worker_registered'] = 'Failed to prepare statement. Error: ' . mysqli_error($db);
    }
    header("Location: registercleaner.php");
    exit();
  }

  // ================== Register User Handler =================== //
  elseif(isset($_POST['regSubmit'])){
    // Validate and sanitize inputs
    $name = filter_input(INPUT_POST, 'regName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'regEmail', FILTER_VALIDATE_EMAIL);
    $password = $_POST['regPassword']; // Do not sanitize password before hashing
    $phone = filter_input(INPUT_POST, 'regPhone', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'regAddress', FILTER_SANITIZE_STRING);

    if(!$name || !$email || !$password || !$phone || !$address) {
      $_SESSION['user_registered'] = "Invalid input data.";
      header("Location: registeruser.php");
      exit();
    }

    // Hash the password for security
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statement to prevent SQL injection
    $reg_query = "INSERT INTO users (username, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $reg_query);

    if ($stmt) {
      // Bind parameters
      mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $password, $phone, $address);
      $reg_result = mysqli_stmt_execute($stmt);

      if ($reg_result) {
        $_SESSION['user_registered'] = 'New User Registered.';
      } else {
        $_SESSION['user_registered'] = 'Registration Failed. Error: ' . mysqli_stmt_error($stmt);
      }

      mysqli_stmt_close($stmt);
    } else {
      $_SESSION['user_registered'] = 'Failed to prepare statement. Error: ' . mysqli_error($db);
    }
    header("Location: registeruser.php");
    exit();
  }

  // If none of the above conditions are met, redirect to login
  else {
    header("Location: alogin.php");
    exit();
  }
?>
