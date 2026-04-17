<?php
session_start(); // Sabse pehle session start karein taaki sab jagah kaam kare

// Database connection
$conn = mysqli_connect("localhost", "root", "", "smart_building", );

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ==========================================
// 1. MAINTENANCE UPDATE LOGIC (Block-Wide)
// ==========================================
if(isset($_POST['update_maintenance'])){
    
    // Session se direct data lein
    $building = isset($_SESSION['society_name']) ? mysqli_real_escape_string($conn, $_SESSION['society_name']) : '';
    $block = isset($_SESSION['loginBlock']) ? mysqli_real_escape_string($conn, $_SESSION['loginBlock']) : '';
    
    // Form se sirf amount lena hai (Kyunki ab Flat_No form mein nahi hai)
    $amt = mysqli_real_escape_string($conn, $_POST['amount']);
    $status = 'Pending'; // Naya bill generate ho raha hai, toh default Pending rahega
    
    if($building != "" && $block != "") {
        
        // 1. Pehle us block ke SAARE flats dhoondo
        $res_query = mysqli_query($conn, "SELECT flat_no FROM residents WHERE block_name = '$block'");
        
        if(mysqli_num_rows($res_query) > 0) {
            
            // 2. Loop chala kar ek-ek flat ke liye database mein maintenance set karo
            while($row = mysqli_fetch_assoc($res_query)){
                $flat = $row['flat_no'];
                
                $sql = "INSERT INTO maintenance (building_name, block_name, flat_no, amount, status) 
                        VALUES ('$building', '$block', '$flat', '$amt', '$status') 
                        ON DUPLICATE KEY UPDATE amount='$amt', status='$status'";
                mysqli_query($conn, $sql);
            }
            
            echo "<script>alert('Maintenance bill sent to ALL flats in Block $block successfully!'); window.location.href='maintenance_notice.php';</script>";
        } else {
            // Agar block mein koi flat hi register nahi hai
            echo "<script>alert('Error: Aapke block mein koi residents nahi mile! Pehle owners add karein.'); window.location.href='maintenance_notice.php';</script>";
        }

    } else {
        echo "<script>alert('Error: Session expired. Please login again.'); window.location.href='login.html';</script>";
    }
}

// ==========================================
// 2. NOTICE UPDATE LOGIC
// ==========================================
if(isset($_POST['add_notice'])){
    
    // Session se building aur block uthana hai
    $building = isset($_SESSION['society_name']) ? mysqli_real_escape_string($conn, $_SESSION['society_name']) : ''; 
    $block = isset($_SESSION['loginBlock']) ? mysqli_real_escape_string($conn, $_SESSION['loginBlock']) : ''; 
    
    $title = mysqli_real_escape_string($conn, $_POST['notice_title']);
    $msg = mysqli_real_escape_string($conn, $_POST['notice_msg']);
    
    if($building != "" && $block != "") {
        // Query mein building_name aur block_name add karein
        $sql = "INSERT INTO notices (building_name, block_name, title, message) 
                VALUES ('$building', '$block', '$title', '$msg')";
        
        if(mysqli_query($conn, $sql)){
            echo "<script>alert('Notice posted for Block $block!'); window.location.href='maintenance_notice.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Error: Session expired. Please login again.'); window.location.href='login.html';</script>";
    }
}

mysqli_close($conn);
?>