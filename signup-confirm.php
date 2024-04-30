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
    if(($conn->query("SELECT * FROM User WHERE username='" . $_POST['user'] . "'")->num_rows) != 1) {
        $x = $_POST['user'];
        $y = $_POST['password'];
        $z = $_POST['role'];
        $sql = "INSERT INTO User (username, pass, U_role) VALUES ('$x', '$y', '$z')";
        if ($conn->query($sql) === TRUE) {
            echo "<script> console.log('Success'); </script>";
        } else {
            echo "<script> console.log('Failure'); </script>";
        }
        echo "<script> window.location = \"./sign-in.php\"; </script>";
    } else {
        $_SESSION['error'] = "ERROR";
        echo "<script> window.location = \"./sign-up.php\"; </script>";
    }  
?>