<?php

class menuSecsWidget extends Widget
{
	private $_modelo;
	public function __construct(){
		$this->_modelo = $this->loadModel("menuSecs");
	}

	public function getMenu()
	{

		$id_marca = $_SESSION["id_marca"];

		$datos["menu"] = $this->_modelo->getMenu();
		$datos["marca"] = $this->_modelo->getMarca($id_marca);
		$datos["menuExtra"] = $this->_modelo->menuExtra();

		return $this->render("menuSecs",$datos);
	}

	public function getConfig()
	{
		return array(
			"position" => "secs",
			"show" => "all",
			"hide" => array("sisfc")
		);
	}
}


?>
