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
echo "<a href=index.php> <- Back to Dashboard</a>";
echo "<table border=1>"; 

//Storage Controller section
$sql = "select storage_controller,source_controller,destination_controller, count(*) from SnapMirror group by storage_controller";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
echo "<tr><td>"  . $row['count(*)'] . "</td><td>" . $row['pre_check'] . "</td><td width=550px>" . $row['description'];
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
