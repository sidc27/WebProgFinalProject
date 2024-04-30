<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Enchanted Estates</title>
    <link rel="icon" href="./house_img/favicon.png">
    <link rel="stylesheet" href="./common.css">
</head>

<body>
    <div class="nav">
        <p class="logo">Enchanted Estates</p>
        <?php
        if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            echo "<div class='nav-link' id='User-choice'><img src='./User.png' style='max-height:27px;' alt='User Image'>";
                echo "<span style='margin-left: 10px; position: relative; top: -10px;'>" . $_SESSION['username'] . "</span><div id='logout-dropdown' style='display: none; position: absolute;border: 1px solid #ccc; padding: 5px;'>
                <a href='./sign-out.php'>Log out</a>
            </div></div>";
        } else {
            print "<a class=\"nav-link\" href=\"./sign-in.php\">Sign-in</a>";
        }
        ?>
        <a class="nav-link" href="./seller-dashboard.php">Sell</a>
        <a class="nav-link" href="./Dashbroad.php">Buy</a>
        <a class="nav-link" href="./index.php">Home</a>
    </div>
    <div class="dash">
        <?php
            echo $_SESSION['User'];
        ?>
    </div>
</body>

</html>