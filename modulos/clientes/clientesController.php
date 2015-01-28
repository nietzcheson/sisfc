<?php
	class clientesController extends Controller{
		private $_clientes;
		public function __construct(){
			parent::__construct();
			//$this->_view->setTemplate("secs");
			$this->_acl->acceso('todo');
			$this->_clientes = $this->loadModel('clientes');
		}
		public function index(){
			$this->_view->setTemplate("responsive");
			$this->_view->assign('titulo','Clientes');
			$btnHeader = array(
				array(
					"titulo" => "Crear cliente",
					"enlace" => "clientes/crear_cliente"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_clientes->getClientes());
			$this->_view->renderizar('index',"clientes");
		}
		public function clasificacion_clientes(){
		    $this->_acl->acceso('todo');
			$this->_view->assign('titulo','Clasificación proveedores');
			$this->_view->setJs(array('proveedores'));
			$this->_view->assign("datos",$this->_clientes->getClasiProveedores());
			$this->_view->renderizar('clasificacion',"clientes");
		}
		public function eliminarCliente(){
		    $this->_acl->acceso('todo');
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_clientes->eliminarMarca($id);
				$this->_clientes->eliminarMarcaClientes($id);
				$this->_clientes->eliminarMarcaSociales($id);
			}
		}
		public function perfil_cliente($id=false,$activo=1){
		    $this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('secs');
				exit();
			}


			$this->_view->setJs(array('ajax'));
			$this->_view->assign('titulo','Perfil cliente');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "clientes"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("activo",$activo);
			$this->_view->assign("identifica",$id);

			//$this->_view->assign("referencias",$this->_clientes->getReferencias($id));

			if ($this->getInt('actualizar1')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$estado = $this->getSql("estado");
				$nombre_marca = $this->getSql("nombre_marca");
				$email = $this->getSql("email");
				$web = $this->getSql("web");
				$telefono1 = $this->getSql("telefono1");
				$telefono2 = $this->getSql("telefono2");
				$facebook = $this->getSql("facebook");
				$twitter = $this->getSql("twitter");
				$observaciones = $this->getSql("observaciones");

				$errores="";
				if ($estado=="x") {
					$errores="Seleccione el estado";
				}
				if ($nombre_marca=="") {
					$errores="Ingrese el nombre";
				}
				if (!$this->validarEmail($email)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="El email es invalido";
				}
				if ($telefono1=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese un numero telefonico";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('perfil_cliente',"clientes");
					exit;
				}
				$datosEnviar = array(
					"id" => $id,
					"estado" => $estado,
					"email" => $email,
					"cliente" => $nombre_marca,
					"web" => $web,
					"telefono1" => $telefono1,
					"telefono2" => $telefono2,
					"facebook" => $facebook,
					"twitter" => $twitter,
					"observaciones" => $observaciones
				);
				$this->_clientes->actualizarMarca($datosEnviar);
				// nombre_marca
				// email

				// web
				// telefono1
				// telefono2
				// facebook
				// twitter
				// observaciones

				$this->_view->assign("_mensaje","Informacion comercial del cliente ha sido actualizado");
			}


			/**
				Estados de cuenta
			*/

			$totalFactura_cliente = 0;
			$totalMercancia_cliente = 0;
			$totalDespacho_cliente = 0;

			$this->getLibrary('Prorrateo/prorrateo.class');
			$prorrateo = new Porrateo();

			$operaciones = $this->_clientes->getEstadosDeCuenta($id);
			// for($i=0;$i<count($operaciones);$i++){
			// 	$prorrateo = new Porrateo();
			// 	$prorrateo->setID($operaciones[$i]["id_u_cotizacion"]);
			// 	$prorrateo->prorratear();
			//
			// 	$cxcCotizacion = $this->_clientes->getCxCCotizacion($operaciones[$i]["id_u_cotizacion"]);
			// 	$abonos = 0;
			// 	$saldoMercancia = 0;
			// 	$saldoDespacho = 0;
			//
			// 	$valor1=1;
			// 	if ($operaciones[$i]["moneda"]==2) {
			// 		$valor1 = $operaciones[$i]["tc_pd"];
			// 	}
			// 	if ($operaciones[$i]["moneda"]==3) {
			// 		$valor1 = $operaciones[$i]["tc_pe"];
			// 	}
			//
			//
			// 	foreach($cxcCotizacion as $cxc){
			// 		$valor2=1;
			// 		if ($cxc["moneda"] == 2) {
			// 			$valor2 = $operaciones[$i]["tc_pd"];
			// 		}
			// 		if ($cxc["moneda"] == 3) {
			// 			$valor2 = $operaciones[$i]["tc_pe"];
			// 		}
			//
			// 		if($cxc["concepto"]==1 || $cxc["concepto"]==7 || $cxc["concepto"]==10){
			// 			$cambioDeDivisa = $this->cambio_divisa($cxc["monto_aplicable"],$valor2,$valor1);
			// 			$saldoMercancia += $cambioDeDivisa;
			// 		}else{
			// 			$cambioDeDivisa = $this->cambio_divisa($cxc["monto_aplicable"],$valor2,$valor1);
			// 			$saldoDespacho += $cambioDeDivisa;
			// 		}
			// 		$abonos += $cxc["monto_aplicable"];
			// 	}
			//
			// 	$operaciones[$i]["saldo_mercancia"] = $prorrateo->valorFactura() - $saldoMercancia;
			// 	$operaciones[$i]["saldo_despacho"] = ($prorrateo->totalFactura() - $prorrateo->valorFactura()) - $saldoDespacho;
			// 	$operaciones[$i]["saldo_total"] = $prorrateo->totalFactura() - ($operaciones[$i]["saldo_mercancia"] + $operaciones[$i]["saldo_despacho"]);
			//
			// 	$totalFactura_cliente += $prorrateo->totalFactura();
			// 	$totalMercancia_cliente += $operaciones[$i]["saldo_mercancia"];
			// 	$totalDespacho_cliente += $operaciones[$i]["saldo_despacho"];
			//
			// 	$operaciones[$i]["totalFactura"] = $prorrateo->totalFactura();
			// }

			$this->_view->assign("operaciones",$operaciones);
			$this->_view->assign("totalFactura_cliente",$totalFactura_cliente);
			$this->_view->assign("totalMercancia_cliente",$totalMercancia_cliente);
			$this->_view->assign("totalDespacho_cliente",$totalDespacho_cliente);

			$this->_view->assign("datos",$this->_clientes->getMarca($id));
			$this->_view->assign("datos2",$this->_clientes->getMarcaCliente($id));
			$this->_view->assign("razones_sociales",$this->_clientes->getMarcaRazones($id));
			$this->_view->assign("tipos_personas",$this->_clientes->getTipoPersona());
			$this->_view->renderizar('perfil_cliente',"clientes");
		}
		public function crear_cliente(){
		    $this->_acl->acceso('todo');
			$this->_view->assign('titulo','Crear cliente');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "clientes"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array("ajax"));


			$this->_view->assign("leads",$this->_clientes->getLeads());
			$this->_view->assign("tipos",$this->_clientes->getTipoPersona());
			$this->_view->assign("paises",$this->_clientes->getPaises());
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);

				$nombre_marca = $this->getSql("nombre_marca");
				$id_u_prospecto = $this->getSql("id_u_prospecto");
				$tipo_persona = $this->getSql("tipo_persona");
				$razon_social = $this->getSql("razon_social");
				$rfc = $this->getSql("rfc");
				$email = $this->getSql("email");
				$domicilio_fiscal = $this->getSql("domicilio_fiscal");
				$calle = $this->getSql("calle");
				$n_externo = $this->getSql("n_externo");
				$n_externo = $this->getSql("n_externo");
				$n_interno = $this->getSql("n_interno");
				$pais = $this->getSql("pais");
				$estado = $this->getSql("estado");
				$municipio = $this->getSql("municipio");
				$ciudad = $this->getSql("ciudad");
				$colonia = $this->getSql("colonia");
				$cp = $this->getSql("cp");

				$errores="";
				if ($nombre_marca=="") {
					$errores="Ingrese el nombre del proveedor";
				}
				if ($id_u_prospecto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el lead";
				}
				if ($tipo_persona=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el tipo de persona";
				}
				if ($razon_social=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la razon social";
				}
				if ($rfc=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el RFC";
				}
				if (!$this->validarEmail($email)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="El email es incorrecto";
				}
				if ($domicilio_fiscal=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el domicilio fiscal";
				}
				if ($calle=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la calle";
				}
				if ($n_externo=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el numero externo";
				}
				if ($n_interno=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el numero interno";
				}
				if ($pais=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Selecione el pais";
				}
				if ($estado=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el estado";
				}
				if ($municipio=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el municipio";
				}
				if ($ciudad=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la ciudad";
				}
				if ($colonia=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la colonia";
				}
				if ($cp=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el codigo postal";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_cliente',"clientes");
					exit;
				}

				//tabla marcas
				$datosEnviar = array(
						"id_u_marca" => "dummy",
						"nombre_marca" => $nombre_marca,
						"fecha_creacion" => Date("d/m/Y"),
						"email" => $email
					);

				$this->_clientes->crearMarca($datosEnviar);
				$id = $this->_clientes->ultimoMarca();
				$id_u_marca = strtoupper(substr($id["nombre_marca"],0,2)).$id["id_marca"];
				$datosEnviar = array(
						"id_marca"=>$id["id_marca"],
						"id_u_marca"=> $id_u_marca
					);

				$this->_clientes->actualizarMarca($datosEnviar);

				$operaciones = $this->_clientes->getOperaciones($id_u_prospecto);

				if(isset($operaciones) && count($operaciones)){
					$this->_clientes->actualizarOperaciones($id_u_marca,$id_u_prospecto);
				}

				//tabla marcas_clientes
				$datosEnviar = array(
						"id_u_marca" => $id_u_marca,
						"id_u_cliente" => $id_u_prospecto,
						"fecha_creacion" => Date("D/M/Y")
					);
				$this->_clientes->crearMarcaClientes($datosEnviar);

				//tabla razones_sociales
				$datosEnviar = array(
						"id_u_rs" => "dummy",
						"id_u_prospecto" => $id_u_prospecto,
						"fecha_creacion" => Date("D/M/Y"),
						"tipo_persona" => $tipo_persona,
						"razon_social" => $nombre_marca,
						"rfc" =>$rfc,
						"email" =>$email,
						"domicilio_fiscal" =>$domicilio_fiscal,
						"calle" =>$calle,
						"n_externo" =>$n_externo,
						"n_interno" =>$n_interno,
						"pais" =>$pais,
						"estado" =>$estado,
						"municipio" =>$municipio,
						"ciudad" =>$ciudad,
						"colonia" =>$colonia,
						"cp" =>$cp
					);
				$this->_clientes->crearRazonesSociales($datosEnviar);
				$id_u= $this->_clientes->ultimoRazonS();
				$id_u_rs = strtoupper(substr($id_u["razon_social"],0,2)).$id_u["id_razon_s"];
				$datosEnviar = array(
						"id_razon_s"=>$id_u["id_razon_s"],
						"id_u_rs"=> $id_u_rs
					);
				$this->_clientes->actualizarRazonS($datosEnviar);

				//tabla marcas_razones
				$datosEnviar = array(
						"id_u_marca" => $id_u_marca,
						"id_u_rs" => $id_u_rs,
						"fecha_creacion" => Date("D/M/Y")
					);
				$this->_clientes->crearMarcaRazones($datosEnviar);

				$this->redireccionar('clientes');
				exit;
			}
			$this->_view->renderizar('crear_cliente',"clientes");
		}
		public function perfil_contacto($retunr=false,$id=false){
		    $this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('clientes');
				exit();
			}
			if(!$retunr){
				$this->redireccionar('clientes');
				exit();
			}
			$this->_view->assign('titulo','Contacto del cliente');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "clientes/perfil_cliente/" .$retunr
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);

			$this->_view->assign("paises",$this->_clientes->getPaises());
			$this->_view->assign("datos",$this->_clientes->getProspecto($id));
			$this->_view->assign("identifica",$retunr);
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);

				$nombre_prospecto= $this->getSql("nombre_prospecto");
				$apellido_prospecto= $this->getSql("apellido_prospecto");
				$telefono_prospecto= $this->getSql("telefono_prospecto");
				$celular_prospecto= $this->getSql("celular_prospecto");
				$email_prospecto= $this->getSql("email_prospecto");
				$pais_prospecto= $this->getSql("pais_prospecto");
				$estado_prospecto= $this->getSql("estado_prospecto");
				$ciudad_prospecto= $this->getSql("ciudad_prospecto");

				$errores="";
				if ($nombre_prospecto=="") {
					$errores="Ingrese el nombre del contacto";
				}
				if ($apellido_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el apellido del contacto";
				}
				if ($telefono_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el telefono del contacto";
				}
				if ($celular_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el celular del contacto";
				}
				if (!$this->validarEmail($email_prospecto)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="El email es invalido";
				}
				if ($pais_prospecto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Selecione el pais";
				}
				if ($estado_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la estado del contacto";
				}
				if ($ciudad_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la ciudad del contacto";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_contacto',"clientes");
					exit;
				}
				$id_u=$this->_clientes->getUsuario_sisfcId(Session::get('id_usuario'));
				$datosEnviar = array(
					"id_u_prospecto"=>$id,
					"nombre_prospecto"=>$nombre_prospecto,
					"apellido_prospecto"=>$apellido_prospecto,
					"telefono_prospecto"=>$telefono_prospecto,
					"celular_prospecto"=>$celular_prospecto,
					"email_prospecto"=>$email_prospecto,
					"pais_prospecto"=>$pais_prospecto,
					"estado_prospecto"=>$estado_prospecto,
					"ciudad_prospecto"=>$ciudad_prospecto,
					"fecha_actualizacion" => Date("D/M/Y"),
					"actualizador" => $id_u["id_u_usuario"]
				);

				$this->_clientes->actualizarProspecto($datosEnviar);

				$this->_view->assign("datos",$_POST);
				$this->_view->assign("_mensaje","El contacto ha sido actualizado");
			}

			$this->_view->renderizar('perfil_contacto',"clientes");
		}
		public function crear_contacto($id=false){
		    $this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('clientes');
				exit();
			}
			$this->_view->assign('titulo','Crear contacto');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "clientes/perfil_cliente/" .$id
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("paises",$this->_clientes->getPaises());
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);

				$nombre_prospecto= $this->getSql("nombre_prospecto");
				$apellido_prospecto= $this->getSql("apellido_prospecto");
				$telefono_prospecto= $this->getSql("telefono_prospecto");
				$celular_prospecto= $this->getSql("celular_prospecto");
				$email_prospecto= $this->getSql("email_prospecto");
				$pais_prospecto= $this->getSql("pais_prospecto");
				$estado_prospecto= $this->getSql("estado_prospecto");
				$ciudad_prospecto= $this->getSql("ciudad_prospecto");

				$errores="";
				if ($nombre_prospecto=="") {
					$errores="Ingrese el nombre del contacto";
				}
				if ($apellido_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el apellido del contacto";
				}
				if ($telefono_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el telefono del contacto";
				}
				if ($celular_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el celular del contacto";
				}
				if (!$this->validarEmail($email_prospecto)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="El email es invalido";
				}
				if ($pais_prospecto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Selecione el pais";
				}
				if ($estado_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la estado del contacto";
				}
				if ($ciudad_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la ciudad del contacto";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_contacto',"clientes");
					exit;
				}
				$id_u=$this->_clientes->getUsuario_sisfcId(Session::get('id_usuario'));
				$datosEnviar = array(
					"id_u_prospecto"=>"dummy",
					"rol_prospecto"=>"prospecto",
					"nombre_prospecto"=>$nombre_prospecto,
					"apellido_prospecto"=>$apellido_prospecto,
					"telefono_prospecto"=>$telefono_prospecto,
					"celular_prospecto"=>$celular_prospecto,
					"email_prospecto"=>$email_prospecto,
					"web_prospecto"=>"",
					"pais_prospecto"=>$pais_prospecto,
					"estado_prospecto"=>$estado_prospecto,
					"ciudad_prospecto"=>$ciudad_prospecto,
					"campana_prospecto"=>"",
					"segmento_prospecto"=>"",
					"s_referencias"=>"",
					"fecha_registro"=>DATE_FORMAT,
					"creador"=>$id_u["id_u_usuario"]
				);

				$this->_clientes->crearProspectoC($datosEnviar);

				$id_u = $this->_clientes->ultimoProspecto();

				$id_u_prospecto = strtoupper(substr($id_u["nombre_prospecto"],0,2)).$id_u["id_prospecto"];
				$datosEnviar = array(
						"id_prospecto"=>$id_u["id_prospecto"],
						"id_u_prospecto"=> $id_u_prospecto
					);
				$this->_clientes->actualizarProspecto($datosEnviar);

				//tabla marcas_clientes
				$datosEnviar = array(
						"id_u_marca" => $id,
						"id_u_cliente" => $id_u_prospecto,
						"fecha_creacion" => Date("D/M/Y")
					);
				$this->_clientes->crearMarcaClientes($datosEnviar);
				$this->_view->assign("datos",$_POST);
				$this->_view->assign("_mensaje","El contacto ha sido creado");
			}
			$this->_view->assign("identifica",$id);
			$this->_view->renderizar('crear_contacto',"clientes");
		}
		public function perfil_razon_social($retunr=false,$id=false){
		    $this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('clientes');
				exit();
			}
			if(!$retunr){
				$this->redireccionar('clientes');
				exit();
			}
			$this->_view->setJs(array('ajax'));
			$this->_view->assign('titulo','Perfil razón social');

			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "clientes/perfil_cliente/" .$retunr
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);


			$this->_view->assign("tipos",$this->_clientes->getTipoPersona());
			$this->_view->assign("paises",$this->_clientes->getPaises());
			$this->_view->assign("datos",$this->_clientes->getRazonSocial($id));
			$this->_view->assign("identifica",$retunr);
			$this->_view->assign("activo",1);
			$this->_view->assign("activo2",1);
			$datos21=$this->_clientes->getFileFiscal($id);
			$this->addCss($datos21);
			$datos23=$this->_clientes->getPorderNotarial($id);
			$datos22=$this->_clientes->getActaConst($id);
			$this->_view->assign("datos21",$datos21);
			$this->_view->assign("datos22",$datos22);
			$this->_view->assign("datos23",$datos23);
			if ($this->getInt('crear1')=="1")
			{
				$tipo_persona = $this->getSql("tipo_persona");
				$razon_social = $this->getSql("razon_social");
				$rfc = $this->getSql("rfc");
				$email = $this->getSql("email");
				$domicilio_fiscal = $this->getSql("domicilio_fiscal");
				$calle = $this->getSql("calle");
				$n_externo = $this->getSql("n_externo");
				$n_externo = $this->getSql("n_externo");
				$n_interno = $this->getSql("n_interno");
				$pais = $this->getSql("pais");
				$estado = $this->getSql("estado");
				$municipio = $this->getSql("municipio");
				$ciudad = $this->getSql("ciudad");
				$colonia = $this->getSql("colonia");
				$cp = $this->getSql("cp");

				$errores="";
				if ($tipo_persona=="Seleccione") {
					$errores.="Seleccione el tipo de persona";
				}
				if ($razon_social=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la razon social";
				}
				if ($rfc=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el RFC";
				}
				if (!$this->validarEmail($email)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="El email es incorrecto";
				}
				if ($domicilio_fiscal=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el domicilio fiscal";
				}
				if ($calle=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la calle";
				}
				if ($n_externo=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el numero externo";
				}
				if ($n_interno=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el numero interno";
				}
				if ($pais=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Selecione el pais";
				}
				if ($estado=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el estado";
				}
				if ($municipio=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el municipio";
				}
				if ($ciudad=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la ciudad";
				}
				if ($colonia=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la colonia";
				}
				if ($cp=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el codigo postal";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_razon_social',"clientes");
					exit;
				}

				//tabla razones_sociales
				$datosEnviar = array(
						"id_u_rs" => $id,
						"tipo_persona" => $tipo_persona,
						"razon_social" => $razon_social,
						"rfc" =>$rfc,
						"email" =>$email,
						"domicilio_fiscal" =>$domicilio_fiscal,
						"calle" =>$calle,
						"num_ext" =>$n_externo,
						"num_int" =>$n_interno,
						"pais" =>$pais,
						"estado" =>$estado,
						"municipio" =>$municipio,
						"ciudad" =>$ciudad,
						"colonia" =>$colonia,
						"cp" =>$cp
					);
				$this->_clientes->actualizarRazonS($datosEnviar);
				$this->_view->assign("_mensaje","La razon social ha sido actualizada");
				$this->_view->assign("datos",$this->_clientes->getRazonSocial($id));
			}
			if ($this->getInt('crear21')=="1")
			{
				$this->_view->assign("activo",2);
				$acta_constitutiva="";
				if (isset($_POST["acta_constitutiva"])) {
					$acta_constitutiva=$this->getSql("acta_constitutiva");
				}
				$poder_notarial="";
				if (isset($_POST["poder_notarial"])) {
					$poder_notarial=$this->getSql("poder_notarial");
				}
				$rppc="";
				if (isset($_POST["rppc"])) {
					$rppc=$this->getSql("rppc");
				}
				$rfc="";
				if (isset($_POST["rfc"])) {
					$rfc=$this->getSql("rfc");
				}
				$r1="";
				if (isset($_POST["r1"])) {
					$r1=$this->getSql("r1");
				}
				$r2="";
				if (isset($_POST["r2"])) {
					$r2=$this->getSql("r2");
				}
				$comp_domicilio="";
				if (isset($_POST["comp_domicilio"])) {
					$comp_domicilio=$this->getSql("comp_domicilio");
				}
				$id_representante="";
				if (isset($_POST["id_representante"])) {
					$id_representante=$this->getSql("id_representante");
				}
				$curp="";
				if (isset($_POST["curp"])) {
					$curp=$this->getSql("curp");
				}
				if (count($datos21)==1) {
					$datosEnviar = array(
						"fecha_creacion"=>Date("D/M/Y"),
						"id_u_razonsocial"=>$id,
						"acta_constitutiva"=>$acta_constitutiva,
						"poder_notarial"=>$poder_notarial,
						"rppc"=>$rppc,
						"rfc"=>$rfc,
						"r1"=>$r1,
						"r2"=>$r2,
						"comp_domicilio"=>$comp_domicilio,
						"id_representante"=>$id_representante,
						"curp"=>$curp
					);
					//crear
					$this->_clientes->crearFilefiscal($datosEnviar);
					$this->_view->assign("_mensaje","Documentos del file fiscal ha sido creado");
				}else{
					$datosEnviar = array(
						"id_u_razonsocial"=>$id,
						"acta_constitutiva"=>$acta_constitutiva,
						"poder_notarial"=>$poder_notarial,
						"rppc"=>$rppc,
						"rfc"=>$rfc,
						"r1"=>$r1,
						"r2"=>$r2,
						"comp_domicilio"=>$comp_domicilio,
						"id_representante"=>$id_representante,
						"curp"=>$curp
					);
					//actuallizar
					$this->_clientes->actualizarFileFiscal($datosEnviar);
					$this->_view->assign("_mensaje","Documentos del file fiscal ha sido actualizado");
				}
				$datos21=$this->_clientes->getFileFiscal($id);
				$this->addCss($datos21);
			}
			if ($this->getInt('crear23')=="1")
			{
				$this->_view->assign("activo",2);
				$this->_view->assign("activo2",3);

				$escritura_publica=$this->getSql("escritura_publica");
				$de_fecha=$this->getSql("de_fecha");
				$ante_la_fe=$this->getSql("ante_la_fe");
				$fe_publica=$this->getSql("fe_publica");
				$numero_federatario=$this->getSql("numero_federatario");
				$estado_federatario=$this->getSql("estado_federatario");
				$nombre_apoderado=$this->getSql("nombre_apoderado");

				$errores="";
				if ($escritura_publica=="") {
					$errores.="Ingrese la escritura pública";
				}
				if ($de_fecha=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese de_fecha";
				}
				if ($ante_la_fe=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese ante la fe";
				}
				if ($fe_publica=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese fecha publica";
				}
				if ($numero_federatario=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese numero federatario";
				}
				if ($estado_federatario=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese estado federatario";
				}

				if ($nombre_apoderado=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese nombre del representante legal";
				}
				// if ($errores!="") {
				// 	$this->_view->assign("_error",$errores);
				// 	$this->_view->renderizar('crear_razon_social');
				// 	exit();
				// }

				if (count($datos22)==1) {
					$datosEnviar = array(
						"id_u_razonsocial"=>$id,
						"fecha_creacion"=>Date("D/M/Y"),
						"escritura_publica"=>$escritura_publica ,
						"de_fecha"=>$de_fecha ,
						"ante_la_fe"=>$ante_la_fe ,
						"fe_publica"=>$fe_publica ,
						"numero_federatario"=>$numero_federatario ,
						"estado_federatario"=>$estado_federatario ,
						"nombre_apoderado"=>$nombre_apoderado
					);
					$this->_clientes->crearActaConstitu($datosEnviar);
					$this->_view->assign("_mensaje","Acta constitutiva del file fiscal ha sido creada1");
				}else{
					$datosEnviar = array(
						"id_u_razonsocial"=>$id,
						"escritura_publica"=>$escritura_publica ,
						"de_fecha"=>$de_fecha ,
						"ante_la_fe"=>$ante_la_fe ,
						"fe_publica"=>$fe_publica ,
						"numero_federatario"=>$numero_federatario ,
						"estado_federatario"=>$estado_federatario ,
						"nombre_apoderado"=>$nombre_apoderado
					);
					$this->_clientes->actualizarActaConstitu($datosEnviar);
					$this->_view->assign("_mensaje","Acta constitutiva del file fiscal ha sido actualizada");
				}
				$datos22=$this->_clientes->getActaConst($id);
				$this->_view->assign("datos22",$datos22);
			}
			if ($this->getInt('crear22')=="1")
			{
				$this->_view->assign("activo",2);
				$this->_view->assign("activo2",2);

				$escritura_publica=$this->getSql("escritura_publica");
				$de_fecha=$this->getSql("de_fecha");
				$ante_la_fe_del=$this->getSql("ante_la_fe_del");
				$fe_publica_del=$this->getSql("fe_publica_del");
				$numero_federatario=$this->getSql("numero_federatario");
				$estado_federatario=$this->getSql("estado_federatario");
				$folio_mercantil_rppc=$this->getSql("folio_mercantil_rppc");
				$ciudad_estado_rppc=$this->getSql("ciudad_estado_rppc");
				$objeto_social=$this->getSql("objeto_social");
				$representante_legal=$this->getSql("representante_legal");

				$errores="";
				if ($escritura_publica=="") {
					$errores.="Ingrese la escritura pública";
				}
				if ($de_fecha=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese de_fecha";
				}
				if ($ante_la_fe_del=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese ante la fe";
				}
				if ($fe_publica_del=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese fecha publica";
				}
				if ($numero_federatario=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese numero federatario";
				}
				if ($estado_federatario=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese estado federatario";
				}
				if ($folio_mercantil_rppc=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el folio mercantil rppc";
				}
				if ($ciudad_estado_rppc=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la ciudad estado";
				}
				if ($objeto_social=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el objeto social";
				}
				if ($representante_legal=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese nombre del representante legal";
				}

				if (count($datos23)==1) {
					$datosEnviar = array(
						"id_u_razonsocial"=>$id,
						"fecha_creacion"=>Date("D/M/Y"),
						"escritura_publica"=>$escritura_publica ,
						"de_fecha"=>$de_fecha ,
						"ante_la_fe_del"=>$ante_la_fe_del ,
						"fe_publica_del"=>$fe_publica_del ,
						"numero_federatario"=>$numero_federatario ,
						"estado_federatario"=>$estado_federatario ,
						"folio_mercantil_rppc"=>$folio_mercantil_rppc,
						"ciudad_estado_rppc"=>$ciudad_estado_rppc,
						"objeto_social"=>$objeto_social,
						"representante_legal"=>$representante_legal
					);
					$this->_clientes->crearPoderNotarial($datosEnviar);
					$this->_view->assign("_mensaje","Poder notarial del file fiscal ha sido creada1");
				}else{
					$datosEnviar = array(
						"id_u_razonsocial"=>$id,
						"escritura_publica"=>$escritura_publica ,
						"de_fecha"=>$de_fecha ,
						"ante_la_fe_del"=>$ante_la_fe_del ,
						"fe_publica_del"=>$fe_publica_del ,
						"numero_federatario"=>$numero_federatario ,
						"estado_federatario"=>$estado_federatario ,
						"folio_mercantil_rppc"=>$folio_mercantil_rppc,
						"ciudad_estado_rppc"=>$ciudad_estado_rppc,
						"objeto_social"=>$objeto_social,
						"representante_legal"=>$representante_legal
					);
					$this->_clientes->actualizarPoderNotarial($datosEnviar);
					$this->_view->assign("_mensaje","Poder notarial del file fiscal ha sido actualizada");
				}
				$datos23=$this->_clientes->getPoderNotarial($id);
				$this->_view->assign("datos23",$datos23);
			}
			$this->_view->renderizar('perfil_razon_social',"clientes");
		}
		public function crear_razon_social($id=false){
		    $this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('clientes');
				exit();
			}
			$this->_view->assign('titulo','Crear razón social');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "clientes/perfil_cliente/" .$id
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("tipos",$this->_clientes->getTipoPersona());
			$this->_view->assign("paises",$this->_clientes->getPaises());
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);


				$tipo_persona = $this->getSql("tipo_persona");
				$razon_social = $this->getSql("razon_social");
				$rfc = $this->getSql("rfc");
				$email = $this->getSql("email");
				$domicilio_fiscal = $this->getSql("domicilio_fiscal");
				$calle = $this->getSql("calle");
				$n_externo = $this->getSql("n_externo");
				$n_externo = $this->getSql("n_externo");
				$n_interno = $this->getSql("n_interno");
				$pais = $this->getSql("pais");
				$estado = $this->getSql("estado");
				$municipio = $this->getSql("municipio");
				$ciudad = $this->getSql("ciudad");
				$colonia = $this->getSql("colonia");
				$cp = $this->getSql("cp");

				$errores="";
				if ($tipo_persona=="Seleccione") {
					$errores.="Seleccione el tipo de persona";
				}
				if ($razon_social=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la razon social";
				}
				if ($rfc=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el RFC";
				}
				if (!$this->validarEmail($email)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="El email es incorrecto";
				}
				if ($domicilio_fiscal=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el domicilio fiscal";
				}
				if ($calle=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la calle";
				}
				if ($n_externo=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el numero externo";
				}
				if ($n_interno=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el numero interno";
				}
				if ($pais=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Selecione el pais";
				}
				if ($estado=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el estado";
				}
				if ($municipio=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el municipio";
				}
				if ($ciudad=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la ciudad";
				}
				if ($colonia=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la colonia";
				}
				if ($cp=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el codigo postal";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_razon_social',"clientes");
					exit;
				}

				//tabla razones_sociales
				$datosEnviar = array(
						"id_u_rs" => "dummy",
						"fecha_creacion" => Date("D/M/Y"),
						"tipo_persona" => $tipo_persona,
						"razon_social" => $razon_social,
						"rfc" =>$rfc,
						"email" =>$email,
						"domicilio_fiscal" =>$domicilio_fiscal,
						"calle" =>$calle,
						"num_ext" =>$n_externo,
						"num_int" =>$n_interno,
						"pais" =>$pais,
						"estado" =>$estado,
						"municipio" =>$municipio,
						"ciudad" =>$ciudad,
						"colonia" =>$colonia,
						"cp" =>$cp
					);
				$this->_clientes->crearRazonesSociales($datosEnviar);
				$id_u = $this->_clientes->ultimoRazonS();
				$id_u_rs = strtoupper(substr($id_u["razon_social"],0,2)).$id_u["id_razon_s"];
				$datosEnviar = array(
						"id_razon_s"=>$id_u["id_razon_s"],
						"id_u_rs"=> $id_u_rs
					);
				$this->_clientes->actualizarRazonS($datosEnviar);

				//tabla marcas_razones
				$datosEnviar = array(
						"id_u_marca" => $id,
						"id_u_rs" => $id_u_rs,
						"fecha_creacion" => Date("d/m/Y")
					);

				$this->_clientes->crearMarcaRazones($datosEnviar);
				$this->_view->assign("_mensaje","La razon social ha sido creada");
			}
			$this->_view->assign("identifica",$id);
			$this->_view->renderizar('crear_razon_social',"clientes");
		}
		public function eliminarMarcasClientes(){
		    $this->_acl->acceso('todo');
			$id=$this->getTexto("id");
			$marca=$this->getTexto("marca");
			if($id!="" && $marca!=""){
				$this->_clientes->eliminarMarcasClientes($id,$marca);
			}
		}
		public function eliminarMarcasRazones(){
		    $this->_acl->acceso('todo');
			$id=$this->getTexto("id");
			$marca=$this->getTexto("marca");
			if($id!="" && $marca!=""){
				$this->_clientes->eliminarMarcasRazones($id,$marca);
			}
		}
		private function addCss($datos21){
		    $this->_acl->acceso('todo');
			$this->_view->assign("var_1_1","default");
			$this->_view->assign("var_1_2","");
			if ($datos21["acta_constitutiva"]=="1") {
				$this->_view->assign("var_1_1","primary active");
				$this->_view->assign("var_1_2","checked");
			}
			$this->_view->assign("var_2_1","default");
			$this->_view->assign("var_2_2","");
			if ($datos21["poder_notarial"]=="1") {
				$this->_view->assign("var_2_1","primary active");
				$this->_view->assign("var_2_2","checked");
			}
			$this->_view->assign("var_3_1","default");
			$this->_view->assign("var_3_2","");
			if ($datos21["rppc"]=="1") {
				$this->_view->assign("var_3_1","primary active");
				$this->_view->assign("var_3_2","checked");
			}
			$this->_view->assign("var_4_1","default");
			$this->_view->assign("var_4_2","");
			if ($datos21["rfc"]=="1") {
				$this->_view->assign("var_4_1","primary active");
				$this->_view->assign("var_4_2","checked");
			}
			$this->_view->assign("var_5_1","default");
			$this->_view->assign("var_5_2","");
			if ($datos21["r1"]=="1") {
				$this->_view->assign("var_5_1","primary active");
				$this->_view->assign("var_5_2","checked");
			}
			$this->_view->assign("var_6_1","default");
			$this->_view->assign("var_6_2","");
			if ($datos21["r2"]=="1") {
				$this->_view->assign("var_6_1","primary active");
				$this->_view->assign("var_6_2","checked");
			}
			$this->_view->assign("var_7_1","default");
			$this->_view->assign("var_7_2","");
			if ($datos21["comp_domicilio"]=="1") {
				$this->_view->assign("var_7_1","primary active");
				$this->_view->assign("var_7_2","checked");
			}
			$this->_view->assign("var_8_1","default");
			$this->_view->assign("var_8_2","");
			if ($datos21["id_representante"]=="1") {
				$this->_view->assign("var_8_1","primary active");
				$this->_view->assign("var_8_2","checked");
			}
			$this->_view->assign("var_9_1","default");
			$this->_view->assign("var_9_2","");
			if ($datos21["curp"]=="1") {
				$this->_view->assign("var_9_1","primary active");
				$this->_view->assign("var_9_2","checked");
			}
		}

		public function operacionesLead(){
			echo json_encode($this->_clientes->getOperaciones($this->getTexto('lead')));
		}

		public function estados($cliente){

			if(!isset($cliente)){
				$this->redireccionar("clientes");
			}

			$this->getLibrary('Prorrateo/prorrateo.class');
			$prorrateo = new Porrateo();

			$operaciones = $this->_clientes->getEstadosDeCuenta($cliente);
			for($i=0;$i<count($operaciones);$i++){
				$prorrateo = new Porrateo();
				$prorrateo->setID($operaciones[$i]["id_u_cotizacion"]);
				$prorrateo->prorratear();

				$cxcCotizacion = $this->_clientes->getCxCCotizacion($operaciones[$i]["id_u_cotizacion"]);
				$abonos = 0;
				$saldoMercancia = 0;
				$saldoDespacho = 0;

				$valor1=1;
				if ($operaciones[$i]["moneda"]==2) {
					$valor1 = $operaciones[$i]["tc_pd"];
				}
				if ($operaciones[$i]["moneda"]==3) {
					$valor1 = $operaciones[$i]["tc_pe"];
				}


				foreach($cxcCotizacion as $cxc){
					$valor2=1;
					if ($cxc["moneda"] == 2) {
						$valor2 = $operaciones[$i]["tc_pd"];
					}
					if ($cxc["moneda"] == 3) {
						$valor2 = $operaciones[$i]["tc_pe"];
					}

					if($cxc["concepto"]==1 || $cxc["concepto"]==7 || $cxc["concepto"]==10){
						$cambioDeDivisa = $this->cambio_divisa($cxc["monto_aplicable"],$valor2,$valor1);
						$saldoMercancia += $cambioDeDivisa;
					}else{
						$cambioDeDivisa = $this->cambio_divisa($cxc["monto_aplicable"],$valor2,$valor1);
						$saldoDespacho += $cambioDeDivisa;
					}
					$abonos += $cxc["monto_aplicable"];
				}

				$operaciones[$i]["saldo_mercancia"] = $prorrateo->valorFactura() - $saldoMercancia;
				$operaciones[$i]["saldo_despacho"] = ($prorrateo->totalFactura() - $prorrateo->valorFactura()) - $saldoDespacho;
				$operaciones[$i]["saldo_total"] = $prorrateo->totalFactura() - ($operaciones[$i]["saldo_mercancia"] + $operaciones[$i]["saldo_despacho"]);


				$operaciones[$i]["totalFactura"] = $prorrateo->totalFactura();
			}




			$this->_view->assign('titulo','Estado de cuentas');
			$btnHeader = array(
				array(
					"titulo" => "return",
					"enlace" => "clientes/perfil_cliente"
				),
			);


			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("operaciones",$operaciones);
			$this->_view->renderizar('estados',"clientes");
		}

		private function cambio_divisa($valor,$divisa_de_valor,$divisa_a_convertir){
			return $valor * $divisa_de_valor / $divisa_a_convertir;
		}
	}


?>
