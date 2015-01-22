<?php
	/**
	*
	*/
	class leadsModel extends Model
	{

		function __construct()
		{
			parent::__construct();
		}
		public function getLeads()//
		{
	    	$prospectos = $this->_db->query(
						"SELECT *
						FROM prospectos
						WHERE rol_prospecto = 'lead'
						ORDER BY nombre_prospecto
						ASC");
						return $prospectos->fetchAll();
	    }

		// public function getLeads()//
		// {
		// 	$prospectos = $this->_db->query(
		// 		"SELECT *
		// 		FROM prospectos p INNER JOIN estatus_ventas ev
		// 		ON p.id_estatus = ev.id
		// 		WHERE p.rol_prospecto = 'lead'
		// 		ORDER BY nombre_prospecto
		// 		ASC");
		// 	return $prospectos->fetchAll();
		// }

	    public function getProspectoLead($id)//
		{
	    	$empresa = $this->_db->query("SELECT * FROM prospectos WHERE rol_prospecto = 'lead' AND id_u_prospecto = '$id'");
			return $empresa->fetch();
	    }
	    public function getCalificacion($id)//
		{
	    	$empresa = $this->_db->query("SELECT * FROM calificacion_prospecto WHERE id_u_prospecto = '$id'");
			return $empresa->fetch();
	    }
	    public function getContacto($id)//
		{
	    	$empresa = $this->_db->query("SELECT * FROM contacto_lead WHERE id_u_prospecto = '$id'");
			return $empresa->fetch();
	    }
	    public function getPaises()//
	    {
	        $empresa = $this->_db->query("SELECT * FROM paises ORDER BY nombre_pais ASC");
			return $empresa->fetchAll();
	    }
	    public function getCampanas()//
	    {
	        $empresa = $this->_db->query("SELECT * FROM campanas ORDER BY campana ASC");
			return $empresa->fetchAll();
	    }
	    public function getSegmentos()//
	    {
	        $empresa = $this->_db->query("SELECT * FROM segmentos ORDER BY segmento ASC");
			return $empresa->fetchAll();
	    }
	    public function getInternos()//
	    {
	        $empresa = $this->_db->query("SELECT * FROM usuarios ORDER BY usuario ASC");
			return $empresa->fetchAll();
	    }
	    public function getEmpresas()//
	    {
	        $empresa = $this->_db->query("SELECT * FROM marcas ORDER BY cliente ASC");
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
	    public function crearContacto($datosEnviar)//
	    {
	    	$this->insertarSQL($datosEnviar,"contacto_lead");
	    }
	    public function actualizarProspecto($datosEnviar)//
	    {
	        $this->actualizarSQL($datosEnviar,"prospectos");
	    }
	    public function actualizarCalificacion($datosEnviar)//
	    {
	        $this->actualizarSQL($datosEnviar,"calificacion_prospecto");
	    }
	    public function actualizarContacto($datosEnviar)//
	    {
	        $this->actualizarSQL($datosEnviar,"contacto_lead");
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

		public function getEstatus(){
			$estatus = $this->_db->query("SELECT id,estatus,acumulado FROM estatus_ventas ORDER BY posicion ASC");
			return $estatus->fetchAll();
		}

		public function getProspectoEstatus($id)//
		{
	    	$empresa = $this->_db->query("SELECT * FROM prospectos WHERE id_estatus = '$id' ");
			return $empresa->fetchAll();
	    }

	    public function getProspectoEstatusCero()//
		{
	    	$empresa = $this->_db->query("SELECT * FROM prospectos WHERE id_estatus = 0 AND rol_prospecto='lead' ");
			return $empresa->fetchAll();
	    }

	    public function getTotalLeads()//
			{
	    	$empresa = $this->_db->query("SELECT * FROM prospectos WHERE rol_prospecto='lead' ");
				return $empresa->fetchAll();
	    }

			public function actualizarEstatus($datosEnviar){
				$this->actualizarSQL($datosEnviar,"prospectos");
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
