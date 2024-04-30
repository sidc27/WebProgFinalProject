<?php 
    session_start();
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
    //Check
    $query = "SELECT * FROM User WHERE username='" . $_POST['user'] . "'";
    $query .= " AND pass='" . $_POST['password'] . "'";
    if(($conn->query($query)->num_rows) != 0) {
        $content = $conn->query($query)->fetch_assoc();
        $_SESSION['username'] = $_POST['user'];
        if ($content['U_role'] == "S") {
            echo "<script> window.location = \"./seller-dashboard.php\"; </script>";
        }
        if ($content['U_role'] == "B") {
            echo "<script> window.location = \"./Dashbroad.php\"; </script>";
        }
        if ($content['U_role'] == "A") {
            echo "<script> window.location = \"./admin-dashboard.php\"; </script>";
        }
    } else {
        $_SESSION['error'] = "ERROR";
        echo "<script> window.location = \"./sign-in.php\"; </script>";
    }  
    ?>