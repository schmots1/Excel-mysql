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
//Qtree section
echo "<tr bgcolor=grey><td>Filer</td><td>Qtree</td><td>Security Style</td><td>Status</td><td>Host Volume</td></tr>";
if (!empty($_GET['vol']) and !empty($_GET['filer']) and !empty($_GET['aggr'])) {
$sql = "select * from Qtrees where storage_controller like '" . $_GET['filer'] . "'  and aggregate_name like '" . $_GET['aggr'] . "' and volume_name like '" . $_GET['vol'] . "'";
}
elseif (!empty($_GET['vfiler']) and !empty($_GET['filer'])) {
$sql = "select * from Qtrees where storage_controller like '" . $_GET['filer'] . "'  and vfiler_name like '" . $_GET['vfiler'] . "'";
}
else {
$sql = "select storage_controller,qtree_name,volume_name,status,security_style from Qtrees order by storage_controller,qtree_name";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td style=\"background:$alt\">"  . $row['storage_controller'] . "</td><td>" . $row['qtree_name'] . "</td><td>" . $row['security_style'] . "</td><td>" . $row['status'] . "</td><td>" . $row['volume_name'];
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
