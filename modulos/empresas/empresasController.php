<?php
	class empresasController extends Controller{
		private $_empresas;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_empresas = $this->loadModel('empresas');
		}
		public function index(){
		    $this->_acl->acceso('todo');
			$this->_view->assign('titulo','Empresas');
			$btnHeader = array(

				array(
					"titulo" => "Crear empresa",
					"enlace" => "empresas/crear_empresa"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_empresas->getEmpresas());
			$this->_view->renderizar('index',"catalogos");
		}
		public function eliminarEmpresa(){
		    $this->_acl->acceso('todo');
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_empresas->eliminarEmpresaModel($id);
			}
		}
		public function perfil_empresa($id=false){
		    $this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('empresas');
				exit();
			}
			$this->_view->assign('titulo','Perfil empresa');
			$this->_view->assign("activo",1);
			$this->_view->assign("referencias",$this->_empresas->getReferencias($id));


			if ($this->getInt('actualizar1')=="1")
			{
				$tipo_persona= $this->getSql("tipo_persona");
				$razon_social= $this->getSql("razon_social");
				$rfc= $this->getSql("rfc");
				$email=  $this->getSql("email");
				$pais=  $this->getSql("pais");
				$emailValido= $this->validarEmail($email);
				$estado=  $this->getSql("estado");
				$municipio= $this->getSql("municipio");
				$ciudad = $this->getSql("ciudad");
				$colonia = $this->getSql("colonia");
				$calle  = $this->getSql("calle");
				$n_externo = $this->getSql("n_externo");
				$n_interno = $this->getSql("n_interno");
				$codigo_postal = $this->getSql("codigo_postal");
				$domicilio_fiscal = $this->getSql("domicilio_fiscal");

				$datosEnviar = array(
					"id_u_empresa"=>$id,
					"tipo_persona"=>$tipo_persona,
					"nombre_empresa"=>$razon_social,
					"rfc"=>$rfc,
					"email"=>$email,
					"pais"=>$pais,
					"estado"=>$estado,
					"municipio"=>$municipio,
					"ciudad"=>$ciudad,
					"colonia"=>$colonia,
					"calle"=>$calle,
					"n_externo"=>$n_externo,
					"n_interno"=>$n_interno,
					"codigo_postal"=>$codigo_postal,
					"domicilio_fiscal"=>$domicilio_fiscal
				);
				$this->_empresas->actualizarEmpresa($datosEnviar);
				$this->_view->assign("_mensaje","Datos de facturación actualizados");
			}
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
				$this->_empresas->actualizarEmpresa($datosEnviar);
				$this->_view->assign("_mensaje","Poder notarial actualizado");
				$this->_view->assign("activo",2);
			}
			$this->_view->assign("identifica",$id);
			$this->_view->assign("paises",$this->_empresas->getPaises());
			//echo print_r($this->_empresas->getPaises());
			//exit();
			$this->_view->assign("datos",$this->_empresas->getEmpresa($id));
			$this->_view->assign("tipos",$this->_empresas->getTipoPersona());
			$this->_view->renderizar('perfil_empresa',"catalogos");
		}
		public function crear_empresa(){
		    $this->_acl->acceso('todo');
			$this->_view->assign('titulo','Crear empresa');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "empresas"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$tipo_persona = $this->getInt("tipo_persona");
				$razon_social = $this->getSql("razon_social");
				$rfc = $this->getSql("rfc");
				$errores="";
				if (!$tipo_persona) {
					$errores="Seleccion el tipo de persona";
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
				if ($errores!="") {
					$this->_view->assign("tipos",$this->_empresas->getTipoPersona());
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_empresa',"catalogos");
					exit;
				}
				$id_u=$this->_empresas->getUsuario_sisfcId(Session::get('id_usuario'));
				$datosEnviar = array(
					"id_u_empresa"=>"dummy",
					"codigo_empresa"=>strtoupper(substr($razon_social,0,3)),
					"nombre_empresa"=>$razon_social,
					"tipo_persona"=>$tipo_persona,
					"rfc"=>$rfc,
					"fecha_registro"=>Date("D/M/Y"),
					"creador"=>$id_u["id_u_usuario"]
				);
				$this->_empresas->crearEmpresa($datosEnviar);
				$id = $this->_empresas->ultimoEmpresa();
				$datosEnviar = array(
						"id_empresa"=>$id["id_empresa"],
						"id_u_empresa"=>strtoupper(substr($id["nombre_empresa"],0,2)).$id["id_empresa"]
					);

				$this->_empresas->actualizarEmpresa($datosEnviar);
				$this->redireccionar('empresas');
				exit;
			}
			$this->_view->assign("tipos",$this->_empresas->getTipoPersona());
			$this->_view->renderizar('crear_empresa',"catalogos");
		}
	}
?>
