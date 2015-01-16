<?php 

//Demo
define("RFC","CAGE7208162S2");

//Produccion Cofeabu
//define("RFC","COF070627R60");

//Produccion IberoExporta
//define("RFC","IBE0907233D4");

function datos_principales(){

	$datos = array(
		"EmRFC"=>RFC, //Requerido CAGE7208162S2
		"CondicionesPago"=>"NA", // No Requerido
		"subTotal"=>"13642.88",
		"Total"=>"15825.74",
		"ReNombre"=>"Wasser Internacional SA de CV", //Razón social del cliente
		"ReRFC"=>"WIN0410215T8", //rfc_cliente
		"ReCalle"=>"", //
		"ReCodigoPostal"=>"77513",
		"ReColonia"=>"Smz 62 Mz 5",
		"ReEstado"=>"Quintana Roo",
		"ReMunicipio"=>"Benito Juárez",
		"ReNoExterior"=>"Lt8",
		"ReNoInterior"=>"Loc 343",
		"RePais"=>"México",
		"TImporte"=>"2182.86",
		"Notas"=>"Importado para interior de la República con número de pedimento # 14 47 1609 4000559",
		"Moneda"=>"USD", // Tipo de moneda
		"OrdCompra"=>"IBE13-0017", // Referencia operación
		"MonedaCotizacion"=>"USD", //$=pesos USD = dólares € = euros
		"CambioDolares" => 13.40,
		"CambioEuros" => 18.50
	);

	return $datos;
}




function datos_productos(){

	$productos ["productos"] = array(
		/*
			Generar array como tantos productos se vayan a facturar
		*/

			//Array de ejemplo

			/*
				array(
					"Cantidad"=>"", //Cantidad de productos
					"Descripcion"=>"Ropa femenina", // Nombre del producto
					//"Importe" => "", //monto_nal
					"NoIdentificacion" => "" //codigo_producto
					"Unidad"=>"", //unidad_medida
					"ValorUnitario" => "", //precio unitario
					"IVA" => "", //iva_aduana
				),
			*/

		array(
			"Cantidad"=>"2", //Cantidad de productos
			"Descripcion"=>"Nest Oval Bubble Spa", // Nombre del producto
			//"Importe" => "123", //monto_nal
			"NoIdentificacion" => "B-100", //codigo_producto
			"Unidad"=>"Pieza", //unidad_medida
			"ValorUnitario" => "405.61", //precio unitario
			"IVA" => "62.36", //iva_aduana
		),

		array(
			"Cantidad"=>"1", //Cantidad de productos
			"Descripcion"=>"Luxory Exotic Bubble Spa with heat mat", // Nombre del producto
			//"Importe" => "123", //monto_nal
			"NoIdentificacion" => "B-131", //codigo_producto
			"Unidad"=>"Pieza", //unidad_medida
			"ValorUnitario" => "494.08", //precio unitario
			"IVA" => "76.52", //iva_aduana
		),

		array(
			"Cantidad"=>"1", //Cantidad de productos
			"Descripcion"=>"Alpine Square Bubble Spa", // Nombre del producto
			//"Importe" => "123", //monto_nal
			"NoIdentificacion" => "B-091", //codigo_producto
			"Unidad"=>"Pieza", //unidad_medida
			"ValorUnitario" => "423.03", //precio unitario
			"IVA" => "65.15", //iva_aduana
		),

		array(
			"Cantidad"=>"5", //Cantidad de productos
			"Descripcion"=>"Comfort set (including 2 polyurethane headrest and holer)", // Nombre del producto
			//"Importe" => "123", //monto_nal
			"NoIdentificacion" => "B03001350", //codigo_producto
			"Unidad"=>"Pieza", //unidad_medida
			"ValorUnitario" => "50.36", //precio unitario
			"IVA" => "5.53", //iva_aduana
		),

		array(
			"Cantidad"=>"5", //Cantidad de productos
			"Descripcion"=>"MSpa Entertainment Set (iPad Tray+iPad/iphone waterpoof cases)", // Nombre del producto
			//"Importe" => "123", //monto_nal
			"NoIdentificacion" => "B0301963", //codigo_producto
			"Unidad"=>"Pieza", //unidad_medida
			"ValorUnitario" => "35.62", //precio unitario
			"IVA" => "3.17", //iva_aduana
		),

		array(
			"Cantidad"=>"4", //Cantidad de productos
			"Descripcion"=>"Ice Box", // Nombre del producto
			//"Importe" => "123", //monto_nal
			"NoIdentificacion" => "B0301368N", //codigo_producto
			"Unidad"=>"Pieza", //unidad_medida
			"ValorUnitario" => "27.58", //precio unitario
			"IVA" => "1.88", //iva_aduana
		),

		array(
			"Cantidad"=>"1", //Cantidad de productos
			"Descripcion"=>"Canapy for Spa", // Nombre del producto
			//"Importe" => "123", //monto_nal
			"NoIdentificacion" => "B0301383", //codigo_producto
			"Unidad"=>"Pieza", //unidad_medida
			"ValorUnitario" => "36.96", //precio unitario
			"IVA" => "3.38", //iva_aduana
		),

		array(
			"Cantidad"=>"15", //Cantidad de productos
			"Descripcion"=>"Pool Lamps Leds", // Nombre del producto
			//"Importe" => "123", //monto_nal
			"NoIdentificacion" => "HT011C-22W-P", //codigo_producto
			"Unidad"=>"Pieza", //unidad_medida
			"ValorUnitario" => "178.35", //precio unitario
			"IVA" => "25.90", //iva_aduana
		),

		array(
			"Cantidad"=>"15", //Cantidad de productos
			"Descripcion"=>"LAMPARA SUBACUATICA CON CAMBIO DE COLOR AUTOMATICO", // Nombre del producto
			//"Importe" => "123", //monto_nal
			"NoIdentificacion" => "HT002C-P", //codigo_producto
			"Unidad"=>"Pieza", //unidad_medida
			"ValorUnitario" => "131.43", //precio unitario
			"IVA" => "18.39", //iva_aduana
		),

		array(
			"Cantidad"=>"15", //Cantidad de productos
			"Descripcion"=>"UNDERWATER LIGHT", // Nombre del producto
			//"Importe" => "123", //monto_nal
			"NoIdentificacion" => "HT003C-P", //codigo_producto
			"Unidad"=>"Pieza", //unidad_medida
			"ValorUnitario" => "189.08", //precio unitario
			"IVA" => "27.62", //iva_aduana
		),

		array(
			"Cantidad"=>"15", //Cantidad de productos
			"Descripcion"=>"Pool Lamps Leds", // Nombre del producto
			//"Importe" => "123", //monto_nal
			"NoIdentificacion" => "HX-YC220-36W", //codigo_producto
			"Unidad"=>"Pieza", //unidad_medida
			"ValorUnitario" => "122.05", //precio unitario
			"IVA" => "16.89", //iva_aduana
		),

		array(
			"Cantidad"=>"15", //Cantidad de productos
			"Descripcion"=>"Pool Lamps Leds", // Nombre del producto
			//"Importe" => "123", //monto_nal
			"NoIdentificacion" => "HX-YC298-54W", //codigo_producto
			"Unidad"=>"Pieza", //unidad_medida
			"ValorUnitario" => "134.11", //precio unitario
			"IVA" => "18.82", //iva_aduana
		),

	);

	return $productos;

}
//Valor = Precio de la cotización.
//Divisa de valor = Pesos que se tienen que dar por una divisa.
//Divisa a convertir = Pesos que se tienen que dar por la divisa a la cual se desea transformar.

function cambio_divisa($valor,$divisa_de_valor,$divisa_a_convertir){
	return $valor * $divisa_de_valor / $divisa_a_convertir;
}

?>