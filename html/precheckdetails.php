<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = $_GET['database'];
$precheck = urldecode($_GET['precheck']);
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<a href=precheck.php?database=$dbname> <- Back to Prechecks</a>";
echo "<h1>$precheck</h1>";
echo "<table border=0>"; 
//Precheck entity section
echo "<tr bgcolor=grey><td>Filer</td><td>Aggregate</td><td>vFiler</td><td>Volume</td><td>Qtree</td><td>Lun</td>";
$sql = "select storage_controller,aggregate_name,vfiler_name,volume_name,qtree_name,lun_name from Transition_PreCheck_Details where pre_check like '$precheck' order by storage_controller";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td>"  . $row['storage_controller'] . "</td><td>" . $row['aggregate_name'] . "</td><td>" . $row['vfiler_name'] . "</td><td>" . $row['volume_name'] . "</td><td>" . $row['qtree_name'] . "</td><td>" . $row['lun_name'];
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
