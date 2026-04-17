<?php
$conn = mysqli_connect("localhost", "root", "", "smart_building", );

if (!$conn) {
    die("Connection failed");
}

// DELETE LOGIC (Jab button click ho)
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM residents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Delete hone ke baad hum sirf 'success' bhejenge
        // Dashboard ka JavaScript ise handle karega
        echo "deleted";
        exit();
    }
}

// DISPLAY LOGIC (Fetch Residents)
if (isset($_GET['block'])) {
    $block = $_GET['block'];
    $stmt = $conn->prepare("SELECT id, name, flat_no, contact, password FROM residents WHERE block_name = ?");
    $stmt->bind_param("s", $block);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered'>";
        echo "<thead class='table-dark'><tr><th>Name</th><th>Flat</th><th>Contact</th><th>Pass</th><th>Action</th></tr></thead><tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['flat_no'] . "</td>
                    <td>" . $row['contact'] . "</td>
                    <td>" . $row['password'] . "</td>
                    <td>
                        <button onclick='deleteResident(" . $row['id'] . ")' class='btn btn-danger btn-sm'>Delete</button>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "No data found.";
    }
}
?>