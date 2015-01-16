<?php 

require_once "pdfdom/dompdf_config.inc.php";

$codigo = $_POST["datos"];

$nombre = $_POST["cotizacion"];

$codigo = utf8_decode($codigo);

$dompdf=new DOMPDF();
$dompdf->load_html($codigo);
ini_set("memory_limit","64M");
$dompdf->render();
$dompdf->stream($nombre);

?>