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

//echo "<a href=dashboard.php?database=$dbname> <- Back to Dashboard</a>";
echo "<table border=0>"; 

//SQL statements section
$sql = "create table `Migration_Plan` (`id` INT(6) auto_increment primary key, `source_filer` varchar(100), `source_volume` varchar(100), `destination_cluster` varchar(100), `destination_svm` varchar(100), `destination_node` varchar(100), `destination_aggr` varchar(100), `classification` varchar(100), `application` varchar(100), `app_owner` varchar(100), `owner_email` varchar(100), `move_group` varchar(100), `group_email` varchar(100), `organization` varchar(100), `service_level` varchar(100), `imt_ready` varchar(25), `comments` varchar(256), `migration_method` varchar(50), `stage` varchar(50))";
$result = $conn->query($sql);
$sql = "INSERT INTO `Migration_Plan` (`source_filer`, `source_volume`) SELECT `storage_controller`, `name` FROM `Volumes`";
$result = $conn->query($sql);
$sql = "update `Migration_Plan` set `stage` = 'Not Started'";
$result = $conn->query($sql);
echo "Migration Plan created, back to <a href=dashboard.php?database=$dbname>Dashboard</a>?";
$conn->close();
?>
