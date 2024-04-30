<?php
session_start();

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $host = "localhost";
    $user = "kevoy2";
    $pass = "kevoy2";
    $dbname = "kevoy2";

    // Create connection using mysqli
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['houseId'])) {
        $houseId = $_POST['houseId'];
        $username = $_SESSION['username'];

        // Retrieve user ID based on session username
        $stmt = $conn->prepare("SELECT U_id FROM User WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $userId = $user['U_id'];

            // Check if the combination of U_id and H_id already exists in the Wishlist
            $checkStmt = $conn->prepare("SELECT 1 FROM Wishlist WHERE U_id = ? AND H_id = ?");
            $checkStmt->bind_param("ii", $userId, $houseId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            if ($checkResult->num_rows > 0) {
                // The combination already exists
                echo "This house is already in your wishlist.";
            } else {
                // The combination does not exist, proceed with the insertion
                $insertStmt = $conn->prepare("INSERT INTO Wishlist (U_id, H_id) VALUES (?, ?)");
                $insertStmt->bind_param("ii", $userId, $houseId);
                if ($insertStmt->execute()) {
                    echo "House added to your wishlist!";
                } else {
                    echo "Failed to add to wishlist: " . $conn->error;
                }
                $insertStmt->close();
            }
            $checkStmt->close();
        } else {
            echo "User session error.";
        }
    } else {
        echo "No house ID provided.";
    }
    $conn->close();
} else {
    echo "You must be logged in to add to your wishlist.";
}
?>
