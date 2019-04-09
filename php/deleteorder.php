<?php
    include 'config.php';

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $orderID = mysqli_real_escape_string($conn, $_GET["OrderID"]);
    $sql = 'DELETE FROM Orders WHERE OrderID="' . $orderID . '"';
    $result = $conn->query($sql);
    echo 'Deleted: ' . $orderID;
    $conn->close();
?>
