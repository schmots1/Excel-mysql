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
echo "<table border=1>"; 

//Storage Controller section
echo "<tr>";
$sql = "select * from Storage_Controllers";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td style = 'width: 200px'><a href=controller.php>Storage Controllers</a></td><td>$num_rows</td>";
echo "</tr>";

//Aggregate section
echo "<tr>";
$sql = "select * from Aggregates";
$result =  $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=aggr.php>Aggregates</a></td><td>$num_rows</td>";
echo "</tr>";
echo "<tr>";
$sql = "select * from Aggregates where block_type like '32-bit'";
$result = $conn->query($sql);
$num_rows=mysqli_num_rows($result);
echo "<td>&nbsp&nbsp32-bit Aggregates</td><td>$num_rows</td>";
echo "</tr>";

//Volume section
echo "<tr>";
$sql = "SELECT name, block_type, total_used_size_GB FROM Volumes";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=volumes.php>Volumes</a></td><td>$num_rows</td>";
echo "</tr>";
echo "<tr>";
$sql = "Select * from Volumes where block_type like '32-bit'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>&nbsp&nbsp32-bit Volumes</td><td>$num_rows</td>";
echo "</tr>";
echo "<tr>";
$sql = "Select * from Volumes where type like 'trad'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>&nbsp&nbspTraditional Volumes</td><td>$num_rows</td>";
echo "</tr>";

//Qtree section
echo "<tr>";
$sql = "select * from Qtrees";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=qtree.php>Qtrees</a></td><td>$num_rows</td>";
echo "</tr>";

//Lun section
echo "<tr>";
$sql = "select * from Luns";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>Luns</td><td>$num_rows</td>";
echo "</tr>";

//CIFS shares section
echo "<tr>";
$sql = "select * from CIFS_Shares where LineID is not null";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>Shares</td><td>$num_rows</td>";
echo "</tr>";

//Export section
echo "<tr>";
$sql = "select * from NFS_Exports";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>Exports</td><td>$num_rows</td>";
echo "</tr>";

//Totals section
echo "<tr>";
$sql = "select cast(sum(replace(total_used_size_GB,',','')) as decimal (10,2)) as total from Volumes";
$result = $conn->query($sql);
echo "<td>Space Used</td><td>";
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
echo $row['total'];
echo "</td>";
//echo "$result</td>";
}
}
else {
echo "0 results";
}
echo "</tr>";

//SnapMirror section
echo "<tr>";
$sql = "select * from SnapMirror";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=snapmirror.php>SnapMirrors</a></td><td>$num_rows</td>";
echo "</tr>";

//SnapVault section
echo "<tr>";
$sql = "select * from SnapVault";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>SnapVaults</td><td>$num_rows</td>";
echo "</tr>";

//Transition PreCheck section
echo "<tr>";
$sql = "select * from Transition_PreCheck_Summary where severity like 'Red'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=precheck.php>PreCheck issues</a></td><td bgcolor='red'>$num_rows</td>";
$sql = "select * from Transition_PreCheck_Summary where severity like 'Yellow'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "</tr><tr>";
echo "<td></td><td bgcolor='yellow'>$num_rows</td>";
echo "</tr>";

echo "</table>";
$conn->close();
?>
