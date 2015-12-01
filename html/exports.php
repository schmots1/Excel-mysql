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
//Exports section
echo "<tr bgcolor=grey><td>Filer</td><td>vFiler</td><td>Volume</td><td>Export</td><td>nosuid</td><td>Anon</td><td>Read-only access</td><td>Read-write access</td><td>Root access</td></tr>";
//$sql = "select storage_controller,vfiler_name,aggregate_name,volume_name,qtree_name,export_path,nosuid,anon,read_only,read_write,root from NFS_Exports order by storage_controller,volume_name";
$sql = "select * from NFS_Exports order by storage_controller,volume_name";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td style=\"background:$alt\">"  . $row['storage_controller'] . "</td><td>" . $row['vfiler_name'] . "</td><td>" . $row['volume_name'] . "</td><td>" . $row['export_path'] . "</td><td>" . $row['nosuid'] . "</td><td>" . $row['anon'] . "</td><td>" . $row['read_only'] . "</td><td>" . $row['read_write'] . "</td><td>" . $row['root'];
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
