<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receive JSON payload
    $data = json_decode(file_get_contents("php://input"), true);
    $houseId = $data['houseId'];
    $imagePath = $data['imagePath'];

    // Database configuration
    $host = "localhost";
    $user = "kevoy2";
    $pass = "kevoy2";
    $dbname = "kevoy2";
    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL to delete the house
    $stmt = $conn->prepare("DELETE FROM Houses WHERE H_id = ?");
    $stmt->bind_param("i", $houseId);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        // Attempt to delete the image file if the database deletion is successful
        if (file_exists($imagePath)) {
            unlink($imagePath);
            echo "House and image deleted successfully!";
        } else {
            echo "House deleted, but image file was not found.";
        }
    } else {
        echo "Error deleting house: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
