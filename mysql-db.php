<?php
$servername = "localhost";
$username = "zahin";
$password = "zahinpassword";
$dbname = "day_10";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection

if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
// else {
//     echo 'database connected';
// }
?>