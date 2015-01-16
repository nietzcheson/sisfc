<?php 

class peticionesModel extends Model{


	public function getPrioridades(){
		$prioridades = $this->_db->query("SELECT * FROM prioridades ORDER BY id");
		return $prioridades->fetchAll();
	}

	public function getPeticiones(){
		$prioridades = $this->_db->query(
			"SELECT p.*, pr.prioridad, u.nombre
			FROM peticiones p, prioridades pr, usuario u
			WHERE p.idprioridad=pr.id
			AND p.idusuario=u.id
			ORDER BY p.id DESC
			");
		return $prioridades->fetchAll(PDO::FETCH_ASSOC);
	}

	public function crearPeticion($datosEnviar){
		$this->insertarSQL($datosEnviar,"peticiones");
	}

	public function crearListadosPeticiones(){
		$this->insertarSQL($datosEnviar,"peticiones");
	}
}



?>