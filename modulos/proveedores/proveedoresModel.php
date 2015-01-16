<?php 
	/**
	* 
	*/
	class proveedoresModel extends Model
	{
		
		function __construct()
		{
			parent::__construct();
		}
		public function getProveedores()
		{
	    	$proveedor = $this->_db->query("SELECT * FROM proveedores ORDER BY proveedor ASC");
			return $proveedor->fetchAll();
	    }
	    public function getProveedor($id)
		{
	    	$proveedor = $this->_db->query("SELECT * FROM proveedores WHERE id_u_proveedor = '$id' ");
			return $proveedor->fetch();
	    }
	    public function getContactosProveedor($id)
		{
	    	$proveedor = $this->_db->query("SELECT * FROM contactos_proveedor WHERE id_u_proveedor = '$id' ");
			return $proveedor->fetchAll();

			//$proveedor = $this->_db->query(
	       	//	"SELECT u.*,r.nombre_pais FROM contactos_proveedor u, paises r " .
	       	//	"WHERE u.pais = r.id_pais AND u.id_u_proveedor = '$id' ORDER BY u.nombre_contacto ASC"
	       	//	);
	      	return $proveedor->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getProveedorContacto($id)
		{
	    	$proveedor = $this->_db->query("SELECT * FROM contactos_proveedor WHERE id_u_contacto_p = '$id' ");
			return $proveedor->fetch();
	    }
	    public function getProveedorProducto($id)
		{
	    	$proveedor = $this->_db->query("SELECT * FROM productos WHERE id_u_producto = '$id' ");
			return $proveedor->fetch();
	    }
	    public function getProductosProveedor($id)
		{
	    	$proveedor = $this->_db->query("SELECT * FROM productos WHERE id_u_proveedor = '$id' ORDER BY nombre_producto");
			return $proveedor->fetchAll();

			//$proveedor = $this->_db->query(
	       	//	"SELECT u.*,r.nombre_medida FROM productos u, unidades_medida r " .
	       	//	"WHERE u.unidad_medida = r.id_unidad_medida AND u.id_u_proveedor = '$id' ORDER BY u.nombre_producto ASC"
	       	//	);
	      	return $proveedor->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getClasiProveedores()
		{
	    	$proveedor = $this->_db->query("SELECT * FROM clasificacion_proveedores ORDER BY nombre_clasificacion ASC");
			return $proveedor->fetchAll();
	    }
	    public function getClasiProveedore($id)
		{
	    	$proveedor = $this->_db->query("SELECT * FROM clasificacion_proveedores WHERE id_clasificacion = '$id' ");
			return $proveedor->fetchAll();
	    }
	    public function getPaises()
	    {
	        $proveedor = $this->_db->query("SELECT * FROM paises ORDER BY nombre_pais ASC");
			return $proveedor->fetchAll();
	    }
	    public function getUnidadesMedida()
	    {
	        $proveedor = $this->_db->query("SELECT * FROM unidades_medida ORDER BY nombre_medida ASC");
			return $proveedor->fetchAll();
	    }
	    public function getCapitulos()
	    {
	        $proveedor = $this->_db->query("SELECT * FROM capitulos");
			return $proveedor->fetchAll();
	    }
	    public function getPartidas($id)
	    {
	        $proveedor = $this->_db->query("SELECT * FROM partidas WHERE codigo_capitulo = '$id' ");
			return $proveedor->fetchAll();
	    }
	    public function getSubPartidas($id)
	    {
	        $proveedor = $this->_db->query("SELECT * FROM subpartidas WHERE codigo_partida = '$id' ");
			return $proveedor->fetchAll();
	    }
	    public function getFracciones($id)
	    {
	        $proveedor = $this->_db->query("SELECT * FROM fracciones_arancelarias WHERE codigo_subpartida = '$id' ");
			return $proveedor->fetchAll();
	    }
	    public function crearProveedor($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"proveedores");
	    }
	    public function crearContactoP($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"contactos_proveedor");
	    }
	    public function crearProductoP($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"productos");
	    }
	    public function crearClasificacionModel($datosEnviar)
	    {
	    	$this->insertarSQL($datosEnviar,"clasificacion_proveedores");
	    }
	    public function actualizarProveedor($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"proveedores");
	    }
	    public function actualizarContactoP($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"contactos_proveedor");
	    }
	     public function actualizarProductoP($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"productos");
	    }
	    public function actualizarClasificacion($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"clasificacion_proveedores");
	    }
	    public function eliminarProveedorModel($id)
	    {
	        $post = $this->_db->query("DELETE FROM proveedores WHERE id_u_proveedor = '$id'");
	    }
	    public function eliminarProveedorTodoContacto($id)
	    {
	        $post = $this->_db->query("DELETE FROM contactos_proveedor WHERE id_u_proveedor = '$id'");
	    }
	    public function eliminarProveedorTodoProducto($id)
	    {
	        $post = $this->_db->query("DELETE FROM productos WHERE id_u_proveedor = '$id'");
	    }
	    public function eliminarContactoPModel($id)
	    {
	        $post = $this->_db->query("DELETE FROM contactos_proveedor WHERE id_u_contacto_p = '$id'");
	    }
	    public function eliminarProductoPModel($id)
	    {
	        $post = $this->_db->query("DELETE FROM productos WHERE id_u_producto = '$id'");
	    }
	     public function eliminarClasificacion($id)
	    {
	        $post = $this->_db->query("DELETE * FROM clasificacion_proveedores WHERE id_clasificacion = '$id'");
	    }
	    public function ultimoProveedor(){
	        $campanas = $this->_db->query("SELECT id_proveedor, proveedor FROM proveedores ORDER BY id_proveedor DESC LIMIT 1");
	        return $campanas->fetch();
	    }
	    public function ultimoContactoP(){
	        $campanas = $this->_db->query("SELECT id_contacto, nombre_contacto FROM contactos_proveedor ORDER BY id_contacto DESC LIMIT 1");
	        return $campanas->fetch();
	    }
	    public function ultimoProductoP(){
	        $campanas = $this->_db->query("SELECT id_producto, nombre_producto FROM productos ORDER BY id_producto DESC LIMIT 1");
	        return $campanas->fetch();
	    }
	    public function ultimoClasificacion(){
	        $campanas = $this->_db->query("SELECT * FROM clasificacion_proveedores ORDER BY id_clasificacion DESC LIMIT 1");
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
	}
 ?>