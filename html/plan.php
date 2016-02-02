<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = $_GET['database'];
$stage = $_GET['stage'];

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
echo "<td white-space: nowrap>Source Filer</td>";
echo "<td white-space: nowrap>Source Volume</td>";
echo "<td white-space: nowrap>Destination Cluster</td>";
echo "<td white-space: nowrap>Destination SVM</td>";
echo "<td white-space: nowrap>Destination Node</td>";
echo "<td white-space: nowrap>Destination Aggregate</td>";
echo "<td white-space: nowrap>Classification</td>";
echo "<td white-space: nowrap>Application/Environment</td>";
echo "<td white-space: nowrap>Application Owner</td>";
echo "<td white-space: nowrap>Owner Email</td>";
echo "<td white-space: nowrap>Move Group</td>";
echo "<td white-space: nowrap>Group Email</td>";
echo "<td white-space: nowrap>Organization</td>";
echo "<td white-space: nowrap>Service Level</td>";
echo "<td white-space: nowrap>IMT Readiness</td>";
echo "<td white-space: nowrap>Comments</td>";
echo "<td white-space: nowrap>Migration Method</td>";
echo "<td white-space: nowrap>Stage</td>";
//SQL statements section
if (!empty($_GET['stage'])) {
$sql = "select * from Migration_Plan where `stage` like '$stage' order by source_filer, source_volume";
}
else{
$sql = "select * from Migration_Plan order by source_filer, source_volume";
}
// Query output section
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\">";
echo "<td white-space: nowrap>"  . $row['source_filer'] . "</td>";
echo "<td white-space: nowrap><a href=planedit.php?database=$dbname&id=" . $row['id'] . ">" . $row['source_volume'] . "</a></td>";
echo "<td white-space: nowrap>" . $row['destination_cluster'] . "</td>";
echo "<td white-space: nowrap>" . $row['destination_svm'] . "</td>";
echo "<td white-space: nowrap>" . $row['destination_node'] . "</td>";
echo "<td white-space: nowrap>" . $row['destination_aggr'] . "</td>";
echo "<td white-space: nowrap>" . $row['classification'] . "</td>";
echo "<td white-space: nowrap>" . $row['application'] . "</td>";
echo "<td white-space: nowrap>" . $row['app_owner'] . "</td>";
echo "<td white-space: nowrap>" . $row['owner_email'] . "</td>";
echo "<td white-space: nowrap>" . $row['move_group'] . "</td>";
echo "<td white-space: nowrap>" . $row['group_email'] . "</td>";
echo "<td white-space: nowrap>" . $row['orginization'] . "</td>";
echo "<td white-space: nowrap>" . $row['service_level'] . "</td>";
echo "<td white-space: nowrap>" . $row['imt_ready'] . "</td>";
echo "<td white-space: nowrap>" . $row['comments'] . "</td>";
echo "<td white-space: nowrap>" . $row['migration_method'] . "</td>";
echo "<td white-space: nowrap>" . $row['stage'] . "</td>";
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
