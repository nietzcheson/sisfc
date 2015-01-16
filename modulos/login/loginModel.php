<?php
	class loginModel extends Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function getUsuario($usuario,$password)
		{
			$datos = $this->_db->query(
				"SELECT * FROM usuarios " .
				"WHERE usuario = '$usuario' " .
				"AND pass = '" . sha1(md5($password)) . "'"
			);
			return $datos->fetch();
		}

		public function getMarca($email,$pass)
		{
			$empresa = $this->_db->query("SELECT * FROM marcas WHERE email='{$email}' AND pass='".sha1(md5($pass))."'");
			return $empresa->fetch();
		}
	}
