<?php require("server.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>User Registration</title>

  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">  

  <!-- Custom Style -->
  <link rel="stylesheet" href="assets/css/main.min.css">

  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
  <link rel="manifest" href="favicon/site.webmanifest">
</head>
<body>
  <header>
    <div class="row parent-row">
      <!-- Image -->
      <div class="col s1 l7 hide-on-med-and-down">
        <div class="flex-v-center">
          <h2>Kneegears</h2>
          <p>
            <span id="day_today"></span>
            <span id="date_today"></span>
            <span id="month_today"></span>
            <span id="circle">.</span>
            <span id="year_today"></span>
          </p>
          <p class="support-text">Get Your Rooms Cleaned at your time <br>with Just a click!</p>
        </div>
      </div>
      <!-- Form -->
      <div class="col s12 l5">
        <div class="center-align form-align">
          <h4 style="margin-bottom: 0px;">Create Account</h4>
          <p class="hide-on-large-only">Sign up to book services.</p>
          <div class="">
            <form action="" method="POST" autocomplete="off" class="col s12">
              <?php include("errors.php") ?>
              <!-- Username -->
              <div class="flex-h-center">
                <div class="input-field col s8">
                  <input name="userUsername" type="text" id="username" class="validate" required>
                  <label for="username">Username</label>
                </div>
              </div>
              <!-- Email -->
              <div class="flex-h-center">
                <div class="input-field col s8">
                  <input name="userEmail" type="email" id="email" class="validate" required>
                  <label for="email">Email</label>
                </div>
              </div>
              <!-- Phone -->
              <div class="flex-h-center">
                <div class="input-field col s8">
                  <input name="userPhone" type="text" id="phone" class="validate" required>
                  <label for="phone">Phone</label>
                </div>
              </div>
              <!-- Address -->
              <div class="flex-h-center">
                <div class="input-field col s8">
                  <input name="userAddress" type="text" id="address" class="validate" required>
                  <label for="address">Address</label>
                </div>
              </div>
              <!-- Password -->
              <div class="flex-h-center">
                <div class="input-field col s8">
                  <input name="userPass1" type="password" id="password1" class="validate" required>
                  <label for="password1">Password</label>
                </div>
              </div>
              <!-- Confirm Password -->
              <div class="flex-h-center">
                <div style="margin-bottom: 0px;" class="input-field col s8">
                  <input name="userPass2" type="password" id="password2" class="validate" required>
                  <label for="password2">Confirm Password</label>
                </div>
              </div>
              <button name="userRegister" type="submit" class="waves-effect waves-light btn">Register</button>
            </form>
            <a class="link" href="login.php">Already have an account? Login</a>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
