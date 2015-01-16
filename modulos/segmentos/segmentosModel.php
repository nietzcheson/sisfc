<?php 
	/**
	* 
	*/
	class segmentosModel extends Model
	{
		
		function __construct()
		{
			parent::__construct();
		}
		public function getSegmentos()
		{
	    	$segmentos = $this->_db->query("SELECT * FROM segmentos ORDER BY nombre_segmento ASC ");
			return $segmentos->fetchAll();
	    }

	    public function getSegmento($id)
	    {
	      	$segmentos = $this->_db->query("SELECT * FROM segmentos WHERE id_u_segmento = '$id' ");
			return $segmentos->fetch();
	    }
	    public function crearSegmento($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"segmentos");
	    }
	    public function actualizarSegmento($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"segmentos");
	    }
	    public function eliminarSegmentoModel($id)
	    {
	        $post = $this->_db->query("DELETE FROM segmentos WHERE id_u_segmento = '$id'");
	    }
	    public function ultimoSegmento(){
	        $segmentos = $this->_db->query("SELECT id_segmento, nombre_segmento FROM segmentos ORDER BY id_segmento DESC LIMIT 1");
	        return $segmentos->fetch();
	    }
	}
 ?>