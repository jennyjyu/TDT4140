<?php
    include 'config.php';

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }


    $userID = mysqli_real_escape_string($conn, $_GET["userID"]);
    $password = mysqli_real_escape_string($conn, $_GET["password"]);
    $name = mysqli_real_escape_string($conn, $_GET["name"]);
    $location = mysqli_real_escape_string($conn, $_GET["location"]);


    $password = hash("sha256", $password);


    $sql = 'INSERT INTO Users (UserID, Pass, Name, Location) VALUES (' . $userID . ', "'. $password .'", "' . $name . '", "' . $location . '")';

    $sqlcheck = 'SELECT UserID FROM Users WHERE UserID = ' . $userID;

    $result = $conn->query($sqlcheck);

    if($result->num_rows > 0) {
        echo "Error 377: This phone number is already registered."; // DO NOT CHANGE THIS
    }
    else {
        $conn->query($sql);
        echo $userID;
    }

    $conn->close();
?>
