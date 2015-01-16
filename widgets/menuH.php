<?php 

class menuHWidget extends Widget{

	private $_modelo;

	public function __construct(){
		$this->_modelo = $this->loadModel("menuH");
	}

	public function getMenuH(){
		$data["menu"] = $this->_modelo->getMenu();
		return $this->render("menuH",$data);
	}

	public function getConfig(){
		return array(
			"position" => "menuH",
			"show" => "all",
			"hide" => array("registro")
		);
	}

}



?>