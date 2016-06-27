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
$heading = split ("\-", $dbname);
echo "<h1>$heading[1]</h1>";
echo "<table><tr><td rowspan=3>";
echo "<table border=1>"; 
echo "<tr><td>";
echo "<table>";

//Start Storage Summary section
echo "<tr bgcolor=blue><th colspan=2><font color=white>Storage Summary</font></th></tr>";
echo "<tr>";
$sql = "select * from Storage_Controllers";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td  = 'width: 200px'>Number of Storage Controllers</td><td>$num_rows</td>";
echo "</tr>";
echo "<tr bgcolor=lightgrey>";
echo "<td>Used Storage / Total Storage (TB)</td><td>";
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
echo "<td>Number of Replications</td>";
$sql = "select * from SnapMirror";
$result = $conn->query($sql);
$num_rows_sm = mysqli_num_rows($result);
$sql = "select * from SnapVault";
$result = $conn->query($sql);
$num_rows_sv = mysqli_num_rows($result);
$rep_total = $num_rows_sm + $num_rows_sv;
echo "<td>$rep_total</td>";
echo "</tr>";
echo "<tr bgcolor=lightgrey>";
echo "<td>Volume SnapMirrored Storage / Total Replicated Storage (GB)</td>";
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
echo "</td></tr></table>";
echo "</td><td>";
echo "<table>";
echo "<tr bgcolor=blue><th colspan=2><font color=white>Workload Summary</font></th></tr>";
$sql = "select cast(sum(replace(total_shares,',','')) as decimal (10,0)) as shares from Storage_Controllers";
$result = $conn->query($sql);
echo "<tr><td>";
echo "CIFS Shares";
echo "</td><td>";
if ($result->num_rows > 0) {
	while($row=$result->fetch_assoc()) {
		$shares = $row['shares'];
	}
	echo "$shares";
}
echo "</td></tr><tr bgcolor=lightgrey><td>";
echo "Mapped Luns";
echo "</td><td>";
$sql = "select * from Luns where status like 'mapped'";
$result = $conn->query($sql);
$luns = mysqli_num_rows($result);
echo "$luns";
echo "</td></tr><tr><td>";
echo "NFS Exports";
echo "</td><td>";
$sql = "select * from NFS_Exports";
$result = $conn->query($sql);
$exports = mysqli_num_rows($result);
echo " $exports</td></tr><tr><td colspan=2><font color=white>.</font></td></tr></table>";
echo "</td><td><table>";
echo "<tr bgcolor=blue><th colspan=2><font color=white>Replication Summary</font></th></tr>";
echo "<tr><td>VSM</td><td>";
$sql = "select * from SnapMirror where type like 'VSM'";
$result = $conn->query($sql);
$vsm = mysqli_num_rows($result);
echo "$vsm";
echo "</td></tr>";
echo "<tr bgcolor=lightgrey><td>QSM</td><td>";
$sql = "select * from SnapMirror where type like 'QSM'";
$result = $conn->query($sql);
$qsm = mysqli_num_rows($result);
echo "$qsm";
echo "</td></tr>";
echo "<tr><td>SV</td><td>";
$sql = "select * from SnapVault where type like 'SV'";
$result = $conn->query($sql);
$sv = mysqli_num_rows($result);
echo "$sv";
echo "</td></tr>";
echo "<tr bgcolor=lightgrey><td>OSSV</td><td>";
$sql = "select * from SnapVault where type like 'OSSV'";
$result = $conn->query($sql);
$ossv = mysqli_num_rows($result);
echo "$ossv";
echo "</td></tr></table>";
echo "</td></tr></table>";

//Start of System’s Support Contracts, Age & Utilization Summary

echo "<table border=1>";
echo "<tr><td>";
echo "<table>";
echo "<tr bgcolor=blue><th><font color=white>Contract Experation</font></th>";
echo "<th><font color=white>Already Expired</font></th>";
echo "<th><font color=white>H2/16</font></th>";
echo "<th><font color=white>H1/17</font></th>";
echo "<th><font color=white>H2/17</font></th>";
echo "<th><font color=white>H1/18</font></th>";
echo "<th><font color=white>H2/18</font></th>";
echo "<th><font color=white>H1/19</font></th>";
echo "<th><font color=white>H2/19</font></th>";
echo "<th><font color=white>H1/20</font></th>";
echo "</tr><tr>";
echo "<td>Controller Count</td>";
echo "<td>";
echo "</table>";
echo "</td></tr>";
echo "<tr><td>";
echo "<table>";
echo "<tr bgcolor=blue><th><font color=white>Years of Service</font></th>";
echo "<th><font color=white>0-1</font></th>";
echo "<th><font color=white>1-2</font></th>";
echo "<th><font color=white>2-3</font></th>";
echo "<th><font color=white>3-4</font></th>";
echo "<th><font color=white>4-5</font></th>";
echo "<th><font color=white>5-6</font></th>";
echo "<th><font color=white>6-7</font></th>";
echo "<th><font color=white>7-8</font></th>";
echo "<th><font color=white>9+</font></th>";
echo "</tr><tr>";
echo "<td>Controller Count</td>";
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
echo "</td></tr><tr><td>";
echo "<table>";
echo "<tr bgcolor=blue><th><font color=white>Storage Utilization %</font></th>";
echo "<th><font color=white>100-80 %</font></th>";
echo "<th><font color=white>80-60 %</font></th>";
echo "<th><font color=white>60-40 %</font></th>";
echo "<th><font color=white>40-20%</font></th>";
echo "<th><font color=white><20%</font></th>";
echo "</tr><tr>";
echo "<td>Controller Count</td>";
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
echo "$eight</td><td>$six</td><td>$four</td><td>$two</td><td>$zero</td>";
echo "</tr></table></td></tr></table>";
echo "<h2> Transition Readiness Dashboard </h2>";
echo "<table>";
echo "<tr bgcolor=blue>";
echo "<th><font color=white>Category</font></th>";
echo "<th><font color=white>Total Count</font></th>";
echo "<th><font color=white>Ready for Transition Planning</font></th>";
echo "<th><font color=white>Needs Review</font></th>";
echo "</tr><tr>";
echo "<td><b>ONTAP</b></td>";
$sql = "select * from Storage_Controllers";
$result = $conn->query($sql);
$num_ontap = mysqli_num_rows($result);
echo "<td>$num_ontap</td>";
$sql = "select * from Storage_Controllers where version REGEXP '8.1.4P[4-9]' or version like '8.2%'";
$result = $conn->query($sql);
$num_ontap_good = mysqli_num_rows($result);
echo "<td>$num_ontap_good</td>";
$ontap_bad = $num_ontap - $num_ontap_good;
echo "<td>$ontap_bad</td>";
echo "</tr>";
echo "<tr><td>";
echo "<b>Aggregate</b></td>";
$sql = "select * from Aggregates";
$result = $conn->query($sql);
$aggr_total = mysqli_num_rows($result);
echo "<td>$aggr_total</td>";
$sql = "select * from Aggregates where block_type like '64-bit'";
$result = $conn->query($sql);
$aggr_good = mysqli_num_rows($result);
echo "<td>$aggr_good</td>";
$aggr_bad = $aggr_total - $aggr_good;
echo "<td>$aggr_bad</td>";
echo "</tr><tr>";
echo "<td><b>Volumes</b></td>";
$sql = "select * from Volumes";
$result = $conn->query($sql);
$vol_total = mysqli_num_rows($result);
echo "<td>$vol_total</td>";
$sql = "select * from Volumes where block_type like '64-bit'";
$result = $conn->query($sql);
$vol_good = mysqli_num_rows($result);
echo "<td>$vol_good</td>";
$vol_bad = $vol_total - $vol_good;
echo "<td>$vol_bad</td>";
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

/* Removing the Dashboard results
echo "</td></tr>";
//vFiler section
echo "<tr>";
$sql = "select * from Vfilers where vfiler_name not in (select storage_controller from Vfilers)";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=vfilers.php?database=$dbname>vFilers</a></td><td>$num_rows</td>";
//echo "<td style = 'width: 200px'><a href=vfilers.php?database=$dbname>vFilers</a></td><td>$num_rows</td>";
echo "</tr>";
//Aggregate section
echo "<tr>";
$sql = "select * from Aggregates";
$result =  $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=aggrs.php?database=$dbname>Aggregates</a></td><td>$num_rows</td>";
echo "</tr>";
echo "<tr>";
$sql = "select * from Aggregates where block_type like '32-bit'";
$result = $conn->query($sql);
$num_rows=mysqli_num_rows($result);
echo "<td>&nbsp&nbsp<a href=aggrs.php?database=$dbname&block='32-bit'>32-bit Aggregates</a></td><td>$num_rows</td>";
echo "</tr>";
//Volume section
echo "<tr>";
$sql = "SELECT name, block_type, total_used_size_GB FROM Volumes";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=volumes.php?database=$dbname>Volumes</a></td><td>$num_rows</td>";
echo "</tr>";
echo "<tr>";
$sql = "Select * from Volumes where block_type like '32-bit'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>&nbsp&nbsp<a href=volumes.php?database=$dbname&block='32-bit'>32-bit Volumes</a></td><td>$num_rows</td>";
echo "</tr>";
echo "<tr>";
$sql = "Select * from Volumes where type like 'trad'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td>&nbsp&nbsp<a href=volumes.php?database=$dbname&type=trad>Traditional Volumes</a></td><td>$num_rows</td>";
echo "</tr>";
//Qtree section
echo "<tr>";
$sql = "select * from Qtrees";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=qtrees.php?database=$dbname>Qtrees</a></td><td>$num_rows</td>";
echo "</tr>";
//Lun section
echo "<tr>";
$sql = "select * from Luns";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=luns.php?database=$dbname>Luns</a></td><td>$num_rows</td>";
echo "</tr>";
//CIFS shares section
echo "<tr>";
$sql = "select * from CIFS_Shares where LineID is not null";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=shares.php?database=$dbname>Shares</a></td><td>$num_rows</td>";
echo "</tr>";
//Export section
echo "<tr>";
$sql = "select * from NFS_Exports";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=exports.php?database=$dbname>Exports</a></td><td>$num_rows</td>";
echo "</tr>";
//Totals section
echo "<tr>";
$sql = "select cast(sum(replace(total_used_size_GB,',','')) as decimal (10,2)) as total from Volumes";
$result = $conn->query($sql);
echo "<td>Space Used</td><td>";
if ($result->num_rows > 0) {
while($row=$result->fetch_assoc()) {
echo $row['total'];
echo "</td>";
//echo "$result</td>";
}
}
else {
echo "0 results";
}
echo "</tr>";
//Transition PreCheck section
echo "<tr>";
$sql = "select * from Transition_PreCheck_Summary where severity like 'Red'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "<td><a href=precheck.php?database=$dbname>PreCheck issues</a></td><td bgcolor='red'>$num_rows</td>";
$sql = "select * from Transition_PreCheck_Summary where severity like 'Yellow'";
$result = $conn->query($sql);
$num_rows = mysqli_num_rows($result);
echo "</tr><tr>";
echo "<td></td><td bgcolor='yellow'>$num_rows</td>";
echo "</tr></table></td><td valign='top'>";
*/
$conn->close();
?>