<?php
  // Get User Information
  function getUser($user_id, $db){
    $query_find_user = "SELECT * FROM users WHERE user_id='$user_id'";
    $result_find_user = mysqli_query($db, $query_find_user);
    if (mysqli_num_rows($result_find_user) == 1) {
      $user = mysqli_fetch_assoc($result_find_user);
      return $user;
    }
    return null;
  }

  // Get Number Of Requests for a User
  function getRequestCount($user_id, $db){
    $query_request_count = "SELECT COUNT(*) as count FROM service_requests WHERE user_id='$user_id'";
    $result_request_count = mysqli_query($db, $query_request_count);
    $countRow = mysqli_fetch_assoc($result_request_count);
    return $countRow['count'];
  }

  // Get Number Of Complaints for a User
  function getComplaintCount($user_id, $db){
    $query_complaint_count = "SELECT COUNT(*) as count FROM complaints WHERE user_id='$user_id'";
    $result_request_count = mysqli_query($db, $query_complaint_count);
    $countRow = mysqli_fetch_assoc($result_request_count);
    return $countRow['count'];
  }

  // Get Number Of Suggestions for a User
  function getSuggestionCount($user_id, $db){
    $query_suggestion_count = "SELECT COUNT(*) as count FROM suggestions WHERE user_id='$user_id'";
    $result_request_count = mysqli_query($db, $query_suggestion_count);
    $countRow = mysqli_fetch_assoc($result_request_count);
    return $countRow['count'];
  }

  // Get Service Requests and Feedback Info
  function getServiceRequests($user_id, $db){
    $query = "SELECT sr.request_id, sr.status, sr.service_date, sr.service_time, c.name AS cleaner_name, f.timein, f.timeout
              FROM service_requests sr
              LEFT JOIN cleaners c ON sr.cleaner_id = c.cleaner_id
              LEFT JOIN feedback f ON sr.request_id = f.request_id
              WHERE sr.user_id='$user_id'
              ORDER BY sr.service_date DESC";
    $result = mysqli_query($db, $query);
    return $result;
  }
?>