<?php
  session_start();
  require("db.php");

  // ================== Service Request Handler =================== //
  if(isset($_POST['reqSubmit']) && isset($_SESSION['user_id'])){
    // Store form data in session variables
    $_SESSION['reqDate'] = mysqli_real_escape_string($db, $_POST['reqDate']);
    $_SESSION['reqTime'] = mysqli_real_escape_string($db, $_POST['reqTime']);

    // Redirect to payment page
    header("Location: payment.php");
    exit();
  }

  // ================== Feedback Handler =================== //
  if(isset($_POST['feedSubmit']) && isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $feedReqid = mysqli_real_escape_string($db, $_POST['feedReqid']);
    $feedRating = mysqli_real_escape_string($db, $_POST['feedRating']);
    $feedTimein = mysqli_real_escape_string($db, $_POST['feedTimein']);
    $feedTimeout = mysqli_real_escape_string($db, $_POST['feedTimeout']);
    $feedSuggestion = mysqli_real_escape_string($db, $_POST['feedSuggestion']);
    $feedComplaints = mysqli_real_escape_string($db, $_POST['feedComplaints']);

    // Insert feedback
    $feed_query = "INSERT INTO feedback (user_id, request_id, rating, timein, timeout) 
                   VALUES ('$user_id', '$feedReqid', '$feedRating', '$feedTimein', '$feedTimeout')";
    if (mysqli_query($db, $feed_query)) {
      $_SESSION['feed_sent'] = "Feedback submitted successfully for request ID - " . $feedReqid;

      // Update service request status to 'Completed'
      mysqli_query($db, "UPDATE service_requests SET status = 'Completed' WHERE request_id = '$feedReqid'");

      // Handle suggestions
      if (!empty($feedSuggestion)) {
        $feedback_id = mysqli_insert_id($db);
        $suggest_query = "INSERT INTO suggestions (feedback_id, user_id, suggestion) 
                          VALUES ('$feedback_id', '$user_id', '$feedSuggestion')";
        mysqli_query($db, $suggest_query);
      }

      // Handle complaints
      if (!empty($feedComplaints)) {
        $feedback_id = mysqli_insert_id($db); // Ensure this is correct
        $complaint_query = "INSERT INTO complaints (feedback_id, user_id, complaint) 
                            VALUES ('$feedback_id', '$user_id', '$feedComplaints')";
        mysqli_query($db, $complaint_query);

        // Update cleaner's complaints count
        $cleaner_id_result = mysqli_query($db, "SELECT cleaner_id FROM service_requests WHERE request_id = '$feedReqid'");
        if ($cleaner_row = mysqli_fetch_assoc($cleaner_id_result)) {
          $cleaner_id = $cleaner_row['cleaner_id'];
          mysqli_query($db, "UPDATE cleaners SET complaints = complaints + 1 WHERE cleaner_id = '$cleaner_id'");
        }
      }

    } else {
      $_SESSION['feed_error'] = "Failed to submit feedback. Please try again.";
    }

    header("Location: feedback.php");
    exit();
  }
?>
