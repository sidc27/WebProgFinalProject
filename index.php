<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Enchanted Estates</title>
    <link rel="icon" href="./house_img/favicon.png">
    <link rel="stylesheet" href="./common.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <div class="display">
        <img class="home" src="./house_img/home.png">
    </div>
    <div class="content">
        <h3>Project Descritption:</h3>
        <p>
        The goal of this project is to create a semi-functional real estate application. 
        The application mainly consists of an index page, sign-in page, sign-up page, seller 
        dashboard, and buyer dashboard which the user can access through the navigation bar. 
        Moreover, the project is programmed in the following languages: HTML, CSS, PHP, and 
        Javascript. Furthermore, we utilized MySQL on the Codd Server to setup the database. 
        Finally, an introduction of the member of the Web Enchanted Devs team:
        <ul>
            <li>Yikai Liu as our designer.</li>
            <li>Sidratul Chowdhury as our programmer/director.</li>
            <li>Kaleb Evoy as our leader.</li>
        </ul>
        </p>
        <h3>About Us:</h3>
        <p>
        We are proud to introduce our application of Enchanted Estates where our goal is to help 
        you find your perfect dream home. Furthermore, our website provides its users with the 
        means to buy and sell houses which are listed on our database. To keep up with the 
        competition, we allow users to either buy or sell regardless to if you initially 
        registered as a buyer or seller. Additionally, we gather more user through a combination 
        of various marketing methods such as:
        <ul>
            <li>Online Advertisement</li>
            <li>Targeted Marketing</li>
            <li>And Simply By Word of Mouth</li>
        </ul>
        </p>
        <p>

        </p>
        <p>
        </p>
    </div>
</body>

</html>