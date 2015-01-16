<?php

require_once "cliente/functions.inc.php";
require_once "cliente/model.inc.php";
$datos = datos_principales();
$productos = datos_productos();

?>


<?php
if(isset($_POST["factura"])=="facturar"){
error_reporting(0);

/////// Cambio de divisas ////////

	$sutotal = cambio_divisa($datos["subTotal"],$datos["CambioDolares"],$datos["CambioDolares"]);
	$total = cambio_divisa($datos["Total"],$datos["CambioDolares"],$datos["CambioDolares"]);
	$iva = cambio_divisa($datos["TImporte"],$datos["CambioDolares"],$datos["CambioDolares"]);

$ws = new WSSinergia();

$setComprobanteV2012 = array(
	"usuario" 					=> USER, // Requerido
	"password" 					=> PASS, // Requerido
	"Id_SistemaPadre" 			=> "SisFC", // Requerido
	"EdoComprobante" 			=> "1", // Requerido
	"Tipo" 						=> "FA", // Requerido
	"EmRFC" 					=> $datos["EmRFC"], // Requerido CAGE7208162S2
	"CondicionesPago" 			=> "NA", // No Requerido
	"FormaPago" 				=> "Pago en parcialidades", // Requerido
	"Descuento" 				=> "", // No Requerido
	"motivoDescuento"			=> "", // No Requerido
	"metodoPago" 				=> "NA", // Requerido
	"subTotal" 					=> $sutotal, // Requerido
	"Total"						=> $total, // Requerido
	"ReID" 						=> "", // No Requerido //Clave cliente
	"ReNombre" 					=> $datos["ReNombre"], // Requerido
	"ReRFC" 					=> $datos["ReRFC"], // Requerido
	"ReCalle" 					=> $datos["ReCalle"], // No Requerido
	"ReCodigoPostal" 			=> $datos["ReCodigoPostal"], // No Requerido
	"ReColonia" 				=> $datos["ReColonia"], // No Requerido
	"ReEstado" 					=> $datos["ReEstado"], // No Requerido
	"ReLocalidad" 				=> "", // No Requerido
	"ReMunicipio" 				=> $datos["ReMunicipio"], // No Requerido
	"ReNoExterior" 				=> $datos["ReNoExterior"], // No Requerido
	"ReNoInterior"				=> $datos["ReNoInterior"], // No Requerido
	"ReTel" 					=> "", // No Requerido
	"RePais" 					=> $datos["RePais"], // Requerido
	"ReReferencia" 				=> "", // No Requerido
	"ReCorreo" 					=> "", // No Requerido
	"TotalImpuestosRetenidos" 	=> "", // Requerido
	"TotalImpuestoTransladado" 	=> "", // Requerido
	"RImpuesto" 				=> "IVA", // No Requerido
	"RImporte" 					=> "", // No Requerido
	"TImpuesto" 				=> "IVA", // Requerido
	"TImporte" 					=> $iva, // Requerido
	"TTasa" 					=> "00", // Requerido
	"Notas" 					=> $datos["Notas"], // No Requerido
	"Moneda" 					=> $datos["Moneda"], // No Requerido
	"TipoCambio" 				=> "", // No Requerido
	"Vendedor" 					=> "", // No Requerido
	"OrdCompra" 				=> $datos["OrdCompra"], // No Requerido /*Referencia
	"Otros" 					=> "", // No Requerido
	"numCtaPago" 				=> "" // No Requerido
);




//Set Comprobante
foreach($ws->servicioAdmovil("setComprobanteV2012",$setComprobanteV2012) as $comprobante){
	$comprobante = $comprobante;
}

foreach($productos as $producto){
	foreach($producto as $p){

		$valor_unitario = cambio_divisa($p["ValorUnitario"],$datos["CambioDolares"],$datos["CambioDolares"]);
		$importe = cambio_divisa($p["Cantidad"] * $p["ValorUnitario"],$datos["CambioDolares"],$datos["CambioDolares"]);

		$setComprobante_Detalle = array(
			"IdComprobante"				=> $comprobante, //Requerido
			"NoPartida"					=> "", //No Requerido
			"Cantidad"					=> $p["Cantidad"], //Requerido
			"Descripcion"				=> $p["Descripcion"], //Requerido
			"Importe"					=> $importe, //Requerido
			"NoIdentificacion"			=> $p["NoIdentificacion"], //No Requerido
			"Unidad"					=> $p["Unidad"], //Requerido
			"ValorUnitario"				=> $valor_unitario, //Requerido
			"PedimentoNo"				=> "", //No Requerido
			"PedimentoNombre"			=> "", //No Requerido
			"PedimentoFecha"			=> "", //No Requerido
			"IVA"						=> $p["IVA"], //Requerido
			"Notas1"					=> "", //No Requerido
			"Notas2"					=> ""  //No Requerido
		);

		foreach($ws->servicioAdmovil("setComprobante_Detalle",$setComprobante_Detalle) as $comprobanteDetalle){
			$comprobanteDetalle = $comprobanteDetalle;
		}
	}
}

//Set Detalle

$sellaComprobante = array(
	"usuario"=>USER,
	"password"=>PASS,
	"IdComprobante"=>$comprobante
);

if($ws->servicioAdmovil("sellaComprobante",$sellaComprobante)){
	echo "No se ha podido generar la factura";
	exit;
}

echo $comprobante.". Se ha generado la factura";

$_POST["factura"] = 0;

}





?>

<form action="" method="POST">
	<input type="hidden" value="facturar" name="factura"/>
	<input type="submit"/>
</form>