<!DOCTYPE html>
<?php
session_set_cookie_params(3600);
session_start();
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

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_wishlist'])) {
    $houseId = $_POST['houseId'];
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Retrieve user ID based on session username
        $stmt = $conn->prepare("SELECT U_id FROM User WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $userId = $user['U_id'];

            // Check if the combination of U_id and H_id already exists
            $checkStmt = $conn->prepare("SELECT * FROM Wishlist WHERE U_id = ? AND H_id = ?");
            $checkStmt->bind_param("ii", $userId, $houseId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            $checkStmt->close();

            if ($checkResult->num_rows > 0) {
                // The combination already exists
                echo "<script>alert('This house is already in your wishlist.');</script>";
            } else {
                // Insert into wishlist
                $insertStmt = $conn->prepare("INSERT INTO Wishlist (U_id, H_id) VALUES (?, ?)");
                $insertStmt->bind_param("ii", $userId, $houseId);
                if ($insertStmt->execute()) {
                    echo "<script>alert('House added to your wishlist!');</script>";
                } else {
                    echo "<script>alert('Failed to add to wishlist');</script>";
                }
                $insertStmt->close();
            }
        } else {
            echo "<script>alert('User session error.');</script>";
        }
    } else {
        echo "<script>alert('You must be logged in to add to your wishlist.');</script>";
    }
    $conn->close();
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DashBroad</title>
    <link rel="stylesheet" type="text/css" href="P3.css">
    <link rel="icon" href="./Icon.png">
</head>
<body>
<div class="nav">
    <p class="logo">Enchanted Estates</p>
	
<?php

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    echo "<div class='nav-link' id='User-choice'><img src='./User.png' style='max-height:27px;' alt='User Image'>";
        echo "<span style='margin-left: 10px; position: relative; top: -10px;'>" . $_SESSION['username'] . "</span><div id='logout-dropdown' style='display: none; position: absolute;border: 1px solid #ccc; padding: 5px;'>
        <a href='./sign-out.php'>Log out</a>
    </div></div>";
} else {
    echo "<a class='nav-link' href='./sign-in.php'>Sign-in</a>";
}
?>
    <a class="nav-link" href="./seller-dashboard.php">Sell</a>
    <a class="nav-link" href="./Dashbroad.php">Buy</a>
    <a class="nav-link" href="./index.php">Home</a>
	
</div>
<div class="display">
    <form method="POST" style="white-space: nowrap;">
        <label for="location">City</label>
        <input type="text" id="location" name="location" maxlength="20" size="10">
        &nbsp;
        <label for="bed#">Bed</label>
        <input type="number" id="bed#" name="bed#" style="width:40px">
        &nbsp;
        <label for="bath#">Bath</label>
        <input type="number" id="bath#" name="bath#" style="width:40px">
        &nbsp;
        <label for="size-min">Size</label>
        <input type="text" id="size-min" name="size-min" maxlength="6" size="2">
        to
        <input type="text" id="size-max" name="size-max" maxlength="6" size="2"> Sq&sup2;
        &nbsp;
        <label for="year-min">Year</label>
        <input type="number" id="year-min" name="year-min" style="width:100px" maxlength="4" min="1900" max="2030" value="1900" placeholder="Year">
        to
        <input type="number" id="year-max" name="year-max" style="width:100px" maxlength="4" min="1900" max="2030" value="2030" placeholder="Year">
        &nbsp;
        <label for="price-min">Price</label>
        <input type="number" id="price-min" style="width:100px; text-align:right;" value="0" name="price-min">
        to
        <input type="number" id="price-max" style="width:100px; text-align:right;" value="9999999" name="price-max">
        <br>
        <input type="submit" value="Search">
    </form>
</div>
<div class="content">
    <div class="results">
        <span style="font-size:26px">Search result</span>
        <?php


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

        // Initialize variables
        $location = $_POST['location'] ?? '';
        $bed = $_POST['bed#'] ?? '';
        $bath = $_POST['bath#'] ?? '';
        $size_min = $_POST['size-min'] ?? '';
        $size_max = $_POST['size-max'] ?? '';
        $year_min = $_POST['year-min'] ?? '';
        $year_max = $_POST['year-max'] ?? '';
        $price_min = $_POST['price-min'] ?? '';
        $price_max = $_POST['price-max'] ?? '';

        // Construct the query dynamically
        $query = "SELECT * FROM Houses WHERE 1 = 1"; // Base query

        // Add conditions based on form input
        if (!empty($location)) {
            $query .= " AND city LIKE '%" . $conn->real_escape_string($location) . "%'";
        }
        if (!empty($bed)) {
            $query .= " AND bed = " . intval($bed);
        }
        if (!empty($bath)) {
            $query .= " AND bath = " . intval($bath);
        }
        if (!empty($size_min) && !empty($size_max)) {
            $query .= " AND H_size BETWEEN " . intval($size_min) . " AND " . intval($size_max);
        }
        if (!empty($year_min) && !empty($year_max)) {
            $query .= " AND B_year BETWEEN " . intval($year_min) . " AND " . intval($year_max);
        }
        if (!empty($price_min) && !empty($price_max)) {
            $query .= " AND price BETWEEN " . intval($price_min) . " AND " . intval($price_max);
        }

        // Execute the query
        $result = $conn->query($query);
        if (!$result) {
            echo "Error in query execution: " . $conn->error;
        } else if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='house'>";
                echo "<img src='" . $row['House_image'] . "' alt='House Image'>";
                echo "<div style='text-align:left; margin-left:10px;padding-top:20px;'>";
                echo "Address: " . $row['H_address'] . "<br>";
                echo "City: " . $row['city'] . "<br>";
                echo "Year of Build: " . $row['B_year'] . "<br>";
                echo $row['bed'] . " Bed " . $row['bath'] . " Bath<br>";
                echo "Size: " . $row['H_size'] . " Sq&sup2;<br>";
			echo "Contact Number: ".$row['house_number']."<br>";
                echo "<span style='color: red; font-size: 24px;'>$" . number_format($row['price']) . "</span>";
                echo "</div>";
			 echo "<div class='add'><button class='add' style='border: none; background-color: transparent;' data-houseid='" . $row['H_id'] . "' onclick='addToWishlist(this)'><img src='Plus.png' style='width:50px;' alt='Add to Wishlist'></button></div>";




                echo "</div>";
            }
        } else {
            echo "<div>No results found based on your search criteria.</div>";
        }

        $conn->close();
        ?>
    </div>
    <div class="wishlist">
        <span style="font-size:23px;">Wishlist</span>
		<?php
session_start();

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $host = "localhost";
    $user = "kevoy2";
    $pass = "kevoy2";
    $dbname = "kevoy2";
    $username = $_SESSION['username'];

    // Create connection
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // First, retrieve the U_id for the logged-in user
    $userIdStmt = $conn->prepare("SELECT U_id FROM User WHERE username = ?");
    if ($userIdStmt) {
        $userIdStmt->bind_param("s", $username);
        $userIdStmt->execute();
        $userIdResult = $userIdStmt->get_result();
        if ($userIdResult->num_rows > 0) {
            $user = $userIdResult->fetch_assoc();
            $userId = $user['U_id'];

            // Prepare SQL to fetch house images for current user
            $sql = "SELECT * FROM Houses
                    JOIN Wishlist ON Houses.H_id = Wishlist.H_id
                    JOIN User ON Wishlist.U_id = User.U_id
                    WHERE User.U_id = ?";

            // Prepare statement for the house images
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<img src="' . htmlspecialchars($row['House_image']) . '" style=" height:200px; overflow: hidden;"alt="House Image">';
						echo '<br><div>';
						echo "Address: " . $row['H_address'] . "<br>";
                echo "City: " . $row['city'] . "<br>";
                echo "Year of Build: " . $row['B_year'] . "<br>";
                echo $row['bed'] . " Bed " . $row['bath'] . " Bath<br>";
                echo "Size: " . $row['H_size'] . " Sq&sup2;<br>";
				echo "Contact Number: ".$row['house_number']."<br>";
                echo "<span style='color: red; font-size: 24px;'>$" . number_format($row['price']) . "</span></div>
				<div class='remove'><button class='remove'  data-houseid='" . $row['H_id'] . "' onclick='removeWishlist(this)'>Remove from wishlist</button></div>";
                    }
                } else {
                    echo "No houses found in your wishlist.";
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "User session error or user ID not found.";
        }
        $userIdStmt->close();
    } else {
        echo "Error preparing user ID statement: " . $conn->error;
    }
    $conn->close();
} else {
    echo "Please log in to view your wishlist.";
}
?>


    </div>
</div><script>
function addToWishlist(button) {
    var houseId = button.getAttribute('data-houseid');
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add_to_wishlist.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            alert(this.responseText);
        }
    }
    xhr.send("houseId=" + houseId);
}
function removeWishlist(button) {
    var houseId = button.getAttribute('data-houseid');
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "remove_from_wishlist.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            alert(this.responseText);  // Displays the server response as an alert
        }
    };
    xhr.send("houseId=" + encodeURIComponent(houseId));  // Ensures houseId is properly URL-encoded
}

</script>


</body>
</html>
