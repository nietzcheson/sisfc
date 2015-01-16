<?php

	class clientesModel extends Model{

		function __construct()
		{
			parent::__construct();
		}
		public function getClientes() //
		{
	    	$Cliente = $this->_db->query("SELECT * FROM marcas ORDER BY nombre_marca ASC");
			return $Cliente->fetchAll();
	    }
	    public function getLeads() //
		{
	    	$Cliente = $this->_db->query("SELECT * FROM prospectos WHERE rol_prospecto = 'lead' ORDER BY nombre_prospecto ASC");
			return $Cliente->fetchAll();
	    }
	    public function getMarca($id)
		{
	    	$Cliente = $this->_db->query("SELECT * FROM marcas WHERE id_u_marca = '$id' ");
			return $Cliente->fetch();
	    }
	    public function getMarcaCliente($id)
		{
			$Cliente = $this->_db->query(
	       		"SELECT u.*,r.* FROM marcas_clientes u, prospectos r " .
	       		"WHERE u.id_u_cliente = r.id_u_prospecto AND u.id_u_marca = '$id'"
	       		);
			return $Cliente->fetchAll();
	    }

	    public function getMarcaRazones($id){
			$Cliente = $this->_db->query(
	       		"SELECT mrs.*,rs.* FROM marca_razon_social mrs, razones_sociales rs WHERE mrs.id_u_rs = rs.id_u_rs AND id_u_marca = '$id'"
	       		);
			//$Cliente = $this->_db->query("SELECT * FROM marca_razon_social");
			return $Cliente->fetchAll();
	    }


	    public function getFileFiscal($id)
		{
	    	$Cliente = $this->_db->query("SELECT * FROM file_fiscal WHERE id_u_razonsocial = '$id' ");
			return $Cliente->fetch();
	    }
	    public function getPorderNotarial($id)
		{
	    	$Cliente = $this->_db->query("SELECT * FROM poder_notarial WHERE id_u_razonsocial = '$id' ");
			return $Cliente->fetch();
	    }
	    public function getActaConst($id)
		{
	    	$Cliente = $this->_db->query("SELECT * FROM acta_constitutiva WHERE id_u_razonsocial = '$id' ");
			return $Cliente->fetch();
	    }
	    public function getProductosCliente($id)
		{
	    	$Cliente = $this->_db->query("SELECT * FROM productos WHERE id_u_Cliente = '$id' ");
			return $Cliente->fetchAll();
	    }
	    public function getProspecto($id)//
		{
	    	$empresa = $this->_db->query("SELECT * FROM prospectos WHERE id_u_prospecto = '$id'");
			return $empresa->fetch();
	    }
	    public function getRazonSocial($id)//
		{
	    	$empresa = $this->_db->query("SELECT * FROM razones_sociales WHERE id_u_rs = '$id'");
			return $empresa->fetch();
	    }
	    public function getClasiCliente($id)
		{
	    	$Cliente = $this->_db->query("SELECT * FROM clasificacion_Clientees WHERE id_clasificacion = '$id' ");
			return $Cliente->fetchAll();
	    }
	    public function getPoderNotarial($id)
	    {
	    	$id = (string) $id;
	      	$Cliente = $this->_db->query("SELECT * FROM poder_notarial WHERE id_u_razonsocial = '$id' ");
			return $Cliente->fetch();
	    }
	    public function getPaises()
	    {
	        $Cliente = $this->_db->query("SELECT * FROM paises ORDER BY nombre_pais ASC");
			return $Cliente->fetchAll();
	    }
	    public function crearMarca($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"marcas");
	    }
	    public function crearMarcaClientes($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"marcas_clientes");
	    }
	    public function crearRazonesSociales($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"razones_sociales");
	    }
	    public function crearProspectoC($datosEnviar)//
	    {
	    	$this->insertarSQL($datosEnviar,"prospectos");
	    }
	    public function crearClasificacionModel($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"clasificacion_Clientees");
	    }
	    public function crearFilefiscal($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"file_fiscal");
	    }
	    public function crearPoderNotarial($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"poder_notarial");
	    }
	    public function crearActaConstitu($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"acta_constitutiva");
	    }
	    public function actualizarMarca($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"marcas");
	    }
	    public function actualizarRazonS($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"razones_sociales");
	    }
	    public function crearMarcaRazones($datosEnviar)
	    {
	        $this->insertarSQL($datosEnviar,"marca_razon_social");
	    }
	    public function actualizarProspecto($datosEnviar)//
	    {
	        $this->actualizarSQL($datosEnviar,"prospectos");
	    }
	    public function actualizarFileFiscal($datosEnviar)//
	    {
	        $this->actualizarSQL($datosEnviar,"file_fiscal");
	    }
	    public function actualizarPoderNotarial($datosEnviar)//
	    {
	        $this->actualizarSQL($datosEnviar,"poder_notarial");
	    }
	    public function actualizarActaConstitu($datosEnviar)//
	    {
	        $this->actualizarSQL($datosEnviar,"acta_constitutiva");
	    }
	    public function actualizarClasificacion($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"clasificacion_Clientees");
	    }
	    public function eliminarMarca($id)
	    {
	        $post = $this->_db->query("DELETE FROM marcas WHERE id_u_marca = '$id'");
	    }
	    public function eliminarMarcaClientes($id)
	    {
	        $post = $this->_db->query("DELETE FROM marcas_clientes WHERE id_u_marca = '$id'");
	    }
	    public function eliminarMarcasClientes($id,$marca)
	    {
	        $post = $this->_db->query("DELETE FROM marcas_clientes WHERE id_u_marca = '$marca' AND id_u_cliente = '$id'");
	    }
	    public function eliminarMarcasRazones($id,$marca)
	    {
	        $post = $this->_db->query("DELETE FROM marca_razon_social WHERE id_u_marca = '$marca' AND id_u_rs = '$id'");
	    }
	    public function eliminarMarcaSociales($id)
	    {
	        $post = $this->_db->query("DELETE FROM razones_sociales WHERE id_u_marca = '$id'");
	    }
	     public function eliminarClasificacion($id)
	    {
	        $post = $this->_db->query("DELETE * FROM clasificacion_Clientees WHERE id_clasificacion = '$id'");
	    }
	    public function ultimoMarca(){
	        $campanas = $this->_db->query("SELECT id_marca, nombre_marca FROM marcas ORDER BY id_marca DESC LIMIT 1");
	        return $campanas->fetch();
	    }
	    public function ultimoProspecto(){//
	        $campanas = $this->_db->query("SELECT id_prospecto, nombre_prospecto FROM prospectos ORDER BY id_prospecto DESC LIMIT 1");
	        return $campanas->fetch();
	    }
	    public function ultimoRazonS(){
	        $campanas = $this->_db->query("SELECT id_razon_s, razon_social FROM razones_sociales ORDER BY id_razon_s DESC LIMIT 1");
	        return $campanas->fetch();
	    }
	    public function ultimoClasificacion(){
	        $campanas = $this->_db->query("SELECT * FROM clasificacion_Clientees ORDER BY id_clasificacion DESC LIMIT 1");
	        return $campanas->fetchAll();
	    }
	    public function actualizarEmpresaUni($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"empresas");
	    }

	    public function getTipoPersona()
	    {
	    	$Cliente = $this->_db->query("SELECT * FROM tipo_persona ORDER BY tipo_persona ASC");
			return $Cliente->fetchAll();
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
			ON r.eta = u.id_u_usuario
			WHERE cliente = '$id'
			");

			return $referencias->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getOperaciones($cliente){
			$operaciones = $this->_db->query("SELECT id_u_referencia FROM referencias WHERE cliente='$cliente'");
			return $operaciones->fetch();
		}

		public function actualizarOperaciones($marca,$lead){
			$actualizar = $this->_db->query("UPDATE referencias SET cliente='$marca',tipo_cliente='1' WHERE cliente='$lead'");
		}

		public function getEstadosDeCuenta($id){
			$estados = $this->_db->query("
			SELECT r.moneda,tc_pd,tc_pe, cot.id_u_referencia,id_u_cotizacion, m.*
			FROM referencias r LEFT JOIN cotizaciones cot
			ON r.id_u_referencia = cot.id_u_referencia
			LEFT JOIN monedas m
			ON r.moneda = m.id_moneda
			WHERE r.cliente='{$id}'
			AND cot.estado = 1
			");
			return $estados->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getCxCCotizacion($id){
			$cxc = $this->_db->query("
			SELECT * FROM cxc_cotizacion WHERE id_u_cotizacion='{$id}'
			");

			return $cxc->fetchAll();
		}
	}
 ?>
