<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_pie.php');



// Some data
$data = array(300,100,400);

// Create the Pie Graph. 
$graph = new PieGraph(500,380);

$theme_class="DefaultTheme";
//$graph->SetTheme(new $theme_class());

// Set A title for the plot
$graph->title->Set("Resumen De Avance En El Estado");
$graph->SetBox(true);



// Create
$p1 = new PiePlot($data);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
$p1->SetSliceColors(array('#1E90FF','#2E8B57','#ADFF2F','#DC143C','#BA55D3'));

// Setup slice labels and move them into the plot
$p1->value->SetFont(FF_FONT1,FS_BOLD);
$p1->value->SetColor("black");


$nombres=array("Culimanadas","Por Culiminar","Sin Iniciar","alberto");
$p1->SetLegends($nombres);

$graph->Stroke();

?>