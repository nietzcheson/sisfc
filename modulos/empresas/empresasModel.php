<?php
	/**
	*
	*/
	class empresasModel extends Model
	{

		function __construct()
		{
			parent::__construct();
		}
		public function getEmpresas()
		{
	    	$empresa = $this->_db->query("SELECT * FROM empresas ORDER BY nombre_empresa ASC");
			return $empresa->fetchAll();
	    }

	    public function getEmpresa($id)
	    {
	      	$empresa = $this->_db->query("SELECT * FROM empresas WHERE id_u_empresa = '$id' ");
			return $empresa->fetch();
	    }
	    public function getPoderNotarial($id)
	    {
	    	$id = (string) $id;
	      	$empresa = $this->_db->query("SELECT id_poder FROM poder_notarial WHERE id_u_razonsocial = '$id' ");
			return $empresa->fetch();
	    }
	    public function getPaises()
	    {
	        $empresa = $this->_db->query("SELECT * FROM paises ORDER BY nombre_pais ASC");
			return $empresa->fetchAll();
	    }
	    public function crearEmpresa($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"empresas");
	    }
	    public function actualizarEmpresa($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"empresas");
	    }
	    public function actualizarPoderNotarial($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"poder_notarial");
	    }
	    public function eliminarEmpresaModel($id)
	    {
	        $post = $this->_db->query("DELETE FROM empresas WHERE id_u_empresa = '$id'");
	    }
	    public function ultimoEmpresa(){
	        $campanas = $this->_db->query("SELECT id_empresa, nombre_empresa FROM empresas ORDER BY id_empresa DESC LIMIT 1");
	        return $campanas->fetch();
	    }

	    public function actualizarEmpresaUni($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"empresas");
	    }

	    public function getTipoPersona()
	    {
	    	$empresa = $this->_db->query("SELECT * FROM tipo_persona ORDER BY tipo_persona ASC");
			return $empresa->fetchAll();
	    }
	    public function getUsuario_sisfcId($id){

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
			LEFT JOIN estatus st
			ON r.status = st.id
			LEFT JOIN usuarios_sisfc u
			ON r.ecl = u.id_u_usuario
			WHERE id_u_empresa = '$id'
			");

			return $referencias->fetchAll(PDO::FETCH_ASSOC);
		}
	}
 ?>
