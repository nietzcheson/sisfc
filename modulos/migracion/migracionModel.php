<?php 

class migracionModel extends Model{

	public function __construct()
	{
		parent::__construct();
	}

	public function getUsuarios_sisfc(){

		 $usuarios_sisfc = $this->_db->query(
                "select * from usuarios_sisfc"
                );

        return $usuarios_sisfc->fetchAll();
	}

	public function registrarUsuario($id, $nombre, $usuario, $pass, $email, $fecha)
	{
		$random = rand(10,99999999);
		$this->_db->prepare(
			"INSERT INTO usuario VALUES" .
			"(:id, :nombre, :usuario, :pass, :email, 1, 1, :fecha, :codigo)"
			)
			->execute(array(
				":id" => $id,
				':nombre'=> $nombre,
				':usuario'=> $usuario,
				':pass' =>  $pass,
				':email' => $email,
				':fecha' => $fecha,
				':codigo' => $random
			)
		);
	}

}


?>