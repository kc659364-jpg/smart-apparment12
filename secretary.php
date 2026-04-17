<?php
$conn = mysqli_connect("localhost", "root", "", "smart_building",);

if (!$conn) { die("Connection Failed"); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['name'] ?? '';
    $flat    = $_POST['flat'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $PASSWORD = $_POST['password'] ?? '';
    $block   = $_POST['block'] ?? ''; 

    // Column names check karein: block_name, name, flat_no, contact
    $sql = "INSERT INTO residents (block_name, name, flat_no, contact) 
            VALUES ('$block', '$name', '$flat', '$contact')";

    if (mysqli_query($conn, $sql)) {
        echo "Successfully Saved!";
    } else {
        // Ye line aapko batayegi ki database kyun mana kar raha hai
        echo "Database Error: " . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>