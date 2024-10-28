<?php
$stats = getCleanerStats($cleaner_id, $db);
?>
<div class="header-body">
  <!-- Card stats -->
  <div class="row">
    <!-- Service Requests Card -->
    <div class="col-lg-4 col-md-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <h5 class="card-title text-uppercase text-muted mb-0">Service Requests</h5>
          <span class="h2 font-weight-bold mb-0"><?php echo $stats['requestCount']; ?></span>
        </div>
      </div>
    </div>
    <!-- Feedback Card -->
    <div class="col-lg-4 col-md-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <h5 class="card-title text-uppercase text-muted mb-0">Feedback</h5>
          <span class="h2 font-weight-bold mb-0"><?php echo $stats['feedbackCount']; ?></span>
        </div>
      </div>
    </div>
    <!-- Suggestions Card -->
    <div class="col-lg-4 col-md-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <h5 class="card-title text-uppercase text-muted mb-0">Suggestions</h5>
          <span class="h2 font-weight-bold mb-0"><?php echo $stats['suggestionCount']; ?></span>
        </div>
      </div>
    </div>
  </div>
</div>
