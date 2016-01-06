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
//Column Header  section
echo "<tr bgcolor=grey>";
echo "<td white-space: nowrap>Filer</td>";
echo "<td white-space: nowrap>Volume</td>";
echo "<td white-space: nowrap>Block Type</td>";
echo "<td white-space: nowrap>Used Space</td>";
echo "<td white-space: nowrap>File Count</td>";
echo "<td white-space: nowrap>Aggregate</td>";
echo "<td white-space: nowrap>Security Style</td>";
echo "<td white-space: nowrap>Number of Qtrees</td>";
echo "<td white-space: nowrap>Number of Luns</td>";
echo "<td white-space: nowrap>Number of Snapmirrors</td>";
echo "<td white-space: nowrap>Number of Snapvaults</td>";
echo "<td white-space: nowrap>State</td>";
echo "<td white-space: nowrap>Language</td>";
echo "<td white-space: nowrap>Vfiler</td>";
//SQL statements section
if (!empty($_GET['block'])) {
$sql = "select storage_controller,aggregate_name,vfiler_name,name,workload,state,block_type,language,files_used,total_used_size_GB,total_luns,total_qtrees,security_style,total_snapmirrors,total_snapvaults from Volumes where `block_type` like $block order by storage_controller, block_type, name";
}
elseif (!empty($_GET['type'])) {
$sql = "select storage_controller,aggregate_name,vfiler_name,name,workload,state,block_type,language,files_used,total_used_size_GB,total_luns,total_qtrees,total_snapmirrors,security_style,total_snapvaults from Volumes where `type` like 'trad' order by storage_controller, block_type, name";
}
elseif (!empty($_GET['aggr']) and !empty($_GET['filer'])) {
$sql = "select * from Volumes where storage_controller like '" . $_GET['filer'] . "'  and aggregate_name like '" . $_GET['aggr'] . "'";
}
elseif (!empty($_GET['vfiler']) and !empty($_GET['filer'])) {
$sql = "select * from Volumes where storage_controller like '" . $_GET['filer'] . "'  and vfiler_name like '" . $_GET['vfiler'] . "'";
}
else{
$sql = "select storage_controller,aggregate_name,vfiler_name,name,workload,state,block_type,language,files_used,total_used_size_GB,total_luns,total_qtrees,total_snapmirrors,security_style,total_snapvaults from Volumes order by storage_controller, block_type, name";
}
// Query output section
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\">";
echo "<td white-space: nowrap>"  . $row['storage_controller'] . "</td>";
echo "<td white-space: nowrap>" . $row['name'] . "</td>";
echo "<td white-space: nowrap>" . $row['block_type'] . "</td>";
echo "<td white-space: nowrap>" . $row['total_used_size_GB'] . "</td>";
echo "<td white-space: nowrap>" . $row['files_used'] . "</td>";
echo "<td white-space: nowrap>" . $row['aggregate_name'] . "</td>";
echo "<td white-space: nowrap>" . $row['security_style'] . "</td>";
if ($row['total_qtrees'] > 0) {
echo "<td white-space: nowrap><a href=qtrees.php?database=$dbname&filer=" . $row['storage_controller'] . "&aggr=". $row['aggregate_name'] . "&vol=" . $row['name'] . ">" . $row['total_qtrees'] . "</a></td>";
}
else {
echo "<td white-space: nowrap>" . $row['total_qtrees'] . "</td>";
}
if ($row['total_luns'] > 0) {
echo "<td white-space: nowrap><a href=luns.php?database=$dbname&filer=" . $row['storage_controller'] . "&vol=" . $row['name'] . ">" . $row['total_luns'] . "</a></td>";
}
else {
echo "<td white-space: nowrap>" . $row['total_luns'] . "</td>";
}
if ($row['total_snapmirrors'] > 0) {
echo "<td white-space: nowrap><a href=snapmirrors.php?database=$dbname&filer=" . $row['storage_controller'] . "&vol=" . $row['name'] . ">" . $row['total_snapmirrors'] . "</a></td>";
}
else {
echo "<td white-space: nowrap>" . $row['total_snapmirrors'] . "</td>";
}
if ($row['total_snapvaults'] > 0) {
echo "<td white-space: nowrap><a href=snapvaults.php?database=$dbname&filer=" . $row['storage_controller'] . "&vol=" . $row['name'] . ">" . $row['total_snapvaults'] . "</a></td>";
}
else {
echo "<td white-space: nowrap>" . $row['total_snapvaults'] . "</td>";
}
echo "<td white-space: nowrap>" . $row['state'] . "</td>";
echo "<td white-space: nowrap>" . $row['language'] . "</td>";
echo "<td white-space: nowrap>" . $row['vfiler_name'] . "</td>";
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
