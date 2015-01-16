<?php
	class registroModel extends Model
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function verficarUsuario($usuario)
		{

			$id = $this->_db->query(
				"SELECT id, codigo FROM usuario WHERE usuario = '$usuario'"
				);
			return $id->fetch();
		}
		public function verficarEmail($email)
		{
			$id = $this->_db->query(
				"SELECT id FROM usuario WHERE email = '$email'"
				);
			if ($id->fetch()) {
				return true;
			}
			return false;
		}

		public function registrarUsuario($nombre, $usuario, $password, $email)
		{
			$random = rand(10,99999999);
			$this->_db->prepare(
				"INSERT into usuario values" .
				"(null, :nombre, :usuario, :pass, :email, 'usuario', 1, now(),:codigo)"
				)
				->execute(array(
					':nombre'=> $nombre,
					':usuario'=> $usuario,
					':pass' =>  Hash::getHash('md5',$password,HASH_KEY),
					':email' => $email,
					':codigo' => $random
				));
		}

		public function getUsuario($id,$codigo)
		{
			$usuario = $this->_db->query(
				"SELECT * FROM usuario WHERE id = '$id' and codigo = '$codigo'"
				);
			return $id->fetch();
		}

		public function activarUsuario($id,$codigo)
		{
			$this->_db->query(
				"UPDATE usuario SET estado = 1 " . 
				"WHERE id = '$id' and codigo = '$codigo'"
				);
		}
	}