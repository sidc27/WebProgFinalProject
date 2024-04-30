
<!DOCTYPE html>
<?php
session_set_cookie_params(3600);
session_start();
?>
<html lang="en">

<head>
	<title>Enchanted Estates</title>
    <link rel="icon" href="./house_img/favicon.png">
    <link rel="stylesheet" href="./P3.css">
</head>

<body>
 <div class="nav">
    <p class="logo">Enchanted Estates</p>
	
<?php

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
     echo "<div class='nav-link' id='User-choice'><img src='./User.png' style='max-height:27px;' alt='User Image'>";
        echo "<span style='margin-left: 10px; position: relative; top: -10px;'>" . $_SESSION['username'] . "</span><div id='logout-dropdown' style='display: none; position: absolute;border: 1px solid #ccc; padding: 5px;'>
        <a href='./sign-out.php'>Log out</button>
    </div></div>";
} else {
    echo "<a class='nav-link' href='./sign-in.php'>Sign-in</a>";
}
?>
    <a class="nav-link" href="./seller-dashboard.php">Sell</a>
    <a class="nav-link" href="./Dashbroad.php">Buy</a>
    <a class="nav-link" href="./index.php">Home</a>
	
</div>
<div class="content">
    <div class="results">
        <span style="font-size:26px">My House Onsale</span>
       <?php
session_start();  // Ensure session_start() is called at the beginning

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $host = "localhost";
    $user = "kevoy2";
    $pass = "kevoy2";
    $dbname = "kevoy2";
    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT U_role FROM User WHERE username = ?");
    if (!$stmt) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user['U_role'] != "S") {
        echo "<script>alert('You are not a seller, please login with a seller account.');</script>";
    } else {
        $stmt2 = $conn->prepare("SELECT U_id FROM User WHERE username = ?");
        $stmt2->bind_param("s", $username);
        $stmt2->execute();
        $idResult = $stmt2->get_result();
        if ($idRow = $idResult->fetch_assoc()) {
            $userId = $idRow['U_id'];

            $stmt3 = $conn->prepare("SELECT * FROM Houses WHERE U_id = ?");
            $stmt3->bind_param("i", $userId);
            $stmt3->execute();
            $housesResult = $stmt3->get_result();

            if ($housesResult->num_rows > 0) {
                while ($row = $housesResult->fetch_assoc()) {
                    echo "<div class='house'>";
                    echo "<img src='" . htmlspecialchars($row['House_image']) . "' alt='House Image'>";
                    echo "<div style='text-align:left; margin-left:10px;padding-top:20px;'>";
                    echo "Address: " . htmlspecialchars($row['H_address']) . "<br>";
                    echo "City: " . htmlspecialchars($row['city']) . "<br>";
                    echo "Year of Build: " . htmlspecialchars($row['B_year']) . "<br>";
                    echo htmlspecialchars($row['bed']) . " Bed " . htmlspecialchars($row['bath']) . " Bath<br>";
                    echo "Size: " . htmlspecialchars($row['H_size']) . " Sq&sup2;<br>";
                    echo "Contact Number: " . htmlspecialchars($row['house_number']) . "<br>";
                    echo "<span style='color: red; font-size: 24px;'>$" . number_format($row['price']) . "</span>";
                    echo "</div>";
                    echo "<div class='edit'>";
                    echo "<button class='edit-btn' data-houseid='" . $row['H_id'] . "'>EDIT</button>";
                    echo "<button class='delete-btn' data-houseid='" . $row['H_id'] . "' data-imagepath='" . htmlspecialchars($row['House_image']) . "'>DELETE</button>";
                    echo "</div></div>";
                }
            } else {
                echo "No houses found in your selling list.";
            }
        } else {
            echo "Failed to retrieve user ID.";
        }
    }
} else {
    echo "Please log in to view your onsale list.";
}
?>

</div>
<div class="wishlist">
<?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])&&($user['U_role'] == "S")) {?>
 <span style="font-size:23px;">Sale another house</span>
  <form id="houseForm" method="post" enctype="multipart/form-data">
        <label for="city">City:</label>
		<input type="hidden" id="Userid" name="Userid" value="<?php echo isset($userId) ? $userId : ''; ?>">

        <input type="text" id="city" name="city" required><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br>

        <label for="year">Year Built (1900 - 2030):</label>
        <input type="number" id="year" name="year" min="1900" max="2030" required><br>

        <label for="bed">Bedrooms:</label>
        <input type="number" id="bed" name="bed" required><br>

        <label for="bath">Bathrooms:</label>
        <input type="number" id="bath" name="bath" required><br>

        <label for="size">Size (Sq Ft):</label>
        <input type="number" id="size" name="size" required><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required><br>
		
		<label for="Contact">Contact# :</label>
            <input type="tel" id="Contact" name="Contact" pattern="[0-9]{10}" title="Contact number must be 10 digits" required><br>

        <label for="image">House Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br>

        <input type="submit" value="Submit House">
    </form> <?php } else { ?>
        <p>Please login as a seller to sell a house.</p>
    <?php } ?>
</div>
</div>
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="updateForm">
            <input type="hidden" id="houseId" name="houseId">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required><br>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required><br>
            <label for="year">Year of Build (1900 - 2030):</label>
            <input type="number" id="year" name="year" min="1900" max="2030" required><br>
            <label for="bed">Bedrooms:</label>
            <input type="number" id="bed" name="bed" required><br>
            <label for="bath">Bathrooms:</label>
            <input type="number" id="bath" name="bath" required><br>
            <label for="size">Size (Sq Ft):</label>
            <input type="number" id="size" name="size" required><br>
            <label for="price">Price ($):</label>
            <input type="number" id="price" name="price" required><br>
			<label for="Contact">Contact# :</label>
            <input type="tel" id="Contact" name="Contact" pattern="[0-9]{10}" title="Contact number must be 10 digits" required><br>

            <button type="submit">Update House</button>
        </form>
    </div>
</div>
<script>
document.querySelectorAll('.edit-btn').forEach(button => {
    button.onclick = function() {
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
        document.getElementById("houseId").value = this.getAttribute("data-houseid");

        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    };
});

document.getElementById("updateForm").onsubmit = function(event) {
    event.preventDefault();  // Prevent default form submission

    var formData = new FormData(this);
    fetch('update-house.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text())
    .then(data => {
        alert(data);  // Alert the response from the server
        document.getElementById("myModal").style.display = "none";
    }).catch(error => {
        console.error('Error:', error);
    });
};

document.getElementById('houseForm').addEventListener('submit', function(e) {
    e.preventDefault();  // Stop the form from submitting normally

    var formData = new FormData(this);  // Create a FormData object from the form

    // Send the FormData object via AJAX to the server
    fetch('submit_house.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())  // Convert the response to text
    .then(html => {
        alert("House submitted successfully!");
        console.log(html);  // Log the response from the server for debugging
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Error submitting house");
    });
});
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        if (confirm("Are you sure you want to delete this house? This action cannot be undone.")) {
            const houseId = this.getAttribute('data-houseid');
            const imagePath = this.getAttribute('data-imagepath');

            fetch('delete_house.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ houseId: houseId, imagePath: imagePath })
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                window.location.reload(); // Reload the page to update the list
            })
            .catch(error => console.error('Error:', error));
        }
    });
});
</script>
</body>

</html>