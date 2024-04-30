<?php 
$host = "localhost";
$user = "kevoy2";
$pass = "kevoy2";
$dbname = "kevoy2";

//Create Connection.
$conn = new mysqli($host, $user, $pass, $dbname);
//Check Connection.
if ($conn->connect_error) {
	echo "Could not connect to server\n";
	die("Connection failed: " . $conn->connect_error);
}
//sql to create tables
$sql0 = "CREATE TABLE Houses(
    H_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    city VARCHAR(30) NOT NULL,
    House_image VARCHAR(200) DEFAULT NULL,
    H_address VARCHAR(60) NOT NULL,
    B_year YEAR NOT NULL,
    bed INT(2) NOT NULL,
    bath INT(2) NOT NULL,
    H_size smallint NOT NULL,
    price INT NOT NULL
)";
$sql1 ="CREATE TABLE User(
    U_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    pass VARCHAR(50) NOT NULL,
    U_role VARCHAR(1) NOT NULL
)";
$sql2 ="CREATE TABLE Wishlist(
    U_id INT(6) UNSIGNED NOT NULL,
    H_id INT(6) UNSIGNED NOT NULL,
    PRIMARY KEY (U_id, H_id),
    FOREIGN KEY (U_id) REFERENCES User(U_id),
    FOREIGN KEY (H_id) REFERENCES Houses(H_id)
)";
$sql3 = "INSERT INTO User(username, pass, U_role) VALUES ('admin', 'admin123', 'A')";
if ($conn->query($sql0) === TRUE) {
	echo "Table Houses created successfully";
}
if ($conn->query($sql1) === TRUE) {
	echo "Table User created successfully";
}
if ($conn->query($sql2) === TRUE) {
	echo "Table Wishlist created successfully";
}
$conn->close();
?>