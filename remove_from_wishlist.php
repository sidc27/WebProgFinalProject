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

            // Prepare to delete from Wishlist
            $deleteStmt = $conn->prepare("DELETE FROM Wishlist WHERE U_id = ? AND H_id = ?");
            $deleteStmt->bind_param("ii", $userId, $houseId);
            if ($deleteStmt->execute()) {
                echo "House removed from your wishlist!";
            } else {
                echo "Failed to remove from wishlist: " . $conn->error;
            }
            $deleteStmt->close();
        } else {
            echo "User session error.";
        }
    } else {
        echo "No house ID provided.";
    }
    $conn->close();
} else {
    echo "You must be logged in to edit your wishlist.";
}
?>
