<html>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT count(*) FROM Volumes";
$result = $conn->query($sql);
print_r($result);
print_r "There are $result Volumes";
print_r $result->num_rows;
print_r mysqli_result($result);
$conn->close();
?>
</body>
</html>
