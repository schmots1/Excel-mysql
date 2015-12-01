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
echo "<tr bgcolor=grey><td>Filer</td><td>Volume</td><td>Block Type</td><td>Used Space</td><td>File Count</td><td>Aggregate</td><td>Number of Qtrees</td><td>Number of Luns</td><td>Number of Snapmirrors</td><td>Number of Snapvaults</td><td>State</td><td>Language</td><td>Vfiler</td>";
$sql = "select storage_controller,aggregate_name,vfiler_name,name,workload,state,block_type,language,files_used,total_used_size_GB,total_luns,total_qtrees,total_snapmirrors,total_snapvaults from Volumes order by storage_controller, block_type, name";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td>"  . $row['storage_controller'] . "</td><td>" . $row['name'] . "</td><td>" . $row['block_type'] . "</td><td>" . $row['total_used_size_GB'] . "</td><td>" . $row['files_used'] . "</td><td>" . $row['aggregate_name'] . "</td><td>" . $row['total_qtrees'] . "</td><td>" . $row['total_luns'] . "</td><td>" . $row['total_snapmirrors'] . "</td><td>" . $row['total_snapvaults'] . "</td><td>" . $row['state'] . "</td><td>" . $row['language'] . "</td><td>" . $row['vfiler_name'];
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
