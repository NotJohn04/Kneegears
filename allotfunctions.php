<?php
  // Get Total Number of Service Requests
  function getRequestCount($db){
    $query_request_count = "SELECT COUNT(*) AS total_requests FROM service_requests";
    $result_request_count = mysqli_query($db, $query_request_count);
    $countRow = mysqli_fetch_assoc($result_request_count);
    return $countRow;
  }

  // Get Total Number of Complaints
  function getComplaintCount($db){
    $query_complaint_count = "SELECT COUNT(*) AS total_complaints FROM complaints";
    $result_complaint_count = mysqli_query($db, $query_complaint_count);
    $countRow = mysqli_fetch_assoc($result_complaint_count);
    return $countRow;
  }

  // Get Total Number of Suggestions
  function getSuggestionCount($db){
    $query_suggestion_count = "SELECT COUNT(*) AS total_suggestions FROM suggestions";
    $result_suggestion_count = mysqli_query($db, $query_suggestion_count);
    $countRow = mysqli_fetch_assoc($result_suggestion_count);
    return $countRow;
  }

  // Get Service Requests, Cleaners & Feedback Info
  function getRequests($db){
    $query_request = "SELECT sr.cleaner_id AS wid, sr.service_date AS date, sr.service_time AS cleaningtime, sr.status AS req_status, sr.request_id, c.name, f.rating, f.timein, f.timeout, u.address FROM 
    users u INNER JOIN service_requests sr ON u.user_id = sr.user_id
    LEFT JOIN cleaners c ON sr.cleaner_id = c.cleaner_id
    LEFT JOIN feedback f ON f.request_id = sr.request_id
    ORDER BY sr.service_date DESC";
    $result_request = mysqli_query($db, $query_request);
    return $result_request;
  }

  // Get Complaints in Detail
  function getComplaints($db){
    $query_complaints = "SELECT c.complaint, f.rating, sr.service_date AS date, cl.name, u.address FROM
    complaints c INNER JOIN feedback f ON c.feedback_id = f.feedback_id
    INNER JOIN service_requests sr ON f.request_id = sr.request_id
    INNER JOIN cleaners cl ON sr.cleaner_id = cl.cleaner_id
    INNER JOIN users u ON c.user_id = u.user_id
    ORDER BY sr.service_date DESC";
    $result_complaints = mysqli_query($db, $query_complaints);
    return $result_complaints;
  }

  // Get Suggestions in Detail
  function getSuggestions($db){
    $query_suggestions = "SELECT s.suggestion, f.rating, sr.service_date AS date, cl.name, u.address FROM
    suggestions s INNER JOIN feedback f ON s.feedback_id = f.feedback_id
    INNER JOIN service_requests sr ON f.request_id = sr.request_id
    INNER JOIN cleaners cl ON sr.cleaner_id = cl.cleaner_id
    INNER JOIN users u ON s.user_id = u.user_id
    ORDER BY sr.service_date DESC";
    $result_suggestions = mysqli_query($db, $query_suggestions);
    return $result_suggestions;
  }
?>
