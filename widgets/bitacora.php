<?php

class bitacoraWidget extends Widget{

	private $_modelo;

	public function __construct(){
		//$this->_modelo = $this->loadModel("menu");
	}

	public function getBitacora()
	{
		if(isset($_POST["nombre"])==1){
			echo "Listo";
		}
		return $this->render("bitacora");
	}

}
