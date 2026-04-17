<?php

include("config/db.php");

$name = $_POST['building_name'];
$pass = $_POST['password'];
$blocks = $_POST['total_blocks'];

// check if already exists
$check = mysqli_query($conn, "SELECT * FROM buildings WHERE building_name='$name'");

if(mysqli_num_rows($check) > 0){
    echo "Building already exists!";
} else {

    $sql = "INSERT INTO buildings (building_name, password, total_blocks)
            VALUES ('$name', '$pass', '$blocks')";

    if(mysqli_query($conn, $sql)){
        header("Location: admin-dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

}

?>