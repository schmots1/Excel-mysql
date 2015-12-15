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
echo "<td>vFiler</td>";
echo "<td>Status</td>";
echo "<td># Volumes</td>";
echo "<td># Qtrees</td>";
echo "<td># Luns</td>";
echo "<td># Shares</td>";
echo "<td># Exports</td>";
echo "<td># Snapmirrors</td>";
echo "<td># SnapVaults</td>";
echo "<td>Total Used Size GB</td>";
echo "</tr>";
//SQL Statement Section
$sql = "select * from Vfilers where vfiler_name not in (select storage_controller from Vfilers)";
//Query results section
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
//Output of query
echo "<tr style=\"background:$alt\">";
echo "<td>"  . $row['storage_controller'] . "</td>";
echo "<td>" . $row['vfiler_name'] . "</td>";
echo "<td>" . $row['status'] . "</td>";
if ($row['total_volumes'] > 0) {
echo "<td><a href=volumes.php?database=$dbname&filer=" . $row['storage_controller'] . "&vfiler=" . $row['vfiler_name'] . ">" . $row['total_volumes'] . "</a></td>";
}
else {
echo "<td>" . $row['total_volumes'] . "</td>";
}
if ($row['total_qtrees'] > 0) {
echo "<td><a href=qtrees.php?database=$dbname&filer=" . $row['storage_controller'] . "&vfiler=" . $row['vfiler_name'] . ">" . $row['total_qtrees'] . "</a></td>";
}
else {
echo "<td>" . $row['total_qtrees'] . "</td>";
}
if ($row['total_luns'] > 0) {
echo "<td><a href=luns.php?database=$dbname&filer=" . $row['storage_controller'] . "&vfiler=" . $row['vfiler_name'] . ">" . $row['total_luns'] . "</a></td>";
}
else {
echo "<td>" . $row['total_luns'] . "</td>";
}
if ($row['total_shares'] > 0) {
echo "<td><a href=shares.php?database=$dbname&filer=" . $row['storage_controller'] . "&vfiler=" . $row['vfiler_name'] . ">" . $row['total_shares'] . "</a></td>";
}
else {
echo "<td>" . $row['total_shares'] . "</td>";
}
if ($row['total_exports'] > 0) {
echo "<td><a href=exports.php?database=$dbname&filer=" . $row['storage_controller'] . "&vfiler=" . $row['vfiler_name'] . ">" . $row['total_exports'] . "</a></td>";
}
else {
echo "<td>" . $row['total_exports'] . "</td>";
}
if ($row['total_snapmirrors'] > 0) {
echo "<td><a href=snapmirrors.php?database=$dbname&filer=" . $row['storage_controller'] . "&vfiler=" . $row['vfiler_name'] . ">" . $row['total_snapmirrors'] . "</a></td>";
}
else {
echo "<td>" . $row['total_snapmirrors'] . "</td>";
}
if ($row['total_snapvaults'] > 0) {
echo "<td><a href=snapvaults.php?database=$dbname&filer=" . $row['storage_controller'] . "&vfiler=" . $row['vfiler_name'] . ">" . $row['total_snapvaults'] . "</a></td>";
}
else {
echo "<td>" . $row['total_snapvaults'] . "</td>";
}
echo "<td>" . $row['total_used_size_GB'] . "</td>";
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
