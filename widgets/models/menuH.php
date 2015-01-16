<?php 

class menuHModelWidget extends Model{

	public function __construct(){
		parent::__construct();
	}

	public function getMenu(){



		$menu = array(
			"titulo" => $_SESSION["nombre_usuario"],
			"listado" => array(
				array(
					"titulo" => "Cuenta",
					"enlace" => BASE_URL . "cuenta",
				),

				array(
					"titulo" => "Cerrar",
					"enlace" => BASE_URL . "login/cerrar",
					"divisor" => true,
				),
			),
		);



		return $menu;

	}

}


?>