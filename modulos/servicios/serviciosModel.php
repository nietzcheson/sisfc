<?php 
	/**
	* 
	*/
	class serviciosModel extends Model
	{
		
		function __construct()
		{
			parent::__construct();
		}
		public function getServicios()
		{
	    	$estatus = $this->_db->query("SELECT * FROM servicios ORDER BY id ASC ");
			return $estatus->fetchAll();
	    }

	    public function getIDServicios()
		{
	    	$estatus = $this->_db->query("SELECT id FROM servicios ORDER BY id DESC LIMIT 1");


			return $estatus->fetch();
	    }

	    public function getServicio($id)
	    {
	      	$segmentos = $this->_db->query("SELECT * FROM servicios WHERE id = '$id' ");
			return $segmentos->fetch();
	    }
	    public function crearServicio($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"servicios");
	    }

	    public function actualizarServicio($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"servicios");
	    }
	    public function eliminarServicio($id)
	    {
	        $post = $this->_db->query("DELETE FROM servicios WHERE id = '$id'");
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
			WHERE servicio = '$id'
			");

			return $referencias->fetchAll(PDO::FETCH_ASSOC);
		}
	    
	}
 ?>