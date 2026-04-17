<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "smart_building",);

if(isset($_POST['send_complaint']) && isset($_SESSION['owner_flat'])){
    
    $building = mysqli_real_escape_string($conn, $_SESSION['society_name']);
    $flat = mysqli_real_escape_string($conn, $_SESSION['owner_flat']);
    $complaint = mysqli_real_escape_string($conn, $_POST['complaint_text']);

    // Owner ka block pata karein
    $res_query = mysqli_query($conn, "SELECT block_name FROM residents WHERE flat_no = '$flat' LIMIT 1");
    $res_data = mysqli_fetch_assoc($res_query);
    $block = $res_data['block_name'];

    // Database mein entry karein
    $sql = "INSERT INTO complaints (building_name, block_name, flat_no, complaint_text, status) 
            VALUES ('$building', '$block', '$flat', '$complaint', 'Pending')";

    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Aapki complaint Block $block ke Secretary ko bhej di gayi hai!'); window.location.href='owner-dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>