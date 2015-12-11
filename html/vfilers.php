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
echo "<tr bgcolor=grey><td>Filer</td><td>vFiler</td><td>Status</td><td># Volumes</td><td># Qtrees</td><td># Luns</td><td># Shares</td><td># Exports</td><td># Snapmirrors</td><td># SnapVaults</td><td>Total Used Size GB</td></tr>";
$sql = "select * from Vfilers where vfiler_name not in (select storage_controller from Vfilers)";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td style=\"background:$alt\">"  . $row['storage_controller'] . "</td><td>" . $row['vfiler_name'] . "</td><td>" . $row['status'] . "</td><td>" . $row['total_volumes'] . "</td><td>" . $row['total_qtrees'] . "</td><td>" . $row['total_luns'] . "</td><td>" . $row['total_shares'] . "</td><td>" . $row['total_exports'] . "</td><td>" . $row['total_snapmirrors'] . "</td><td>" . $row['total_snapvaults'] . "</td><td>" . $row['total_used_size_GB'];
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
