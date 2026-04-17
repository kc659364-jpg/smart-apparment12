<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "smart_building",);

if (isset($_POST['login'])) {
    $flat_no = mysqli_real_escape_string($conn, $_POST['flat_no']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Database mein check karna
    $sql = "SELECT * FROM residents WHERE flat_no = '$flat_no' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
 
    // ... baki code same rahega ...
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    $_SESSION['owner_id'] = $row['id'];
    $_SESSION['owner_name'] = $row['name'];
    $_SESSION['owner_flat'] = $row['flat_no'];
    // 🔥 YE LINE ADD KARO: Block name session mein save karne ke liye
    $_SESSION['owner_block'] = $row['block_name']; 
    
    echo "<script>alert('Login Successful!'); window.location.href='owner-dashboard.php';</script>";
}
// ... baki code same ...
    else {
        // Login fail
        echo "<script>alert('Invalid Flat Number or Contact!'); window.location.href='owner-login.html';</script>";
    }
}
?>