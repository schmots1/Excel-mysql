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
echo "<tr bgcolor=grey><td>Filer</td><td>Volume</td><td>Lun</td><td>iGroup</td></tr>";
$sql = "select storage_controller,volume_name,lun_name,igroups_lunid from Luns order by storage_controller,qtree_name";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$igroup = split ("\:", $row['igroups_lunid']);
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td style=\"background:$alt\">"  . $row['storage_controller'] . "</td><td>" . $row['volume_name'] . "</td><td>" . $row['lun_name'] . "</td><td><a href=igroups.php?database=$dbname&igroup=" . $igroup['0'] . ":" . $igroup['1'] . ">" . $row['igroups_lunid'] . "</a>";
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
