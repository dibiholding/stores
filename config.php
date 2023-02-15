<?php
$servername = "localhost";
$username = "dibi";
$password = "qiVgyh-hysta8-tyrfiq";
$dbname = "stores";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

mysqli_close($conn);

?>