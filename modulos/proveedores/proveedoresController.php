<?php
	class proveedoresController extends Controller{
		private $_proveedores;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_proveedores = $this->loadModel('proveedores');
		}

		public function index(){
		    //$this->_acl->acceso('todo');
			$this->_view->assign('titulo','Proveedores');
			$btnHeader = array(

				array(
					"titulo" => "Crear proveedor",
					"enlace" => "proveedores/crear_proveedor"
				),

				array(
					"titulo" => "Clasificación de proveedores",
					"enlace" => "proveedores/clasificacion_proveedores"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_proveedores->getProveedores());
			$this->_view->renderizar('index',"proveedores");
		}

		public function clasificacion_proveedores(){
		    //$this->_acl->acceso('todo');
			$this->_view->assign('titulo','Clasificación proveedores');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "proveedores"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('proveedores'));
			$this->_view->assign("datos",$this->_proveedores->getClasiProveedores());
			$this->_view->renderizar('clasificacion',"proveedores");
		}
		public function crear_clasificacion(){
		    //$this->_acl->acceso('todo');
			if($this->getTexto('clasi')){
				$clasificacion = $this->getSql("clasi");
				if($clasificacion==""){
					exit;
				}
				if(!$clasificacion){
					exit;
				}
				$datosEnviar = array(
					"nombre_clasificacion"=>$clasificacion,
					"fecha_creacion"=>Date("D/M/Y")
					);
				$this->_proveedores->crearClasificacionModel($datosEnviar);
				echo json_encode($this->_proveedores->ultimoClasificacion());
			}else{
				echo json_encode("");
			}
		}
		public function clasificacion_actualizar(){
		    //$this->_acl->acceso('todo');
			$id = (int) $_POST["id"];
			$valor = (string) $_POST["valor"];
			if($this->getInt("id") && $this->getTexto("valor")){
				$datosEnviar = array(
					"id_clasificacion"=>$id,
					"nombre_clasificacion"=>$valor
					);
				$this->_proveedores->actualizarClasificacion($datosEnviar);
			}
		}
		public function clasificacion_eliminar(){
		    //$this->_acl->acceso('todo');
			$id = (int) $_POST["id"];
			if($this->getInt("id")){
				$this->_proveedores->eliminarClasificacion($id);
			}
		}
		public function eliminarProveedor()
		{
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_proveedores->eliminarProveedorTodoContacto($id);
				$this->_proveedores->eliminarProveedorTodoProducto($id);
				$this->_proveedores->eliminarProveedorModel($id);
			}
		}
		public function eliminarContactoP()
		{
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_proveedores->eliminarContactoPModel($id);
			}
		}
		public function eliminarProductoP()
		{
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_proveedores->eliminarProductoPModel($id);
			}
		}
		public function perfil_proveedor($id=false,$activo=1){
		    //$this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('proveedores');
				exit();
			}
			$this->_view->assign('titulo','Perfil proveedor');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "proveedores"
				)
			);
			$this->_view->assign("proveedor",$id);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("activo",$activo);
			$this->_view->setJs(array('contactos'));
			if ($this->getInt('actualizar1')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$clasificacion= $this->getInt("clasificacion");
				$tipo_persona= $this->getInt("tipo_persona");
				$pais = $this->getInt("pais");
				$proveedor = $this->getSql("proveedor");
				$razon_social= $this->getSql("razon_social");
				$direccion= $this->getSql("direccion");
				$telefono= $this->getSql("telefono");
				$rfc_tax= $this->getSql("rfc_tax");
				$domicilio_fiscal= $this->getSql("domicilio_fiscal");
				$datos_bancarios= $this->getSql("datos_bancarios");
				$errores="";
				if (!$clasificacion) {
					$errores="Seleccione la clasificacion del proveedor";
				}
				if (!$tipo_persona) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el tipo de persona";
				}
				if (!$tipo_persona) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el tipo de persona";
				}
				if (!$pais) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el pais";
				}
				if ($proveedor=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el proveedor";
				}
				if ($razon_social=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la razon social";
				}
				if ($direccion=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la direccion";
				}
				if ($telefono=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el telefono";
				}
				if ($rfc_tax=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el RFC o Taxi";
				}
				if ($domicilio_fiscal=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el domicilio fiscal";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_proveedor',"proveedores");
					exit;
				}

				$datosEnviar = array(
					"id_u_proveedor"=>$id,
					"clasificacion"=>$clasificacion ,
					"tipo_persona"=>$tipo_persona ,
					"pais"=>$pais ,
					"proveedor"=>$proveedor ,
					"razon_social"=>$razon_social ,
					"direccion"=>$direccion ,
					"telefono"=>$telefono ,
					"rfc_tax"=>$rfc_tax ,
					"domicilio_fiscal"=>$domicilio_fiscal ,
					"datos_bancarios"=>$datos_bancarios,
					"ultima_actualizacion"=>Date("D/M/Y")
				);
				$this->_proveedores->actualizarProveedor($datosEnviar);
				$this->_view->assign("_mensaje","Informacion general del proveedor actualizados");
			}
			$this->_view->assign("identifica",$id);
			$this->_view->assign("datos",$this->_proveedores->getProveedor($id));
			$this->_view->assign("datos2",$this->_proveedores->getContactosProveedor($id));

			$this->_view->assign("datos3",$this->_proveedores->getProductosProveedor($id));
			$this->_view->assign("clasis",$this->_proveedores->getClasiProveedores());
			$this->_view->assign("tipos",$this->_proveedores->getTipoPersona());
			$this->_view->assign("paises",$this->_proveedores->getPaises());
			$this->_view->renderizar('perfil_proveedor',"proveedores");
		}

		public function crear_proveedor(){
		    //$this->_acl->acceso('todo');
			$this->_view->assign('titulo','Crear proveedor');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "proveedores"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("clasis",$this->_proveedores->getClasiProveedores());
			$this->_view->assign("tipos",$this->_proveedores->getTipoPersona());
			$this->_view->assign("paises",$this->_proveedores->getPaises());
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$clasificacion= $this->getInt("clasificacion");
				$tipo_persona= $this->getInt("tipo_persona");
				$pais = $this->getInt("pais");
				$proveedor = $this->getSql("proveedor");
				$razon_social= $this->getSql("razon_social");
				$direccion= $this->getSql("direccion");
				$telefono= $this->getSql("telefono");
				$rfc_tax= $this->getSql("rfc_tax");
				$domicilio_fiscal= $this->getSql("domicilio_fiscal");
				$datos_bancarios= $this->getSql("datos_bancarios");
				$errores="";
				if (!$clasificacion) {
					$errores="Seleccione la clasificacion del proveedor";
				}
				if (!$tipo_persona) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el tipo de persona";
				}
				if (!$tipo_persona) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el tipo de persona";
				}
				if (!$pais) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el pais";
				}
				if ($proveedor=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el proveedor";
				}
				if ($razon_social=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la razon social";
				}
				if ($direccion=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la direccion";
				}
				if ($telefono=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el telefono";
				}
				if ($rfc_tax=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el RFC o Taxi";
				}
				if ($domicilio_fiscal=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el domicilio fiscal";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_proveedor',"proveedores");
					exit;
				}
				$datosEnviar = array(
					"id_u_proveedor"=>"dummy",
					"clasificacion"=>$clasificacion ,
					"tipo_persona"=>$tipo_persona ,
					"pais"=>$pais ,
					"proveedor"=>$proveedor ,
					"razon_social"=>$razon_social ,
					"direccion"=>$direccion ,
					"telefono"=>$telefono ,
					"rfc_tax"=>$rfc_tax ,
					"domicilio_fiscal"=>$domicilio_fiscal ,
					"datos_bancarios"=>$datos_bancarios
				);
				$this->_proveedores->crearProveedor($datosEnviar);
				$id = $this->_proveedores->ultimoProveedor();
				$datosEnviar = array(
						"id_proveedor"=>$id["id_proveedor"],
						"id_u_proveedor"=>strtoupper(substr($id["proveedor"],0,2)).$id["id_proveedor"]
					);

				$this->_proveedores->actualizarProveedor($datosEnviar);
				$this->redireccionar('proveedores');
				exit;
			}

			$this->_view->renderizar('crear_proveedor',"proveedores");
		}

		public function perfil_contacto($prov,$id=false)
		{
		    //$this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('proveedores');
				exit();
			}
			$this->_view->assign('titulo','Contacto del proveedor');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "proveedores/perfil_proveedor" . DS . $prov
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("paises",$this->_proveedores->getPaises());
			$datos=$this->_proveedores->getProveedorContacto($id);
			$this->_view->assign("regreso",$datos["id_u_proveedor"]);
			if ($this->getInt('crear')=="1")
			{
				$nombre_contacto = $this->getSql("nombre_contacto");
				$apellido_contacto= $this->getSql("apellido_contacto");
				$telefono= $this->getSql("telefono");
				$celular= $this->getSql("celular");
				$email= $this->getSql("email");
				$pais= $this->getInt("pais");
				$estado= $this->getSql("estado");
				$ciudad= $this->getSql("ciudad");
				$errores="";

				if ($nombre_contacto=="") {
					$errores="Ingrese el nombre del contacto";
				}
				if ($apellido_contacto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el apellido del contacto";
				}
				if ($telefono=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el telefono del contacto";
				}
				if ($telefono=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el telefono del contacto";
				}
				if ($celular=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el celular del contacto";
				}
				if ($email=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el email del contacto";
				}
				if (!$this->validarEmail($email)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="El email es invalido";
				}
				if (!$pais) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el pais";
				}
				if ($estado=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el estado del contacto";
				}
				if ($ciudad=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la ciudad del contacto";
				}
				if ($errores!="") {
					$errores = "Los siguientes son campos obligatorios:<br>".$errores;
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_contacto',"proveedores");
					exit;
				}
				$datosEnviar = array(
					"id_u_contacto_p"=>$id,
					"nombre_contacto"=>$nombre_contacto,
					"apellido_contacto"=>$apellido_contacto,
					"telefono"=>$telefono,
					"celular"=>$celular,
					"email"=>$email,
					"pais"=>$pais,
					"estado"=>$estado,
					"ciudad"=>$ciudad
				);
				$this->_proveedores->actualizarContactoP($datosEnviar);
				$this->_view->assign("_mensaje","El contacto ha sido actualizado");
				$datos=$this->_proveedores->getProveedorContacto($id);
			}
			$this->_view->assign("datos",$datos);
			$this->_view->renderizar('perfil_contacto',"proveedores");
		}

		public function crear_contacto($id=false)
		{
		    //$this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('proveedores');
				exit();
			}
			$this->_view->assign('titulo','Crear contacto');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "proveedores/perfil_proveedor" . DS . $id
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);

			$this->_view->assign("identifica",$id);
			$this->_view->assign("paises",$this->_proveedores->getPaises());
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$nombre_contacto = $this->getSql("nombre_contacto");
				$apellido_contacto= $this->getSql("apellido_contacto");
				$telefono= $this->getSql("telefono");
				$celular= $this->getSql("celular");
				$email= $this->getSql("email");
				$pais= $this->getInt("pais");
				$estado= $this->getSql("estado");
				$ciudad= $this->getSql("ciudad");
				$errores="";
				if ($nombre_contacto=="") {
					$errores="Ingrese el nombre del contacto";
				}
				if ($apellido_contacto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el apellido del contacto";
				}
				if ($telefono=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el telefono del contacto";
				}
				if ($telefono=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el telefono del contacto";
				}
				if ($celular=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el celular del contacto";
				}
				if ($email=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el email del contacto";
				}
				if (!$this->validarEmail($email)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="El email es invalido";
				}
				if (!$pais) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el pais";
				}
				if ($estado=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el estado del contacto";
				}
				if ($ciudad=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la ciudad del contacto";
				}
				if ($errores!="") {
					$errores = "Los siguientes son campos obligatorios:<br>".$errores;
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_contacto');
					exit;
				}
				$datosEnviar = array(
					"id_u_contacto_p"=>"dummy",
					"id_u_proveedor"=>$id,
					"nombre_contacto"=>$nombre_contacto,
					"apellido_contacto"=>$apellido_contacto,
					"telefono"=>$telefono,
					"celular"=>$celular,
					"email"=>$email,
					"pais"=>$pais,
					"estado"=>$estado,
					"ciudad"=>$ciudad
				);
				$this->_proveedores->crearContactoP($datosEnviar);
				$id = $this->_proveedores->ultimoContactoP();
				$datosEnviar = array(
						"id_contacto"=>$id["id_contacto"],
						"id_u_contacto_p"=>strtoupper(substr($id["nombre_contacto"],0,2)).$id["id_contacto"]
					);
				$this->_proveedores->actualizarContactoP($datosEnviar);
				$this->_view->assign("datos","");
				$this->_view->assign("_mensaje","El contacto ha sido creado");
			}
			$this->_view->renderizar('crear_contacto');
		}

		public function perfil_producto($prov,$id=false)
		{
			if(!$id){
				$this->redireccionar('proveedores');
				exit();
			}
			$this->_view->assign('titulo','Perfil producto');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "proveedores/perfil_proveedor" . DS . $prov
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);

			$datos=$this->_proveedores->getProveedorProducto($id);
			$this->_view->assign("regreso",$datos["id_u_proveedor"]);

			$this->_view->setJs(array('crearProducto'));
			$this->_view->assign('titulo','Crear producto');
			$this->_view->assign("identifica",$id);
			$this->_view->assign("paises",$this->_proveedores->getPaises());
			$this->_view->assign("capitulos",$this->_proveedores->getCapitulos());
			$this->_view->assign("medidas",$this->_proveedores->getUnidadesMedida());
			$tipo_fraccion=$datos["tipo_fraccion"];
			$this->_view->assign("fraccion",$datos["tipo_fraccion"]);

			$this->_view->assign("partidas",$this->_proveedores->getPartidas($datos["capitulo"]));
			$this->_view->assign("subpartidas",$this->_proveedores->getSubPartidas($datos["partida"]));
			$this->_view->assign("fracciones",$this->_proveedores->getFracciones($datos["subpartida"]));
			if ($this->getInt('crear')=="1")
			{
				$codigo_producto = $this->getSql("codigo_producto");
				$nombre_producto= $this->getSql("nombre_producto");
				$descripcion_producto= $this->getSql("descripcion_producto");
				$unidad_medida= $this->getInt("unidad_medida");
				$pais_origen=0;
				if (isset($_POST["pais_origen"])) {
					$pais_origen= $this->getInt("pais_origen");
				}
				$tipo_fraccion=$_POST["options"];
				// if (isset($_POST["options1"])) {
				// 	$tipo_fraccion="sugerida";
				// }elseif (isset($_POST["options2"])) {
				// 	$tipo_fraccion="confirmada";
				// }
				$this->_view->assign("fraccion",$tipo_fraccion);
				$capitulo= $this->getSql("capitulo");
				$partida= $this->getSql("partida");
				$subpartida= $this->getSql("subpartida");
				$fraccion= $this->getSql("fraccion");

				$errores="";
				if ($codigo_producto=="") {
					$errores="Ingrese el codigo del producto";
				}
				if ($nombre_producto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el nombre del producto";
				}
				if ($descripcion_producto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la descripcion del producto";
				}
				if (!$unidad_medida) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione la unidad de medida";
				}
				if (!$pais_origen) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el pais de origen del producto";
				}
				if ($tipo_fraccion=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el tipo de fraccion";
				}

				if ($capitulo=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el capitulo";
				}else{
					$this->_view->assign("partidas",$this->_proveedores->getPartidas($capitulo));
				}
				if ($partida=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione la partida";
				}else{
					$this->_view->assign("subpartidas",$this->_proveedores->getSubPartidas($partida));
				}
				if ($subpartida=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione la subpartida";
				}else{
					$this->_view->assign("fracciones",$this->_proveedores->getFracciones($subpartida));
				}

				if ($fraccion=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione la fraccion";
				}


				if ($errores!="") {
					$errores = "Los siguientes son campos obligatorios:<br>".$errores;
					$this->_view->assign("_error",$errores);
					$this->_view->assign("datos",$datos);
					$this->_view->renderizar('perfil_producto');
					exit;
				}

				$datosEnviar = array(
						"id_u_producto"=>$id,
						"codigo_producto"=>$codigo_producto,
						"nombre_producto"=>$nombre_producto,
						"descripcion_producto"=>$descripcion_producto,
						"id_unidadmedida"=>$unidad_medida,
						"pais_origen"=>$pais_origen,
						"tipo_fraccion"=>$tipo_fraccion,
						"capitulo"=>$capitulo,
						"partida"=>$partida,
						"subpartida"=>$subpartida,
						"fraccion"=>$fraccion
					);
				$this->_proveedores->actualizarProductoP($datosEnviar);
				$this->_view->assign("_mensaje","El producto ha sido actualizado");
				$datos=$this->_proveedores->getProveedorProducto($id);
			}
			$this->_view->assign("datos",$datos);
			$this->_view->renderizar('perfil_producto');
		}

		public function crear_producto($id=false)
		{
		    //$this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('proveedores');
				exit();
			}
			$this->_view->setJs(array('crearProducto'));
			$this->_view->assign('titulo','Crear producto');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "proveedores/perfil_proveedor" . DS . $id
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("fraccion","");
			$this->_view->assign("identifica",$id);
			$this->_view->assign("paises",$this->_proveedores->getPaises());
			$this->_view->assign("capitulos",$this->_proveedores->getCapitulos());
			$this->_view->assign("medidas",$this->_proveedores->getUnidadesMedida());
			if ($this->getInt('crear')=="1")
			{
				$tipo_fraccion="";
				if (isset($_POST["options"])) {
					$tipo_fraccion=$_POST["options"];
				}
				$this->_view->assign("datos",$_POST);
				$codigo_producto = $this->getSql("codigo_producto");
				$nombre_producto= $this->getSql("nombre_producto");
				$descripcion_producto= $this->getSql("descripcion_producto");
				$unidad_medida= $this->getInt("unidad_medida");
				$pais_origen=0;
				if (isset($_POST["pais_origen"])) {
					$pais_origen= $this->getInt("pais_origen");
				}

				$this->_view->assign("fraccion",$tipo_fraccion);
				$capitulo= $this->getSql("capitulo");
				$partida= $this->getSql("partida");
				$subpartida= $this->getSql("subpartida");
				$fraccion= $this->getSql("fraccion");

				$errores="";
				if ($codigo_producto=="") {
					$errores="Ingrese el codigo del producto";
				}
				if ($nombre_producto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el nombre del producto";
				}
				if ($descripcion_producto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la descripcion del producto";
				}
				if (!$unidad_medida) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione la unidad de medida";
				}
				if (!$pais_origen) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el pais de origen del producto";
				}
				if ($tipo_fraccion=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el tipo de fraccion";
				}

				if ($capitulo=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el capitulo";
				}else{
					$this->_view->assign("partidas",$this->_proveedores->getPartidas($capitulo));
				}
				if ($partida=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione la partida";
				}else{
					$this->_view->assign("subpartidas",$this->_proveedores->getSubPartidas($partida));
				}
				if ($subpartida=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione la subpartida";
				}else{
					$this->_view->assign("fracciones",$this->_proveedores->getFracciones($subpartida));
				}
				if ($fraccion=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione la fraccion";
				}
				if ($errores!="") {
					$errores = "Los siguientes son campos obligatorios:<br>".$errores;
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_producto');
					exit;
				}
				$datosEnviar = array(
						"id_u_producto"=>"dummy",
						"id_u_proveedor"=>$id,
						"codigo_producto"=>$codigo_producto,
						"nombre_producto"=>$nombre_producto,
						"descripcion_producto"=>$descripcion_producto,
						"id_unidadmedida"=>$unidad_medida,
						"pais_origen"=>$pais_origen,
						"tipo_fraccion"=>$tipo_fraccion,
						"capitulo"=>$capitulo,
						"partida"=>$partida,
						"subpartida"=>$subpartida,
						"fraccion"=>$fraccion
					);
				$this->_proveedores->crearProductoP($datosEnviar);
				$id = $this->_proveedores->ultimoProductoP();
				$datosEnviar = array(
					"id_producto"=>$id["id_producto"],
					"id_u_producto"=>strtoupper(substr($id["nombre_producto"],0,2)).$id["id_producto"]
				);
				$this->_proveedores->actualizarProductoP($datosEnviar);
				$this->_view->assign("datos","");
				$this->_view->assign("_mensaje","El producto ha sido creado");
			}
			$this->_view->renderizar('crear_producto');
		}
		public function getPartidas()
		{
			$id=$this->getTexto("capitulo");
			if($id!=""){
				echo json_encode($this->_proveedores->getPartidas($id));
			}
		}
		public function getSubPartidas()
		{
			$id=$this->getTexto("partida");
			if($id!=""){
				echo json_encode($this->_proveedores->getSubPartidas($id));
			}
		}
		public function getFracciones()
		{
			$id=$this->getTexto("subpartida");
			if($id!=""){
				echo json_encode($this->_proveedores->getFracciones($id));
			}
		}
	}
?>
