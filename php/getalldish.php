 <?php
    include 'config.php';

    $sql = "SELECT * FROM Dish";
    $result = $conn->query($sql);
    $returnString = "";

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            #echo 'ID: ' . $row['DishID'] . ', Name: ' . $row['Name'] . ", Descpription: " . $row['Description'] . ", Price: " . $row['Price'] . "\n";
            $returnString .= $row['DishID'] . '|' . $row['Name'] . '|' . $row['Description'] . '|' . $row['Price'] . ';'; #Seperate values with | and columns with ;
        }
    } else {
        $returnString = "0 results;";
    }
    $returnString = substr($returnString, 0, -1);
    echo $returnString;

    $conn->close();
?>