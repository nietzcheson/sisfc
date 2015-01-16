<?php
	/**
	*
	*/
	class perfilModel extends Model
	{
		function __construct(){parent::__construct();}

		function getPerfil($id){
			$id = (int) $id;
			$perfil = $this->_db->query("SELECT * FROM usuarios WHERE id='{$id}'");
			return $perfil->fetch();
		}

		public function actualizarPerfil($datosEnviar){
			$this->actualizarSQL($datosEnviar,"usuarios");
		}

		public function actualizarPassPerfil($datosEnviar){
				$this->actualizarSQL($datosEnviar,"usuarios");
		}

		public function getPassPerfil($id){

			$pass = $this->_db->query("SELECT pass FROM usuarios WHERE id='{$id}'");
			return $pass->fetch();
		}
	}
?>
