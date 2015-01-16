<?php
	class operacionesController extends Controller{
		private $_operaciones;
		private $_menu;
		private $_pdf;
		private $_wsCliente; //WebServices
		private $_wsError;
		private $_wsFault;

		private $datosOperacion;

		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_operaciones = $this->loadModel('operaciones');
			$this->getLibrary('pdfdom/dompdf_config.inc');
			$this->_pdf = new DOMPDF();
			$this->getLibrary('nuSoap/nusoap');
			$this->_wsCliente = new nusoap_client(WS,true);
			$this->_wsError = $this->_wsCliente->getError();
			$this->_wsFault = $this->_wsCliente->fault;
		}

		public function menu_cotizacion(){
		  $this->_acl->acceso('todo');
			$this->_menu = "El menú";
			return $this->_menu;
		}

		public function index($id = false){
		  $this->_acl->acceso('todo');

			$this->_view->assign('panel_operaciones', $this->_view->widget('operaciones', 'getOperaciones',array($id)));

			$this->_view->assign('titulo','Operaciones');
			//$this->_view->assign("widgetOperaciones",$this->_view->widget("operaciones","getOperaciones"));
			$this->_view->assign("estatus",$this->_operaciones->getEstatus());
			$btnHeader = array(

				array(
					"titulo" => "Crear referencia",
					"enlace" => "operaciones/crear_referencia"
				),
				array(
					"titulo" => "Embudo de operaciones",
					"enlace" => "operaciones/embudo"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$datos = $this->_operaciones->getEmpresas();
			if($id == false){
				$id = $datos[0]['id_u_empresa'];
			}
			//$this->_view->setJs(array('index'));
			$signo_mone=array(
				"1"=>"Pesos",
				"2"=>"Dolar",
				"3"=>"Euro");

			$this->_view->assign("monedas",$this->_operaciones->getMonedas());
			$this->_view->assign("signo_mone",$signo_mone);
			$this->_view->setJs(array('filtrar'));
			$this->_view->assign("identifica",$id);
			$this->_view->assign("datos",$datos);
			$this->_view->assign("datos2",$this->_operaciones->getReferencias($id));
			$this->_view->renderizar('index',"operaciones");
		}

		public function perfil_referencia($id,$activo=1){
		    $this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('operaciones');
				exit();
			}
			$this->_view->setJs(array('ajax'));
			$this->_view->assign("referencia",$id);
			$this->_view->assign('titulo','Perfil Referencia | '.$id);
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "operaciones"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("empresas",$this->_operaciones->getEmpresas());
			$this->_view->assign("marcas",$this->_operaciones->getMarcas());
			$this->_view->assign("leads",$this->_operaciones->getLeads());
			$this->_view->assign("status",$this->_operaciones->getStatus());
			$this->_view->assign("usuarios",$this->_operaciones->getUsuarios());
			$this->_view->assign("monedas",$this->_operaciones->getMonedas());
			$datos= $this->_operaciones->getReferencia($id);
			$this->_view->assign("datos",$datos);
			$this->_view->assign("activo",$activo);
			$this->_view->assign("contactos",$this->_operaciones->getContactoCliente($datos["cliente"]));
			$this->_view->assign("cotizaciones",$this->_operaciones->getCotizaciones($id));
			$this->_view->assign("ordenes",$this->_operaciones->getOrdenesCotizacion($id));
            $analis=$this->_operaciones->getCotizaciones($id);
            $ina=0;
            $this->_view->assign("tipos_clientes",$this->_operaciones->getTiposClientes());
            $this->_view->assign("servicios",$this->_operaciones->getServicios());

            foreach($analis as $ana){
                if($ana["estado"]==1){
                    $ina=1;
                }
            }
            $this->_view->assign("enab",$ina);
			if ($this->getInt('crear1')=="1")
			{
				$tipo_cliente = $this->getSql("tipo_cliente");
				$cliente = $this->getSql("cliente");

				if($tipo_cliente==1){
					$contacto = $this->getSql("contacto");
				}else{
					$contacto = $cliente;
				}

				$id_catstatus = $this->getSql("id_catstatus");
				$servicio = $this->getSql("servicio");
				$co = $this->getSql("co");
				$ecl = $this->getSql("ecl");
				$eta = $this->getSql("eta");
				$moneda = $this->getSql("moneda");
				$tc_pd = $this->getSql("tc_pd");
				$tc_pe = $this->getSql("tc_pe");
				$observaciones = $this->getSql("observaciones");

				$errores="";
				if ($cliente=="Seleccione") {
					$errores.="Seleccione el cliente";
				}
				if ($contacto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el contacto";
				}
				if ($id_catstatus=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el status";
				}
				if ($servicio=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el servicio";
				}
				if ($co=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el CO";
				}
				if ($ecl=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el ECL";
				}
				if ($eta=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el ETA";
				}

				if ($moneda=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione la moneda";
				}
				if ($tc_pd=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese TC Peso/Dll";
				}
				if ($tc_pe=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese TC Peso/Euro";
				}
				if ($observaciones=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Las observaciones están vacias";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('perfil_referencia',"operaciones");
					exit;
				}

				$id_u=$this->_operaciones->getUsuario_sisfcId(Session::get('id_usuario'));

				$datosEnviar = array(
					"id_u_referencia"=>$id,
					"tipo_cliente" => $tipo_cliente,
					"cliente"=>$cliente,
					"contacto"=>$contacto,
					"status"=>$id_catstatus,
					"servicio"=>$servicio,
					"ecl"=>$ecl,
					"co"=>$co,
					"eta"=>$eta,
					"moneda"=>$moneda,
					"tc_pd"=>$tc_pd,
					"tc_pe"=>$tc_pe,
					"observaciones"=>$observaciones,
					"fecha_actualizacon"=>DATE_NOW,
					"actualizador"=>$_SESSION["id_usuario"]
				);
				$this->_operaciones->actualizarReferencia($datosEnviar);
				$this->_view->assign("_mensaje","La referencia ha sido actualizada");
				$datos=$this->_operaciones->getReferencia($id);
				$this->_view->assign("datos",$datos);
				$this->_view->assign("contactos",$this->_operaciones->getContactoCliente($datos["cliente"]));
			}
			/*
			if ($this->getInt('actualizar2')=="1")
			{
				$apoderado = $this->getSql("apoderado");
				$escritura_publica = $this->getSql("escritura_publica");
				$de_fecha = $this->getSql("de_fecha");
				$numero_federatario = $this->getSql("numero_federatario");
				$fe_publica = $this->getSql("fe_publica");
				$numero_federatario = $this->getSql("numero_federatario");
				$estado_federatario = $this->getSql("estado_federatario");

				$datosEnviar = array(
					"id_u_empresa"=>$id,
					"apoderado"=>$apoderado,
					"escritura_publica"=>$escritura_publica,
					"de_fecha"=>$de_fecha,
					"numero_federatario"=>$nombre_federatario,
					"fe_publica"=>$fe_publica,
					"numero_federatario"=>$numero_federatario,
					"estado_federatario"=>$estado_federatario
				);
				$this->_proveedores->actualizarEmpresa($datosEnviar);
				$this->_view->assign("_mensaje","Poder notarial actualizado");
				$this->_view->assign("activo",2);
			}
			$this->_view->assign("identifica",$id);
			$this->_view->assign("paises",$this->_proveedores->getPaises());
			//echo print_r($this->_proveedores->getPaises());
			//exit();
			*/
			$this->_view->assign("identifica",$id);
			//$this->_view->assign("datos",$this->_proveedores->getProveedor($id));
			//$this->_view->assign("datos2",$this->_proveedores->getContactosProveedor($id));
			//$this->_view->assign("datos3",$this->_proveedores->getProductosProveedor($id));
			//$this->_view->assign("clasis",$this->_proveedores->getClasiProveedores());
			//$this->_view->assign("tipos",$this->_proveedores->getTipoPersona());
			//$this->_view->assign("paises",$this->_proveedores->getPaises());
			$this->_view->renderizar('perfil_referencia',"operaciones");
		}

		public function crear_referencia(){
		    $this->_acl->acceso('todo');
			$this->_view->setJs(array('ajax'));
			$this->_view->assign('titulo','Crear referencia');
			$btnHeader = array(
				array(
					"titulo" => "return",
					"enlace" => "operaciones"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("empresas",$this->_operaciones->getEmpresas());
			$this->_view->assign("marcas",$this->_operaciones->getMarcas());
			$this->_view->assign("status",$this->_operaciones->getStatus());
			$this->_view->assign("usuarios",$this->_operaciones->getUsuarios());
			$this->_view->assign("monedas",$this->_operaciones->getMonedas());
			$this->_view->assign("tipos_clientes",$this->_operaciones->getTiposClientes());
			$this->_view->assign("servicios",$this->_operaciones->getServicios());

			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$empresa = $this->getSql("empresa");
				$tipo_cliente = $this->getSql("tipo_cliente");
				$cliente = $this->getSql("cliente");

				if($tipo_cliente==1){
					$contacto = $this->getSql("contacto");
				}else{
					$contacto = $cliente;
				}

				$id_catstatus = $this->getSql("id_catstatus");
				$servicio = $this->getSql("servicio");
				$co = $this->getSql("co");
				$ecl = $this->getSql("ecl");
				$ace = $this->getSql("ace");
				$moneda = $this->getSql("moneda");
				$tc_pd = $this->getSql("tc_pd");
				$tc_pe = $this->getSql("tc_pe");
				$observaciones = $this->getSql("observaciones");

				$errores="";
				if ($empresa=="Seleccione") {
					$errores="Seleccione la empresa";
				}
				if ($tipo_cliente=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el tipo de cliente";
				}
				if ($cliente=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el cliente";
				}
				if ($contacto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el contacto";
				}
				if ($id_catstatus=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el status";
				}
				if ($servicio=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el servicio";
				}
				if ($co=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el CO";
				}
				if ($ecl=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el ECL";
				}
				if ($ace=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el ACE";
				}

				if ($moneda=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione la moneda";
				}
				if ($tc_pd=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese TC Peso/Dll";
				}
				if ($tc_pe=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese TC Peso/Euro";
				}
				if ($observaciones=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Las observaciones están vacias";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_referencia');
					exit;
				}
				$id_u=$this->_operaciones->getUsuario_sisfcId(Session::get('id_usuario'));
				$nombre = $this->_operaciones->getEmpresa($empresa);
				$id_u_refe=strtoupper(substr($nombre["codigo_empresa"],0,3)).substr(Date("Y"),2,4)."-00".$nombre["contador"];
				$datosEnviar = array(
					"id_u_referencia"=>$id_u_refe,
					"id_u_empresa"=>$empresa ,
					"tipo_cliente" => $tipo_cliente,
					"cliente"=>$cliente,
					"contacto"=>$contacto,
					"status"=>$id_catstatus,
					"servicio"=>$servicio,
					"ecl"=> $ecl,
					"co"=>$co,
					"eta"=>$ace,
					"moneda"=>$moneda,
					"tc_pd"=>$tc_pd,
					"tc_pe"=>$tc_pe,
					"observaciones"=>$observaciones,
					"fecha_creacion"=>DATE_NOW,
					"creador"=>$_SESSION["id_usuario"]
				);
				$this->_operaciones->crearRefeerencia($datosEnviar);
				$datosEnviar = array(
					"id_u_empresa"=>$empresa,
					"contador"=>($nombre["contador"]+1)
				);
				$this->_operaciones->actualizarEmpresa($datosEnviar);
				$this->_view->assign("_mensaje","La referencia ha sido creada");
				$this->redireccionar('operaciones/perfil_referencia/'. $id_u_refe);
				exit();

			}

			$this->_view->renderizar('crear_referencia');
		}

		public function perfil_orden($refe = false, $orde = false )
		{
		    $this->_acl->acceso('todo');
			if (!$refe || !$orde) {
				$this->redireccionar('operaciones');
				exit();
			}
			$this->_view->setJs(array('perfilOrdenCompra'));
			$this->_view->assign('referencia',$refe);
			$orden= $this->_operaciones->getOrdenesCompra($orde);
			$this->_view->assign('orden',$orden);
			$this->_view->assign('productos',$this->_operaciones->getProductosProveedor($orden["id_u_proveedor"]));
			$this->_view->assign('titulo','Perfil orden de compra');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "operaciones/perfil_referencia/".$refe
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign('productosAgre',$this->_operaciones->getOrdenesProductos($orde));
			if ($this->getInt('crear')=="1")
			{
				$producto=$this->getSql("producto");
				$cantidad=$this->getInt("cantidad");
				$precio=$this->getFloat("precio");

				$errores="";
				if ($producto=="Seleccione") {
					$errores="Seleccione el producto";
				}
				if ($cantidad<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el cliente";
				}
				if ($precio<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el precio";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('perfil_orden',"operaciones");
					exit;
				}
				$resul = $this->_operaciones->getReferencia($refe);
				$id_u=$this->_operaciones->getUsuario_sisfcId(Session::get('id_usuario'));

				$datosEnviar = array(
					"id_u_orden"=>$orde,
					"id_u_proveedor"=>$orden["id_u_proveedor"],
					"id_u_producto"=>$producto,
					"cantidad"=>$cantidad,
					"precio"=>$precio,
					"total"=>($cantidad*$precio),
					"fecha_creacion"=>Date("d/m/Y"),
					"creador"=>$id_u["id_u_usuario"]
				);

				$this->_operaciones->crearProducto($datosEnviar);

				$datosEnviar = array(
					"id_u_orden"=>$orde,
					"fecha_actualizacon"=>Date("d/m/Y"),
					"actualizador"=>$id_u["id_u_usuario"]
				);

				$this->_operaciones->actualizarOrdenCompra($datosEnviar);

				$this->_view->assign('_mensaje',"Producto agregado");
				$orden= $this->_operaciones->getOrdenesCompra($orde);
				$this->_view->assign('orden',$orden);
				$this->_view->assign('productos',$this->_operaciones->getProductosProveedor($orden["id_u_proveedor"]));
				$this->_view->assign('productosAgre',$this->_operaciones->getOrdenesProductos($orde));
			}
			$this->_view->renderizar('perfil_orden',"operaciones");
		}

		public function actualizarOrden(){

			$id = $this->getInt("id");
			$valor = $this->getSql("valor");
			$celda = $this->getSql("celda");

			if($celda=="producto"){
				$celda = "id_u_producto";
			}

			$datosEnviar = array(
				"id_orden_producto"=>$id,
				 $celda=>$valor
			);

			$this->_operaciones->actualizarOrden($datosEnviar);
			//echo json_encode("Se ha actualizado");
		}

		public function crear_orden($id=false)
		{
		    $this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('operaciones');
				exit();
			}
			$this->_view->setJs(array('orden_compra'));
			$this->_view->assign("referencia",$id);
			$this->_view->assign('titulo','Crear orden de compra');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "operaciones/perfil_referencia/".$id
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("proveedores",$this->_operaciones->getProveedores());
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$proveedor = $this->getSql("id_u_proveedor");
				$numero_factura = $this->getSql("numero_factura");
				$producto = $this->getSql("producto");
				$cantidad = $this->getInt("cantidad");
				$precio = $this->getFloat("precio");

				$errores="";
				if ($proveedor=="Seleccione") {
					$errores="Seleccione el proveedor";
				}
				if ($numero_factura=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el número de la factura";
				}
				if ($producto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el producto";
				}
				if ($cantidad<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Cantidad no válida";
				}
				if ($precio<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="El precio no es válido";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_orden',"operaciones");
					exit;
				}
				$resul = $this->_operaciones->getReferencia($id);
				$id_u=$this->_operaciones->getUsuario_sisfcId(Session::get('id_usuario'));

				if (count($resul)>1) {
					$contador=$resul["contador_orden"];
					if ($contador=="") {
						$contador=0;
					}

					$orden = $id . "-OC-00" . ($contador + 1);
					$datosEnviar = array(
						"id_u_referencia"=>$id,
						"contador_orden"=>($resul["contador_orden"]+1)
					);
					$this->_operaciones->actualizarReferencia($datosEnviar);
					$datosEnviar = array(
						"id_u_referencia"=>$id,
						"id_u_orden"=>$orden,
						"id_u_proveedor"=>$proveedor ,
						"numero_factura"=>$numero_factura,
						"fecha_creacion"=>DATE_NOW,
						"creador"=>Session::get('id_usuario')
					);
					$this->_operaciones->crearOrden($datosEnviar);
					//$orden = $refe . "-OC-00" . ($contador + 1);
					$datosEnviar = array(
						"id_u_orden"=>$orden,
						"id_u_proveedor"=>$proveedor ,
						"id_u_producto"=>$producto,
						"cantidad"=>$cantidad,
						"precio"=>$precio,
						"total"=>($cantidad*$precio),
						"fecha_creacion"=>Date("d/m/Y"),
						"creador"=>$id_u["id_u_usuario"]
					);

					$this->_operaciones->crearProducto($datosEnviar);
					$this->redireccionar("operaciones/perfil_orden/".$id."/".$orden);
					exit;
				}
			}
			$this->_view->renderizar('crear_orden',"operaciones");
		}

		public function perfil_cotizacion($referencia, $cotizacion, $ruta = "datos")
		{
      $this->_acl->acceso('todo');
			$this->_view->assign('titulo','Perfil cotización');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "operaciones/perfil_referencia/".$referencia
				)
			);



			$this->getDatosOperacion = $this->_operaciones->getDatosOperacion($referencia);
			// echo "<pre>";print_r($this->getDatosOperacion);
			// exit;
			$this->_view->assign('datosOperacion',$this->getDatosOperacion);

			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign('id_referencia',$referencia);
			$this->_view->assign('id_cotizacion',$cotizacion);
			$this->_view->assign('el_menu',$this->menu_cotizacion());
			$cxc = $this->_operaciones->getCxCCotizacion($cotizacion);

			$datos_cotizacion = $this->_operaciones->getDatosCotizacion($cotizacion);
			$gastos_aduanales = $this->_operaciones->getGastosCotizacion($cotizacion);
			$impuestos_cotizacion = $this->_operaciones->getImpuestosCotizacion($cotizacion);
			$datos_referencia = $this->_operaciones->getReferencia($referencia);
			$this->_view->assign("tipo_cliente",$datos_referencia["tipo_cliente"]);

			$incrementables_cotizacion = $this->_operaciones->getIncrementables($cotizacion);
			$this->_view->assign("incrementables",$incrementables_cotizacion);
			$incrementables = $this->_operaciones->getIncrementablesCotizacion($cotizacion);
			$this->_view->assign("incrementables_cotizacion",$incrementables);
			$this->_view->assign("monedas",$this->_operaciones->getMonedas());
            $tipos_facturacion = $this->_operaciones->getTiposFacturacion();

			$moneda_referencia = $datos_referencia["moneda"];
			$monedas = $this->_operaciones->getMonedas();

			$datos_empresa = $this->_operaciones->getEmpresa($datos_referencia["id_u_empresa"]);

			if($moneda_referencia == 3){
				$this->_view->assign("signo_moneda","<img src='".BASE_URL."public/img/euro.jpg'/>");
				$this->_view->assign("tipo_moneda","Euros");
			}else if($moneda_referencia == 1){
				$this->_view->assign("signo_moneda","$");
				$this->_view->assign("tipo_moneda","Pesos");
			}else {
				$this->_view->assign("signo_moneda","US$");
				$this->_view->assign("tipo_moneda","Dolar");
			}

			$logo_empresa = $this->_operaciones->getLogoEmpresas($datos_referencia["id_u_empresa"]);
			$this->_view->assign("logo_empresa",$logo_empresa["logo"]);

			$this->_view->assign("gastos",$this->_operaciones->getGastosAduanales());
			$this->_view->assign("gastos_cotizacion",$gastos_aduanales);



			//Valor factura

			$valor_factura = 0;
			$ordenes = $this->_operaciones->getCotizacionesOrdenes($cotizacion);

			$productos = array();
			$prorrateo = array();
			$cantidad_productos = 0;
			foreach($ordenes as $orden){
				$producto = $this->_operaciones->getOrdenesProductos($orden['id_u_orden']);
				foreach($producto as $p){
					$productos [] = array(
						"id_orden_producto" => $p['id_orden_producto'],
						"id_u_producto" => $p['id_u_producto'],
						"igi" => $p['igi'],
						"iva" => $p['iva_aduanal'],
						"nombre_producto" => $p['nombre_producto'],
						"total"=>$p["cantidad"] * $p["precio"]
					);

					$prorrateo [] = array(
						"unidad_medida"=>$p['nombre_medida'],
						"igi"=>$p['igi'],
						"sku"=>$p['codigo_producto'],
						"producto"=>$p['nombre_producto'],
						"cantidad_producto"=>$p['cantidad'],
						"precio_unitario"=>$p['precio'],
						"monto_total" => 0,
						"por_incrementables" => 0,
						"incrementables" => 0,
						"incrementable_x_pieza" => 0,
						"valor_aduana_unitario" => 0,
						"valor_aduana_tototal" => 0,
						"igi_unitario" => 0,
						"igi_total" => 0,
						"dta_unitario" => 0,
						"dta_total" => 0,
						"prv_unitario" => 0,
						"prv_total" => 0,
						"iva_unitario" => 0,
						"iva_total" => 0,
						"gastos_aduanales" => 0,
						"gastos_aduanales_total" => 0,
						"honorarios_unitario" => 0,
						"honorarios_total" => 0,
						"precio_u_nacional" => 0,
						"monto_nacional" => 0
					);

					$cantidad_productos += $p['cantidad'];
					$valor_factura += $p['cantidad'] * $p['precio'];

				}
			}

			//Total incrementables

			$total_incrementables = 0;

			foreach($incrementables as $incrementable){
				$total_incrementables += $incrementable['valor'];
			}

			//Seguro cotizacion

			$seguro_cotizacion = $datos_cotizacion["seguro"];
			$min_seguro_cotizacion = $datos_cotizacion["min_seguro"];

			$seguro = 0;
			if((($valor_factura + $total_incrementables) * $seguro_cotizacion / 100)>$min_seguro_cotizacion){
				$seguro = ($valor_factura + $total_incrementables) * $seguro_cotizacion / 100;
			}else{
				$seguro = $datos_cotizacion["min_seguro"];
			}
			$this->_view->assign("seguro_cotizacion",$seguro);

			//Valor en aduana

			$valor_aduana = $valor_factura + $total_incrementables + $seguro;
			$this->_view->assign("valor_aduana",$valor_aduana);

			//Honorarios Agente aduanal

			$honorarios_agente = $valor_aduana * ($datos_cotizacion["hon_agente"] / 100) + $datos_cotizacion["hon_agente_plus"] * $datos_cotizacion["cantidad_embalaje"];
			$this->_view->assign("honorarios_agente",$honorarios_agente);

			//Gastos aduanales

			$total_gastos_aduanales = 0;
			foreach($gastos_aduanales as $gasto){
				$total_gastos_aduanales += $gasto["valor"];
			}

			$total_gastos_aduanales = $total_gastos_aduanales + $honorarios_agente;

			$this->_view->assign("total_gastos_aduanales",$total_gastos_aduanales);

			/**

			*/
			$this->_view->assign("cantidad_productos",$cantidad_productos);
			$suma_monto_total = 0;

			for ($i=0; $i < count($prorrateo); $i++) {
				$prorrateo[$i]["monto_total"] = $prorrateo[$i]["precio_unitario"] * $prorrateo[$i]["cantidad_producto"];
				$suma_monto_total += $prorrateo[$i]["monto_total"];
			}

			$suma_por_incrementables = 0;
			$suma_valor_aduana_total = 0;
			$suma_igi_total = 0;
			$suma_dta_total = 0;
			$suma_prv_total = 0;
			$suma_iva_total = 0;
			$suma_gastos_aduanales_total = 0;

			//DTA unitario
			$dta_unitario = 0;

			if($valor_aduana * $impuestos_cotizacion["dta_porcentaje"] / 100 > $impuestos_cotizacion["dta"]){
				$dta_unitario = $valor_aduana * $impuestos_cotizacion["dta_porcentaje"] / 100;
			}else{
				$dta_unitario = $impuestos_cotizacion["dta"];
			}

			for ($i=0; $i < count($prorrateo); $i++) {
				$prorrateo[$i]["por_incrementables"] = $prorrateo[$i]["monto_total"] / $suma_monto_total;
				$suma_por_incrementables += $prorrateo[$i]["por_incrementables"];


				$prorrateo[$i]["incrementables"] = ($total_incrementables + $seguro) * $prorrateo[$i]["por_incrementables"];

				$prorrateo[$i]["incrementable_x_pieza"] = $prorrateo[$i]["incrementables"] / $prorrateo[$i]["cantidad_producto"];

				$prorrateo[$i]["valor_aduana_unitario"] = $prorrateo[$i]["incrementable_x_pieza"] + $prorrateo[$i]["precio_unitario"];

				$prorrateo[$i]["valor_aduana_tototal"] = $prorrateo[$i]["valor_aduana_unitario"] * $prorrateo[$i]["cantidad_producto"];
				$suma_valor_aduana_total += $prorrateo[$i]["valor_aduana_tototal"];

				$prorrateo[$i]["igi_unitario"] = $prorrateo[$i]["valor_aduana_unitario"] * $prorrateo[$i]["igi"] / 100;

				$prorrateo[$i]["igi_total"] = $prorrateo[$i]["igi_unitario"] * $prorrateo[$i]["cantidad_producto"];

				$suma_igi_total += $prorrateo[$i]["igi_total"];

				$prorrateo[$i]["dta_unitario"] = $dta_unitario / $cantidad_productos;

				$prorrateo[$i]["dta_total"] = $prorrateo[$i]["dta_unitario"] * $prorrateo[$i]["cantidad_producto"];

				$suma_dta_total += $prorrateo[$i]["dta_total"];


				$prorrateo[$i]["prv_unitario"] = $impuestos_cotizacion["prv"] / $cantidad_productos;

				$prorrateo[$i]["prv_total"] = $prorrateo[$i]["prv_unitario"] * $prorrateo[$i]["cantidad_producto"];

				$suma_prv_total += $prorrateo[$i]["prv_total"];

				$prorrateo[$i]["iva_unitario"] = ($prorrateo[$i]["valor_aduana_unitario"] + $prorrateo[$i]["igi_unitario"] + $prorrateo[$i]["dta_unitario"]) * $productos[$i]["iva"] / 100;

				$prorrateo[$i]["iva_total"] = $prorrateo[$i]["iva_unitario"] * $prorrateo[$i]["cantidad_producto"];

				$suma_iva_total += $prorrateo[$i]["iva_total"];

				$prorrateo[$i]["gastos_aduanales"] = $total_gastos_aduanales / $cantidad_productos;

				$prorrateo[$i]["gastos_aduanales_total"] = $prorrateo[$i]["gastos_aduanales"] * $prorrateo[$i]["cantidad_producto"];

				$suma_gastos_aduanales_total += $prorrateo[$i]["gastos_aduanales_total"];
			}

			$impuestos = $suma_igi_total + $suma_dta_total + $suma_prv_total + $suma_iva_total;

			$honorarios_porcentaje = ($valor_aduana + $total_gastos_aduanales + $impuestos) * $datos_cotizacion["hon_cia"] / 100;

			$honorarios_unitarios = 0;
			if($honorarios_porcentaje > $datos_cotizacion["hon_cia_plus"]){
				$honorarios_unitarios = $honorarios_porcentaje;
			}else{
				$honorarios_unitarios = $datos_cotizacion["hon_cia_plus"];
			}

			$suma_honorarios_total = 0;
			$subtotal = 0;

			for($i=0; $i < count($prorrateo); $i++){
				$prorrateo[$i]["honorarios_unitarios"] = $honorarios_unitarios / $cantidad_productos;
				$prorrateo[$i]["honorarios_total"] = $prorrateo[$i]["honorarios_unitarios"] * $prorrateo[$i]["cantidad_producto"];

				$suma_honorarios_total += $prorrateo[$i]["honorarios_total"];

				$prorrateo[$i]["precio_u_nacional"] = $prorrateo[$i]["valor_aduana_unitario"] + $prorrateo[$i]["igi_unitario"] + $prorrateo[$i]["dta_unitario"] + $prorrateo[$i]["prv_unitario"] + $prorrateo[$i]["gastos_aduanales"] + $prorrateo[$i]["honorarios_unitarios"];

				$prorrateo[$i]["monto_nacional"] = $prorrateo[$i]["precio_u_nacional"] * $prorrateo[$i]["cantidad_producto"];

				$subtotal += $prorrateo[$i]["monto_nacional"];
			}

			$iva = $impuestos_cotizacion["iva_factura"] * $subtotal / 100;
			$total_factura = $iva + $subtotal;
			$total_gastos_impuestos = $total_gastos_aduanales + $impuestos + $suma_honorarios_total;
			$gastos_sin_iva = $total_gastos_impuestos - $suma_iva_total;

			$this->_view->assign("total_incrementables",$total_incrementables);
			$this->_view->assign("suma_monto_total",$suma_monto_total);
			$this->_view->assign("prorrateo",$prorrateo);
			$this->_view->assign("suma_por_incrementables",$suma_por_incrementables);
			$this->_view->assign("suma_valor_aduana_total",$suma_valor_aduana_total);
			$this->_view->assign("suma_igi_total",$suma_igi_total);
			$this->_view->assign("suma_dta_total",$suma_dta_total);
			$this->_view->assign("suma_prv_total",$suma_prv_total);
			$this->_view->assign("suma_iva_total",$suma_iva_total);
			$this->_view->assign("suma_gastos_aduanales_total",$suma_gastos_aduanales_total);
			$this->_view->assign("suma_honorarios_total",$suma_honorarios_total);
			$this->_view->assign("subtotal",$subtotal);
			$this->_view->assign("iva",$iva);
			$this->_view->assign("total_factura",$total_factura);
			$this->_view->assign("total_impuestos",$impuestos);//$suma_honorarios_total;
			$this->_view->assign("honorarios_sinergia",$suma_honorarios_total);
			$this->_view->assign("total_gastos_impuestos",$total_gastos_impuestos);
			$this->_view->assign("gastos_sin_iva",$gastos_sin_iva);
			$this->_view->assign("impuestos",$impuestos);
			$this->_view->assign("iva_factura",$impuestos_cotizacion["iva_factura"]);



			//end-prorrateo
			/**

			*/
			$suma_abonos = 0;

			$abonos=array();
			$valor1=1;
			if ($moneda_referencia==2) {
				$valor1=$datos_referencia["tc_pd"];
			}
			if ($moneda_referencia==3) {
				$valor1=$datos_referencia["tc_pe"];
			}
			
			for($i=0; $i < count($cxc); $i++){
				$valor2=1;
				if ($cxc[$i]["moneda"]==2) {
					$valor2=$datos_referencia["tc_pd"];
				}
				if ($cxc[$i]["moneda"]==3) {
					$valor2=$datos_referencia["tc_pe"];
				}
				$abonos[]=array(
					"fecha"=>$cxc[$i]["fecha"],
					"monto_aplicable"=>$this->cambio_divisa($cxc[$i]["monto_aplicable"],$valor2,$valor1),
					"concepto"=>$cxc[$i]["nombre_concepto"],
					"id_concepto"=>$cxc[$i]["concepto"]
				);

				$suma_abonos += $abonos[$i]['monto_aplicable'];


			}


			$this->_view->assign("abonos",$abonos);

			$contadorAbonos = count($abonos);
			$saldoMercancia = 0;
			$saldoDespacho = 0;
			foreach($abonos as $abono){
				if($abono["id_concepto"]==1 || $abono["id_concepto"]==7 || $abono["id_concepto"]==10){
					$saldoMercancia += $abono["monto_aplicable"];
				}else{
					$saldoDespacho += $abono["monto_aplicable"];
				}
			}

			$this->_view->assign("saldoMercancia",$valor_factura - $saldoMercancia);


			$this->_view->assign("saldoDespacho",($total_factura - $valor_factura) - $saldoDespacho);
			$saldo_factura = $total_factura - $suma_abonos;

			$this->_view->assign("id_referencia",$referencia);
			$this->_view->assign("valor_factura",$valor_factura);

			$this->_view->assign("saldo_factura",$saldo_factura);

			if($ruta=="datos"){
				$this->_view->assign('ruta',"datos");
				$this->_view->assign("datos",$datos_cotizacion);
				$this->_view->assign("incoterms",$this->_operaciones->getIncoterms());
				$this->_view->assign("tipos_embalaje",$this->_operaciones->getTiposEmbalaje());
				$this->_view->assign("tipos_operacion",$this->_operaciones->getOperaciones());
				$this->_view->assign("secciones_aduaneras",$this->_operaciones->getSeccionesAduaneras());
				$this->_view->assign("medios_transporte",$this->_operaciones->getMediosTransporte());
				$this->_view->setJs(array('cotizacion'));
				$this->_view->assign("ordenC",$this->_operaciones->getCotizacionesOrdenes($cotizacion));

				if ($this->getInt('crear')=="1")
				{
					$vigencia=$this->getSql("vigencia");
					$incoterm=$this->getSql("incoterm");
					$tipo_embalaje=$this->getSql("tipo_embalaje");
					$cantidad_embalaje=$this->getInt("cantidad_embalaje");
					$operacion=$this->getSql("operacion");
					$seccion_aduanera=$this->getSql("seccion_aduanera");
					$medio_transporte=$this->getSql("medio_transporte");
					$dias_previos=$this->getInt("dias_previos");
					$cantidad_transferencias=$this->getFloat("cantidad_transferencias");
					$cantidad_pedimentos=$this->getInt("cantidad_pedimentos");
					$mercancia=$this->getSql("mercancia");
					$seguro=$this->getFloat("seguro");
					$min_seguro=$this->getFloat("min_seguro");
					$hon_agente=$this->getFloat("hon_agente");
					$hon_agente_plus=$this->getFloat("hon_agente_plus");
					$hon_cia=$this->getFloat("hon_cia");
					$hon_cia_plus=$this->getFloat("hon_cia_plus");
					$observaciones=$this->getSql("observaciones");
					$this->getLibrary('dateUtils');
					$dateUtils = new dateUtils();
					$errores="";
					// if (count($dateUtils->formatearFecha($vigencia))==0) {
					// 	$errores="La vigencia es incorrecta";
					// }
					if ($incoterm=="Seleccione") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Seleccione el incoterm";
					}
					if ($tipo_embalaje=="Seleccione") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Seleccione el tipo de enbalaje";
					}
					if ($cantidad_embalaje<0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese la cantidad de embalaje";
					}
					if ($operacion=="Seleccione") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Selecione la operacion";
					}
					if ($seccion_aduanera=="Seleccione") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Selecione la seccion aduanere";
					}
					if ($medio_transporte=="Seleccione") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Selecione el medio de transporte";
					}
					if ($dias_previos<0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese la cantidad de dias previos";
					}
					if ($cantidad_transferencias<0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese la cantidad de transferencias";
					}
					if ($cantidad_pedimentos<0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese la cantidad de pedimentos";
					}
					if ($mercancia=="") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese la mercancia";
					}
					if ($seguro<0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese el valor del seguro";
					}
					if ($min_seguro<0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese el valor minimo de seguro";
					}
					if ($hon_agente<0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese los honorarios del agente aduanal";
					}
					if ($hon_agente_plus<0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese los honorarios del agente aduanal +";
					}
					if ($hon_cia<0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese los honorarios CIA";
					}
					if ($hon_cia_plus<0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese los honorarios CIA +";
					}
					if ($observaciones=="") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Las observaciones están vacías";
					}
					if ($errores!="") {
						$this->_view->assign("_error",$errores);

					}else{

						/**
							Si la cantidad de pedimentos almacenada es igual a la cantidad de pedimentos enviada para almacenar los datos de los impuestos de la cotización se mantienen.
							Si alguno de los dos es distitnos los impuestos son borrados y calculados nuevamente
						*/

						$pedimentoGuardado = $this->_operaciones->getDatosCotizacion($cotizacion);
						if($cantidad_pedimentos!=$pedimentoGuardado["cantidad_pedimentos"]){
							$this->_operaciones->eliminarImpuestosCotizacion($cotizacion);
						}


						$datosEnviar = array(
							"id_u_cotizacion"=>$cotizacion,
							"vigencia"=>$vigencia ,
							"incoterm"=>$incoterm ,
							"tipo_embalaje"=>$tipo_embalaje ,
							"cantidad_embalaje"=>$cantidad_embalaje ,
							"operacion"=>$operacion ,
							"seccion_aduanera"=>$seccion_aduanera ,
							"medio_transporte"=>$medio_transporte ,
							"dias_previos"=>$dias_previos,
							"cantidad_transferencias"=>$cantidad_transferencias ,
							"cantidad_pedimentos"=>$cantidad_pedimentos ,
							"mercancia"=>$mercancia ,
							"seguro"=>$seguro ,
							"min_seguro"=>$min_seguro ,
							"hon_agente"=>$hon_agente ,
							"hon_agente_plus"=>$hon_agente_plus ,
							"hon_cia"=>$hon_cia ,
							"hon_cia_plus"=>$hon_cia_plus,
							"observaciones"=>$observaciones
						);
						$this->_operaciones->actualizarCotizacion($datosEnviar);
						$this->_operaciones->eliminarCoti($cotizacion);

						$values = array_keys($_POST);
						for ($i=0; $i < count($values) ; $i++) {
							if (substr($values[$i],0,6)=='orden_') {
								if ($_POST[$values[$i]]) {
									$datosEnviar = array(
										"id_u_cotizacion"=>$cotizacion,
										"id_u_orden"=>substr($values[$i],6, strlen($values[$i])-5)
									);
									$this->_operaciones->crearCotizacionOrdenes($datosEnviar);

								}
							}
						}
						$this->_view->assign("ordenC",$this->_operaciones->getCotizacionesOrdenes($cotizacion));
						$this->_view->assign("_mensaje","La cotizacion ha sido actualizada");





						$this->_view->assign("datos",$this->_operaciones->getDatosCotizacion($cotizacion));
					}
				}
				$ordenes=$this->_operaciones->getOrdenes($referencia);
				$dataordenes= array();
				foreach ($ordenes as $orden) {
					$suma=0;
					$resultado=$this->_operaciones->getProductos($orden["id_u_orden"]);
					foreach ( $resultado as $resu) {
						$suma+=$resu["cantidad"]*$resu["precio"];

					}

					$dataordenes[]=array(
						"id_u_orden"=>$orden["id_u_orden"],
						"proveedor"=>$orden["proveedor"],
						"numero_factura"=>$orden["numero_factura"],
						"total"=>$suma
						);

				}


				$this->_view->assign("ordenes",$dataordenes);
				$this->_view->assign('vista', ROOT . 'modulos' . DS . "operaciones" . DS . "views" . DS . "cot_datos" . '.tpl');
			}
			//Definición de imagen-logo

			if($ruta=="gastos"){
				$this->_view->setJs(array('cot_gastos'));
				$this->_view->assign('ruta',"gastos");
				if ($this->getInt('crearg')=="1")
				{
					$id_gasto=$this->getSql("id_gasto");
					$valor_gasto= $this->getInt("valor_gasto");
					$errores="";
					if ($id_gasto=="Seleccione") {
						$errores="Seleccione el gasto aduanal";
					}
					if ($valor_gasto<=0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese un valor de gasto aduanal valido";
					}
					if ($errores!="") {
						$this->_view->assign("_error",$errores);
					}else{

						$datosEnviar = array(
								"id_u_cotizacion"=>$cotizacion,
								"id_gasto"=>$id_gasto,
								"valor"=>$valor_gasto
							);
						$this->_operaciones->crearGastosCotizaciones($datosEnviar);
						$this->_view->assign("gastos_cotizacion",$this->_operaciones->getGastosCotizacion($cotizacion));
					}
				}
				$this->_view->assign('vista', ROOT . 'modulos' . DS . "operaciones" . DS . "views" . DS . "cot_gastos" . '.tpl');
			}

			if($ruta=="incrementables"){
				$this->_view->assign('ruta',"incrementables");
				$this->_view->setJs(array('cot_incrementables'));
				if ($this->getInt('creari')=="1")
				{
					$incrementable=$this->getSql("incrementable");
					$valor=$this->getFloat("valor");
					$errores="";
					if ($incrementable=="Seleccione") {
						$errores="Seleccione el incrementable";
					}
					if ($valor<=0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese el valor del incrementable";
					}
					if ($errores!="") {
						$this->_view->assign("_error",$errores);
					}else{
						$datosEnviar = array(
								"id_u_cotizacion"=>$cotizacion,
								"id_incrementable"=>$incrementable,
								"valor"=>$valor
							);
						$this->_operaciones->crearIncreCotizaciones($datosEnviar);
						$this->_view->assign("incrementables_cotizacion",$this->_operaciones->getIncrementablesCotizacion($cotizacion));
					}
				}
				$this->_view->assign('vista', ROOT . 'modulos' . DS . "operaciones" . DS . "views" . DS . "cot_incrementables" . '.tpl');
			}

			if($ruta=="impuestos"){
				$this->_view->assign('ruta',"impuestos");
				$this->_view->setJs(array('cot_impuestos'));
				$this->_view->assign('ruta',"impuestos");
				if ($datos_referencia["moneda"]=="1") {
					$this->_view->assign('prv_default',244 * $datos_cotizacion["cantidad_pedimentos"]);
					$this->_view->assign('dta_default',250 * $datos_cotizacion["cantidad_pedimentos"]);
				}else{
					$this->_view->assign('prv_default',21 * $datos_cotizacion["cantidad_pedimentos"]);
					$this->_view->assign('dta_default',21 * $datos_cotizacion["cantidad_pedimentos"]);
				}

				$this->_view->assign("impuestos",$impuestos_cotizacion);


				$this->_view->assign("productos",$productos);

				$this->_view->assign('vista', ROOT . 'modulos' . DS . "operaciones" . DS . "views" . DS . "cot_impuestos" . '.tpl');
			}

			if($ruta=="cxc"){

				$this->_view->assign('ruta',"cxc");
				$this->_view->setJs(array('cot_cxc'));
				$this->_view->assign("cxc",$cxc);
				$this->_view->assign('tipos_facturacion',$tipos_facturacion);

				$this->_view->assign("conceptos_cxc",$this->_operaciones->getConceptosCxC());
				$razones_sociales = $this->_operaciones->getRazonesSociales($datos_referencia["cliente"]);
				$this->_view->assign("razones_sociales",$razones_sociales);

				$datosFactura = function()use($referencia,$cotizacion,$cxc,$monedas){
					$facturas = $this->_operaciones->getFacturasCxC($cotizacion);
					$this->_view->assign("referencia",$referencia);
					$this->_view->assign("cotizacion",$cotizacion);
					for($i=0;$i<count($facturas);$i++){
						foreach($cxc as $c){
							if($c["id"] == $facturas[$i]["id_cxc"]){
								$facturas[$i]["fecha_deposito"] = $c["fecha"];
							}
						}

						foreach($monedas as $moneda){
							if($moneda["id_moneda"]==$facturas[$i]["divisa_referencia"]){
								$facturas[$i]["divisa_referencia"] = $moneda["n_espanol"];
							}

							if($moneda["id_moneda"]==$facturas[$i]["divisa_facturacion"]){
								$facturas[$i]["divisa_facturacion"] = $moneda["n_espanol"];
								$facturas[$i]["signo_divisa_facturacion"] = $moneda["signo"];
							}
						}
					}

					// echo "<pre>";print_r($facturas);
					// exit;
					$this->_view->assign("facturas",$facturas);
				};

			 	$datosFactura();




				if ($this->getInt('crearcxc')=="1")
				{
					$fecha=$this->getSql("fecha");
					$mdeposito=$this->getSql("mdeposito");
					$maplicable=$this->getSql("maplicable");
					$moneda=$this->getSql("moneda");
					$conceptoc=$this->getSql("conceptoc");
					$this->getLibrary('dateUtils');
					$dateUtils = new dateUtils();
					$errores="";
					if (count($dateUtils->formatearFecha($fecha))==0) {
						$errores="La fecha es incorrecta";
					}
					if ($mdeposito<=0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese el valor el monto deposito";
					}
					if ($maplicable<=0) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese el valor el monto aplicable";
					}
					if ($moneda=="Seleccione") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Seleccione la moneda";
					}
					if ($conceptoc=="Seleccione") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$conceptoc.="Seleccione el concepto";
					}
					if ($errores!="") {
						$this->_view->assign("_error",$errores);
					}else{
						$datosEnviar = array(
							"id_u_cotizacion"=>$cotizacion,
							"fecha"=>$fecha,
							"monto_depositado"=>$mdeposito,
							"monto_aplicable"=>$maplicable,
							"moneda"=>$moneda,
							"concepto"=>$conceptoc
						);
						$this->_operaciones->crearCxCCotizacion($datosEnviar);
						$this->_view->assign("_mensaje","Cuenta por cobrar creada");
						$cxc=$this->_operaciones->getCxCCotizacion($cotizacion);



						$this->_view->assign("cxc",$cxc);
					}
					// fecha
					// mdeposito
					// maplicable
					// moneda
					// conceptoc
				}

				if(isset($_POST["facturar"])==1){


    				//$this->_operaciones->actualizarCotizacion($datosEnviar);

					$razon_social = $this->getSql("razon_social");
					$concepto = $this->getSql("concepto");
					$id_cxc = $this->getSql("id_cxc");
					$moneda = $this->getSql("divisa");
					$a_facturar = $this->getSql("monto_factura");
					$razon_social = $this->_operaciones->getRazonSocial($razon_social);

					$tipo_facturacion = $this->getSql("tipofacturacion");
					$tipo_facturacion = $this->_operaciones->getTipoFactura($tipo_facturacion);

					$tipo_facturacion = $tipo_facturacion["codigo"];
					$rfc_sinergia = $datos_empresa["rfc"];

					if(WS_TIPO=="prueba"){
					       $rfc_sinergia = "CAGE7208162S2";
					}

					$errores="";
					if ($tipo_facturacion=="Seleccione") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Seleccione tipo de facturación";
					}
					if ($razon_social=="Seleccione") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Seleccione razón social";
					}
					if ($razon_social["rfc"]=="") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="La razón social que está escogiendo no tiene RFC";
					}
					// if ($moneda=="") {
					// 	if ($errores!="") {
					// 		$errores .="<br>";
					// 	}
					// 	$errores.="Debe escoger una moneda";
					// }
					if ($a_facturar=="") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Debe escoger una moneda";
					}
					if ($errores!="") {
						$this->_view->assign("_error",$errores);
					}else{
						if($this->_wsError){
							$this->_view->assign("_error","Error de conexión con el servidor. Intente más tarde por favor...");
						}else{
							$valor1=1;
							if ($moneda_referencia==2) {
								$valor1=$datos_referencia["tc_pd"];
							}
							if ($moneda_referencia==3) {
								$valor1=$datos_referencia["tc_pe"];
							}
							$nombre_moneda = "Pesos";

							$valor2=1;
							if ($moneda==2) {
								$valor2=$datos_referencia["tc_pd"];
								$nombre_moneda = "USD";
							}
							if ($moneda==3) {
								$valor2=$datos_referencia["tc_pe"];
								$nombre_moneda = "Euros";
							}

                //$a_facturar=$this->cambio_divisa($a_facturar,$valor1,$valor2);
                $iva = $impuestos_cotizacion["iva_factura"]/100;
                $subtotal = $a_facturar / (1 + $iva);
                $iva = $subtotal * $impuestos_cotizacion["iva_factura"]/100;

							$setComprobanteV2012 = array(
							"usuario" 					=> USER, // Requerido
							"password" 					=> PASS, // Requerido
							"Id_SistemaPadre" 			=> "SisFC", // Requerido
							"EdoComprobante" 			=> "1", // Requerido
							"Tipo" 						=> $tipo_facturacion, // Requerido
							"EmRFC" 					=> $rfc_sinergia, // Requerido
							"CondicionesPago" 			=> "NA", // No Requerido
							"FormaPago" 				=> "Pago en parcialidades", // Requerido
							"Descuento" 				=> "", // No Requerido
							"motivoDescuento"			=> "", // No Requerido
							"metodoPago" 				=> "NA", // Requerido
							"subTotal" 					=> $subtotal, // Requerido
							"Total"						=> $a_facturar, // Requerido
							"ReID" 						=> "", // No Requerido //Clave cliente
							"ReNombre" 					=> $razon_social["razon_social"], // Requerido
							"ReRFC" 					=> $razon_social["rfc"], // Requerido
							"ReCalle" 					=> $razon_social["domicilio_fiscal"], // No Requerido
							"ReCodigoPostal" 			=> "", // No Requerido
							"ReColonia" 				=> "", // No Requerido
							"ReEstado" 					=> "", // No Requerido
							"ReLocalidad" 				=> "", // No Requerido
							"ReMunicipio" 				=> $razon_social["municipio"], // No Requerido
							"ReNoExterior" 				=> $razon_social["num_ext"], // No Requerido
							"ReNoInterior"				=> $razon_social["num_int"], // No Requerido
							"ReTel" 					=> "", // No Requerido
							"RePais" 					=> $razon_social["pais"], // Requerido
							"ReReferencia" 				=> "", // No Requerido
							"ReCorreo" 					=> "", // No Requerido
							"TotalImpuestosRetenidos" 	=> "", // Requerido
							"TotalImpuestoTransladado" 	=> "", // Requerido
							"RImpuesto" 				=> "IVA", // No Requerido
							"RImporte" 					=> "", // No Requerido
							"TImpuesto" 				=> "IVA", // Requerido
							"TImporte" 					=> $iva, // Requerido
							"TTasa" 					=> $impuestos_cotizacion["iva_factura"], // Requerido
							"Notas" 					=> $_POST["comentarios"], // No Requerido
							"Moneda" 					=> $nombre_moneda, // No Requerido
							"TipoCambio" 				=> "", // No Requerido
							"Vendedor" 					=> "", // No Requerido
							"OrdCompra" 				=> $referencia, // No Requerido /*Referencia
							"Otros" 					=> "", // No Requerido
							"numCtaPago" 				=> "" // No Requerido
							);

							//$this->_wsCliente->call("setComprobanteV2012",$setComprobanteV2012);
							$setComprobante = $this->_wsCliente->call("setComprobanteV2012",$setComprobanteV2012);

							$comprobante = 0;

							foreach($setComprobante as $comprobante){
								$comprobante = $comprobante;
							}

							if($this->_wsFault){
								$this->_view->assign("_error","Por favor revice que los datos que se necesitan para facturar estén bien: RFC del cliente y razón social...");
								exit;
							}

								$setComprobante_Detalle = array(
									"IdComprobante"				=> $comprobante, //Requerido
									"NoPartida"					=> "NA", //No Requerido
									"Cantidad"					=> 1, //Requerido
									"Descripcion"				=> $_POST["descripcion"], //Requerido
									"Importe"					=> $subtotal, //Requerido
									"NoIdentificacion"			=> "NA", //No Requerido
									"Unidad"					=> "NA", //Requerido
									"ValorUnitario"				=> $subtotal, //Requerido
									"PedimentoNo"				=> "", //No Requerido
									"PedimentoNombre"			=> "", //No Requerido
									"PedimentoFecha"			=> "", //No Requerido
									"IVA"						=> $iva, //Requerido
									"Notas1"					=> "", //No Requerido
									"Notas2"					=> ""  //No Requerido
								);

								$comprobanteDetalle = $this->_wsCliente->call("setComprobante_Detalle",$setComprobante_Detalle);

							if($this->_wsFault){
								$this->_view->assign("_error","Revise los datos de cada producto a facturar: precio unitario, descripción, unidad de medida e identificación");
								exit;
							}

							$sellaComprobante = array(
								"usuario"=>USER,
								"password"=>PASS,
								"IdComprobante"=>$comprobante
							);

							$sello = $this->_wsCliente->call("sellaComprobante",$sellaComprobante);

							if($sello){
								$this->_view->assign("_error","No se pudo facturar. Intente nuevamente. O espere más tarde. Puede ser conexión del servidor");
							}else{

								$valorDivisa = 1;

								if($moneda_referencia==2){
									$valorDivisa = $datos_referencia["tc_pd"];
								}else if($moneda_referencia==3){
									$valorDivisa = $datos_referencia["tc_pe"];
								}

								$datosEnviar = array(
									"comprobante" => $comprobante,
									"id_referencia" => $referencia,
									"id_cotizacion" => $cotizacion,
									"id_cxc"	=> $id_cxc,
									"concepto" => $concepto,
									"concepto_facturacion" => 2, //Por desglose [1] - Por anticipos [2]
									"tipo_facturacion" => $tipo_facturacion,
									"id_razonsocial"=> $razon_social["id_u_rs"],
									"divisa_referencia" => $moneda_referencia,
									"valor_divisa_referencia" => $valorDivisa,
									"divisa_facturacion" => $moneda,
									"total_factura" => $a_facturar,
									"comentarios_factura" => $this->getSql("comentarios"),
									"estado" => 1,
									"fecha_facturacion" => DATE_NOW,
									"usuario_facturacion" => $_SESSION["id_usuario"]
								);

								$this->_operaciones->crearReporteFacturacion($datosEnviar);



								$this->_view->assign("_mensaje","Se ha generado la factura");

								$datosFactura();

								$datosEnviar = array(
        							"id_u_cotizacion"=>$cotizacion,
        							"estado"=>1
        						);
        						$this->_operaciones->actualizarCotizacion($datosEnviar);
							}
						}
					}
				}

				$this->_view->assign('vista', ROOT . 'modulos' . DS . "operaciones" . DS . "views" . DS . "cot_cxc" . '.tpl');
			}

			if($ruta=="prorrateo"){
				$this->_view->assign('ruta',"prorrateo");
				$this->_view->assign('total_incrementables',$total_incrementables);

				$this->_view->assign('vista', ROOT . 'modulos' . DS . "operaciones" . DS . "views" . DS . "cot_prorrateo" . '.tpl');
			}

			if($ruta=="cotizacion"){
				$this->_view->assign('ruta',"cotizacion");
				$this->_view->setJs(array('pdf_cotizacion'));
				$this->_view->assign("prospectos",$this->_operaciones->getProspectos());

				$datos_referencia["cliente"];


				$this->_view->assign("marcas",$this->_operaciones->getMarcas());
				$this->_view->assign("cxc",$cxc);

				$this->_view->assign("conceptos_cxc",$this->_operaciones->getConceptosCxC());

				$this->_view->assign("datos_referencia",$datos_referencia);

				$colores = array(
					"si000"=>"#7f7f7f",
					"co001"=>"#217c9e",
					"im002"=>"#f19331",
					"ib003"=>"#af1727",
					"pr004"=>"#505050"
				);

				$this->_view->assign("color_caption",$colores[$datos_referencia["id_u_empresa"]]);
				$this->_view->assign("contacto_cliente",$datos_referencia["contacto"]);

				$this->_view->assign("datos_cotizacion",$datos_cotizacion);
				$datos=$this->_operaciones->getReferencia($referencia);
				$this->_view->assign("datos",$datos);
				$this->_view->assign("contactos",$this->_operaciones->getContactoCliente($datos["cliente"]));
				$this->_view->assign("tipos_embalaje",$this->_operaciones->getTiposEmbalaje());
				$this->_view->assign("secciones_aduaneras",$this->_operaciones->getSeccionesAduaneras());
				$this->_view->assign("medios_transporte",$this->_operaciones->getMediosTransporte());
				$this->_view->assign("incoterms",$this->_operaciones->getIncoterms());


				$co = $this->_operaciones->getUsuariosID($datos_referencia['co']);
				$this->_view->assign("co",$co);



				$this->_view->assign('vista', ROOT . 'modulos' . DS . "operaciones" . DS . "views" . DS . "cot_cotizacion" . '.tpl');
			}

			if($ruta=="factura"){

				$datosFactura = function()use($referencia,$cotizacion,$moneda_referencia,$tipos_facturacion,$datos_referencia){

					$this->_view->assign("referencia",$referencia);
					$this->_view->assign("cotizacion",$cotizacion);

					$facturas = $this->_operaciones->getFacturas($cotizacion);

					for($i=0;$i<count($facturas);$i++){
						$monedas = $this->_operaciones->getMonedas();

						foreach($monedas as $moneda){
							if($moneda["id_moneda"]==$facturas[$i]["divisa_referencia"]){
								$facturas[$i]["divisa_referencia"] = $moneda["n_espanol"];
							}

							if($moneda["id_moneda"]==$facturas[$i]["divisa_facturacion"]){
								$facturas[$i]["divisa_facturacion"] = $moneda["n_espanol"];
								$facturas[$i]["signo_divisa"] = $moneda["signo"];
							}
						}

						$usuario_facturacion = $this->_operaciones->getUsuario($facturas[$i]["usuario_facturacion"]);
						$usuario_cancelacion = $this->_operaciones->getUsuario($facturas[$i]["usuario_cancelacion"]);
						$facturas[$i]["usuario_facturacion"] = $usuario_facturacion["nombre"];
						$facturas[$i]["usuario_cancelacion"] = $usuario_cancelacion["nombre"];
					}


					$this->_view->assign("facturas",$facturas);
					$activas = 0;
					$this->_view->assign('formFactura', ROOT . 'componentes/operaciones/formFactura.tpl');

					foreach($facturas as $factura){
						if($factura["estado"]==1){
							$activas = $activas + 1;
						}
					}

					$this->_view->assign("activas",$activas);

					$this->_view->assign('ruta',"factura");
					$this->_view->setJs(array('factura'));
					$this->_view->assign('monedaref',$moneda_referencia);
					$this->_view->assign('tipos_facturacion',$tipos_facturacion);
					$razones_sociales = $this->_operaciones->getRazonesSociales($datos_referencia["cliente"]);
					$this->_view->assign("razones_sociales",$razones_sociales);
				};

				$datosFactura();

				if(isset($_POST["facturar"])==1){

					$tipo_facturacion = $this->getSql("tipos_facturacion");
					$tipo_facturacion = $this->_operaciones->getTipoFactura($tipo_facturacion);

					$tipo_facturacion = $tipo_facturacion["codigo"];

					$rfc_sinergia = $datos_empresa["rfc"];

					$id_razon_social = $this->getSql("id_u_rs");

					$moneda = $this->getSql("moneda_factura");

					$rfc_sinergia = $datos_empresa["rfc"];

					if(WS_TIPO=="prueba"){
								$rfc_sinergia = "CAGE7208162S2";
					}

					$errores="";
					if ($tipo_facturacion=="") {
						$errores.="Seleccione un tipo de facturación";
					}
					if ($id_razon_social=="") {
							if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Seleccione razón social";
					}
					if ($moneda=="") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Debe escoger una moneda";
					}
					if ($errores!="") {
						$this->_view->assign("_error",$errores);
					}else{
						if($this->_wsError){
							$this->_view->assign("_error","Error de conexión con el servidor. Intente más tarde por favor...");
						}else{
							///

							$razon_social = $this->_operaciones->getRazonSocial($id_razon_social);

							$valor1=1;
							if ($moneda_referencia==2) {
								$valor1=$datos_referencia["tc_pd"];
							}
							if ($moneda_referencia==3) {
								$valor1=$datos_referencia["tc_pe"];
							}

							$nombre_moneda = "Pesos";

							$valor2=1;
							if ($moneda==2) {
								$valor2=$datos_referencia["tc_pd"];
								$nombre_moneda = "USD";
							}
							if ($moneda==3) {
								$valor2=$datos_referencia["tc_pe"];
								$nombre_moneda = "Euros";
							}

							//Detalles de la factura

							$subTotalFactura = $this->cambio_divisa($subtotal,$valor1,$valor2);
							$totalFactura = $this->cambio_divisa($total_factura,$valor1,$valor2);
							$ivaTotalFactura = $this->cambio_divisa($iva,$valor1,$valor2);



							$setComprobanteV2012 = array(
							"usuario" 					=> USER, // Requerido
							"password" 					=> PASS, // Requerido
							"Id_SistemaPadre" 			=> "SisFC", // Requerido
							"EdoComprobante" 			=> "1", // Requerido
							"Tipo" 						=> $tipo_facturacion, // Requerido
							"EmRFC" 					=> $rfc_sinergia, // Requerido CAGE7208162S2
							"CondicionesPago" 			=> "NA", // No Requerido
							"FormaPago" 				=> "Pago en parcialidades", // Requerido
							"Descuento" 				=> "", // No Requerido
							"motivoDescuento"			=> "", // No Requerido
							"metodoPago" 				=> "NA", // Requerido
							"subTotal" 					=> $subTotalFactura, // Requerido
							"Total"						=> $totalFactura, // Requerido
							"ReID" 						=> "", // No Requerido //Clave cliente
							"ReNombre" 					=> $razon_social["razon_social"], // Requerido
							"ReRFC" 					=> $razon_social["rfc"], // Requerido
							"ReCalle" 					=> $razon_social["domicilio_fiscal"], // No Requerido
							"ReCodigoPostal" 			=> "", // No Requerido
							"ReColonia" 				=> "", // No Requerido
							"ReEstado" 					=> "", // No Requerido
							"ReLocalidad" 				=> "", // No Requerido
							"ReMunicipio" 				=> "", // No Requerido
							"ReNoExterior" 				=> "", // No Requerido
							"ReNoInterior"				=> "", // No Requerido
							"ReTel" 					=> "", // No Requerido
							"RePais" 					=> $razon_social["pais"], // Requerido
							"ReReferencia" 				=> "", // No Requerido
							"ReCorreo" 					=> "", // No Requerido
							"TotalImpuestosRetenidos" 	=> "", // Requerido
							"TotalImpuestoTransladado" 	=> "", // Requerido
							"RImpuesto" 				=> "IVA", // No Requerido
							"RImporte" 					=> "", // No Requerido
							"TImpuesto" 				=> "IVA", // Requerido
							"TImporte" 					=> $ivaTotalFactura, // Requerido
							"TTasa" 					=> $impuestos_cotizacion["iva_factura"], // Requerido
							"Notas" 					=> $_POST["comentarios"], // No Requerido
							"Moneda" 					=> $nombre_moneda, // No Requerido
							"TipoCambio" 				=> "", // No Requerido
							"Vendedor" 					=> "", // No Requerido
							"OrdCompra" 				=> $referencia, // No Requerido /*Referencia
							"Otros" 					=> "", // No Requerido
							"numCtaPago" 				=> "" // No Requerido
							);

							//$this->_wsCliente->call("setComprobanteV2012",$setComprobanteV2012);
							$setComprobante = $this->_wsCliente->call("setComprobanteV2012",$setComprobanteV2012);

							$comprobante = 0;

							foreach($setComprobante as $comprobante){
								$comprobante = $comprobante;
							}

							if($this->_wsFault){
								$this->_view->assign("_error","Por favor revice que los datos que se necesitan para facturar estén bien: RFC del cliente y razón social...");
								exit;
							}

							foreach($prorrateo as $producto){
								$setComprobante_Detalle = array(
									"IdComprobante"				=> $comprobante, //Requerido
									"NoPartida"					=> "", //No Requerido
									"Cantidad"					=> $producto["cantidad_producto"], //Requerido
									"Descripcion"				=> $producto["producto"], //Requerido
									"Importe"					=> $this->cambio_divisa($producto["monto_nacional"],$valor1,$valor2), //Requerido
									"NoIdentificacion"			=> $producto["sku"], //No Requerido
									"Unidad"					=> $producto["unidad_medida"], //Requerido
									"ValorUnitario"				=> $this->cambio_divisa($producto["precio_u_nacional"],$valor1,$valor2), //Requerido
									"PedimentoNo"				=> "", //No Requerido
									"PedimentoNombre"			=> "", //No Requerido
									"PedimentoFecha"			=> "", //No Requerido
									"IVA"						=> $this->cambio_divisa($producto["iva_unitario"],$valor1,$valor2), //Requerido
									"Notas1"					=> "", //No Requerido
									"Notas2"					=> ""  //No Requerido
								);
								$comprobanteDetalle = $this->_wsCliente->call("setComprobante_Detalle",$setComprobante_Detalle);
							}

							if($this->_wsFault){
								$this->_view->assign("_error","Revise los datos de cada producto a facturar: precio unitario, descripción, unidad de medida e identificación");
							}

							$sellaComprobante = array(
								"usuario"=>USER,
								"password"=>PASS,
								"IdComprobante"=>$comprobante
							);

							$sello = $this->_wsCliente->call("sellaComprobante",$sellaComprobante);

							if($sello){
								$this->_view->assign("_error","No se pudo facturar. Intente nuevamente. O espere más tarde. Puede ser conexión del servidor");
							}else{
								$valorDivisa = 1;

								if($moneda_referencia==2){
									$valorDivisa = $datos_referencia["tc_pd"];
								}else if($moneda_referencia==3){
									$valorDivisa = $datos_referencia["tc_pe"];
								}

								$datosEnviar = array(
									"comprobante" => $comprobante,
									"id_referencia" => $referencia,
									"id_cotizacion" => $cotizacion,
									"concepto_facturacion" => 1, //Por desglose [1] - Por anticipos [2]
									"tipo_facturacion" => $tipo_facturacion,
									"id_razonsocial"=> $id_razon_social,
									"divisa_referencia" => $moneda_referencia,
									"valor_divisa_referencia" => $valorDivisa,
									"divisa_facturacion" => $moneda,
									"subtotal_factura" => $subTotalFactura,
									"iva_factura" => $ivaTotalFactura,
									"total_factura" => $totalFactura,
									"comentarios_factura" => $this->getSql("comentarios"),
									"estado" => 1,
									"fecha_facturacion" => DATE_NOW,
									"usuario_facturacion" => $_SESSION["id_usuario"]
								);

								$this->_operaciones->crearReporteFacturacion($datosEnviar);

								$this->_view->assign("_mensaje","Se ha generado la factura");
								$this->_view->assign("facturado",0);

								$datosFactura();
								$this->_view->assign('vista', ROOT . 'modulos' . DS . "operaciones" . DS . "views" . DS . "factura.tpl");
							}
						}
					}
				}
					$this->_view->assign('vista', ROOT . 'modulos' . DS . "operaciones" . DS . "views" . DS . "factura.tpl");
			}

			$this->_view->renderizar('perfil_cotizacion',"operaciones");
		}

		public function crear_cotizacion($id=false)
		{
		    $this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('operaciones');
				exit();
			}
			$this->_view->assign("referencia",$id);
			$this->_view->setJs(array('cotizacion'));
			$this->_view->assign('titulo','Crear cotización');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "operaciones/perfil_referencia/".$id
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("incoterms",$this->_operaciones->getIncoterms());
			$this->_view->assign("tipos_embalaje",$this->_operaciones->getTiposEmbalaje());
			$this->_view->assign("tipos_operacion",$this->_operaciones->getOperaciones());
			$this->_view->assign("secciones_aduaneras",$this->_operaciones->getSeccionesAduaneras());
			$this->_view->assign("medios_transporte",$this->_operaciones->getMediosTransporte());

			$tipos_facturacion = $this->_operaciones->getTiposFacturacion();

			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$vigencia=$this->getSql("vigencia");
				$incoterm=$this->getSql("incoterm");
				$tipo_embalaje=$this->getSql("tipo_embalaje");
				$cantidad_embalaje=$this->getInt("cantidad_embalaje");
				$operacion=$this->getSql("operacion");
				$seccion_aduanera=$this->getSql("seccion_aduanera");
				$medio_transporte=$this->getSql("medio_transporte");
				$dias_previos=$this->getInt("dias_previos");
				$cantidad_transferencias=$this->getFloat("cantidad_transferencias");
				$cantidad_pedimentos=$this->getInt("cantidad_pedimentos");
				$mercancia=$this->getSql("mercancia");
				$seguro=$this->getFloat("seguro");
				$min_seguro=$this->getFloat("min_seguro");
				$hon_agente=$this->getFloat("hon_agente");
				$hon_agente_plus=$this->getFloat("hon_agente_plus");
				$hon_cia=$this->getFloat("hon_cia");
				$hon_cia_plus=$this->getFloat("hon_cia_plus");
				$observaciones=$this->getSql("observaciones");
				$this->getLibrary('dateUtils');
				$dateUtils = new dateUtils();
				$errores="";
				if (count($dateUtils->formatearFecha($vigencia))==0) {
					$errores="La vigencia es incorrecta";
				}
				if ($incoterm=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el incoterm";
				}
				if ($tipo_embalaje=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el tipo de enbalaje";
				}
				if ($cantidad_embalaje<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la cantidad de embalaje";
				}
				if ($operacion=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Selecione la operacion";
				}
				if ($seccion_aduanera=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Selecione la seccion aduanere";
				}
				if ($medio_transporte=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Selecione el medio de transporte";
				}
				if ($dias_previos<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la cantidad de dias previos";
				}
				if ($cantidad_transferencias<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la cantidad de transferencias";
				}
				if ($cantidad_pedimentos<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la cantidad de pedimentos";
				}
				if ($mercancia=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la mercancia";
				}
				if ($seguro<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el valor del seguro";
				}
				if ($min_seguro<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el valor minimo de seguro";
				}
				if ($hon_agente<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese los honorarios del agente aduanal";
				}
				if ($hon_agente_plus<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese los honorarios del agente aduanal +";
				}
				if ($hon_cia<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese los honorarios CIA";
				}
				if ($hon_cia_plus<0) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese los honorarios CIA +";
				}
				if ($observaciones=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Las observaciones están vacías";
				}

				if ($errores!="") {
					$this->_view->assign("_error",$errores);

					$ordenes=$this->_operaciones->getOrdenes($id);
					$dataordenes= array();
					foreach ($ordenes as $orden) {
						$suma=0;
						$total = 0;
						$resultado=$this->_operaciones->getProductos($orden["id_u_orden"]);
						foreach ( $resultado as $resu) {
							$suma=$resu["cantidad"]*$resu["precio"];
							$total += $suma;
						}

						$dataordenes[]=array(
							"id_u_orden"=>$orden["id_u_orden"],
							"proveedor"=>$orden["proveedor"],
							"numero_factura"=>$orden["numero_factura"],
							"total"=>$total
							);
					}
					$this->_view->assign("ordenes",$dataordenes);

					$this->_view->renderizar('crear_cotizacion');
					exit;
				}
				$datosEnviar = array(
					"id_u_cotizacion"=>"dummy",
					"id_u_referencia"=>$id ,
					"fecha_creacion"=>Date("d/m/Y") ,
					"vigencia"=>$vigencia ,
					"incoterm"=>$incoterm ,
					"tipo_embalaje"=>$tipo_embalaje ,
					"cantidad_embalaje"=>$cantidad_embalaje ,
					"operacion"=>$operacion ,
					"seccion_aduanera"=>$seccion_aduanera ,
					"medio_transporte"=>$medio_transporte ,
					"dias_previos"=>$dias_previos,
					"cantidad_transferencias"=>$cantidad_transferencias ,
					"cantidad_pedimentos"=>$cantidad_pedimentos ,
					"mercancia"=>$mercancia ,
					"seguro"=>$seguro ,
					"min_seguro"=>$min_seguro ,
					"hon_agente"=>$hon_agente ,
					"hon_agente_plus"=>$hon_agente_plus ,
					"hon_cia"=>$hon_cia ,
					"hon_cia_plus"=>$hon_cia_plus,
					"observaciones"=>$observaciones
				);
				$this->_operaciones->crearCotizacion($datosEnviar);

				$resul = $this->_operaciones->getReferencia($id);
				//$id_u=$this->_operaciones->getUsuario_sisfcId(Session::get('id_usuario'));
				if (count($resul)>1) {
					$contador=$resul["contador_cotizacion"];
					if ($contador=="") {
						$contador=0;
					}
					$datosEnviar = array(
						"id_u_referencia"=>$id,
						"contador_cotizacion"=>($resul["contador_cotizacion"]+1)
					);
					$this->_operaciones->actualizarReferencia($datosEnviar);
					$id_c = $this->_operaciones->ultimoCotizacion();
					$id_cotizacionG=$id."-COT-00".($contador+1);
					$datosEnviar = array(
							"id_cotizacion"=>$id_c["id_cotizacion"],
							"id_u_cotizacion"=>$id_cotizacionG
						);
					$this->_operaciones->actualizarCotizacion($datosEnviar);
					$values = array_keys($_POST);
					for ($i=0; $i < count($values) ; $i++) {
						if (substr($values[$i],0,6)=='orden_') {
							if ($_POST[$values[$i]]) {
								$datosEnviar = array(
									"id_u_cotizacion"=>$id_cotizacionG,
									"id_u_orden"=>substr($values[$i],6, strlen($values[$i])-5)
								);
								$this->_operaciones->crearCotizacionOrdenes($datosEnviar);

							}
						}
					}
					$this->_view->assign("_mensaje","La cotizacion ha sido creada " . $contador);
					$this->redireccionar('operaciones/perfil_cotizacion/'.$id."/". $id_cotizacionG ."/datos");
					exit();
					}
			}
			$ordenes=$this->_operaciones->getOrdenes($id);
			$dataordenes= array();
			foreach ($ordenes as $orden) {
				$suma=0;
				$total = 0;
				$resultado=$this->_operaciones->getProductos($orden["id_u_orden"]);
				foreach ( $resultado as $resu) {
					$suma=$resu["cantidad"]*$resu["precio"];
					$total += $suma;
				}

				$dataordenes[]=array(
					"id_u_orden"=>$orden["id_u_orden"],
					"proveedor"=>$orden["proveedor"],
					"numero_factura"=>$orden["numero_factura"],
					"total"=>$total
					);
			}
			$this->_view->assign("ordenes",$dataordenes);
			$this->_view->renderizar('crear_cotizacion');
		}

		public function getEmpresas()
		{
		    //$this->_acl->acceso('todo');
			//$id=$this->getTexto("id");
			//if ($id!="") {
			echo json_encode($this->_operaciones->getMarcas());
			//}
		}

		public function getLeads()
		{
		    //$this->_acl->acceso('todo');
			//$id=$this->getTexto("id");
			//if ($id!="") {
				echo json_encode($this->_operaciones->getLeads());
			//}
		}


		public function getContactoCliente()
		{
		    $this->_acl->acceso('todo');
			$id=$this->getTexto("id");
			if ($id!="") {
				echo json_encode($this->_operaciones->getContactoCliente($id));
			}
		}

		public function getProductos()
		{
		    $this->_acl->acceso('todo');
			$id=$this->getTexto("id");
			if ($id!="") {
				echo json_encode($this->_operaciones->getProductosProveedor($id));
			}
		}

		public function pdf_cotizacion(){
		    $this->_acl->acceso('todo');
			$pdf=$this->$_POST["pdf"];
			if ($pdf!="") {
				$codigo = utf8_decode("PDF");
				$this->_pdf->load_html($codigo);
				ini_set("memory_limit","32M");
				$this->_pdf->render();
				$this->_pdf->stream("unPDF.pdf");
			}
		}

		public function guardarOrdenC(){
		    $this->_acl->acceso('todo');
			$refe=$this->getSql("refe");
			$prov=$this->getSql("prov");
			$num=$this->getSql("num");
			if ($refe!="" && $prov!="" && $num!=""){
				$resul = $this->_operaciones->getReferencia($refe);
				$id_u=$this->_operaciones->getUsuario_sisfcId(Session::get('id_usuario'));
				if (count($resul)>1) {
					$contador=$resul["contador_orden"];
					$orden = $refe . "-OC-00" . ($contador);
					$datosEnviar = array(
						"id_u_referencia"=>$refe,
						"contador_orden"=>($resul["contador_orden"]+1)
					);
					$this->_operaciones->actualizarReferencia($datosEnviar);
					$datosEnviar = array(
						"id_u_referencia"=>$refe,
						"id_u_orden"=>$orden,
						"id_u_proveedor"=>$prov ,
						"numero_factura"=>$num,
						"fecha_creacion"=>Date("d/m/Y"),
						"creador"=>$id_u["id_u_usuario"]
					);
					$this->_operaciones->crearOrden($datosEnviar);
					echo json_encode($orden);
				}
			}
		}
		public function guardarProducto(){
		    $this->_acl->acceso('todo');
			$refe=$this->getSql("refe");
			$prov=$this->getSql("prov");
			$num=$this->getSql("num");
			$prod=$this->getSql("prod");
			$cant=$this->getInt("cant");
			$prec=$this->getFloat("prec");
			if ($refe!="" && $prov!="" && $num!="" && $prod!="" && $cant>=0 && $prec>=0) {
				$resul = $this->_operaciones->getReferencia($refe);
				$id_u=$this->_operaciones->getUsuario_sisfcId(Session::get('id_usuario'));
				if (count($resul)>1) {
					$contador=$resul["contador_orden"];
					if ($contador=="") {
						$contador=0;
					}
					$orden = $refe . "-OC-00" . ($contador);
					$datosEnviar = array(
						"id_u_orden"=>$orden,
						"id_u_proveedor"=>$prov ,
						"id_u_producto"=>$prod,
						"cantidad"=>$cant,
						"precio"=>$prec,
						"total"=>($cant*$prec),
						"fecha_creacion"=>Date("d/m/Y"),
						"creador"=>$id_u["id_u_usuario"]
					);
					$this->_operaciones->crearProducto($datosEnviar);
					echo json_encode("listo");
				}
			}else{
				echo json_encode("Pailas");
			}
		}
		public function eliminarOrdenProducto(){
		    $this->_acl->acceso('todo');
			$id=$this->getSql("id");
			if ($id!=""){
				$this->_operaciones->eliminarOrdenProducto($id);
				echo json_encode("listo");
			}
		}
		public function eliminarGastosCotizaciones(){
		    $this->_acl->acceso('todo');
			$id=$this->getSql("id");
			if ($id!=""){
				$this->_operaciones->eliminarGastosCotizacionesM($id);
			}
		}
		public function actualizarGastosCotizaciones(){
		    $this->_acl->acceso('todo');
			$id=$this->getSql("id");
			$id_gasto=$this->getSql("id_gasto");
			$valor=$this->getSql("valor");
			if ($id!="" && $id_gasto!="" && $valor!=""){
				$datosEnviar = array(
						"id_gasto_referencia"=>$id,
						"id_gasto"=>$id_gasto ,
						"valor"=>$valor
					);
				$this->_operaciones->actualizarGastosCotizacionesM($datosEnviar);
			}
		}
		public function eliminarIncreCotizaciones(){
		    $this->_acl->acceso('todo');
			$id=$this->getSql("id");
			if ($id!=""){
				$this->_operaciones->eliminarIncreCotizacionesM($id);
			}
		}
		public function actualizarIncreCotizaciones(){
		    $this->_acl->acceso('todo');
			$id=$this->getSql("id");
			$id_incre=$this->getSql("id_incre");
			$valor=$this->getSql("valor");
			if ($id!="" && $id_incre!="" && $valor!=""){
				$datosEnviar = array(
						"id_incrementables_referencia"=>$id,
						"id_incrementable"=>$id_incre ,
						"valor"=>$valor
					);
				$this->_operaciones->actualizarIncreCotizaciones($datosEnviar);
			}
		}
		public function actualizarImpuestosGenrales(){
		    $this->_acl->acceso('todo');
			$id=$this->getSql("id");
			$prv=$this->getFloat("prv");
			$dta=$this->getFloat("dta");
			$dta_porcentaje=$this->getFloat("dta_porcentaje");
			$iva_factura=$this->getFloat("iva_factura");
			if ($id!="" && $prv>=0 && $dta>=0 & $dta_porcentaje>=0 & $iva_factura>=0) {
				$resul= $this->_operaciones->getImpuestosCotizacion($id);
				$datosEnviar = array(
					"id_u_cotizacion"=>$id,
					"prv"=>$prv,
					"dta"=>$dta,
					"dta_porcentaje"=>$dta_porcentaje,
					"iva_factura"=>$iva_factura
				);
				if (count($resul)==1) {
					$this->_operaciones->crearImpuestosCotizacion($datosEnviar);
					echo json_encode("Impuestos generales guardados");
				}else{
					$this->_operaciones->actualizarImpuestosCotizacion($datosEnviar);
					echo json_encode("Impuestos generales actualizados");
				}
			}else{
				echo json_encode("Error, algun dato es incorrecto");
			}
		}
		public function actualizarOrdProd(){
		    $this->_acl->acceso('todo');
			$id=$this->getSql("id");
			$igi=$this->getFloat("igi");
			$iva_aduanal=$this->getFloat("iva_aduanal");
			if ($id!="" && $igi>=0 && $iva_aduanal>=0) {
				$datosEnviar = array(
						"id_orden_producto"=>$id,
						"igi"=>$igi ,
						"iva_aduanal"=>$iva_aduanal
					);
				$this->_operaciones->actualizarOrdProdM($datosEnviar);
			}
		}
		public function eliminarCxC(){
		    $this->_acl->acceso('todo');
			$id=$this->getSql("id");
			if ($id!=""){
				$this->_operaciones->eliminarCxCM($id);
			}
		}
		public function actualizarCxC(){
		    $this->_acl->acceso('todo');
			$id = $this->getSql("id");
            $fecha=$this->getSql("fecha");
            $monto=$this->getSql("monto");
            $montoA=$this->getSql("montoA");
            $mone=$this->getSql("mone");
            $concep=$this->getSql("concep");
            if ($id!="" && $fecha!="" && $monto!="" && $montoA!="" && $mone!="" && $concep!=""){

            	$datosEnviar = array(
					"id"=>$id,
					"fecha"=>$fecha,
					"monto_depositado"=>$monto,
					"monto_aplicable"=>$montoA,
					"moneda"=>$mone,
					"concepto"=>$concep
				);
				$this->_operaciones->actualizarCxCM($datosEnviar);
			}
		}

		private function cambio_divisa($valor,$divisa_de_valor,$divisa_a_convertir){
			return $valor * $divisa_de_valor / $divisa_a_convertir;
		}
		public function eliminarCotizacion(){
		    $this->_acl->acceso('todo');
			$id=$this->getSql("id");
			if ($id!=""){
				$this->_operaciones->eliminarCxCCotizacion($id);
				$this->_operaciones->eliminarImpuestosCotizacion($id);
				$this->_operaciones->eliminarGastosCotizacion($id);
				$this->_operaciones->eliminarIncrementablesCotizacion($id);
				$this->_operaciones->eliminarCotizacionesCotizacion($id);
				$this->_operaciones->eliminarCotizacionesOrdenesCotizacion($id);
			}
		}
		public function eliminarOrden(){
		    $this->_acl->acceso('todo');
			$id=$this->getSql("id");
			if ($id!=""){
				$this->_operaciones->eliminarOrdenesProductosOrdenes($id);
				$this->_operaciones->eliminarCotizacionesOrdenesOrdenes($id);
				$this->_operaciones->eliminarProductosOrdenes($id);
			}
		}

		public function eliminarReferencia(){
		    $this->_acl->acceso('todo');
			$id=$this->getSql("id");
			if ($id!=""){
			    $ordenes=$this->_operaciones->getOrdenesCotizacion($id);
			    $cotizaciones=$this->_operaciones->getCotizaciones($id);
			    foreach($ordenes as $orden){
			        $this->_operaciones->eliminarOrdenesProductosOrdenes($orden["id_u_orden"]);
    				$this->_operaciones->eliminarCotizacionesOrdenesOrdenes($orden["id_u_orden"]);
    				$this->_operaciones->eliminarProductosOrdenes($orden["id_u_orden"]);
			    }
			    foreach($cotizaciones as $cotizacion){
			        $this->_operaciones->eliminarCxCCotizacion($cotizacion["id_u_cotizacion"]);
    				$this->_operaciones->eliminarImpuestosCotizacion($cotizacion["id_u_cotizacion"]);
    				$this->_operaciones->eliminarGastosCotizacion($cotizacion["id_u_cotizacion"]);
    				$this->_operaciones->eliminarIncrementablesCotizacion($cotizacion["id_u_cotizacion"]);
    				$this->_operaciones->eliminarCotizacionesCotizacion($cotizacion["id_u_cotizacion"]);
    				$this->_operaciones->eliminarCotizacionesOrdenesCotizacion($cotizacion["id_u_cotizacion"]);
			    }
				$this->_operaciones->eliminarRefereciaAll($id);
			}
		}

		public function embudo(){
		    $this->_view->assign('titulo','Embudo de operaciones');
				$btnHeader = array(

					array(
						"titulo" => "return",
						"enlace" => "operaciones"
					)
				);
				$this->_view->assign("btnHeader",$btnHeader);
		    $empresas = $this->_operaciones->getEmpresasReal();
		    $this->_view->assign("empresas",$empresas);
		    $estatus = $this->_operaciones->getStatus();
		    $this->_view->assign("status",$estatus);


		    $statusReferencias = array();
		    $total = 0;

		    foreach($estatus as $st){

		    	$datos = array();
		    	$porcentaje = 0;
		    	foreach($empresas as $empresa){
		    		$cantidad = count($this->_operaciones->getReferenciasStatus($empresa['id_u_empresa'],$st["id"]));
		    		$porcentaje += $cantidad;
		    		$datos [] = array(
		    			"empresa" => $empresa['id_u_empresa'],
		    			"status" => $st["id"],
		    			"cantidad" => $cantidad
		    		);
		    	}

		    	$statusReferencias [] = array(
		    		"estatus" => $st["nombre"],
		    		"codigo_estatus" => $st["id"],
		    		"datos" => $datos,
		    		"porcentaje" => $porcentaje
		    	);
		    	$total = $total + $porcentaje;

		    }

		    $this->_view->assign("statusReferencias",$statusReferencias);
		    $this->_view->assign("total",$total);

		    $this->_view->renderizar('embudo',"operaciones");
		}

		public function embudo_status($id){
			$this->_view->assign('titulo','Operaciones por:');
			$datos = $this->_operaciones->getEmpresas();
			$this->_view->assign("datos",$datos);
			$this->_view->assign("datos2",$this->_operaciones->getReferencias($id));
			$this->_view->renderizar('embudo_status');
		}


		public function elegirCotizacion(){
		    $this->_acl->acceso('todo');
			$id=$this->getSql("id");
			if ($id!=""){
			    $datosEnviar = array(
					"id_u_cotizacion"=>$id,
					"estado"=>1
				);
				$this->_operaciones->actualizarCotizacion($datosEnviar);
			}
		}

		public function cambiarEstatus(){

			$datosEnviar = array(
				"id_u_referencia" => $this->getSql("id"),
				"status" =>$this->getSql("est")
			);

			$this->_operaciones->actualizarEstatus($datosEnviar);
		}

		public function saberRazonSocial(){
			echo json_encode($this->_operaciones->getRazonSocial($this->getSql("id")));
		}

		public function cancelarFactura(){

			if(isset($_POST["cancelar"])==1){

				$referencia = $this->getSql("referencia");
				$cotizacion = $this->getSql("cotizacion");
				$comprobante = $this->getSql("comprobante");
				$ruta = $this->getSql("ruta");

				$datosEnviar = array(
					"comprobante" => $comprobante,
					"estado" => 0,
					"fecha_cancelacion" => DATE_NOW,
					"usuario_cancelacion" => $_SESSION["id_usuario"]
				);

				$cancelaComprobante = array(
					"usuario"=>USER,
					"password"=>PASS,
					"IdComprobante"=>$comprobante
				);

				$cancelar_comprobante = $this->_wsCliente->call("Cancela_Comprobante",$cancelaComprobante);
				$cancelado = $this->_operaciones->getCancelarFactura($datosEnviar);



				$this->redireccionar("operaciones/perfil_cotizacion/".$referencia."/".$cotizacion."/".$ruta);

				exit();
			}

			$this->redireccionar("operaciones");
		}

		public function enviarMailFactura(){
			if(isset($_POST["enviar"])==1){
				$referencia = $this->getSql("referencia");
				$cotizacion = $this->getSql("cotizacion");
				$comprobante = $this->getSql("comprobante");

				$ruta = $this->getSql("ruta");

				$correos = $this->getSql("correos");
				$correos = explode(",",$correos);

				foreach($correos as $correo=>$key){

					$sendCorreo = array(
						"usuario"=>USER,
						"password"=>PASS,
						"IdComprobante"=>$comprobante,
						"mail" => $key
					);

					$enviarCorreo = $this->_wsCliente->call("Send_Correo",$sendCorreo);
				}

				$this->redireccionar("operaciones/perfil_cotizacion/".$referencia."/".$cotizacion."/".$ruta);
				exit();
			}

			$this->redireccionar("operaciones");
		}

	}
?>
