<?php
   include 'config.php';

   $orderID = mysqli_real_escape_string($conn, $_GET["orderID"]);
   $orderID = (int) $orderID;
   $status = "CANCELED";

   # UPDATE Orders SET OrderStatus="Confirm" WHERE OrderID=165;
   $sql = 'UPDATE Orders SET OrderStatus="' . $status . '" WHERE OrderID=' . $orderID;
   $conn->query($sql);


   $conn->close();
?>
