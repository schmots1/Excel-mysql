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
echo "<tr bgcolor=grey><td>Host Name</td><td>Model</td><td>OnTap Version</td><td>Serial Number</td><td>Aggregate Count</td></tr>";
$sql = "select storage_controller,system_model,system_serial_number,version,total_aggregates from Storage_Controllers order by storage_controller";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td style=\"background:$alt\">"  . $row['storage_controller'] . "</td><td>" . $row['system_model'] . "</td><td>" . $row['version'] . "</td><td>" . $row['system_serial_number'] . "</td><td><a href=aggr.php?filer=" . $row['storage_controller'] . ">" . $row['total_aggregates'] . "</a>";
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
