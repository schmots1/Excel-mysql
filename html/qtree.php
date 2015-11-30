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
echo "<table border=0>"; 
//Storage Controller section
echo "<tr bgcolor=grey><td>Filer</td><td>Qtree</td><td>Status</td><td>Host Volume</td></tr>";
$sql = "select storage_controller,qtree_name,volume_name,status from Qtrees order by storage_controller,qtree_name";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td style=\"background:$alt\">"  . $row['storage_controller'] . "</td><td>" . $row['qtree_name'] . "</td><td>" . $row['status'] . "</td><td>" . $row['volume_name'];
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
