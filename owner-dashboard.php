<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "smart_building", );

if (!isset($_SESSION['owner_id'])) {
    header("Location: owner-login.html");
    exit();
}

// Owner ki detail session se lein
$my_building = isset($_SESSION['society_name']) ? $_SESSION['society_name'] : 'Building'; 
$my_flat = $_SESSION['owner_flat']; 

// Pehle residents table se owner ka BLOCK pata karein
$res_query = mysqli_query($conn, "SELECT block_name FROM residents WHERE flat_no = '$my_flat' LIMIT 1");
$res_data = mysqli_fetch_assoc($res_query);
$my_block = $res_data['block_name'];

// 1. NOTICE FETCH
$notice_sql = "SELECT * FROM notices WHERE building_name = '$my_building' AND block_name = '$my_block' ORDER BY id DESC LIMIT 1";
$notice_query = mysqli_query($conn, $notice_sql);
$notice_data = mysqli_fetch_assoc($notice_query);

// 2. MAINTENANCE FETCH
$maint_sql = "SELECT * FROM maintenance WHERE flat_no = '$my_flat' AND block_name = '$my_block'";
$maint_query = mysqli_query($conn, $maint_sql);
$maint_data = mysqli_fetch_assoc($maint_query);

// 3. NAYA: OWNER KI COMPLAINTS FETCH KAREIN
$comp_sql = "SELECT * FROM complaints WHERE flat_no = '$my_flat' AND block_name = '$my_block' ORDER BY id DESC";
$comp_history_query = mysqli_query($conn, $comp_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Owner Dashboard - Stark Industries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="owner.css" rel="stylesheet">
</head>
<body>

<div class="dashboard-wrapper">
    <div class="card shadow p-5 mx-auto extra-wide-card">
        <h1 class="mb-4">Welcome, <?php echo $_SESSION['owner_name']; ?>!</h1>
        
        <div class="info-box mb-4">
            <p class="lead text-white">
                Building: <span class="fw-bold"><?php echo $my_building; ?></span> | 
                Block: <span class="fw-bold"><?php echo $my_block; ?></span> | 
                Flat: <span class="flat-number-display"><?php echo $my_flat; ?></span>
            </p>
        </div>

        <div class="row mt-4 g-4 justify-content-center">
            <div class="col-md-5">
                <button class="btn btn-action-info giant-btn w-100" data-bs-toggle="modal" data-bs-target="#maintModal">
                    <span class="icon">💰</span><br>View Maintenance
                </button>
            </div>
            <div class="col-md-5">
                <button class="btn btn-action-success giant-btn w-100" data-bs-toggle="modal" data-bs-target="#noticeModal">
                    <span class="icon">📢</span><br>Notice Board
                </button>
            </div>
            
            <div class="col-md-5">
                <button class="btn btn-warning w-100 shadow-sm py-3 fs-5 fw-bold" data-bs-toggle="modal" data-bs-target="#complaintModal">
                    📝 Register Complaint
                </button>
            </div>
            
            <div class="col-md-5">
                <button class="btn btn-secondary w-100 shadow-sm py-3 fs-5 fw-bold" data-bs-toggle="modal" data-bs-target="#complaintHistoryModal">
                    📋 Check Status
                </button>
            </div>
            
            <div class="col-md-10 mt-4">
                <a href="login.html" class="btn btn-danger w-100">Logout Account</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="noticeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Society Notice Board</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php if($notice_data): ?>
            <h4 class="text-dark"><?php echo $notice_data['title']; ?></h4>
            <hr>
            <p class="text-muted"><?php echo $notice_data['message']; ?></p>
        <?php else: ?>
            <div class="text-center p-3">
                <p class="text-muted">Aapke Block (<?php echo $my_block; ?>) ke liye abhi koi naya notice nahi hai.</p>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="maintModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Maintenance Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <?php if($maint_data): ?>
            <h2 class="display-6 mb-3">₹<?php echo $maint_data['amount']; ?></h2>
            <div class="mb-3">
                Status: 
                <span class="badge <?php echo ($maint_data['status'] == 'Paid') ? 'bg-success' : 'bg-danger'; ?> fs-5">
                    <?php echo $maint_data['status']; ?>
                </span>
            </div>
        <?php else: ?>
            <p class="text-muted">Aapke flat ka maintenance record abhi add nahi hua hai.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="complaintModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title fw-bold">Lodge a Complaint</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="submit_complaint.php" method="POST">
          <div class="modal-body">
              <label class="form-label fw-bold">Apni Problem Likhein:</label>
              <textarea name="complaint_text" class="form-control" rows="4" placeholder="Example: Lift is not working, Water issue..." required></textarea>
          </div>
          <div class="modal-footer">
              <button type="submit" name="send_complaint" class="btn btn-dark w-100">Send to Block <?php echo $my_block; ?> Secretary</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="complaintHistoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-white">
        <h5 class="modal-title fw-bold">My Complaints Status</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Complaint Details</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($comp_history_query) > 0): ?>
                        <?php while($comp = mysqli_fetch_assoc($comp_history_query)): ?>
                            <tr>
                                <td><?php echo $comp['complaint_text']; ?></td>
                                <td><?php echo date('d M Y', strtotime($comp['created_at'])); ?></td>
                                <td>
                                    <?php if($comp['status'] == 'Pending'): ?>
                                        <span class="badge bg-danger fs-6">Pending 🔴</span>
                                    <?php else: ?>
                                        <span class="badge bg-success fs-6">Solved 🟢</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="text-center text-muted py-4">Aapne abhi tak koi complaint nahi ki hai.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>