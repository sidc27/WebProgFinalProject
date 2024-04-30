kevoy2<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $user = "kevoy2";
    $pass = "kevoy2";
    $dbname = "kevoy2";

    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $city = $conn->real_escape_string($_POST['city']);
    $address = $conn->real_escape_string($_POST['address']);
    $year = $conn->real_escape_string($_POST['year']);
    $bed = $conn->real_escape_string($_POST['bed']);
    $bath = $conn->real_escape_string($_POST['bath']);
    $size = $conn->real_escape_string($_POST['size']);
    $price = $conn->real_escape_string($_POST['price']);
    $number = $conn->real_escape_string($_POST['Contact']);
    $id = $conn->real_escape_string($_POST['Userid']);

    if ($_FILES['image']['error'] == 0) {
        $target_dir = "./house_img/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . DIRECTORY_SEPARATOR . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File upload error: " . $_FILES['image']['error'];
    }

    $stmt = $conn->prepare("INSERT INTO Houses (city, H_address, B_year, bed, bath, H_size, price, house_number, U_id, House_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiiiiiis", $city, $address, $year, $bed, $bath, $size, $price, $number, $id, $target_file);
    if ($stmt->execute()) {
        echo "New house added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
