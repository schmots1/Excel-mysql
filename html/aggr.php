<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = $_GET['database'];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<a href=dashboard.php?database=$dbname> <- Back to Dashboard</a>";
echo "<table border=0>"; 
//Storage Controller section
echo "<tr bgcolor=grey><td>Filer</td><td>Aggregate</td><td>Block type</td><td>Used Space</td></tr>";
if (empty($_GET['filer'])) {
$sql = "select storage_controller,name,total_used_size_GB,block_type from Aggregates order by storage_controller,block_type,name";
}
else {
$sql = "select storage_controller,name,total_used_size_GB,block_type from Aggregates where storage_controller like '" .  $_GET['filer'] . "' order by storage_controller,block_type,name";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td>"  . $row['storage_controller'] . "</td><td>" . $row['name'] . "</td><td>" . $row['block_type'] . "</td><td>" . $row['total_used_size_GB'];
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
