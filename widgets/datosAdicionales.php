<?php

class datosAdicionalesWidget extends Widget
{
	private $_modelo;
	public function __construct()
	{
		$this->_modelo = $this->loadModel("datosAdicionales");
	}

	public function getDatos($id)
	{

		$datos["tipos_adicionales"] = $this->_modelo->getTiposAdicionales();
		$datos_adicionales = $this->_modelo->getDatosAdicionales($id);

		if($this->getInt("datos_adicionales")==1){

			$_post = $_POST;

			$almacenarDatos = function() use ($_post,$id){

				if(isset($_post["id_dato"])){
					$id_dato = $_post["id_dato"];
					$valor_dato = $_post["valor_dato"];
					$datos = array();

					for($i=0;$i<count($id_dato);$i++){

						if($id_dato[$i]!="x"){
							$datos[$i]["id_dato"] = $id_dato[$i];
							$datos[$i]["valor_dato"] = $valor_dato[$i];
						}
					}


					foreach($datos as $d){

						if($d["id_dato"]!="x" && $d["valor_dato"]!=""){

							$datosEnviar = array(
								"id_prospecto" => $id,
								"id_tipodato" => $d["id_dato"],
								"dato" => $d["valor_dato"]
							);

							$this->_modelo->setDatosAdicionales($datosEnviar);
						}
					}
				}

			};

			$almacenarDatos();



			$ids_adicionales = array();

			for($i=0;$i<count($datos_adicionales);$i++){
				$ids_adicionales[$i] = $datos_adicionales[$i]["id"];
			}

			if(isset($_POST["id_adicional"])){

				$ids_adicionales_ = $_POST["id_adicional"];

				$diferencias = array_diff($ids_adicionales,$ids_adicionales_);
				$igualdad = array_intersect($ids_adicionales, $ids_adicionales_);

				foreach($diferencias as $ide){
					$this->_modelo->eliminarDatosAdicionales($ide);
				}

			}else{
				$this->_modelo->eliminarDatoAdicional($id);
				$almacenarDatos();
			}

		}

		$datos["tipos_adicionales"] = $this->_modelo->getTiposAdicionales();
		$datos_adicionales = $this->_modelo->getDatosAdicionales($id);
		$datos["datos_adicionales"] = $datos_adicionales;
		return $this->render("datosAdicionales",$datos);
	}
}

?>
