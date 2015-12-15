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
//Column Header Section
echo "<tr bgcolor=grey>";
echo "<td>Storage Controller</td>";
echo "<td>Direction</td>";
echo "<td>SnapMirror Partner</td>";
echo "<td># of Snapmirrors</td>";
echo "</tr>";
//SQL Statement section
if (!empty($_GET['vfiler']) and !empty($_GET['filer'])) {
$sql = "select *, count(*) from SnapMirror where storage_controller like '" . $_GET['filer'] . "'  and (source_vfiler like '" . $_GET['vfiler'] . "' or destination_vfiler like '" . $_get['vfiler'] . "') group by source_controller";
}
else {
$sql = "select storage_controller,source_controller,destination_controller, count(*) from SnapMirror group by source_controller order by storage_controller, source_controller";
}
// Results
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
//Outputs
if ($row['storage_controller'] == $row['source_controller']){
echo "<tr style=\"background:$alt\">";
echo "<td>"  . $row['storage_controller'] . "</td>";
echo "<td align=center> -> </td>";
echo "<td>" . $row['destination_controller'] . "</td>";
echo "<td>" . $row['count(*)'] . "</td>";
}
if ($row['storage_controller'] != $row['source_controller']){
echo "<tr style=\"background:$alt\">";
echo "<td>"  . $row['storage_controller'] . "</td>";
echo "<td align=center> <- </td>";
echo "<td>" . $row['source_controller'] . "</td>";
echo "<td>" . $row['count(*)'] . "</td>";
}
echo "</tr>";
}
//echo "$result</td>";
}
else {
echo "0 results";
echo "<br>$sql";
}
echo "</tr>";


echo "</table>";
$conn->close();
?>
