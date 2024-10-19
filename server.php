<?php
session_start();
require("db.php");

$errors = array();

// ========================= USER LOGIN =======================
if(isset($_POST['userLogin'])){
  $username = mysqli_real_escape_string($db, $_POST['userUsername']);
  $password = mysqli_real_escape_string($db, $_POST['userPass']);
  // $password = md5($password); // Use password_hash in production

  $query_find_user = "SELECT * FROM users WHERE username='$username'";
  $result_find_user = mysqli_query($db,$query_find_user);

  if (mysqli_num_rows($result_find_user) == 1) {
    $row = mysqli_fetch_assoc($result_find_user);
    if($password == $row['password']){ // In production, use password_verify
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['username'] = $username;
      $_SESSION['user_logged'] = "You are now logged in";
      header("Location: index.php");
    } else {
      array_push($errors, "Wrong password! Please try again.");
    }
  } else {
    array_push($errors, "User not found!");
  }
}

// ========================= USER REGISTRATION =======================
if(isset($_POST['userRegister'])){
  $username = mysqli_real_escape_string($db, $_POST['userUsername']);
  $email = mysqli_real_escape_string($db, $_POST['userEmail']);
  $phone = mysqli_real_escape_string($db, $_POST['userPhone']);
  $address = mysqli_real_escape_string($db, $_POST['userAddress']);
  $password_1 = mysqli_real_escape_string($db, $_POST['userPass1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['userPass2']);
  // $password_1 = md5($password_1);
  // $password_2 = md5($password_2);

  if($password_1 == $password_2){
    $query_insert_user = "INSERT INTO users (username, email, phone, address, password) VALUES ('$username', '$email', '$phone', '$address', '$password_1')";
    $result_insert_user = mysqli_query($db, $query_insert_user);
    if($result_insert_user){
      $_SESSION['user_id'] = mysqli_insert_id($db);
      $_SESSION['username'] = $username;
      $_SESSION['user_logged'] = "You are now logged in";
      header("Location: index.php");
    } else {
      array_push($errors, "Failed to register user!");
    }
  } else {
    array_push($errors, "Passwords do not match!");
  }
}


// ========================= LOGIN ADMIN =======================
if(isset($_POST['adminLogin'])){
  $adminUsername = mysqli_real_escape_string($db, $_POST['adminUsername']);
  $adminPassword = $_POST['adminPassword']; // Don't escape the password before hashing
  
  $query_find_admin = "SELECT * FROM admins WHERE username = '$adminUsername'";
  // $stmt = mysqli_prepare($db, $query_find_admin);
  // mysqli_stmt_bind_param($stmt, "s", $adminUsername);
  // mysqli_stmt_execute($stmt);
  // $result_find_admin = mysqli_query($db, $query_find_admin);
  $result_find_admin = mysqli_query($db,$query_find_admin);
  
  if (mysqli_num_rows($result_find_admin) == 1) {
    $row = mysqli_fetch_assoc($result_find_admin);
    if($adminPassword == $row['password']){
      // Set session variables
      $_SESSION['admin_id'] = $row['admin_id'];
      $_SESSION['username'] = $adminUsername;
      // $_SESSION['hostel'] = $row['hostel']; // Store hostel in session
      $_SESSION['admin_logged'] = "You are now logged in";
      
      // Regenerate session ID for security
      // session_regenerate_id(true);
      
      header("Location: allot.php");
    } else {
      array_push($errors, "Wrong password! Please try again.");
    }
  } else {
    array_push($errors, "Admin not found!");
  }
}

?>
