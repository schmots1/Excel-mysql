<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = $_GET['database'];
$block = $_GET['block'];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<a href=dashboard.php?database=$dbname> <- Back to Dashboard</a>";
echo "<table border=0>"; 
//Storage Controller section
echo "<tr bgcolor=grey>";
echo "<td>Filer</td>";
echo "<td>Aggregate</td>";
echo "<td>Block type</td>";
echo "<td># Volumes</td>";
echo "<td>Used Space</td>";
echo "</tr>";
if (empty($_GET['filer'])) {
   if (empty($_GET['block'])) {
   $sql = "select storage_controller,name,total_used_size_GB,block_type from Aggregates order by storage_controller,block_type,name";
   }
   else {   
   $sql = "select storage_controller,name,total_used_size_GB,block_type from Aggregates where block_type like $block order by storage_controller,block_type,name";
   }
}
else {
$sql = "select storage_controller,name,total_used_size_GB,block_type from Aggregates where storage_controller like '" .  $_GET['filer'] . "' order by storage_controller,block_type,name";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
   $sql1 = "select * from Volumes where storage_controller like '" . $row['storage_controller'] . "'  and aggregate_name like '" . $row['name'] . "'";
   $result1 = $conn->query($sql1);
   $num_rows = mysqli_num_rows($result1); 
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\">";
echo "<td>"  . $row['storage_controller'] . "</td>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['block_type'] . "</td>";
if ($num_rows > 0){
echo "<td><a href=volumes.php?database=$dbname&filer=" . $row['storage_controller'] . "&aggr=". $row['name'] . ">$num_rows</a></td>";
}
else {
echo "<td>$num_rows</td>";
}
echo "<td>" . $row['total_used_size_GB'] . "</td>";
}
echo "</tr>";
//echo "$result</td>";
}
else {
echo "0 results";
}
echo "</tr>";
echo "</table>";
$conn->close();
?>
