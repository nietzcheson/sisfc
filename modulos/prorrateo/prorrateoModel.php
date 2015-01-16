<?php 

class campanasModel extends Model{

	public function __construct() 
    {
        parent::__construct();
    }

    public function getCampanas(){
    	$campanas = $this->_db->query("SELECT * FROM campanas ORDER BY nombre_campana ASC");
		return $campanas->fetchAll();
    }

    public function getCampana($id)
    {
      	$campana = $this->_db->query("SELECT * FROM campanas WHERE id_u_campana = '$id' ");
		return $campana->fetch();
    }

    public function crear_tipo($nombre)
    {
        $this->_db->query("insert into tipos_campanas values(null, '{$nombre}')");
    }

    public function get_tipos()
    {
        $tipos_campanas = $this->_db->query("SELECT * FROM tipos_campanas ORDER BY nombre ASC");
        return $tipos_campanas->fetchAll();
    }
    public function getTiposAso()
    {
        $tipos_campanas = $this->_db->query(
            "SELECT u.*,r.nombre FROM campanas u, tipos_campanas r " .
            "WHERE u.tipo_campana = r.id"
            );
        return $tipos_campanas->fetchAll(PDO::FETCH_ASSOC);
    }
    public function actualizar_tipos($id,$valor)
    {
        //$id = (int) $id;
        $this->_db->prepare("UPDATE tipos_campanas SET nombre = :nombre WHERE id = :id")
            ->execute(
                array(
                    'id'=>$id,
                    'nombre'=>$valor
                )
            );
    }
    public function actualizarCampana($datosEnviar)
    {
        $this->actualizarSQL($datosEnviar,"campanas");
    }
    public function ultimoCampana(){
        $campanas = $this->_db->query("SELECT id_campana, nombre_campana FROM campanas ORDER BY id_campana DESC LIMIT 1");
        return $campanas->fetch();
    }
    public function crearCampana($datosEnviar)
    {
        $this->insertarSQL($datosEnviar,"campanas");
    }
    public function eliminar_tipos($id)
    {
        $id = (int) $id;
        $post = $this->_db->query("DELETE FROM tipos_campanas WHERE id = ". $id);
    }

    public function ultimo_tipo(){
        $tipos_campanas = $this->_db->query("SELECT * FROM tipos_campanas ORDER BY id DESC LIMIT 1");
        return $tipos_campanas->fetchAll();
    }
    public function eliminarCampanaModel($id)
    {
        $post = $this->_db->query("DELETE FROM campanas WHERE id_u_campana = '$id'");
    }

}


?>