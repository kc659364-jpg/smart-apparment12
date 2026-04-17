<?php
// Host hamesha "localhost" ya "127.0.0.1" hona chahiye
$conn = mysqli_connect("localhost", "root", "", "smart_building", );

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>