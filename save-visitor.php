<?php
session_start(); 
$conn = mysqli_connect("localhost", "root", "", "smart_building",);

// HTML form mein button ka naam 'save_entry' hai
if (isset($_POST['save_entry'])) {
    
    // Check karein session hai ya nahi
    if (!isset($_SESSION['society_name'])) {
        die("Error: Session expired. Please login again.");
    }

    $building = $_SESSION['society_name']; 
    
    // HTML names (visitor_name, mobile, etc.) ke hisab se fetch karein
    $name = mysqli_real_escape_string($conn, $_POST['visitor_name']);
    $contact = mysqli_real_escape_string($conn, $_POST['mobile']);
    $vehicle = mysqli_real_escape_string($conn, $_POST['vehicle_no']);
    $flat = mysqli_real_escape_string($conn, $_POST['flat_no']);
    $work = mysqli_real_escape_string($conn, $_POST['work_type']); // Naya field

    // Query mein building_name aur work_type (agar column hai) add karein
    // Note: Agar 'work_type' column nahi hai database mein, toh use query se hata dein
    $sql = "INSERT INTO visitor_logs (name, contact, vehicle_no, flat_no, building_name) 
            VALUES ('$name', '$contact', '$vehicle', '$flat', '$building')";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: security-dashboard.php");
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    echo "Form not submitted properly.";
}
?>