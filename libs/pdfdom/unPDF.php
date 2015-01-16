<?php 

require_once "dompdf_config.inc.php";

$codigo = "<html>
	<!DOCTYPE html>
<html>
	<head>
		<link rel='stylesheet' href='css/estilos.css'/>

		<script src='rutaScript'></script>
	</head>

	<body>
		<table>
			<caption>Título</caption>
			<thead>
				<tr>
					<th colspan='2' rowspan='2'>Columna1</th>
					<th colspan='2'>Columna2</th>

				</tr>
				<tr>
					<th>SubColumna1</th>
					<th>SubColumna2</th>

				</tr>
			</thead>
			<tbody>
				<tr>
					<th rowspan='2'>Celda1</th>
					<th scope='row'>celda2</th>
					<td>Contenido3</td>
					<td>Contenido4</td>
				</tr>
				<tr>
					<th scope='row'>celda2</th>
					<td>Contenido3</td>
					<td>Contenido4</td>
				</tr>
				<tr>
					<td>Contenido</td>
					<td>Contenido</td>
					<td>Contenido</td>
					<td>Contenido</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>

";
$codigo = utf8_decode($codigo);

$dompdf=new DOMPDF();
$dompdf->load_html($codigo);
ini_set("memory_limit","32M");
$dompdf->render();
$dompdf->stream("unPDF.pdf");
?>