<?php
    include 'config.php';

    $userID = mysqli_real_escape_string($conn, $_GET["userID"]);

    $sql = "SELECT * FROM Orders natural join UsersWhoOrdered where UserID =" .$userID;
    $result = $conn->query($sql);

    $returnString = "";
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $returnString .= $row['OrderID'] . '|' . $row['PickUpTime'] . "|" . $row['OrderStatus'] . '|';
            $tempOrderID = (int) $row['OrderID'];

            //New
            $tempUserID = 0;
            $sql3 = 'SELECT UserID FROM (Orders NATURAL JOIN UsersWhoOrdered) WHERE UsersWhoOrdered.OrderID=' . $tempOrderID;
            $result3 = $conn->query($sql3);
            if($result3->num_rows > 0){
                while($row3 = $result3->fetch_assoc()){
                    $tempUserID = $row3['UserID'];
                    //$returnString .= $row3['UserID'] . '|' . $row3['Name'] . '|';
                }
            } else {
                $returnString .= "Error getallorder.php in result3 else statement;"; # Fix
            }

            $tempUserID = (int) $tempUserID;
            $sql4 = 'SELECT UserID, Name FROM (Users NATURAL JOIN UsersWhoOrdered) WHERE UsersWhoOrdered.UserID=' . $tempUserID . ' LIMIT 1';
            $result4 = $conn->query($sql4);
            if($result4->num_rows > 0){
                while($row4 = $result4->fetch_assoc()){
                    $returnString .= $row4['UserID'] . '|' . $row4['Name'] . '|';
                }
            } else {
                $returnString .= "Error getallorder.php in result4 else statement;"; # Fix
            }

            //End new

            $sql2 = 'SELECT Orders.OrderID, Orders.PickUpTime, Orders.OrderStatus, Dish.Name, DishInOrder.Quantity FROM Orders NATURAL JOIN DishInOrder NATURAL JOIN Dish WHERE OrderID=' . $tempOrderID . ' ORDER BY Orders.OrderID';
            $result2 = $conn->query($sql2);
            if($result2->num_rows > 0){
                while($row2 = $result2->fetch_assoc()){
                    $returnString .= $row2['Name'] . "|" . $row2['Quantity'] . "|";
                }
            } else {
                $returnString .= "0 dishes in the order| ;"; # Fix
            }
            $returnString = substr($returnString, 0, -1);
            $returnString .= ";";
        }
    } else {
        $returnString = "0 orders;"; # Fix
    }
    $returnString = substr($returnString, 0, -1);
    echo $returnString;

    $conn->close();
?>
