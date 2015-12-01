<?php
$servername = "localhost";
$username = "root";
$password = "root";

echo "<html><body>";
// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "show databases";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
   while($row=$result->fetch_assoc()) {
      if (strpos($row['Database'], 'up') === 0) {
      $database = split ("\_", $row['Database']);
      echo "<a href=dashboard.php?database=up_" . $database['1'] . ">" . $database['1'] . "</a><br>";
      }
   }
}
else {
echo "0 results";
}
echo "</body></html>";
$conn->close();
?>
