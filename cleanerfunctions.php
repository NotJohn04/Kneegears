<?php
// Get service requests assigned to the cleaner
function getCleanerServiceRequests($cleaner_id, $db){
  $query = "SELECT sr.request_id, u.username, u.address, sr.service_date, sr.service_time, sr.status
            FROM service_requests sr
            INNER JOIN users u ON sr.user_id = u.user_id
            WHERE sr.cleaner_id='$cleaner_id'
            ORDER BY sr.service_date DESC";
  $result = mysqli_query($db, $query);
  $requests = array();
  while($row = mysqli_fetch_assoc($result)){
    $requests[] = $row;
  }
  return $requests;
}

// Get feedback for the cleaner
function getCleanerFeedback($cleaner_id, $db){
  $query = "SELECT f.*, u.username, sr.service_date, sr.service_time
            FROM feedback f
            INNER JOIN service_requests sr ON f.request_id = sr.request_id
            INNER JOIN users u ON sr.user_id = u.user_id
            WHERE sr.cleaner_id='$cleaner_id'
            ORDER BY sr.service_date DESC";
  $result = mysqli_query($db, $query);
  $feedbacks = array();
  while($row = mysqli_fetch_assoc($result)){
    $feedbacks[] = $row;
  }
  return $feedbacks;
}

// Get suggestions for the cleaner
function getCleanerSuggestions($cleaner_id, $db){
  $query = "SELECT s.*, u.username, sr.service_date, sr.service_time
            FROM suggestions s
            INNER JOIN feedback f ON s.feedback_id = f.feedback_id
            INNER JOIN service_requests sr ON f.request_id = sr.request_id
            INNER JOIN users u ON sr.user_id = u.user_id
            WHERE sr.cleaner_id='$cleaner_id'
            ORDER BY sr.service_date DESC";
  $result = mysqli_query($db, $query);
  $suggestions = array();
  while($row = mysqli_fetch_assoc($result)){
    $suggestions[] = $row;
  }
  return $suggestions;
}

// Get counts for header stats
function getCleanerStats($cleaner_id, $db){
  $service_requests = getCleanerServiceRequests($cleaner_id, $db);
  $feedbacks = getCleanerFeedback($cleaner_id, $db);
  $suggestions = getCleanerSuggestions($cleaner_id, $db);

  return array(
    'requestCount' => count($service_requests),
    'feedbackCount' => count($feedbacks),
    'suggestionCount' => count($suggestions)
  );
}
?>
