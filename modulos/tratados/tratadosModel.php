<?php 
	/**
	* 
	*/
	class tratadosModel extends Model
	{
		
		function __construct()
		{
			parent::__construct();
		}
		public function getTratados()
		{
	    	$tratados = $this->_db->query("SELECT * FROM tratados ORDER BY sigla ASC ");
			return $tratados->fetchAll();
	    }
	    public function getPaises()
		{
	    	$pais = $this->_db->query("SELECT * FROM paises ORDER BY nombre_pais ASC");
			return $pais->fetchAll();
	    }
	    public function getTratado($id)
	    {
	      	$tratados = $this->_db->query("SELECT * FROM tratados WHERE id_u_tratado = '$id' ");
			return $tratados->fetch();
	    }
	    public function getTratadoPaises($id)
	    {
	      	$tratados = $this->_db->query("SELECT id_pais FROM tratados_paises WHERE id_u_tratado = '$id' ");
			return $tratados->fetchAll();
	    }
	    public function crearTratado($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"tratados");
	    }
	    public function crearTratadoPais($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"tratados_paises");
	    }
	    public function actualizarSTratado($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"tratados");
	    }
	    public function eliminarTratadoModel($id)
	    {
	        $post = $this->_db->query("DELETE FROM tratados WHERE id_u_tratado = '$id'");
	    }
	    public function eliminarTratadoPaisesModel($id)
	    {
	        $post = $this->_db->query("DELETE FROM tratados_paises WHERE id_u_tratado = '$id'");
	    }
	    public function ultimoTratado(){
	        $tratados = $this->_db->query("SELECT id_tratado, nombre_tratado FROM tratados ORDER BY id_tratado DESC LIMIT 1");
	        return $tratados->fetch();
	    }
	}
 ?>