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
//Column Header  section
echo "<tr bgcolor=grey>";
echo "<td>Filer</td>";
echo "<td>Volume</td>";
echo "<td>Lun</td>";
echo "<td>OS</td>";
echo "<td>iGroup</td>";
echo "</tr>";
if (!empty($_GET['filer']) and !empty($_GET['vol'])) {
$sql = "select * from Luns where storage_controller like '" . $_GET['filer'] . "' and volume_name like '" . $_GET['vol'] . "'";
}
else {
$sql = "select * from Luns order by storage_controller,qtree_name";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$igroup = split ("\:", $row['igroups_lunid']);
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\">";
echo "<td>" . $row['storage_controller'] . "</td>";
echo "<td>" . $row['volume_name'] . "</td>";
echo "<td>" . $row['lun_name'] . "</td>";
echo "<td>" . $row['os_type'] . "</td>";
echo "<td><a href=igroups.php?database=$dbname&igroup=" . $igroup['0'] . ":" . $igroup['1'] . ">" . $row['igroups_lunid'] . "</a></td>";
echo "</tr>";
}
//echo "$result</td>";
}
else {
echo "0 results";
}
echo "</tr>";
echo "</table>";
$conn->close();
?>
