 <?php
    $servername = "mysql.stud.ntnu.no";
    $username = "magnuti_super";
    $password = "nigiri50";
    $db_name = "magnuti_nigiridb";

    $conn = mysqli_connect($servername, $username, $password, $db_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>