<?php
    include 'config.php';

    /*if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }*/

    $userID = mysqli_real_escape_string($conn, $_GET["userID"]);
    $password = mysqli_real_escape_string($conn, $_GET["password"]);

    $password = hash("sha256", $password);

    //$sql = 'SELECT UserID, Pass FROM User WHERE UserID = ' . $userID  . ' AND Pass = "'. $password .'"';

    //$result = $conn->query($sql);

    /*if($result->num_rows > 0){
        if($result->num_rows == 1){
            while($row = $result->fetch_assoc()){
                echo $row['UserID'];
                #. ", " . $row['Pass']
            }
        } else{
            echo "Error 652: Call Nigiri Falls and order by phone.";
        }
    } else {
        echo "Wrong username or password. Please try again.";
    }*/
    #echo "New user with phone number:" . $row["userID"]. "\n";

    $statement = $conn->prepare('SELECT UserID, Pass FROM Users WHERE UserID = ? AND Pass = ?');
    $statement->bind_param("is", $userID, $password); // integer, string
    $statement->execute();
    
    $statement->store_result();
    $statement->bind_result($resultUserID, $resultPassword);
    $statement->fetch();

    echo $resultUserID;

    $statement->close();
    $conn->close();
?>
