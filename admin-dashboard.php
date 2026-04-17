<?php
session_start(); // Session start karna sabse zaroori hai taaki login building ka pata chale

// Agar bina login koi yahan aaye, toh wapas bhej do
if (!isset($_SESSION['society_name'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Building Dashboard - Stark Industries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="ad-dashboard.css">
</head>
<body>

<div class="dashboard-wrapper">
    <div class="container-fluid content-box">
        <h2 class="text-center">Building Dashboard</h2>
        
        <?php
        include("config/db.php");
        
        // Session se login wale admin ki building ka naam nikalna
        $current_building = mysqli_real_escape_string($conn, $_SESSION['society_name']);

        // Ab sirf usi building ka data fetch karenge jo login hai
        $sql = "SELECT * FROM buildings WHERE building_name = '$current_building' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        ?>

        <div class="table-responsive mt-4">
            <table>
                <thead>
                    <tr>
                        <th>Building Name</th>
                        <th>Access Password</th>
                        <th>Available Blocks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check karenge ki building mili ya nahi
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td class="fw-bold"><?php echo $row['building_name']; ?></td>
                        <td class="password-text"><?php echo $row['password']; ?></td>
                        <td>
                            <?php
                            $letters = range('A','Z');
                            for($i=0; $i < $row['total_blocks']; $i++){
                                echo "<span class='block-badge'>Block-" . $letters[$i] . "</span>";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php 
                        } // End while
                    } else {
                        echo "<tr><td colspan='3' class='text-center text-danger'>Aapki building ka data nahi mila. Pehle building create karein.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="nav-footer mt-5">
            <a href="javascript:history.back()" class="btn-back">⬅ Back to Admin Panel</a>
        </div>
    </div>
</div>

</body>
</html>