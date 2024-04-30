<?php
$host = "localhost";
$user = "kevoy2";
$pass = "kevoy2";
$dbname = "kevoy2";

// Create connection using mysqli
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Could not connect to server: " . $conn->connect_error);
} else {
    echo "Connection established\n";
}

// Function to generate a 10-digit phone number
function generatePhoneNumber() {
    return rand(1000000000, 9999999999);
}

// Generate 78 phone numbers
$phoneNumbers = array();
for ($i = 0; $i < 78; $i++) {
    $phoneNumbers[] = generatePhoneNumber();
}

// Insert phone numbers into the Houses table
// Prepare the statement
if ($stmt = $conn->prepare("UPDATE Houses SET house_number = ? WHERE H_id = ?")) {
    // Assuming H_ids are from 1 to 78
    for ($h_id = 1; $h_id <= 78; $h_id++) {
        // Bind the parameters and execute the query
        $stmt->bind_param('ii', $phoneNumbers[$h_id - 1], $h_id);
        $stmt->execute();
    }
    echo "Phone numbers have been successfully updated.";
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
