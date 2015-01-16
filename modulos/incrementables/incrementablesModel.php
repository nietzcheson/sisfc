<?php 
	/**
	* 
	*/
	class incrementablesModel extends Model
	{
		
		function __construct()
		{
			parent::__construct();
		}
		public function getIncrementables()
		{
	    	$segmentos = $this->_db->query("SELECT * FROM incrementables ORDER BY nombre_incrementable ASC ");
			return $segmentos->fetchAll();
	    }

	    public function getIncrementable($id)
	    {
	      	$segmentos = $this->_db->query("SELECT * FROM incrementables WHERE id_incrementable = '$id' ");
			return $segmentos->fetch();
	    }
	    public function crearIncrementable($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"incrementables");
	    }
	    public function actualizarIncrementable($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"incrementables");
	    }
	    public function eliminarIncrementableModel($id)
	    {
	        $post = $this->_db->query("DELETE FROM incrementables WHERE id_incrementable = '$id'");
	    }
	    public function ultimoIncrementable(){
	        $segmentos = $this->_db->query("SELECT id_incrementable, nombre_incrementable FROM incrementables ORDER BY id_incrementables DESC LIMIT 1");
	        return $segmentos->fetch();
	    }
	}
 ?>