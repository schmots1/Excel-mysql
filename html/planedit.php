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
// Update section
if (!empty($_GET['action'])) {
$destination_cluster = $_GET['destination_cluster'];
$destination_svm = $_GET['destination_svm'];
$destination_node = $_GET['destination_node'];
$destination_aggr = $_GET['destination_aggr'];
$classification = $_GET['classification'];
$application = $_GET['application'];
$app_owner = $_GET['app_owner'];
$owner_email = $_GET['owner_email'];
$move_group = $_GET['move_group'];
$group_email = $_GET['group_email'];
$organization = $_GET['organization'];
$service_level = $_GET['service_level'];
$imt_ready = $_GET['imt_ready'];
$comments = $_GET['comments'];
$migration_method = $_GET['migration_method'];
$stage = $_GET['stage'];
$sql = "update Migration_Plan set `destination_cluster`='$destination_cluster', `destination_svm`='$destination_svm', `destination_node`='$destination_node', `destination_aggr`='$destination_aggr', `classification`='$classification', `application`='$application', `app_owner`='$app_owner', `owner_email`='$owner_email', `move_group`='$move_group', `group_email`='$group_email', `organization`='$orginization', `service_level`='$service_level', `imt_ready`='$imt_ready', `comments`='$comments', `migration_method`='$migration_method', `stage`='$stage' where `id`=$id";
$result = $conn->query($sql);
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
echo "<input type=hidden name=id value=$id><input type=hidden name=database value=$dbname>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Source Filer</td><td white-space: nowrap>"  . $row['source_filer'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Source Volume</td><td white-space: nowrap>" . $row['source_volume'] . "</td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Destination Cluster</td><td white-space: nowrap><input type=text name=destination_cluster value='" . $row['destination_cluster'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Destination SVM</td><td white-space: nowrap><input type=text name=destination_svm value='" . $row['destination_svm'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Destination Node</td><td white-space: nowrap><input type=text name=destination_node value='" . $row['destination_node'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Destination Aggregate</td><td white-space: nowrap><input type=text name=destination_aggr value='" . $row['destination_aggr'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Classification</td><td white-space: nowrap><input type=text name=classification value='" . $row['classification'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Application/Environment</td><td white-space: nowrap><input type=text name=application value='" . $row['application'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Application Owner</td><td white-space: nowrap><input type=text name=app_owner value='" . $row['app_owner'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Owner Email</td><td white-space: nowrap><input type=text name=owner_email value='" . $row['owner_email'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Move Group</td><td white-space: nowrap><input type=text name=move_group value='" . $row['move_group'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Group Email</td><td white-space: nowrap><input type=text name=group_email value='" . $row['group_email'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Organization</td><td white-space: nowrap><input type=text name=orginization value='" . $row['organization'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Service Level</td><td white-space: nowrap><input type=text name=service_level value='" . $row['service_level'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>IMT Readiness</td><td white-space: nowrap><input type=text name=imt_ready value='" . $row['imt_ready'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Comments</td><td white-space: nowrap><input type=text name=comments value='" . $row['comments'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Migration Method</td><td white-space: nowrap><input type=text name=migration_method value='" . $row['migration_method'] . "'></td></tr>";
echo "<tr style=\"background:$alt\"><td bgcolor=lightgrey white-space: nowrap>Stage</td><td white-space: nowrap><input type=text name=stage value='" . $row['stage'] . "'></td></tr>";
echo "<input type=hidden name=action value=update>";
echo "<tr><td><input type=submit value=update></td></tr>";
echo "</form>";
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
