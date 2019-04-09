<?php
    include 'config.php';

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $orderID = mysqli_real_escape_string($conn, $_GET["orderID"]);
    $stars = mysqli_real_escape_string($conn, $_GET["stars"]);
    $review = mysqli_real_escape_string($conn, $_GET["review"]);

    // INSERT INTO Reviews (orderID, stars, review) VALUES(orderID, "stars", "review");
    $sql = 'INSERT INTO Reviews (orderID, stars, review) VALUES(' . $orderID  . ', "' . $stars . '", "' . $review . '")';
    $conn->query($sql);

    $conn->close();
?>
