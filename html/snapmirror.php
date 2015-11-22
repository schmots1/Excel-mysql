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
echo "<a href=index.php> <- Back to Dashboard</a>";
echo "<table border=1>"; 
echo "<tr><td>Storage Controller</td><td>Source Controller</td><td>Destination Controller</td><td># of Snapmirrors</td></tr>";
//Snapmirror relationship section
$sql = "select storage_controller,source_controller,destination_controller, count(*) from SnapMirror group by source_controller order by storage_controller, source_controller";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
echo "<tr><td>"  . $row['storage_controller'] . "</td><td>" . $row['source_controller'] . "</td><td>" . $row['destination_controller'] . "</td><td>" . $row['count(*)'];
}
echo "</td></tr>";
//echo "$result</td>";
}
else {
echo "0 results";
}
echo "</tr>";


echo "</table>";
$conn->close();
?>
