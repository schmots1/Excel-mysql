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
//Storage Controller section
if (!empty ($_GET['detail'])) {
}
elseif (!empty ($_GET['serial'])) {
  $sql = "select system_serial_number from Storage_Controllers";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row=$result->fetch_assoc()) {
      $alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
      echo "<tr style=\"background:$alt\"><td style=\"background:$alt\">"  . $row['system_serial_number'];
    }
    echo "</td></tr>";
  }
  else {
    echo "0 results";
  }
}
else {
  echo "<tr bgcolor=grey>";
  echo "<td>Host Name</td>";
  echo "<td>Model</td>";
  echo "<td>OnTap Version</td>";
  echo "<td>Serial Number</td>";
  echo "<td>Aggregate Count</td>";
  echo "</tr>";
  $sql = "select storage_controller,system_model,system_serial_number,version,total_aggregates from Storage_Controllers order by storage_controller";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row=$result->fetch_assoc()) {
      $alt = ($coloralternator++ %2 ? "CCCCCE" : "FFFFFF");
      echo "<tr style=\"background:$alt\">";
      echo "<td>"  . $row['storage_controller'] . "</td>";
      echo "<td>" . $row['system_model'] . "</td>";
      echo "<td>" . $row['version'] . "</td>";
      echo "<td>" . $row['system_serial_number'] . "</td>";
      echo "<td><a href=aggrs.php?database=$dbname&filer=" . $row['storage_controller'] . ">" . $row['total_aggregates'] . "</a></td>";
      echo "</tr>";
    }
//echo "$result</td>";
  }
  else {
    echo "0 results";
  }
}
echo "</tr>";
echo "</table>";
echo "<a href=controller.php?database=$dbname&serial=yes>Just Serial list</a>";
$conn->close();
?>
