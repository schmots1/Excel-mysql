<?php
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_pie.php');
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = $_GET['database'];
$project = split ("\-", $dbname);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Database(customer) we are working with
$heading = split ("\-", $dbname);
echo "<h1>$heading[1]</h1>";

//Start Storage Summary section
echo "<h2>7-Mode Storage Summary</h2>";
echo "<table>";
	echo "<tr>";
		echo "<td rowspan=3>";
			echo "<table>";
				echo "<tr bgcolor=blue>";
					echo "<th colspan=2>";
						echo "<font color=white>";
							echo "Storage Summary";
						echo "</font>";
					echo "</th>";
				echo "</tr>";
				echo "<tr>";
					$sql = "select * from Storage_Controllers";
					$result = $conn->query($sql);
					$num_rows = mysqli_num_rows($result);
					echo "<td  = 'width: 200px'>";
						echo "Number of Storage Controllers";
					echo "</td>";
					echo "<td>";
						echo "$num_rows";
					echo "</td>";
				echo "</tr>";
				echo "<tr bgcolor=lightgrey>";
					echo "<td>";
						echo "Used Storage / Total Storage (TB)";
					echo "</td>";
					echo "<td>";
						$sql = "select cast(sum(replace(total_used_size_GB,',','')) as decimal (10,2)) as total from Aggregates";
						$result = $conn->query($sql);
						if ($result->num_rows > 0){
							while($row=$result->fetch_assoc()) {
								echo round($row['total'] / 1024);
							}
						}
						echo " / ";
						$sql = "select cast(sum(replace(total_size_GB,',','')) as decimal (10,2)) as total from Aggregates";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while($row=$result->fetch_assoc()) {
								echo round($row['total'] / 1024);
							}
						}
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "Number of Replications";
					echo "</td>";
					echo "<td>";
						$sql = "select * from SnapMirror";
						$result = $conn->query($sql);
						$num_rows_sm = mysqli_num_rows($result);
						$sql = "select * from SnapVault";
						$result = $conn->query($sql);
						$num_rows_sv = mysqli_num_rows($result);
						$rep_total = $num_rows_sm + $num_rows_sv;
						echo "$rep_total";
					echo "</td>";
				echo "</tr>";
				echo "<tr bgcolor=lightgrey>";
					echo "<td>";
						echo "Volume SnapMirrored Storage / Total Replicated Storage (GB)";
					echo "</td>";
					echo "<td>";
						$sql = "select * from SnapMirror";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							$total = 0;
							while($row=$result->fetch_assoc()) {
								$filer = $row['source_controller'];
								$name = $row['source_volume'];
								$sql1 = "select * from Volumes where name like '$name'and storage_controller like '$filer'";
								$result1 = $conn->query($sql1);
								if ($result->num_rows > 0) {
									while($row1=$result1->fetch_assoc()) {
										$total = $total + $row1['total_used_size_GB'];
									}
								}
							}
							echo round($total) . " / ";
						}
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
		echo "<td>";
			echo "<table>";
				echo "<tr bgcolor=blue>";
					echo "<th colspan=2>";
						echo "<font color=white>";
							echo "Workload Summary";
						echo "</font>";
					echo "</th>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "CIFS Shares";
					echo "</td>";
					echo "<td>";
						$sql = "select cast(sum(replace(total_shares,',','')) as decimal (10,0)) as shares from Storage_Controllers";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while($row=$result->fetch_assoc()) {
								$shares = $row['shares'];
							}
							echo "$shares";
						}
					echo "</td>";
				echo "</tr>";
				echo "<tr bgcolor=lightgrey>";
					echo "<td>";
						echo "Mapped Luns";
					echo "</td>";
					echo "<td>";
						$sql = "select * from Luns where status like 'mapped'";
						$result = $conn->query($sql);
						$luns = mysqli_num_rows($result);
						echo "$luns";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "NFS Exports";
					echo "</td>";
					echo "<td>";
						$sql = "select * from NFS_Exports";
						$result = $conn->query($sql);
						$exports = mysqli_num_rows($result);
						echo "$exports";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td colspan=2>";
						echo "<font color=white>";
							echo ".";
						echo "</font>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
		echo "<td>";
			echo "<table>";
				echo "<tr bgcolor=blue>";
					echo "<th colspan=2>";
						echo "<font color=white>";
							echo "Replication Summary";
						echo "</font>";
					echo "</th>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "VSM";
					echo "</td>";
					echo "<td>";
						$sql = "select * from SnapMirror where type like 'VSM'";
						$result = $conn->query($sql);
						$vsm = mysqli_num_rows($result);
						echo "$vsm";
					echo "</td>";
				echo"</tr>";
				echo "<tr bgcolor=lightgrey>";
					echo "<td>";
						echo "QSM";
					echo "</td>";
					echo "<td>";
						$sql = "select * from SnapMirror where type like 'QSM'";
						$result = $conn->query($sql);
						$qsm = mysqli_num_rows($result);
						echo "$qsm";
					echo "</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "SV";
					echo "</td>";
					echo "<td>";
						$sql = "select * from SnapVault where type like 'SV'";
						$result = $conn->query($sql);
						$sv = mysqli_num_rows($result);
						echo "$sv";
					echo "</td>";
				echo "</tr>";
				echo "<tr bgcolor=lightgrey>";
					echo "<td>";
						echo "OSSV";
					echo "</td>";
					echo "<td>";
						$sql = "select * from SnapVault where type like 'OSSV'";
						$result = $conn->query($sql);
						$ossv = mysqli_num_rows($result);
						echo "$ossv";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr>";
echo "</table>";
//Start of System’s Support Contracts, Age & Utilization Summary
echo "<h2>System's Support Contracts, Age & Utilization Summary</h2>";
echo "<table>";
	echo "<tr>";
		echo "<td>";
			echo "<table>";
				echo "<tr bgcolor=blue>";
					echo "<th>";
						echo "<font color=white>";
							echo "Contract Experation";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "Already Expired";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "H2/16";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "H1/17";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "H2/17";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "H1/18";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "H2/18";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "H1/19";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "H2/19";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "H1/20";
						echo "</font>";
					echo "</th>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "Controller Count";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo "<table>";
				echo "<tr bgcolor=blue>";
					echo "<th>";
						echo "<font color=white>";
							echo "Years of Service";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "0-1";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "1-2";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "2-3";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "3-4";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "4-5";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "5-6";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "6-7";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "7-8";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "9+";
						echo "</font>";
					echo "</th>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "Controller Count";
					echo "</td>";
					echo "<td>";
						$sql = "select * from Storage_Controllers where LastShipDate like '%2016%'";
						$result = $conn->query($sql);
						echo mysqli_num_rows($result);
					echo "</td>";
					echo "<td>";
						$sql = "select * from Storage_Controllers where LastShipDate like '%2015%'";
						$result = $conn->query($sql);
						echo mysqli_num_rows($result);
					echo "</td>";
					echo "<td>";
						$sql = "select * from Storage_Controllers where LastShipDate like '%2014%'";
						$result = $conn->query($sql);
						echo mysqli_num_rows($result);
					echo "</td>";
					echo "<td>";
						$sql = "select * from Storage_Controllers where LastShipDate like '%2013%'";
						$result = $conn->query($sql);
						echo mysqli_num_rows($result);
					echo "</td>";
					echo "<td>";
						$sql = "select * from Storage_Controllers where LastShipDate like '%2012%'";
						$result = $conn->query($sql);
						echo mysqli_num_rows($result);
					echo "</td>";
					echo "<td>";
						$sql = "select * from Storage_Controllers where LastShipDate like '%2011%'";
						$result = $conn->query($sql);
						echo mysqli_num_rows($result);
					echo "</td>";
					echo "<td>";
						$sql = "select * from Storage_Controllers where LastShipDate like '%2010%'";
						$result = $conn->query($sql);
						echo mysqli_num_rows($result);
					echo "</td>";
					echo "<td>";
						$sql = "select * from Storage_Controllers where LastShipDate like '%2009%'";
						$result = $conn->query($sql);
						echo mysqli_num_rows($result);
					echo "</td>";
					echo "<td>";
						$sql = "select * from Storage_Controllers where LastShipDate like '%2008%'";
						$result = $conn->query($sql);
						echo mysqli_num_rows($result);
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo "<table>";
				echo "<tr bgcolor=blue>";
					echo "<th>";
						echo "<font color=white>";
							echo "Storage Utilization %";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "100-80 %";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "80-60 %";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "60-40 %";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "40-20%";
						echo "</font>";
					echo "</th>";
					echo "<th>";
						echo "<font color=white>";
							echo "<20%";
						echo "</font>";
					echo "</th>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>";
						echo "Controller Count";
					echo "</td>";
					echo "<td>";
						$sql = "select * from Storage_Controllers";
						$result = $conn->query($sql);
						$filer_total = 0;
						$filer_used = 0;
						$eight = 0;
						$six = 0;
						$four = 0;
						$two = 0;
						$zero = 0;
						if ($result->num_rows > 0) {
							while($row=$result->fetch_assoc()) {
								$filer = $row['storage_controller'];
								$sql1 = "select cast(sum(replace(total_size_GB,',','')) as decimal (10,2)) as total from Aggregates where storage_controller like '$filer'";
								$result1 = $conn->query($sql1);
								if ($result1->num_rows > 0) {
									while($row1=$result1->fetch_assoc()) {
										$filer_total = $row1['total'];
									}
								}
								$sql2 = "select cast(sum(replace(total_used_size_GB,',','')) as decimal (10,2)) as used from Aggregates where storage_controller like '$filer'";
								$result2 = $conn->query($sql2);
								if ($result2->num_rows > 0) {
									while($row2=$result2->fetch_assoc()) {
										$filer_used = $row2['used'];
									}
								}
								$percent = $filer_used / $filer_total;
								if ($percent > .80) {
	  								$eight = $eight + 1;
	  							}
	  							elseif ($percent > .60) {
	  								$six = $six + 1;
	  							}
	  							elseif ($percent > .40) {
	  								$four = $four + 1;
	  							}
	  							elseif ($percent > .20) {
	  								$two = $two + 1;
	  							}
	  							else{
	  								$zero = $zero + 1;
	  							} 
							}
						}
						echo "$eight";
					echo "</td>";
					echo "<td>";
						echo "$six";
					echo "</td>";
					echo "<td>";
						echo "$four";
					echo "</td>";
					echo "<td>";
						echo "$two";
					echo "</td>";
					echo "<td>";
						echo "$zero";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr>";
echo "</table>";
echo "<h2>";
	echo "Transition Readiness Dashboard";
echo "</h2>";
echo "<table>";
	echo "<tr bgcolor=blue>";
		echo "<th>";
			echo "<font color=white>";
				echo "Category";
			echo "</font>";
		echo "</th>";
		echo "<th>";
			echo "<font color=white>";
				echo "Total Count";
			echo "</font>";
		echo "</th>";
		echo "<th>";
			echo "<font color=white>";
				echo "Ready for Transition Planning";
			echo "</font>";
		echo "</th>";
		echo "<th>";
			echo "<font color=white>";
				echo "Needs Review";
			echo "</font>";
		echo "</th>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo "<b>";
				echo "ONTAP";
			echo "</b>";
		echo "</td>";
		echo "<td>";
			$sql = "select * from Storage_Controllers";
			$result = $conn->query($sql);
			$num_ontap = mysqli_num_rows($result);
			echo "$num_ontap";
		echo "</td>";
			$sql = "select * from Storage_Controllers where version REGEXP '8.1.4P[4-9]' or version like '8.2%'";
			$result = $conn->query($sql);
			$num_ontap_good = mysqli_num_rows($result);
		echo "<td>";
			echo "$num_ontap_good";
		echo "</td>";
		echo "<td>";
			$ontap_bad = $num_ontap - $num_ontap_good;
			echo "$ontap_bad";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo "<b>";
				echo "Aggregate";
			echo "</b>";
		echo "</td>";
		echo "<td>";
			$sql = "select * from Aggregates";
			$result = $conn->query($sql);
			$aggr_total = mysqli_num_rows($result);
			echo "$aggr_total";
		echo "</td>";
		echo "<td>";
			$sql = "select * from Aggregates where block_type like '64-bit'";
			$result = $conn->query($sql);
			$aggr_good = mysqli_num_rows($result);
			echo "$aggr_good";
		echo "</td>";
		echo "<td>";
			$aggr_bad = $aggr_total - $aggr_good;
			echo "$aggr_bad";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>";
			echo "<b>";
				echo "Volumes";
			echo "</b>";
		echo "</td>";
		echo "<td>";
			$sql = "select * from Volumes";
			$result = $conn->query($sql);
			$vol_total = mysqli_num_rows($result);
			echo "$vol_total";
		echo "</td>";
		echo "<td>";
			$sql = "select * from Volumes where block_type like '64-bit'";
			$result = $conn->query($sql);
			$vol_good = mysqli_num_rows($result);
			echo "$vol_good";
		echo "</td>";
		echo "<td>";
			$vol_bad = $vol_total - $vol_good;
			echo "$vol_bad";
		echo "</td>";
	echo "</tr>";
echo "</table>";
//This is supposed to be a graph
/*$data = array($luns,$shares,$exports);

$graph = new PieGraph(350,250);
$graph->SetShadow();

$graph->title->Set("Workload Summary");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$p1 = new PiePlot($data);
$p1->SetLegends(array("Lun","Share","Export"));
$p1->SetCenter(0.8);

$graph->Add($p1);
$graph->Stroke();
*/
//END Storage Summary Section


$conn->close();
?>