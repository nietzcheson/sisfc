<?php

	class deployModel extends Model
	{

		private $_table;

		public function __construct()
		{
			$this->_table = $_table;
			parent::__construct();
		}

		public function updateSchemaToFKey($tabla_update, $tabla_extraer = false, $col_old, $fk)
		{
			$this->_table[] = array(
				"tabla_actualizar" => $tabla_update,
				"tabla_extraer" => array(
					'tabla' => $tabla_extraer["tabla"],
					'col' => $tabla_extraer["tabla"]
				),
				'col_old' => $col_old,
				'fk' => $fk
			);

			$consulta = $this->_db->query("SELECT * FROM $tabla_update")->fetchAll();

			for($i=0; $i<count($consulta); $i++){

				$id_consulta = (int) $consulta[$i][$col_old];

				if($tabla_extraer !=false){
					$fetch = $this->_db->query("SELECT * FROM ".$tabla_extraer['tabla']." WHERE ".$tabla_extraer['col']."='".$consulta[$i][$col_old]."'")->fetch();
					$id_consulta = ($fetch["id"] !=null || $fetch["id"] !="") ? $fetch["id"] = (int) $fetch["id"] : $fetch["id"] = 0;
				}

				if($id_consulta!=0){
					$this->_db->query("UPDATE $tabla_update SET $fk='$id_consulta' WHERE $col_old='".$consulta[$i][$col_old]."'");
				}

			}

		}

		public function deploy()
		{

			// $paises = $this->_db->query("SELECT * FROM paises")->fetchAll();
			//
			// for($i=0;$i<count($paises);$i++){
			//
			// 	$pais = $paises[$i]['nombre_pais'];
			// 	$sigla = $paises[$i]['codigo'];
			//
			// 	$this->_db->query("INSERT INTO pais (id, pais, sigla) VALUES (NULL, '$pais', '$sigla')");
			// }
			//
			// exit();


			// $empresas = $this->_db->query("SELECT nombre_empresa,pais_id FROM empresas WHERE pais_id =21")->fetchAll();
			//
			// echo "<pre>";print_r($empresas);
			// exit();

			// $incoterms = $this->_db->query("SELECT * FROM incoterms")->fetchAll();
			//
			// for($i=0; $i<count($incoterms);$i++){
			// 	$incoterm = $incoterms[$i]["nombre"];
			// 	$codigo = $incoterms[$i]["codigo"];
			//
			// 	$this->_db->query("INSERT INTO incoterm (id, incoterm, codigo) VALUES(NULL, '$incoterm', '$codigo')");
			// }


			// $this->updateSchemaToFKey("empresas",false,"pais","pais_id");
			//
			// $this->updateSchemaToFKey("empresas_prospectos",array("tabla"=>"prospectos", "col" => "id_u_prospecto"),"id_prospecto", "prospecto_id");
			// $this->updateSchemaToFKey("empresas_prospectos",false,"id_empresa", "empresa_id");
			// $this->updateSchemaToFKey("prospectos",array("tabla"=>"pais", "col" => "id"),"pais_prospecto", "pais_id");
			// $this->updateSchemaToFKey("prospectos",false,"campana_prospecto", "campana_id");
			// $this->updateSchemaToFKey("prospectos",false,"id_estatus", "estatus_ventas_id");
			// $this->updateSchemaToFKey("calificacion_prospecto",array("tabla"=>"prospectos", "col" => "id_u_prospecto"),"id_u_prospecto", "prospecto_id");
			// $this->updateSchemaToFKey("contacto_lead",array("tabla"=>"prospectos", "col" => "id_u_prospecto"),"id_u_prospecto", "prospecto_id");
			//
			// // Marcas - Prospectos
			// $this->updateSchemaToFKey("marcas_clientes",array("tabla"=>"marcas", "col" => "id_u_marca"),"id_u_marca", "cliente_id");
			// $this->updateSchemaToFKey("marcas_clientes",array("tabla"=>"prospectos", "col" => "id_u_prospecto"),"id_u_cliente", "prospecto_id");
			//
			// // Marcas - Razones sociales
			// $this->updateSchemaToFKey("marca_razon_social",array("tabla"=>"marcas", "col" => "id_u_marca"),"id_u_marca", "cliente_id");
			// $this->updateSchemaToFKey("marca_razon_social",array("tabla"=>"razones_sociales", "col" => "id_u_rs"),"id_u_rs", "razon_social_id");
			//
			// //Razon social - Acta constitutiva
			// $this->updateSchemaToFKey("acta_constitutiva",array("tabla"=>"razones_sociales", "col" => "id_u_rs"),"id_u_razonsocial", "razon_social_id");
			//
			// // Razon social - File fiscal
			// $this->updateSchemaToFKey("file_fiscal",array("tabla"=>"razones_sociales", "col" => "id_u_rs"),"id_u_razonsocial", "razon_social_id");
			//
			// //Proveedores - Productos
			// $this->updateSchemaToFKey("productos",array("tabla"=>"proveedores", "col" => "id_u_proveedor"),"id_u_proveedor", "proveedor_id");
			//
			// //Proveedores - Paises
			// $this->updateSchemaToFKey("proveedores",array("tabla"=>"pais", "col" => "id"),"pais", "pais_id");
			//
			// //Operaciones - Tipo cliente
			// $this->updateSchemaToFKey("referencias",array("tabla"=>"tipos_clientes", "col" => "id"),"tipo_cliente", "tipo_cliente_id");
			//
			// //Operaciones - Empresas
			// $this->updateSchemaToFKey("referencias",array("tabla"=>"empresas", "col" => "id_u_empresa"),"id_u_empresa", "empresa_id");
			//
			// //Operaciones - Clientes
			// $this->updateSchemaToFKey("referencias",array("tabla"=>"marcas", "col" => "id_u_marca"),"cliente", "cliente_id");
			//
			// //Operaciones - Prospectos
			// $this->updateSchemaToFKey("referencias",array("tabla"=>"prospectos", "col" => "id_u_prospecto"),"contacto", "prospecto_id");
			//
			// //Operaciones - Estatus
			// $this->updateSchemaToFKey("referencias",array("tabla"=>"estatus", "col" => "id"),"status", "estatus_id");
			//
			// //Operaciones - Servicios
			// $this->updateSchemaToFKey("referencias",array("tabla"=>"servicios", "col" => "id"),"servicio", "servicio_id");
			//
			// //Operaciones - CO
			// $this->updateSchemaToFKey("referencias",array("tabla"=>"usuarios", "col" => "id"),"co", "co_id");
			//
			// //Operaciones - ECL
			// $this->updateSchemaToFKey("referencias",array("tabla"=>"usuarios", "col" => "id"),"ecl", "ecl_id");
			//
			// //Operaciones - ETA
			// $this->updateSchemaToFKey("referencias",array("tabla"=>"usuarios", "col" => "id"),"eta", "eta_id");
			//
			// //Operaciones - Monedas
			// $this->updateSchemaToFKey("referencias",array("tabla"=>"monedas", "col" => "id"),"moneda", "moneda_id");
			//
			// //Órdenes de compra - Referencias
			// $this->updateSchemaToFKey("ordenes_compra",array("tabla"=>"referencias", "col" => "id_u_referencia"),"id_u_referencia", "referencia_id");
			//
			// //Órdenes de compra - Proveedores
			// $this->updateSchemaToFKey("ordenes_compra",array("tabla"=>"proveedores", "col" => "id_u_proveedor"),"id_u_proveedor", "proveedor_id");
			//
			// //Orden detalle - Ordenes de compra
			// $this->updateSchemaToFKey("orden_detalle",array("tabla"=>"ordenes_compra", "col" => "id_u_orden"),"id_u_orden", "orden_compra_id");
			//
			// //Orden detalle - Productos
			// $this->updateSchemaToFKey("orden_detalle",array("tabla"=>"productos", "col" => "id_u_producto"),"id_u_producto", "producto_id");
			//
			// //Cotizacion - Referencias
			// $this->updateSchemaToFKey("cotizaciones",array("tabla"=>"referencias", "col" => "id_u_referencia"),"id_u_referencia", "referencia_id");

			//Cotizacion - Incoterms
			// Update en los incoterms : UPDATE cotizaciones SET incoterm=2 WHERE incoterm="FCA"

			// $this->updateSchemaToFKey("cotizaciones",array("tabla"=>"incoterm", "col" => "id"),"incoterm", "incoterm_id");
			//
			// //Cotizacion - Embalajes
			//
			// $this->updateSchemaToFKey("cotizaciones",array("tabla"=>"embalaje", "col" => "id"),"tipo_embalaje", "embalaje_id");
			//
			// //Cotizacion - Tipo Operacion
			//
			// $this->_db->query("UPDATE cotizaciones SET operacion=1 WHERE operacion='impor'");
			// $this->_db->query("UPDATE cotizaciones SET operacion=2 WHERE operacion='expor'");
			//
			// $this->updateSchemaToFKey("cotizaciones",array("tabla"=>"tipos_operaciones", "col" => "id"),"operacion", "operacion_id");
			//
			// //Cotizacion - Embalajes
			//
			// $this->updateSchemaToFKey("cotizaciones",array("tabla"=>"secciones_aduaneras", "col" => "id"),"seccion_aduanera", "seccion_aduanera_id");
			//
			// //Cotizacion - Medios transporte
			//
			// $this->updateSchemaToFKey("cotizaciones",array("tabla"=>"medios_transporte", "col" => "id"),"medio_transporte", "medio_transporte_id");
			//
			// //Cotizacion Ordenes - Cotizaciones
			// $this->updateSchemaToFKey("cotizacion_ordenes",array("tabla"=>"cotizaciones", "col" => "id_u_cotizacion"),"id_u_cotizacion", "cotizacion_id");
			//
			// //Cotizacion Ordenes - Órdenes compra
			// $this->updateSchemaToFKey("cotizacion_ordenes",array("tabla"=>"ordenes_compra", "col" => "id_u_orden"),"id_u_orden", "orden_compra_id");
			//
			// //Cotizacion Incrementables - Cotizaciones
			// $this->updateSchemaToFKey("cotizacion_incrementables",array("tabla"=>"cotizaciones", "col" => "id_u_cotizacion"),"id_u_cotizacion", "cotizacion_id");
			//
			// //Cotizacion Incrementables - Incrementables
			// $this->updateSchemaToFKey("cotizacion_incrementables",array("tabla"=>"incrementables", "col" => "id"),"id_incrementable", "incrementable_id");
			//
			// //Cotizacion Gastos - Cotizaciones
			// $this->updateSchemaToFKey("gastos_cotizaciones",array("tabla"=>"cotizaciones", "col" => "id_u_cotizacion"),"id_u_cotizacion", "cotizacion_id");
			//
			// //Cotizacion Gastos - Cotizaciones
			// $this->updateSchemaToFKey("gastos_cotizaciones",array("tabla"=>"gastos_aduanales", "col" => "id"),"id_gasto", "gasto_aduanal_id");
			//
			// //Impuestos cotizacion - Cotizaciones
			// $this->updateSchemaToFKey("impuestos_cotizacion",array("tabla"=>"cotizaciones", "col" => "id_u_cotizacion"),"id_u_cotizacion", "cotizacion_id");

			//CxC cotizacion - Cotizaciones
			$this->updateSchemaToFKey("cxc_cotizacion",array("tabla"=>"cotizaciones", "col" => "id_u_cotizacion"),"id_u_cotizacion", "cotizacion_id");

			//CxC cotizacion - Conceptos CxC
			$this->updateSchemaToFKey("cxc_cotizacion",array("tabla"=>"conceptos_cxc", "col" => "id"),"concepto", "concepto_cxc_id");

			return $this->_table;
		}

	}

?>
