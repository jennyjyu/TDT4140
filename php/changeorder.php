 <?php
    include 'config.php';

    $orderid = mysqli_real_escape_string($conn, $_GET["orderid"]);
    $orderid = (int) $orderid;
    $status = mysqli_real_escape_string($conn, $_GET["status"]);

    # UPDATE Orders SET OrderStatus="Confirm" WHERE OrderID=165;
    $sql = 'UPDATE Orders SET OrderStatus="' . $status . '" WHERE OrderID=' . $orderid;
    $conn->query($sql);


    $conn->close();
?>