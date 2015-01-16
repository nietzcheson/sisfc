<?php
	class gastosaduanalesController extends Controller{

		private $_gastos;

		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_gastos = $this->loadModel('gastosaduanales');
		}

		public function index(){
			$this->_view->assign('titulo','Gastos Aduanales');
			$btnHeader = array(

				array(
					"titulo" => "Crear gasto",
					"enlace" => "gastosaduanales/crear_gasto"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_gastos->getGastosAduanales());
			$this->_view->renderizar('index',"catalogos");
		}

		public function perfil_gasto($id=false){
			if(!$id){
				$this->redireccionar('gastosaduanales');
				exit();
			}
			$this->_view->assign('titulo','Perfil gasto aduanal');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "gastosaduanales"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			if ($this->getInt('actualizar')=="1")
			{
				$nombre_es = $this->getSql("nombre_es");
				$errores="";
				if ($nombre_es=="") {
					$errores="Ingrese el gasto aduanal";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('perfil_gasto',"catalogos");
					exit;
				}
				$datosEnviar = array(
					"id_gasto"=>$id,
					"nombre_es"=>$nombre_es
				);
				$this->_gastos->actualizarGastosAduanal($datosEnviar);
				$this->_view->assign("_mensaje","El gasto aduanal ha sido actualizado");
			}
			$this->_view->assign("datos",$this->_gastos->getGastosAduanal($id));
			$this->_view->renderizar('perfil_gasto',"catalogos");
		}

		public function eliminarGastoAduanal()
		{
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_gastos->eliminarGastosAduanalModel($id);
			}
		}

		public function crear_gasto(){
			$this->_view->assign('titulo','Crear gasto aduanal');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "gastosaduanales"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$nombre_es = $this->getSql("nombre_es");
				$errores="";
				if ($nombre_es=="") {
					$errores="Ingrese el gasto aduanal";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_gasto',"catalogos");
					exit;
				}
				$datosEnviar = array(
					"nombre_es"=>$nombre_es
				);
				$this->_gastos->crearGastosAduanal($datosEnviar);
				$this->_view->assign("_mensaje","El gasto aduanal ha sido creado");
				$this->redireccionar('gastosaduanales');
			}
			$this->_view->renderizar('crear_gasto',"catalogos");
		}

	}
?>
