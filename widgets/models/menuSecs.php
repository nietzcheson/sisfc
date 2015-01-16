<?php

class menuSecsModelWidget extends Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getMenu(){
		$menu = array(
			array(
				"id"			=>		"inicio",
				"icono" 	=> 		"cog",
				"titulo"	=>		"Inicio",
				"enlace"	=>		BASE_URL . "secs/inicio",
			),

			array(
				"id"			=>		"perfil",
				"icono" 	=> 		"cog",
				"titulo"	=>		"Perfil",
				"enlace"	=>		BASE_URL . "secs/perfil",
			),

			array(
				"id"			=>		"operaciones",
				"icono" 	=> 		"user",
				"titulo"	=>		"Operaciones",
				"enlace"	=>		BASE_URL . "secs/operaciones",
			),

			array(
				"id"			=>		"proveedores",
				"icono" 	=> 		"cog",
				"titulo"	=>		"Proveedores",
				"enlace"	=>		BASE_URL . "secs/proveedores",
			),

			array(
				"id"			=>		"contactos",
				"icono" 	=> 		"user",
				"titulo"	=>		"Contactos",
				"enlace"	=>		BASE_URL . "secs/contactos",
			),
		);

		return $menu;
	}

	public function menuExtra()
	{

		$menu = array(
			array(
				"id"			=>		"cuente",
				"icono" 	=> 		"cog",
				"titulo"	=>		"Configuración de la cuenta",
				//"enlace"	=>		BASE_URL . "login/cuenta",
			),
			array(
				"id"			=>		"buzon",
				"icono" 	=> 		"bullhorn",
				"titulo"	=>		"¿Algún problema?",
				//"enlace"	=>		BASE_URL . "login/buzon",
			),
			array(
				"id"			=>		"cerrar",
				"icono" 	=> 		"off",
				"titulo"	=>		"Cerrar",
				"enlace"	=>		BASE_URL . "login/cerrar",
			),
		);

		return $menu;
	}

	public function getMarca($id){
		$marca = $this->_db->query("SELECT nombre_marca FROM marcas WHERE id_u_marca='{$id}'");
		return $marca->fetch();
	}


}

?>
