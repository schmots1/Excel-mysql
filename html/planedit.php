<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = $_GET['database'];
$id = $_GET['id'];

echo "<a href=dashboard.php?database=$dbname> <- Back to Dashboard</a>";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//SQL statements section
$sql = "select * from Migration_Plan where `id` like '$id'";
// Query output section
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
echo "<h1>" . $row['source_volume'] . "</h1>";

echo "<table border=0>"; 
//Data  section
echo "<form action=planedit.php method=get>";
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Source Filer</td><td white-space: nowrap>"  . $row['source_filer'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Source Volume</td><td white-space: nowrap>" . $row['source_volume'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Destination Cluster</td><td white-space: nowrap><input type=text name=destination_cluster value=" . $row['destination_cluster'] . "></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Destination SVM</td><td white-space: nowrap>" . $row['destination_svm'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Destination Node</td><td white-space: nowrap>" . $row['destination_node'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Destination Aggregate</td><td white-space: nowrap>" . $row['destination_aggr'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Classification</td><td white-space: nowrap>" . $row['classification'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Application/Environment</td><td white-space: nowrap>" . $row['application'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Application Owner</td><td white-space: nowrap>" . $row['app_owner'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Owner Email</td><td white-space: nowrap>" . $row['owner_email'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Move Group</td><td white-space: nowrap>" . $row['move_group'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Group Email</td><td white-space: nowrap>" . $row['group_email'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Organization</td><td white-space: nowrap>" . $row['orginization'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Service Level</td><td white-space: nowrap>" . $row['service_level'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>IMT Readiness</td><td white-space: nowrap>" . $row['imt_ready'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Comments</td><td white-space: nowrap>" . $row['comments'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>State</td><td white-space: nowrap>" . $row['state'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Migration Method</td><td white-space: nowrap>" . $row['method'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Stage</td><td white-space: nowrap>" . $row['stage'] . "</td></tr>";
echo "<tr><td><input type=button value=submit></td></tr>";
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
