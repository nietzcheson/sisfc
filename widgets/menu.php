<?php

class menuWidget extends Widget{

	private $_modelo;

	public function __construct(){
		$this->_modelo = $this->loadModel("menu");
	}

	public function getMenu(){
		$data["menu"] = $this->_modelo->getMenu();

		// - Archivo // - Datos // - Extensión(Default:|phtml)
		return $this->render("menu",$data);
	}

	public function getConfig(){
		return array(
			"position" => "sidebar",
			"show" => "all",
			"hide" => array("registro")
		);
	}

}



?>
