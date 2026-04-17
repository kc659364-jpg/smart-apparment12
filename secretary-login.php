<?php
session_start(); // Session start karna sabse zaroori hai
include("config/db.php");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // JS se aane wala data
    $building = mysqli_real_escape_string($conn, $_POST['building_name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $block = mysqli_real_escape_string($conn, $_POST['block']); // Block check karein

    $sql = "SELECT * FROM buildings WHERE building_name='$building' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        // LOGIN SUCCESS: Yahan hum session mein details save kar lenge
        $_SESSION['society_name'] = $building;
        $_SESSION['loginBlock'] = $block;
        
        echo "success";
    } else {
        echo "fail";
    }
}
?>