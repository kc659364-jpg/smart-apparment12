<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretary Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="secretar-dashboard.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="dashboard-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Secretary Dashboard</h2>
            <a href="login.html" class="btn btn-outline-danger">Logout</a>
        </div>

        <div class="mb-4">
            <a href="secretary.html" class="btn btn-primary me-2 shadow-sm">➕ Create Owner</a>
            <a href="security-dashboard.php" class="btn btn-warning shadow-sm">🛡️ Security Dashboard</a>
            <a href="maintenance_notice.php" class="btn btn-success shadow-sm">🛡️ maintance & notice</a>
        </div>

        <hr>
        <div class="alert alert-light border">
            Selected Block: <span id="blockDisplay" class="status-badge">Detecting...</span>
        </div>
        <hr>

        <h4>Owner Details</h4>
        <div id="ownerDetails" class="table-responsive mt-3">
            <p class="text-muted">Loading residents data...</p>
        </div>

        <hr class="mt-5">
        <h4 class="text-danger">🚨 Pending Complaints (Block <span id="compBlockDisplay"></span>)</h4>
        <div id="complaintDetails" class="table-responsive mt-3 mb-5">
            <p class="text-muted">Loading complaints...</p>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. LocalStorage se block uthao
    const block = localStorage.getItem("loginBlock");
    const blockDisplay = document.getElementById("blockDisplay");
    const ownerDiv = document.getElementById("ownerDetails");
    
    // Naye elements
    const compBlockDisplay = document.getElementById("compBlockDisplay");
    const complaintDiv = document.getElementById("complaintDetails");

    if (block && block !== "null") {
        blockDisplay.innerText = "Block " + block;
        
        // Naya: Complaint section ke title mein bhi block name dikhane ke liye
        if(compBlockDisplay) compBlockDisplay.innerText = block;

        // 2. AJAX Fetch call to get Residents data from PHP
        fetch("get-residents.php?block=" + encodeURIComponent(block))
            .then(response => response.text())
            .then(data => {
                ownerDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
                ownerDiv.innerHTML = "<div class='alert alert-danger'>Data load karne mein dikkat hui.</div>";
            });

        // ==========================================
        // 3. NAYA: AJAX Fetch call to get Complaints
        // ==========================================
        fetch("get-complaints.php?block=" + encodeURIComponent(block))
            .then(response => response.text())
            .then(data => {
                complaintDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching complaints:', error);
                complaintDiv.innerHTML = "<div class='alert alert-danger'>Complaints load nahi ho payi.</div>";
            });

    } else {
        blockDisplay.innerHTML = "<span class='text-danger'>None (Please Login Again)</span>";
        ownerDiv.innerHTML = "<div class='alert alert-warning'>Login ke bina data nahi dikhega.</div>";
        complaintDiv.innerHTML = "<div class='alert alert-warning'>Login ke bina complaints nahi dikhengi.</div>";
    }
});

// Purana fetch code waisa hi rehne dein
function deleteResident(id) {
    if (confirm("Kya aap sach mein delete karna chahte hain?")) {
        // AJAX call delete karne ke liye
        fetch("get-residents.php?delete_id=" + id)
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "deleted") {
                    alert("Data delete ho gaya!");
                    location.reload(); // Page refresh taaki table update ho jaye
                } else {
                    alert("Delete nahi ho paya: " + data);
                }
            });
    }
}
</script>

</body>
</html>