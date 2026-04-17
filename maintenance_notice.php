<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Maintenance & Notice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="maintenance_notice.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .btn-update { background: #4e73df; color: white; border-radius: 10px; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="d-flex justify-content-between mb-4">
        <div>
            <h2>Secretary Control Panel</h2>
            <p class="text-muted">Updating for: <span id="displayInfo" class="fw-bold text-primary">Detecting...</span></p>
        </div>
        <a href="secretary-dashboard.php" class="btn btn-secondary">← Back</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card p-4">
                <h4 class="mb-3 text-primary">💰 Generate Block Maintenance</h4>
                <form action="process_updates.php" method="POST">
                    <div class="mb-3">
                        <label>Maintenance Amount (₹) for all Flats</label>
                        <input type="number" name="amount" class="form-control" placeholder="e.g. 1500" required>
                    </div>
                    <div class="alert alert-warning py-2 fs-6">
                        Ye amount block ke sabhi flats ke liye 'Pending' mark ho jayega.
                    </div>
                    <button type="submit" name="update_maintenance" class="btn btn-update w-100">Send Bill to All Owners</button>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4">
                <h4 class="mb-3 text-success">📢 Post New Notice</h4>
                <form action="process_updates.php" method="POST">
                    <div class="mb-3">
                        <label>Notice Title</label>
                        <input type="text" name="notice_title" class="form-control" placeholder="Meeting / Event" required>
                    </div>
                    <div class="mb-3">
                        <label>Message</label>
                        <textarea name="notice_msg" class="form-control" rows="5" placeholder="Write details..." required></textarea>
                    </div>
                    <button type="submit" name="add_notice" class="btn btn-success w-100">Broadcast Notice</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // LocalStorage se nikalenge (ya fir session se)
        const building = localStorage.getItem("loginBuilding");
        const block = localStorage.getItem("loginBlock");

        if (building && block) {
            document.getElementById("displayInfo").innerText = building + " (Block " + block + ")";
        } else {
            // Fallback: Agar localstorage me nahi hai, toh PHP session ka wait karenge
            document.getElementById("displayInfo").innerText = "Current Block";
        }
    });
</script>
</body>
</html>