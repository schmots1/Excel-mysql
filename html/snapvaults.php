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
echo "<tr bgcolor=grey><td>Storage Controller</td><td>Direction</td><td>SnapVault Partner</td><td># of SnapVaults</td></tr>";
//Snapmirror relationship section
$sql = "select storage_controller,source_controller,destination_controller, count(*) from SnapVault group by source_controller order by storage_controller, source_controller";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
if ($row['storage_controller'] == $row['source_controller']){
echo "<tr style=\"background:$alt\"><td>"  . $row['storage_controller'] . "</td><td align=center> -> </td><td>" . $row['destination_controller'] . "</td><td>" . $row['count(*)'];
}
if ($row['storage_controller'] != $row['source_controller']){
echo "<tr style=\"background:$alt\"><td>"  . $row['storage_controller'] . "</td><td align=center> <- </td><td>" . $row['source_controller'] . "</td><td>" . $row['count(*)'];
}
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
