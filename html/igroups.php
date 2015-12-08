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
echo "<a href=luns.php?database=$dbname> <- Back to Luns</a>";
echo "<table border=0>"; 
//iGroup section
$igroup = $_GET['igroup'];
echo "<tr bgcolor=grey><td>iGroup</td><td>Protocol</td><td>OS</td><td>Alua?</td><td>Members</td></tr>";
$sql = "select igroup_name,alua,protocol,os,member from iGroups where `igroup_name` like '$igroup'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td style=\"background:$alt\">"  . $row['igroup_name'] . "</td><td>" . $row['protocol'] . "</td><td>" . $row['os'] . "</td><td>" . $row['alua'] . "</td><td>" . $row['member'];
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
