<?php 
	/**
	* 
	*/
	class estatusModel extends Model
	{
		
		function __construct()
		{
			parent::__construct();
		}
		public function getEstatus()
		{
	    	$estatus = $this->_db->query("SELECT * FROM estatus ORDER BY posicion ASC ");
			return $estatus->fetchAll();
	    }

	    public function getEstatusId($id)
	    {
	      	$segmentos = $this->_db->query("SELECT * FROM estatus WHERE id = '$id' ");
			return $segmentos->fetch();
	    }
	    public function crearEstatus($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"estatus");
	    }
	    public function actualizarEstatus($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"estatus");
	    }
	    public function eliminarEstatus($id)
	    {
	        $post = $this->_db->query("DELETE FROM estatus WHERE id = '$id'");
	    }
	    public function ultimoIncrementable(){
	        $segmentos = $this->_db->query("SELECT id_incrementable, nombre_incrementable FROM incrementables ORDER BY id_incrementables DESC LIMIT 1");
	        return $segmentos->fetch();
	    }

	    public function getReferencias($id){
			$referencias = $this->_db->query("
			SELECT *
			FROM referencias r LEFT JOIN marcas m
			ON r.cliente = m.id_u_marca
			LEFT JOIN estatus st
			ON r.status = st.id
			LEFT JOIN usuarios_sisfc u
			ON r.ace = u.id_u_usuario
			WHERE status = '$id'
			");

			return $referencias->fetchAll(PDO::FETCH_ASSOC);
		}
	}
 ?>