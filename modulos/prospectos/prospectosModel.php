<?php
	/**
	*
	*/
	class prospectosModel extends Model
	{

		function __construct()
		{
			parent::__construct();
		}
		public function getProspectos()//
		{
	    $prospectos = $this->_db->query(
			"SELECT p.id_u_prospecto,nombre_prospecto,apellido_prospecto, fecha_registro, cp.calificacion_porcentaje
			FROM prospectos p LEFT JOIN calificacion_prospecto cp
			ON p.id_u_prospecto = cp.id_u_prospecto
			WHERE rol_prospecto = 'prospecto'
			ORDER BY nombre_prospecto
			ASC");
			return $prospectos->fetchAll();
	  }
	    public function getProspecto($id)//
		{
	    	$empresa = $this->_db->query("SELECT * FROM prospectos WHERE id_u_prospecto = '$id'");
			return $empresa->fetch();
	    }
	    public function getCalificacion($id)//
		{
	    	$calificacion = $this->_db->query("SELECT * FROM calificacion_prospecto WHERE id_u_prospecto = '$id'");
			return $calificacion->fetch();
	    }
	    public function getContacto($id)//
		{
	    	$empresa = $this->_db->query("SELECT * FROM contacto_lead WHERE id_u_prospecto = '$id'");
			return $empresa->fetch();
	    }
	    public function getPaises()//
	    {
	        $empresa = $this->_db->query("SELECT * FROM pais ORDER BY pais ASC");
			return $empresa->fetchAll();
	    }
	    public function getCampanas()//
	    {
	        $empresa = $this->_db->query("SELECT * FROM campanas ORDER BY campana ASC");
			return $empresa->fetchAll();
	    }
	    public function getSegmentos()//
	    {
	        $empresa = $this->_db->query("SELECT * FROM segmentos ORDER BY nombre_segmento ASC");
			return $empresa->fetchAll();
	    }
	    public function getInternos()//
	    {
	        $empresa = $this->_db->query("SELECT * FROM usuarios_sisfc ORDER BY nombre_usuario ASC");
			return $empresa->fetchAll();
	    }
	    public function getEmpresas()//
	    {
	        $empresa = $this->_db->query("SELECT * FROM marcas ORDER BY nombre_marca ASC");
			return $empresa->fetchAll();
	    }
	    public function crearProspecto($datosEnviar)//
	    {
	    	$this->insertarSQL($datosEnviar,"prospectos");
	    }
	    public function crearCalificacion($datosEnviar)//
	    {
	    	$this->insertarSQL($datosEnviar,"calificacion_prospecto");
	    }
	    public function actualizarProspecto($datosEnviar)//
	    {
	        $this->actualizarSQL($datosEnviar,"prospectos");
	    }
	    public function actualizarCalificacion($datosEnviar)//
	    {
	        $this->actualizarSQL($datosEnviar,"calificacion_prospecto");
	    }
	    public function eliminarProspectoModel($id)//
	    {
	        $post = $this->_db->query("DELETE FROM prospectos WHERE id_u_prospecto = '$id'");
	    }
	    public function ultimoProspecto(){//
	        $campanas = $this->_db->query("SELECT id_prospecto, nombre_prospecto FROM prospectos ORDER BY id_prospecto DESC LIMIT 1");
	        return $campanas->fetch();
	    }
	    public function getUsuario_sisfcId($id){//
			$usuarios_sisfc = $this->_db->query(
                "SELECT id_u_usuario FROM usuarios_sisfc WHERE id_usuario = $id"
                );
        	return $usuarios_sisfc->fetch();
		}

		public function getReferencias($id){
			$referencias = $this->_db->query("
			SELECT *
			FROM referencias r LEFT JOIN marcas m
			ON r.cliente = m.id_u_marca
			LEFT JOIN usuarios_sisfc u
			ON r.ace = u.id_u_usuario
			LEFT JOIN prospectos p
			ON r.cliente = p.id_u_prospecto
			WHERE id_u_empresa = '$id' ORDER BY id_u_referencia ASC
			");
			return $referencias->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getTiposDatos(){
			$tiposDatos = $this->_db->query("SELECT * FROM t_datos_adicionales");
			return $tiposDatos->fetchAll();
		}

		public function setDatosAdicionales($datosEnviar)//
		{
			$this->insertarSQL($datosEnviar,"datos_adicionales");
		}

		public function getDatosAdicionales($id){
			$datos = $this->_db->query("SELECT * FROM datos_adicionales WHERE id_prospecto='{$id}'");

			return $datos->fetchAll();
		}

		public function actualizarDatosAdicionales($datosEnviar)//
		{
				$this->actualizarSQL($datosEnviar,"datos_adicionales");
		}

		public function eliminarDatoAdicional($id)//
		{
				$id = (int) $id;
				$post = $this->_db->query("DELETE FROM datos_adicionales WHERE id = '$id'");
		}

		public function empresasFC()
		{
			$empresas = $this->_db->query("SELECT id,empresa FROM empresas");

			return $empresas->fetchAll();
		}

		public function eliminarEmpresasFC($id)//
		{
				$empresas = $this->_db->query("DELETE FROM empresas_prospectos WHERE id_prospecto = '$id'");
		}

		public function setEmpresasFC($datosEnviar)
		{
			$this->insertarSQL($datosEnviar,"empresas_prospectos");
		}

		public function getEmpresasFC($id)
		{
			$empresas = $this->_db->query("SELECT * FROM empresas_prospectos WHERE id_prospecto='$id'");

			return $empresas->fetchAll(PDO::FETCH_ASSOC);
		}


	}
 ?>
