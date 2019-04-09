<?php
    include 'config.php';

    $order = mysqli_real_escape_string($conn, $_GET["order"]);
    $time = mysqli_real_escape_string($conn, $_GET["time"]);
    $location = mysqli_real_escape_string($conn, $_GET["location"]);
    $userID = mysqli_real_escape_string($conn, $_GET["userID"]);

    $sql = 'INSERT INTO Orders (PickUpTime, Location) VALUES("'. $time .'"' . ', "' . $location . '")';
    $conn->query($sql);

    $sql1 = 'SELECT * FROM Orders ORDER BY OrderID DESC LIMIT 1';
    $result = $conn->query($sql1); //returnerer 1 istedenfor siste tall
    $LastOrder = 0;
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $LastOrder = (int) $row['OrderID'];
            echo $LastOrder;
        }
    }

    $sql2 = 'INSERT INTO UsersWhoOrdered (UserID, OrderID) VALUES(' . $userID . ', ' . $LastOrder .')';

    $splittedString = explode("|", $order);
    for($i = 0; $i < sizeof($splittedString); $i += 2) {
        # INSERT INTO DishInOrder VALUES(orderid, dishid, quantity);
        $conn->query('INSERT INTO DishInOrder (OrderID, DishID, Quantity) VALUES(' . $LastOrder . ', ' . $splittedString[$i] . ', ' . $splittedString[$i+1] . ')');
    }
    $conn->query($sql2);

    $conn->close();
?>
