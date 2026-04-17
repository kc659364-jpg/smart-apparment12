<?php
session_start(); // Session sabse pehle start karein

// 1. Database connection
include("db.php"); 

$error_message = ""; // Error dikhane ke liye variable

// 2. Sirf tabhi chale jab form submit ho
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Data fetch aur Sanitize karna
    $building = isset($_POST['building_name']) ? mysqli_real_escape_string($conn, $_POST['building_name']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';
    $role = isset($_POST['role']) ? mysqli_real_escape_string($conn, $_POST['role']) : '';

    // Check karo user already hai ya nahi
    $sql = "SELECT * FROM users WHERE building_name='$building' AND role='$role'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        // User mil gaya → password check karo
        $row = mysqli_fetch_assoc($result);

        if($row['password'] == $password){
            
            // Session mein details save karna
            $_SESSION['society_name'] = $building; 
            $_SESSION['role'] = $role;

            // Role ke hisab se redirect
            switch($role) {
                case "admin":
                    header("Location: admin.html");
                    break;
                case "secretary-login":
                    header("Location: secretary-login.html");
                    break;
                case "owner-login":
                    header("Location: owner-login.html");
                    break;
                case "security":
                    header("Location: security.php");
                    break;
                default:
                    header("Location: login.html");
            }
            exit();

        } else {
            $error_message = "Wrong Password!";
        }

    } else {
        // User nahi hai → Auto register logic
        $insert = "INSERT INTO users (building_name, password, role) 
                   VALUES ('$building', '$password', '$role')";

        if(mysqli_query($conn, $insert)){
            echo "<script>alert('Registration Successful! Please Login.'); window.location.href='index.php';</script>";
            exit();
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Society Login - Stark Industries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <div class="login-wrapper">
        <div class="card login-card p-4">
            <h3 class="text-center mb-4">Smart Society Login</h3>

            <?php if($error_message != ""): ?>
                <div class="alert alert-danger p-2 text-center" style="font-size: 14px;">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form action="index.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Building Name</label>
                    <input type="text" name="building_name" class="form-control" placeholder="Identify Structure" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Access Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Secure Key" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Login Authorization</label>
                    <select class="form-select" name="role" required>
                        <option value="">Select Role</option>
                        <option value="admin">Admin Control</option>
                        <option value="secretary-login">Secretary</option>
                        <option value="owner-login">Property Owner</option>
                        <option value="security">Security Detail</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-stark w-100 mb-3">Initialize Login</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
