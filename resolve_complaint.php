<?php
$conn = mysqli_connect("localhost", "root", "", "smart_building",);

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Status ko Pending se badal kar Solved kar do
    $sql = "UPDATE complaints SET status = 'Solved' WHERE id = '$id'";
    
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Complaint marked as Solved!'); window.location.href='secretary-dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>