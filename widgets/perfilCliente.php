<?php

class perfilClienteWidget extends Widget
{

	private $_modelo;

	public function __construct()
	{
		//$this->_modelo = $this->loadModel("operaciones");
	}

	public function getPerfil()
	{

	
		$p["datos_adicionales"] = "Hola";
		return $this->render("perfilCliente",$p);
	}

}

?>
