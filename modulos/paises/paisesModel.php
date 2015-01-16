<?php 
	/**
	* 
	*/
	class paisesModel extends Model
	{
		function __construct()
		{
			parent::__construct();
		}
		public function getPaises()
		{
	    	$pais = $this->_db->query("SELECT * FROM paises ORDER BY nombre_pais ASC");
			return $pais->fetchAll();
	    }

	    public function getPais($id)
	    {
	      	$segmentos = $this->_db->query("SELECT * FROM paises WHERE id_pais = '$id' ");
			return $segmentos->fetch();
	    }
	    public function crearPais($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"paises");
	    }
	    public function actualizarPais($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"paises");
	    }
	    public function eliminarPaisModel($id)
	    {
	        $post = $this->_db->query("DELETE FROM paises WHERE id_pais = '$id'");
	    }
	    public function ultimoSegmento(){
	        $segmentos = $this->_db->query("SELECT id_segmento, nombre_segmento FROM paises ORDER BY id_segmento DESC LIMIT 1");
	        return $segmentos->fetch();
	    }
	}
 ?>