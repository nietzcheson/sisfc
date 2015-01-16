<?php

class menuModelWidget extends Model{

	public function __construct(){
		parent::__construct();
	}

	public function getMenu(){
		$menu = array(
			array(
				"id"			=>		"kpis",
				"icono" 	=> 		"stats",
				"titulo"	=>		"KPI's",
				"enlace"	=>		BASE_URL . "kpis",
			),
			array(
				"id"			=>		"operaciones",
				"icono" 	=> 		"cog",
				"titulo"	=>		"Operaciones",
				"enlace"	=>		BASE_URL . "operaciones",
			),
			array(
				"id"			=>		"facturacion",
				"icono" 	=> 		"list-alt",
				"titulo"	=>		"Facturación",
				"enlace"	=>		BASE_URL . "facturacion",
			),
			array(
				"id"			=>		"clientes",
				"icono" 	=> 		"lock",
				"titulo"	=>		"Clientes",
				"enlace"	=>		BASE_URL . "clientes",
				"submenu" =>		array(
					array(
						"id"  		=>		"prospectos",
						"titulo"  =>		"Prospectos",
						"enlace"  =>		BASE_URL . "prospectos",
					),
					array(
						"id"  		=>		"leads",
						"titulo"  =>		"Leads",
						"enlace"  =>		BASE_URL . "leads",
					),
					array(
						"id"  		=>		"clientes",
						"titulo"  =>		"Clientes",
						"enlace"  =>		BASE_URL . "clientes",
					),

				),

			),

			// array(
			// 	"id"		=>		"peticiones",
			// 	"icono" 	=> 		"bullhorn",
			// 	"titulo"	=>		"Peticiones",
			// 	"enlace"	=>		BASE_URL . "peticiones"
			//
			// ),

			array(
				"id"		=>		"proveedores",
				"icono" 	=> 		"globe",
				"titulo"	=>		"Proveedores",
				"enlace"	=>		BASE_URL . "proveedores"

			),

			/*array(
				"id"			=>		"sdt",
				"icono" 	=> 		"time",
				"titulo"	=>		"SDT",
				"enlace"	=>		BASE_URL . "sdt"

			),
			*/
			array(
				"id"		=>		"catalogos",
				"icono" 	=> 		"list",
				"titulo"	=>		"Catalogos",
				"enlace"	=>		BASE_URL . "catalogos",
				"submenu" =>		array(
					array(
						"id"  		=>		"campanas",
						"titulo"  =>		"Campañas",
						"enlace"  =>		BASE_URL . "campanas",
					),
					array(
						"id"  		=>		"empresas",
						"titulo"  =>		"Empresas",
						"enlace"  =>		BASE_URL . "empresas",
					),
					array(
						"id"  		=>		"estatus",
						"titulo"  =>		"Estatus de operaciones",
						"enlace"  =>		BASE_URL . "estatus",
					),
					array(
						"id"  		=>		"estatus_ventas",
						"titulo"  =>		"Estatus de ventas",
						"enlace"  =>		BASE_URL . "estatus_ventas",
					),
					array(
						"id"  		=>		"incrementables",
						"titulo"  =>		"Incrementables",
						"enlace"  =>		BASE_URL . "incrementables",
					),
					array(
						"id"  		=>		"gastos_aduanales",
						"titulo"  =>		"Gastos aduanales",
						"enlace"  =>		BASE_URL . "gastosaduanales",
					),
					array(
						"id"  		=>		"paises",
						"titulo"  =>		"Países",
						"enlace"  =>		BASE_URL . "paises",
					),
					array(
						"id"  		=>		"segmentos",
						"titulo"  =>		"Segmentos",
						"enlace"  =>		BASE_URL . "segmentos",
					),
					array(
						"id"  		=>		"servicios",
						"titulo"  =>		"Servicios",
						"enlace"  =>		BASE_URL . "servicios",
					),
					array(
						"id"  		=>		"tratados",
						"titulo"  =>		"Tratados",
						"enlace"  =>		BASE_URL . "tratados",
					),

				),

			),

			array(
				"id"		=>		"sdt",
				"icono" 	=> 		"tasks",
				"titulo"	=>		"SDT",
				"enlace"	=>		BASE_URL . "sdt_live",

			),

			array(
				"id"		=>		"reportes",
				"icono" 	=> 		"signal",
				"titulo"	=>		"Reportes",
				"submenu" =>		array(
					array(
						"id"  		=>		"datosclientes",
						"titulo"  =>		"Origen de ingreso",
						"enlace"  =>		BASE_URL . "datosclientes/datos",
					),
					array(
						"id"  		=>		"embudodeventas",
						"titulo"  =>		"Embudo de ventas",
						"enlace"  =>		BASE_URL . "leads/embudo",
					),

					array(
						"id"  		=>		"embudooperaciones",
						"titulo"  =>		"Embudo de operaciones",
						"enlace"  =>		BASE_URL . "operaciones/embudo",
					),

				),

			),


		);

		return $menu;
	}


}


?>
