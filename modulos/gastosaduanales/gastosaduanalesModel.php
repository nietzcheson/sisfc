<?php 
	/**
	* 
	*/
	class gastosaduanalesModel extends Model
	{
		
		function __construct()
		{
			parent::__construct();
		}
		public function getGastosAduanales()
		{
	    	$gastos = $this->_db->query("SELECT * FROM gastos_aduanales ORDER BY nombre_es ASC ");
			return $gastos->fetchAll();
	    }

	    public function getGastosAduanal($id)
	    {
	      	$gastos = $this->_db->query("SELECT * FROM gastos_aduanales WHERE id_gasto = '$id' ");
			return $gastos->fetch();
	    }
	    public function crearGastosAduanal($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"gastos_aduanales");
	    }
	    public function actualizarGastosAduanal($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"gastos_aduanales");
	    }
	    public function eliminarGastosAduanalModel($id)
	    {
	        $post = $this->_db->query("DELETE FROM gastos_aduanales WHERE id_gasto = '$id'");
	    }
	    public function ultimoSegmento(){
	        $gastos = $this->_db->query("SELECT id_segmento, nombre_segmento FROM gastos_aduanales ORDER BY id_segmento DESC LIMIT 1");
	        return $gastos->fetch();
	    }
	}
 ?>