<?php
	class paisesController extends Controller{
		private $_pais;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_pais = $this->loadModel('paises');
		}

		public function index(){
			$this->_view->assign('titulo','Países');
			$btnHeader = array(

				array(
					"titulo" => "Crear país",
					"enlace" => "paises/crear_pais"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_pais->getPaises());
			$this->_view->renderizar('index',"catalogos");
		}
		public function perfil_pais($id){
			if(!$id){
				$this->redireccionar('paises');
				exit();
			}

			$this->_view->assign('titulo','Perfil país');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "paises"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("identifica",$id);
			if ($this->getInt('actualizar')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$nombre_pais = $this->getSql("nombre_pais");
				$codigo = $this->getSql("codigo");
				$errores="";
				if ($nombre_pais=="") {
					$errores="Ingrese el nombre del pais";
				}
				if ($codigo=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el codigo del pais";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_pais',"catalogos");
					exit;
				}
				$datosEnviar = array(
					"id_pais"=>$id,
					"nombre_pais"=>$nombre_pais,
					"codigo"=>$codigo
				);
				$this->_pais->actualizarPais($datosEnviar);
				$this->_view->assign("_mensaje","El pais ha sido actualizado");
			}
			$this->_view->assign("datos",$this->_pais->getPais($id));
			$this->_view->renderizar('perfil_pais',"catalogos");
		}

		public function eliminarPais()
		{
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_pais->eliminarPaisModel($id);
			}
		}

		public function crear_pais(){
			$this->_view->assign('titulo','Crear país');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "paises"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);

			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$nombre_pais = $this->getSql("nombre_pais");
				$codigo = $this->getSql("codigo");
				$errores="";
				if ($nombre_pais=="") {
					$errores="Ingrese el nombre del pais";
				}
				if ($codigo=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el codigo del pais";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_pais',"catalogos");
					exit;
				}
				$datosEnviar = array(
					"nombre_pais"=>$nombre_pais,
					"codigo"=>$codigo
				);
				$this->_pais->crearPais($datosEnviar);
				$this->_view->assign("_mensaje","El segmento ha sido creado");
				$this->redireccionar('paises');
			}
			$this->_view->renderizar('crear_pais',"catalogos");
		}

	}
?>
