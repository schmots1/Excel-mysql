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
//Column Header section
echo "<tr bgcolor=grey>";
echo "<td>Filer</td>";
echo "<td>Volume</td>";
echo "<td>Share</td>";
echo "<td>Mount Point</td>";
echo "</tr>";
//SQL Statement section
if (!empty($_GET['vfiler']) and !empty($_GET['filer'])) {
$sql = "select * from CIFS_Shares where storage_controller like '" . $_GET['filer'] . "'  and vfiler_name like '" . $_GET['vfiler'] . "'";
}
else {
$sql = "select storage_controller,volume_name,share_name,mount_point from CIFS_Shares order by storage_controller,volume_name";
}
//Results Section
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td style=\"background:$alt\">"  . $row['storage_controller'] . "</td><td>" . $row['volume_name'] . "</td><td><a href=acls.php?database=$dbname&share=" . $row['share_name'] . ">" . $row['share_name'] . "</a></td><td>" . $row['mount_point'];
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
