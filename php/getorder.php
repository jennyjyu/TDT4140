<?php
    include 'config.php';

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $orderID = mysqli_real_escape_string($conn, $_GET["OrderID"]);
    $pickUpTime = mysqli_real_escape_string($conn, $_GET["PickUpTime"]);

    if($orderID == '' && $pickUpTime == ''){

    }
    else if($orderID == ''){
        $sql = 'SELECT * FROM Orders WHERE PickUpTime=' . $pickUpTime;
        echo "All orders with pick up time =" . $pickUpTime . "\n";
    }
    else if($pickUpTime == ''){
        $sql = 'SELECT * FROM Orders WHERE OrderID="' . $orderID . '"';
    }
    else{
        $sql = 'SELECT * FROM Orders WHERE OrderID="' . $orderID . '" OR PickUpTime =' . $pickUpTime;
         echo "Selection where orderID =" . $orderID . " or pick up time=" . $pickUpTime . "\n";
    }
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo $row["OrderID"]. "|" . $row["PickUpTime"] . "|" . $row["OrderStatus"];
        }
    } else {
        echo "0 results";
    }

    $conn->close();
?>
