<?php require("server.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cleaner Login</title>

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
      <!-- Left side content -->
      <div class="col s1 l7 hide-on-med-and-down">
        <div class="flex-v-center">
          <h2>Cleaner Portal</h2>
          <p class="support-text">Access your cleaning service requests and feedback.</p>
        </div>
      </div>
      <!-- Login Form -->
      <div class="col s12 l5">
        <div class="center-align form-align">
          <h4>Cleaner Sign In</h4>
          <div class="row">
            <form action="" method="POST" autocomplete="off" class="col s12">
              <?php include("errors.php") ?>
              <div class="row flex-h-center mb-0">
                <div class="input-field col s8">
                  <input type="email" name="cleanerEmail" id="cleanerEmail" class="validate" required>
                  <label for="cleanerEmail">Email</label>
                </div>
                <div class="input-field col s8">
                  <input type="password" name="cleanerPassword" id="cleanerPassword" class="validate" required>
                  <label for="cleanerPassword">Password</label>
                </div>
              </div>
              <button type="submit" name="cleanerLogin" class="waves-effect waves-light btn">Login</button>
            </form>
            <a class="link" href="login.php">User Login</a>
            <br>
            <a class="link" href="alogin.php">Admin Login</a>
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
