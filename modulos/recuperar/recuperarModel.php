<?php

class recuperarModel extends Model
{
	function __construct(){parent::__construct();}

	public function getEmailsUsuarios($id)
	{
		$emails = $this->_db->query("SELECT email FROM usuarios WHERE email='{$id}'");

		return $emails->fetch();
	}

	public function actualizarCodigo($email,$codigo)
	{
		$this->_db->query("UPDATE usuarios SET codigo_recuperar='{$codigo}' WHERE email='{$email}'");
	}

	public function getDatosPerfil($codigo)
	{
		$datos = $this->_db->query("SELECT * FROM usuarios WHERE codigo_recuperar='{$codigo}'");
		return $datos->fetch();
	}

	public function actualizarPass($codigo,$pass)
	{
		$this->_db->query("UPDATE usuarios SET pass='{$pass}' WHERE codigo_recuperar='{$codigo}'");
	}

	public function borrarCodigo($codigo)
	{
		$this->_db->query("UPDATE usuarios SET codigo_recuperar='' WHERE codigo_recuperar='{$codigo}'");

	}


}
?>
