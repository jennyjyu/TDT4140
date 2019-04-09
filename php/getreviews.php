<?php
    include 'config.php';

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }



    $sql = 'SELECT * FROM Reviews';
    $result = $conn->query($sql);



    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo $row["orderID"]. "|" . $row["stars"] . "|" . $row ["review"] . ";";
        }
    } else {
        echo "0 results";
    }

    $conn->close();
?>
