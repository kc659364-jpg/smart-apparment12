<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "smart_building",);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    // Form se data lena
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $flat = mysqli_real_escape_string($conn, $_POST['flat_no']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $block = isset($_POST['block_name']) ? mysqli_real_escape_string($conn, $_POST['block_name']) : '';

    if ($block != '') {
        // Database mein save karne ki query
        $sql = "INSERT INTO residents (name, flat_no, contact, password, block_name) VALUES ('$name', '$flat', '$contact','$password', '$block')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Owner Added Successfully!'); window.location.href='secretary-dashboard.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: Block Name missing. Please login again.";
    }
}
mysqli_close($conn);
?>