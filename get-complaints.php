<?php
$conn = mysqli_connect("localhost", "root", "", "smart_building", );

if (isset($_GET['block'])) {
    $block = mysqli_real_escape_string($conn, $_GET['block']);
    
    // Status ke hisaab se sort karenge: Pending pehle, Solved neeche
    $sql = "SELECT * FROM complaints WHERE block_name = '$block' ORDER BY status ASC, id DESC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered bg-white shadow-sm'>";
        echo "<thead class='table-dark'><tr><th>Flat No</th><th>Complaint</th><th>Date</th><th>Status</th><th>Action</th></tr></thead><tbody>";
        
        while ($row = mysqli_fetch_assoc($result)) {
            // RED ya GREEN color decide karna
            $badgeColor = ($row['status'] == 'Pending') ? 'bg-danger' : 'bg-success';
            
            echo "<tr>
                    <td class='fw-bold'>" . $row['flat_no'] . "</td>
                    <td>" . $row['complaint_text'] . "</td>
                    <td>" . date('d M Y', strtotime($row['created_at'])) . "</td>
                    <td><span class='badge $badgeColor fs-6'>" . $row['status'] . "</span></td>
                    <td>";
            
            // Agar pending hai, toh 'Mark Solved' ka button dikhao
            if($row['status'] == 'Pending') {
                echo "<a href='resolve_complaint.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'>✔ Mark Solved</a>";
            } else {
                echo "<span class='text-muted'>✔ Resolved</span>";
            }
            
            echo "</td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-success'>🎉 Aapke block mein koi nayi complaint nahi hai!</div>";
    }
}
?>