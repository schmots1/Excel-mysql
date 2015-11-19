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
echo "<table border=1>"; 

//Storage Controller section
echo "<tr>";
$sql = "select * from Storage_Controllers";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td style = 'width: 200px'>Storage Controllers</td><td>$num_rows</td>";
echo "</tr>";

//Aggregate section
echo "<tr>";
$sql = "select * from Aggregates";
$result =  $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>Aggregates</td><td>$num_rows</td>";
echo "</tr>";
echo "<tr>";
$sql = "select * from Aggregates where block_type like '32-bit'";
$result = $conn->query($sql);
$num_rows=mysqli_num_rows($result);
echo "<td>&nbsp&nbsp32-bit Aggregates</td><td>$num_rows</td>";
echo "</tr>";

//Volume section
echo "<tr>";
$sql = "SELECT name, block_type, total_used_size_GB FROM Volumes";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>Volumes</td><td>$num_rows</td>";
echo "</tr>";
echo "<tr>";
$sql = "Select * from Volumes where block_type like '32-bit'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>&nbsp&nbsp32-bit Volumes</td><td>$num_rows</td>";
echo "</tr>";

//Qtree section
echo "<tr>";
$sql = "select * from Qtrees";
$result =  $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>Qtrees</td><td>$num_rows</td>";
echo "</tr>";

//if ($result->num_rows > 0) {
    // output data of each row
//    while($row = $result->fetch_assoc()) {
//        echo "name: " . $row["name"]. " - Block Type: " . $row["block_type"]. " Used Space: " . $row["total_used_size_GB"]. "<br>";
//    }
//} else {
//    echo "0 results";
//}
$conn->close();
?>
