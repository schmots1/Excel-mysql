<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = $_GET['database'];
$method = urldecode($_GET['method']);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<a href=dashboard.php?database=$dbname> <- Back to Dashboard</a>";
echo "<table border=0>"; 
//Migration section
echo "<tr bgcolor=grey><td>Filer</td><td>Aggregate</td><td>vFiler</td><td>Volume</td><td>Workload</td><td>Used Size GB</td><td>Snapmirror Type</td><td>Snapmirror Mode</td><td>Snapmirror Partner</td><td>Snapvaults</td><td>Snapvault Mode</td><td>SnapVault Partner</td>";
$sql = "select storage_controller,aggregate_name,vfiler_name,source_volume,workload,total_used_size_GB,snapmirror_type,snapmirror_mode,snapmirror_partner,snapvaults,snapvault_mode,snapvault_partner from Migration_Master_Volume_View where `migration_methodology` like '$method' order by storage_controller, workload, source_volume";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td>"  . $row['storage_controller'] . "</td><td>" . $row['aggregate_name'] . "</td><td>" . $row['vfiler_name'] . "</td><td>" . $row['source_volume'] . "</td><td>" . $row['workload'] . "</td><td>" . $row['total_used_size_GB'] . "</td><td>" . $row['snapmirror_type'] . "</td><td>" . $row['snapmirror_mode'] . "</td><td>" . $row['snapmirror_partner'] . "</td><td>" . $row['snapvaults'] . "</td><td>" . $row['snapvault_mode'] . "</td><td>" . $row['snapvault_partner'];
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
