<?php
	class Database extends PDO //se inxtancion con la clase para el control de la base de datos PDO
	{
		public function __construct()
		{
			parent:: __construct( //se inicializa la classe con su contructor padre, dandole los argumentos
				'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
				DB_USER,
				DB_PASS,
				array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . DB_CHAR
				)
			);
		}
	} 