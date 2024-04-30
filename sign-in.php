<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Enchanted Estates</title>
    <link rel="icon" href="./house_img/favicon.png">
    <link rel="stylesheet" href="./common.css">
    <script type="text/javascript" src="validSignin.js"></script>
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
    <form method="post" action="./signin-confirm.php" id="sign-in" onsubmit="return validSignIn()">
        <fieldset class="sign-in">
            <legend>Sign-in:</legend>
            <table>
                <tr>
                    <td></td>
                    <td id="errorUser"></td>
                </tr>
                <tr>
                    <td>
    					<label><strong>Username:</strong></label>
                    </td>
                    <td>
	    				<input type="text" name="user" value="" maxlength="50">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td id="errorPass"></td>
                </tr>
                <tr>
                    <td>
    					<label><strong>Password:</strong></label>
                    </td>
                    <td>
	    				<input type="text" name="password" value="" maxlength="50">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                        <input type="submit" value="Sign In">
                    </td>
                </tr>
            </table>
            <a class="new" href="./sign-up.php">I don't have an account</a>
        </fieldset>
    </form>
    <?php
    if(isset($_SESSION['error']) && !empty($_SESSION['error'])) {
        echo "<script>alert('You don\'t have an account in our systems or you have the wrong password.');</script>";
        unset($_SESSION['error']);
    } 
    ?>
</body>

</html>