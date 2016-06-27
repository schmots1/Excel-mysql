<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_pie.php');

$data = array(82,64,123);

$graph = new PieGraph(350,250);
$graph->SetShadow();

$graph->title->Set("Workload Summary");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$p1 = new PiePlot($data);
$p1->SetLegends(array("Lun","Share","Export"));
$p1->SetCenter(0.8);

$graph->Add($p1);
$graph->Stroke();

?>
