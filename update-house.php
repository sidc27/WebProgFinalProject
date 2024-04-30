<?php
session_start();


$host = "localhost";
$user = "kevoy2";
$pass = "kevoy2";
$dbname = "kevoy2";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $houseId = $_POST['houseId'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $year = $_POST['year'];
    $bed = $_POST['bed'];
    $bath = $_POST['bath'];
    $size = $_POST['size'];
    $price = $_POST['price'];
	$number = $_POST['Contact'];
    // Prepare the update statement
    $stmt = $conn->prepare("UPDATE Houses SET H_address = ?, city = ?, B_year = ?, bed = ?, bath = ?, H_size = ?, price = ?, house_number=?  WHERE H_id = ?");
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("ssiiiiiii", $address, $city, $year, $bed, $bath, $size, $price,$number ,$houseId);
    $stmt->execute();

    // Check for successful update
    if ($stmt->affected_rows > 0) {
        echo "House updated successfully!";
    } else {
        echo "No changes were made to the house details.";
    }

    $stmt->close();
}
$conn->close();
?>
