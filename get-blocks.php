<?php
include("config/db.php");

// Input ko clean karna zaroori hai
$building = isset($_GET['building']) ? mysqli_real_escape_string($conn, $_GET['building']) : '';

if($building != "") {
    $sql = "SELECT total_blocks FROM buildings WHERE building_name='$building'";
    $result = mysqli_query($conn, $sql);

    if($row = mysqli_fetch_assoc($result)) {
        $total = $row['total_blocks'];
        $letters = range('A', 'Z');
        $blocks = array_slice($letters, 0, $total); // Jitne blocks hain utne hi dikhayega
        echo json_encode($blocks);
    } else {
        echo json_encode([]); // Agar building nahi mili toh khali array
    }
} else {
    echo json_encode([]);
}
?>