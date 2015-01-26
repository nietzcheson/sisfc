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

			$this->updateSchemaToFKey("empresas",false,"pais","pais_id");

			$this->updateSchemaToFKey("empresas_prospectos",array("tabla"=>"prospectos", "col" => "id_u_prospecto"),"id_prospecto", "prospecto_id");
			$this->updateSchemaToFKey("empresas_prospectos",false,"id_empresa", "empresa_id");
			$this->updateSchemaToFKey("prospectos",array("tabla"=>"pais", "col" => "id"),"pais_prospecto", "pais_id");
			$this->updateSchemaToFKey("prospectos",false,"campana_prospecto", "campana_id");
			$this->updateSchemaToFKey("prospectos",false,"id_estatus", "estatus_ventas_id");
			$this->updateSchemaToFKey("calificacion_prospecto",array("tabla"=>"prospectos", "col" => "id_u_prospecto"),"id_u_prospecto", "prospecto_id");
			$this->updateSchemaToFKey("contacto_lead",array("tabla"=>"prospectos", "col" => "id_u_prospecto"),"id_u_prospecto", "prospecto_id");


			return $this->_table;
		}

	}

?>
