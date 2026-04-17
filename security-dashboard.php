<?php 
// 1. Session start karna zaroori hai login info check karne ke liye
session_start(); 

// Database connection
$conn = mysqli_connect("localhost", "root", "", "smart_building", 3307);

// 2. Security Check: Agar guard login nahi hai, toh login page par bhej do
if (!isset($_SESSION['society_name'])) {
    header("Location: login.html"); // Apne login page ka sahi naam yahan check kar lena
    exit();
}

// 3. Current login guard ki society ka naam session se lena
$current_society = $_SESSION['society_name']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Dashboard - <?php echo htmlspecialchars($current_society); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="security-dashboard.css" rel="stylesheet">
</head>
<body>

<div class="dashboard-wrapper">
    <div class="container-fluid">
        <div class="mb-4 text-start d-flex justify-content-between align-items-center">
            <a href="javascript:history.back()" class="btn-back">⬅ Back to Control Center</a>
            <h5 class="text-info m-0">📍 Monitoring: <?php echo htmlspecialchars($current_society); ?></h5>
        </div>

        <div class="card p-5 shadow-lg">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>🛡️ Recent Visitor Entries</h4>
                <span class="badge-live">LIVE MONITORING</span>
            </div>

            <div class="table-responsive">
                <table class="table text-center align-middle">
                    <thead>
                        <tr>
                            <th>Visitor Name</th>
                            <th>Contact Info</th>
                            <th>Vehicle No</th>
                            <th>Target Flat (Block)</th>
                            <th>Check-In Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // 4. Query change: Sirf wahi data dikhao jo is society_name se match kare
                        // Note: Make sure visitor_logs table mein 'building_name' column ho
                        $query = "SELECT * FROM visitor_logs WHERE building_name = '$current_society' ORDER BY id DESC";
                        $result = mysqli_query($conn, $query);

                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td class="fw-bold text-white"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td class="text-info"><?php echo htmlspecialchars($row['contact']); ?></td>
                                    <td><span class="vehicle-tag"><?php echo htmlspecialchars($row['vehicle_no']); ?></span></td>
                                    <td class="text-white">
                                        <?php echo htmlspecialchars($row['flat_no']); ?> 
                                        <span class="block-text">(<?php echo htmlspecialchars($row['block_name']); ?>)</span>
                                    </td>
                                    <td class="time-stamp">
                                        <?php 
                                        // Check karein agar time null nahi hai
                                        echo ($row['entry_time']) ? date('h:i A', strtotime($row['entry_time'])) : 'No Time'; 
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-muted py-5'>No Active Logs Found for $current_society</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>