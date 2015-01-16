<?php

class operacionesWidget extends Widget
{

	private $_modelo;

	public function __construct()
	{
		$this->_modelo = $this->loadModel("operaciones");
	}

	public function getOperaciones($empresa)
	{

		if($empresa==""){
			$empresa = "si000";
		}

		$operaciones = $this->_modelo->getReferencias($empresa);

		$monedas = $this->_modelo->getMonedas();
		$usuarios = $this->_modelo->getUsuarios();

		for($i=0;$i<count($operaciones);$i++){

			for($u=0;$u<count($usuarios);$u++){
				if ($operaciones[$i]["co"]==$usuarios[$u]["id"]){
					$operaciones[$i]["co"] = $usuarios[$u]["nombre"];
				}

				if ($operaciones[$i]["ecl"]==$usuarios[$u]["id"]){
					$operaciones[$i]["ecl"] = $usuarios[$u]["nombre"];
				}

				if ($operaciones[$i]["eta"]==$usuarios[$u]["id"]){
					$operaciones[$i]["eta"] = $usuarios[$u]["nombre"];
				}

			}
		}

		$operaciones["operaciones"] = $operaciones;
		$operaciones["estatus"] = $this->_modelo->getEstatus();
		return $this->render("operaciones",$operaciones);
	}

	public function getConfig()
	{
		return "Las configuraciones";
	}
}




?>
