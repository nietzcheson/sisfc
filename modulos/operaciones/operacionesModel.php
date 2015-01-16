<?php

	class operacionesModel extends Model
	{

		function __construct()
		{
			parent::__construct();
		}

		public function getEmpresas(){
			$empresas = $this->_db->query("SELECT * FROM empresas");
			return $empresas->fetchAll();
		}

		public function getReferencias($id){
			$referencias = $this->_db->query("
			SELECT *
			FROM referencias r LEFT JOIN marcas m
			ON r.cliente = m.id_u_marca
			LEFT JOIN usuarios_sisfc u
			ON r.co = u.id_u_usuario
			LEFT JOIN prospectos p
			ON r.cliente = p.id_u_prospecto
			WHERE id_u_empresa = '$id' ORDER BY id_u_referencia ASC
			");
			return $referencias->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getReferenciasSt($id){
			$referencias = $this->_db->query("
			SELECT *
			FROM referencias r LEFT JOIN marcas m
			ON r.cliente = m.id_u_marca
			LEFT JOIN status st
			ON r.status = st.codigo
			LEFT JOIN usuarios_sisfc u
			ON r.ace = u.id_u_usuario
			WHERE status = '$id' ORDER BY id_u_referencia ASC
			");
			return $referencias->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getDatosOperacion($id){
			$referencia = $this->_db->query("
				/*/// Tablas ///*/
				SELECT
				ref.*,
				em.nombre_empresa,
				tc.tipo,
				mar.nombre_marca,
				contacto.*,
				est.estatus,
				serv.servicio,
				mon.n_espanol

				/*/// Empresas ///*/
				FROM referencias ref LEFT JOIN empresas em
				ON ref.id_u_empresa = em.id_u_empresa

				/*/// Tipos clientes ///*/
				LEFT JOIN tipos_clientes tc
				ON ref.tipo_cliente = tc.id

				/*/// Clientes ///*/
				LEFT JOIN marcas mar
				ON ref.cliente = mar.id_u_marca

				/*/// Contacto Cliente ///*/
				LEFT JOIN prospectos contacto
				ON ref.contacto = contacto.id_u_prospecto

				/*/// Contacto Cliente ///*/
				LEFT JOIN estatus est
				ON ref.status = est.id

				/*/// Servicio ///*/
				LEFT JOIN servicios serv
				ON ref.servicio = serv.id

				/*/// Moneda ///*/
				LEFT JOIN monedas mon
				ON ref.moneda = mon.id_moneda

				WHERE ref.id_u_referencia = '$id'
			");
			return $referencia->fetch(PDO::FETCH_ASSOC);
		}

		public function getReferencia($id){
			$referencias = $this->_db->query("
			SELECT *
			FROM referencias
			WHERE id_u_referencia = '$id'
			");
			return $referencias->fetch();
		}

		public function getMarcas(){
			$marcas = $this->_db->query("
			SELECT *
			FROM marcas ORDER BY nombre_marca ASC
			");
			return $marcas->fetchAll();
		}

		public function getContactosMarcas($id){
			$contactos = $this->_db->query("
			SELECT r.cliente, mc.id_u_cliente, p.nombre_prospecto,apellido_prospecto
			FROM referencias r, marcas_clientes mc, prospectos p
			WHERE r.cliente = mc.id_u_marca
			AND mc.id_u_cliente = p.id_u_prospecto
			AND id_u_referencia = '$id'
			");
			return $contactos->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getStatus(){
			$estatus = $this->_db->query("
			SELECT *
			FROM estatus
			ORDER BY posicion ASC
			");
			return $estatus->fetchAll();
		}

		public function getUsuarios(){
			$contactos = $this->_db->query("
			SELECT *
			FROM usuarios ORDER BY nombre ASC
			");
			return $contactos->fetchAll();
		}

		public function getUsuariosID($id){
			$contactos = $this->_db->query("
			SELECT *
			FROM usuarios
			WHERE id = '$id'
			");
			return $contactos->fetch();
		}

		public function getMonedas(){
			$contactos = $this->_db->query("
			SELECT *
			FROM monedas ORDER BY n_espanol ASC
			");

			return $contactos->fetchAll();
		}

		public function getOrdenes($id){
			$ordenes = $this->_db->query("
			SELECT *
			FROM ordenes_compra oc, proveedores pr
			WHERE oc.id_u_proveedor = pr.id_u_proveedor
			AND id_u_referencia = '$id'
			");

			return $ordenes->fetchAll(PDO::FETCH_ASSOC);
		}
		public function getOrdenesCompra($id){
			$ordenes = $this->_db->query("
			SELECT *
			FROM ordenes_compra oc, proveedores p
			WHERE oc.id_u_orden = '$id'
			AND  oc.id_u_proveedor = p.id_u_proveedor
			");

			return $ordenes->fetch();
		}
		public function actualizarOrdenCompra($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"ordenes_compra");
	    }
	    public function crearProducto($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"ordenes_productos");
	    }
	    public function crearOrden($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"ordenes_compra");
	    }
	    public function eliminarOrdenProducto($id)
	    {
	        $post = $this->_db->query("DELETE FROM `ordenes_productos` WHERE id_orden_producto = '$id'");
	    }
		public function getCotizaciones($id){
			$ordenes = $this->_db->query("
			SELECT *
			FROM cotizaciones
			WHERE id_u_referencia = '$id'
			");

			return $ordenes->fetchAll();
		}

		public function getDatosCotizacion($id){
			$ordenes = $this->_db->query("
			SELECT *
			FROM cotizaciones
			WHERE id_u_cotizacion = '$id'
			");

			return $ordenes->fetch();
		}

		public function getIncoterms(){
			$incoterms = $this->_db->query("
			SELECT *
			FROM incoterms ORDER BY nombre ASC
			");
			return $incoterms->fetchAll();
		}

		public function getTiposEmbalaje(){
			$incoterms = $this->_db->query("
			SELECT *
			FROM tipos_embalaje ORDER BY nombre ASC
			");
			return $incoterms->fetchAll();
		}

		public function getOperaciones(){
			$operacion = $this->_db->query("
			SELECT *
			FROM tipo_operacion ORDER BY nombre ASC
			");

			return $operacion->fetchAll();
		}

		public function getSeccionesAduaneras(){
			$secciones = $this->_db->query("
			SELECT *
			FROM secciones_aduaneras ORDER BY denominacion ASC
			");

			return $secciones->fetchAll();
		}

		public function getMediosTransporte(){
			$transporte = $this->_db->query("
			SELECT *
			FROM medios_transporte ORDER BY medio_t_espanol ASC
			");

			return $transporte->fetchAll();
		}

		public function getOrdenesCotizacion($id){
			$ordenes = $this->_db->query("
			SELECT *
			FROM ordenes_compra oc, proveedores pr
			WHERE oc.id_u_proveedor = pr.id_u_proveedor
			AND id_u_referencia = '$id'
			");

			return $ordenes->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getGastosAduanales(){
			$ordenes = $this->_db->query("
			SELECT *
			FROM gastos_aduanales ORDER BY nombre_es ASC
			");

			return $ordenes->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getGastosCotizacion($id){
			$gastos = $this->_db->query("
			SELECT *
			FROM gastos_cotizaciones WHERE id_u_cotizacion = '$id'
			");

			return $gastos->fetchAll();
		}

		public function getIncrementables(){
			$ordenes = $this->_db->query("
			SELECT *
			FROM incrementables ORDER BY nombre_incrementable ASC
			");

			return $ordenes->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getIncrementablesCotizacion($id){
			$gastos = $this->_db->query("
			SELECT *
			FROM incrementables_cotizacion WHERE id_u_cotizacion = '$id'
			");

			return $gastos->fetchAll();
		}

		public function getImpuestosCotizacion($id){
			$gastos = $this->_db->query("
			SELECT *
			FROM impuestos_cotizacion WHERE id_u_cotizacion = '$id'
			");

			return $gastos->fetch();
		}

		public function getCotizacionesOrdenes($id){
			$gastos = $this->_db->query("
			SELECT id_u_orden
			FROM cotizaciones_ordenes
			WHERE id_u_cotizacion = '$id'
			");
			return $gastos->fetchAll();
		}

		public function getOrdenesProductos($id){
			$gastos = $this->_db->query("
			SELECT *
			FROM ordenes_productos op LEFT JOIN productos p
			ON op.id_u_producto = p.id_u_producto
			LEFT JOIN unidades_medida um
			ON p.id_unidadmedida = um.id
			WHERE op.id_u_orden = '$id'
			ORDER BY id_orden_producto
			");

			return $gastos->fetchAll();
		}

		public function getCxCCotizacion($id){
			$gastos = $this->_db->query("
			SELECT cot.*,con.nombre_concepto
			FROM cxc_cotizacion cot LEFT JOIN conceptos_cxc con
			ON cot.concepto = con.id
			WHERE cot.id_u_cotizacion = '$id'
			");
			return $gastos->fetchAll();
		}

		public function getConceptosCxC(){
			$gastos = $this->_db->query("
			SELECT *
			FROM conceptos_cxc ORDER BY nombre_concepto ASC
			");
			return $gastos->fetchAll();
		}

		public function getRazonesSociales($id){
			$gastos = $this->_db->query("
			SELECT *
			FROM marca_razon_social op LEFT JOIN razones_sociales p
			ON op.id_u_rs = p.id_u_rs
			WHERE op.id_u_marca = '$id'
			");

			return $gastos->fetchAll();
		}

		public function getRazonSocial($id){
			$razon_social = $this->_db->query("
				SELECT *
				FROM razones_sociales
				WHERE id_u_rs = '$id'
			");

			return $razon_social->fetch();
		}

		public function getLogoEmpresas($id){
			$razon_social = $this->_db->query("
				SELECT logo
				FROM empresas
				WHERE id_u_empresa = '$id'
			");

			return $razon_social->fetch();
		}

		public function getProveedores()
		{
	    	$proveedor = $this->_db->query("SELECT * FROM proveedores ORDER BY proveedor ASC");
			return $proveedor->fetchAll();
	    }
	    public function getEmpresa($id)
		{
	    	$empresa = $this->_db->query("SELECT * FROM empresas WHERE id_u_empresa = '$id' ");
			return $empresa->fetch();
	    }
	    public function getContactosProveedor($id)
		{
	    	$proveedor = $this->_db->query("SELECT * FROM contactos_proveedor WHERE id_u_proveedor = '$id' ");
			return $proveedor->fetchAll();
	    }
	    public function getProductosProveedor($id)
		{
	    	$proveedor = $this->_db->query("SELECT * FROM productos WHERE id_u_proveedor = '$id' ORDER BY nombre_producto");
			return $proveedor->fetchAll();
	    }
	    public function ƒ()
		{
	    	$proveedor = $this->_db->query("SELECT * FROM clasificacion_proveedores ORDER BY nombre_clasificacion ASC");
			return $proveedor->fetchAll();
	    }
	    public function getClasiProveedore($id)
		{
	    	$proveedor = $this->_db->query("SELECT * FROM clasificacion_proveedores WHERE id_clasificacion = '$id' ");
			return $proveedor->fetchAll();
	    }
	    public function getPoderNotarial($id)
	    {
	    	$id = (string) $id;
	      	$proveedor = $this->_db->query("SELECT id_poder FROM poder_notarial WHERE id_u_razonsocial = '$id' ");
			return $proveedor->fetch();
	    }
	    public function getPaises()
	    {
	        $proveedor = $this->_db->query("SELECT * FROM paises ORDER BY nombre_pais ASC");
			return $proveedor->fetchAll();
	    }
	    public function crearProveedor($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"proveedores");
	    }
	    public function crearClasificacionModel($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"clasificacion_proveedores");
	    }
	    public function crearRefeerencia($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"referencias");
	    }

	    public function actualizarProveedor($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"proveedores");
	    }
	    public function actualizarEmpresa($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"empresas");
	    }
	    public function actualizarReferencia($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"referencias");
	    }
	    public function actualizarClasificacion($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"clasificacion_proveedores");
	    }
	    public function eliminarProveedorModel($id)
	    {
	        $post = $this->_db->query("DELETE FROM proveedores WHERE id_u_proveedor = '$id'");
	    }
	     public function eliminarClasificacion($id)
	    {
	        $post = $this->_db->query("DELETE * FROM clasificacion_proveedores WHERE id_clasificacion = '$id'");
	    }
	    public function ultimoProveedor(){
	        $campanas = $this->_db->query("SELECT id_proveedor, proveedor FROM proveedores ORDER BY id_proveedor DESC LIMIT 1");
	        return $campanas->fetch();
	    }
	    public function ultimoClasificacion(){
	        $campanas = $this->_db->query("SELECT * FROM clasificacion_proveedores ORDER BY id_clasificacion DESC LIMIT 1");
	        return $campanas->fetchAll();
	    }
	    public function ultimoReferencia(){
	        $campanas = $this->_db->query("SELECT id_referencia FROM referencias ORDER BY id_referencia DESC LIMIT 1");
	        return $campanas->fetchAll();
	    }
	    public function actualizarEmpresaUni($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"empresas");
	    }

	    public function getTipoPersona()
	    {
	    	$proveedor = $this->_db->query("SELECT * FROM tipo_persona ORDER BY tipo_persona ASC");
			return $proveedor->fetchAll();
	    }

	    public function getUsuario_sisfcId($id){

			$usuarios_sisfc = $this->_db->query(
                "SELECT id_u_usuario FROM usuarios_sisfc WHERE id_usuario = $id"
                );

        	return $usuarios_sisfc->fetch();
		}

		public function menu_cotizacion(){

		}
		public function getContactoCliente($id)
		{
			$Cliente = $this->_db->query(
	       		"SELECT u.*,r.* FROM marcas_clientes u, prospectos r " .
	       		"WHERE u.id_u_cliente = r.id_u_prospecto AND u.id_u_marca = '$id'"
	       		);
			return $Cliente->fetchAll();
	    }
	    public function crearCotizacion($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"cotizaciones");
	    }
	    public function ultimoCotizacion(){
	        $campanas = $this->_db->query("SELECT * FROM cotizaciones ORDER BY id_cotizacion DESC LIMIT 1");
	        return $campanas->fetch();
	    }
	    public function actualizarCotizacion($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"cotizaciones");
	    }
	    public function crearCotizacionOrdenes($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"cotizaciones_ordenes");
	    }
	    public function getProductos($id){
			$ordenes = $this->_db->query("
				SELECT cantidad, precio
				FROM ordenes_productos
				WHERE id_u_orden = '$id'
				");
			return $ordenes->fetchAll();
		}
		public function eliminarCoti($id)
	    {
	    	$id = (string) $id;
	        $post = $this->_db->query("DELETE FROM `cotizaciones_ordenes` WHERE `id_u_cotizacion` = '$id'");

	    }
	    public function crearGastosCotizaciones($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"gastos_cotizaciones");
	    }
	    public function eliminarGastosCotizacionesM($id)
	    {
	        $post = $this->_db->query("DELETE FROM gastos_cotizaciones WHERE id_gasto_referencia = '$id'");
	    }
	    public function actualizarGastosCotizacionesM($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"gastos_cotizaciones");
	    }
	    public function crearIncreCotizaciones($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"incrementables_cotizacion");
	    }
	    public function eliminarIncreCotizacionesM($id)
	    {
	        $post = $this->_db->query("DELETE FROM incrementables_cotizacion WHERE id_incrementables_referencia = '$id'");
	    }
	    public function actualizarIncreCotizaciones($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"incrementables_cotizacion");
	    }
	     public function crearImpuestosCotizacion($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"impuestos_cotizacion");
	    }
	    public function actualizarImpuestosCotizacion($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"impuestos_cotizacion");
	    }
	    public function actualizarOrdProdM($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"ordenes_productos");
	    }
	    public function crearCxCCotizacion($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"cxc_cotizacion");
	    }
	    public function eliminarCxCM($id)
	    {
	    	$id = (string) $id;
	        $post = $this->_db->query("DELETE FROM `cxc_cotizacion` WHERE `id` = '$id'");
	    }
	    public function actualizarCxCM($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"cxc_cotizacion");
	    }
	    //// eliminar cotizacion
	    public function eliminarCxCCotizacion($id){
			 $this->_db->query("DELETE FROM `cxc_cotizacion` WHERE `id_u_cotizacion` = '$id'");
		}
		public function eliminarImpuestosCotizacion($id){
			$this->_db->query("DELETE FROM `impuestos_cotizacion` WHERE `id_u_cotizacion` = '$id'");
		}
		public function eliminarGastosCotizacion($id){
			$this->_db->query("DELETE FROM `gastos_cotizaciones` WHERE `id_u_cotizacion` = '$id'");
		}
		public function eliminarIncrementablesCotizacion($id){
			$this->_db->query("DELETE FROM `incrementables_cotizacion` WHERE `id_u_cotizacion` = '$id'");
		}
		public function eliminarCotizacionesCotizacion($id){
			$this->_db->query("DELETE FROM `cotizaciones` WHERE `id_u_cotizacion` = '$id'");
		}
		public function eliminarCotizacionesOrdenesCotizacion($id){
			$this->_db->query("DELETE FROM `cotizaciones_ordenes` WHERE `id_u_cotizacion` = '$id'");
		}
		///eliminar orden
		public function eliminarOrdenesProductosOrdenes($id){
			$this->_db->query("DELETE FROM `ordenes_compra` WHERE `id_u_orden` = '$id'");
		}
		public function eliminarCotizacionesOrdenesOrdenes($id){
			$this->_db->query("DELETE FROM `cotizaciones_ordenes` WHERE `id_u_orden` = '$id'");
		}
		public function eliminarProductosOrdenes($id){
			$this->_db->query("DELETE FROM `ordenes_productos` WHERE `id_u_orden` = '$id'");
		}
		// eliminarReferencia
		public function eliminarRefereciaAll($id){
			$this->_db->query("DELETE FROM `referencias` WHERE `id_u_referencia` = '$id'");
		}

		public function getEmpresasReal(){
			$empresas = $this->_db->query("SELECT * FROM empresas WHERE empresa_real=1");
			return $empresas->fetchAll();
		}

		public function getReferenciasStatus($r,$st){
			$referencias = $this->_db->query("
			SELECT *
			FROM referencias
			WHERE id_u_empresa = '$r'
			AND
            status = '$st'
			");
			return $referencias->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getTiposFacturacion(){
			$tipos = $this->_db->query("SELECT * FROM tipos_facturacion ORDER BY nombre ASC");
			return $tipos->fetchAll();
		}

		public function getReferenciaStatus(){
			$tipos = $this->_db->query("SELECT id_u_empresa,status FROM referencias");
			return $tipos->fetchAll();
		}

		public function getLeads(){
			$leads = $this->_db->query("SELECT * FROM prospectos WHERE rol_prospecto='lead' ORDER BY nombre_prospecto ASC");
			return $leads->fetchAll();
		}

		public function getTiposClientes(){
			$tipos = $this->_db->query("SELECT * FROM tipos_clientes");
			return $tipos->fetchAll();
		}

		public function getServicios(){
			$servicios = $this->_db->query("SELECT * FROM servicios ORDER BY servicio ASC");
			return $servicios->fetchAll();
		}

		public function getEstatus(){
			$estatus = $this->_db->query("SELECT * FROM estatus");
			return $estatus->fetchAll();
		}

		public function actualizarEstatus($datosEnviar){
			$this->actualizarSQL($datosEnviar,"referencias");
		}

		public function getProspectos(){
			$prospectos = $this->_db->query("SELECT * FROM prospectos");
			return $prospectos->fetchAll();
		}

		public function actualizarOrden($datosEnviar){
			$this->actualizarSQL($datosEnviar,"ordenes_productos");
		}

		public function crearReporteFacturacion($datosEnviar){
			$this->insertarSQL($datosEnviar,"reporte_facturacion");
		}

		public function getFacturas($id){

			$reporte = $this->_db->query(
			"SELECT rf.*,tf.nombre, rs.razon_social,email
				FROM reporte_facturacion rf LEFT JOIN tipos_facturacion tf
				ON rf.tipo_facturacion = tf.id
				LEFT JOIN razones_sociales rs
				ON rf.id_razonsocial = rs.id_u_rs
				WHERE rf.id_cotizacion='{$id}'
				AND concepto_facturacion = 1
				ORDER BY id DESC
			");
			return $reporte->fetchAll();
		}

		public function getUsuario($id){
			$usuario = $this->_db->query("SELECT nombre FROM usuarios WHERE id='{$id}'");
			return $usuario->fetch();
		}

		public function getCancelarFactura($datosEnviar)
		{
				$this->actualizarSQL($datosEnviar,"reporte_facturacion");
		}

		public function getFacturasCxC($id){

			$reporte = $this->_db->query(
			"SELECT rf.*,tf.nombre, rs.razon_social,email, cxc.nombre_concepto
				FROM reporte_facturacion rf LEFT JOIN tipos_facturacion tf
				ON rf.tipo_facturacion = tf.id
				LEFT JOIN razones_sociales rs
				ON rf.id_razonsocial = rs.id_u_rs
				LEFT JOIN conceptos_cxc cxc
				ON rf.concepto = cxc.id
				WHERE rf.id_cotizacion='{$id}'
				AND concepto_facturacion = 2
				ORDER BY id DESC
			");
			return $reporte->fetchAll();
		}

		public function getTipoFactura($tipo){
			$tipo = $this->_db->query("SELECT codigo FROM tipos_facturacion WHERE id='{$tipo}'");
			return $tipo->fetch();
		}

	}
 ?>
