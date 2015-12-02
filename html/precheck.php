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
echo "<a href=dashboard.php?database=$dbname> <- Back to Dashboard</a>";
echo "<table border=0>"; 
//Pre Checksection
$sql = "select severity,pre_check,description,corrective_action, count(*) from Transition_PreCheck_Details group by pre_check order by severity";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
$severity = $row['severity'];
if ($severity == "Red"){
echo "<tr bgcolor='FF6347'><td><a href=precheckdetails.php?database=$dbname&precheck=" . urlencode($row['pre_check']) . ">"  . $row['count(*)'] . "</a></td><td>" . $row['pre_check'] . "</td><td width=550px>" . $row['description'] . "</td><td width=550px>" . $row['corrective_action'];
}
if ($severity == "Yellow"){
echo "<tr bgcolor='FAFAD2'><td><a href=precheckdetails.php?database=$dbname&precheck=" . urlencode($row['pre_check']) . ">"  . $row['count(*)'] . "</a></td><td>" . $row['pre_check'] . "</td><td width=550px>" . $row['description'] . "</a></td><td width=550px>" . $row['corrective_action'];
}
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
