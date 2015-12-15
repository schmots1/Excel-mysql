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
$heading = split ("\-", $dbname);
echo "<h1>$heading[1]</h1>";
echo "<table><tr><td>";
echo "<table border=1>"; 

//Storage Controller section
echo "<tr>";
$sql = "select * from Storage_Controllers";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td style = 'width: 200px'><a href=controllers.php?database=$dbname>Storage Controllers</a></td><td>$num_rows</td>";
echo "</tr>";

//vFiler section
echo "<tr>";
$sql = "select * from Vfilers where vfiler_name not in (select storage_controller from Vfilers)";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td style = 'width: 200px'><a href=vfilers.php?database=$dbname>vFilers</a></td><td>$num_rows</td>";
echo "</tr>";

//Aggregate section
echo "<tr>";
$sql = "select * from Aggregates";
$result =  $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=aggrs.php?database=$dbname>Aggregates</a></td><td>$num_rows</td>";
echo "</tr>";
echo "<tr>";
$sql = "select * from Aggregates where block_type like '32-bit'";
$result = $conn->query($sql);
$num_rows=mysqli_num_rows($result);
echo "<td>&nbsp&nbsp<a href=aggrs.php?database=$dbname&block='32-bit'>32-bit Aggregates</a></td><td>$num_rows</td>";
echo "</tr>";

//Volume section
echo "<tr>";
$sql = "SELECT name, block_type, total_used_size_GB FROM Volumes";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=volumes.php?database=$dbname>Volumes</a></td><td>$num_rows</td>";
echo "</tr>";
echo "<tr>";
$sql = "Select * from Volumes where block_type like '32-bit'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>&nbsp&nbsp<a href=volumes.php?database=$dbname&block='32-bit'>32-bit Volumes</a></td><td>$num_rows</td>";
echo "</tr>";
echo "<tr>";
$sql = "Select * from Volumes where type like 'trad'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>&nbsp&nbsp<a href=volumes.php?database=$dbname&type=trad>Traditional Volumes</a></td><td>$num_rows</td>";
echo "</tr>";

//Qtree section
echo "<tr>";
$sql = "select * from Qtrees";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=qtrees.php?database=$dbname>Qtrees</a></td><td>$num_rows</td>";
echo "</tr>";

//Lun section
echo "<tr>";
$sql = "select * from Luns";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=luns.php?database=$dbname>Luns</a></td><td>$num_rows</td>";
echo "</tr>";

//CIFS shares section
echo "<tr>";
$sql = "select * from CIFS_Shares where LineID is not null";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=shares.php?database=$dbname>Shares</a></td><td>$num_rows</td>";
echo "</tr>";

//Export section
echo "<tr>";
$sql = "select * from NFS_Exports";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=exports.php?database=$dbname>Exports</a></td><td>$num_rows</td>";
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
echo "<td><a href=snapmirrors.php?database=$dbname>SnapMirrors</a></td><td>$num_rows</td>";
echo "</tr>";

//SnapVault section
echo "<tr>";
$sql = "select * from SnapVault";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=snapvaults.php?database=$dbname>SnapVaults</a></td><td>$num_rows</td>";
echo "</tr>";

//Transition PreCheck section
echo "<tr>";
$sql = "select * from Transition_PreCheck_Summary where severity like 'Red'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=precheck.php?database=$dbname>PreCheck issues</a></td><td bgcolor='red'>$num_rows</td>";
$sql = "select * from Transition_PreCheck_Summary where severity like 'Yellow'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "</tr><tr>";
echo "<td></td><td bgcolor='yellow'>$num_rows</td>";
echo "</tr></table></td><td>";
// Migration Suggustion section
echo "<table border=1>";
echo "<tr><td colspan=2>Migration Suggestions</td></tr>";
$sql = "select `migration_methodology`, count(*) from Migration_Master_Volume_View group by `migration_methodology`";
$result = $conn->query($sql);
while($row=$result->fetch_assoc()) {
echo "<tr><td><a href=migration.php?database=$dbname&method=". urlencode($row['migration_methodology']) . ">" . $row['migration_methodology'] . "</td><td>" . $row['count(*)'] . "</td></tr>";
}
echo "</table>";
echo "</table>";
echo "<a href=index.php>Select another Dataset</a> <a href=verify.php?delete=$dbname>Delete this dataset</a>";
$conn->close();
?>
