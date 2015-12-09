<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = $_GET['database'];
$share = $_GET['share'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<h1>$share</h1>";
echo "<a href=shares.php?database=$dbname> <- Back to Shares</a>";
echo "<table border=0>"; 
//ACL section
echo "<tr bgcolor=grey><td>Filer</td><td>Volume</td><td>Account</td><td>Permission</td></tr>";
$sql = "select storage_controller,volume_name,acl_account,acl_permission from CIFS_Share_ACLs where share_name like '$share'  order by storage_controller,volume_name";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
echo "<tr style=\"background:$alt\"><td style=\"background:$alt\">"  . $row['storage_controller'] . "</td><td>" . $row['volume_name'] . "</td><td>" . $row['acl_account'] . "</td><td>" . $row['acl_permission'];
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
