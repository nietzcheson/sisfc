<?php
	class incrementablesController extends Controller{
		private $_incre;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_incre = $this->loadModel('incrementables');
		}

		public function index(){
			$this->_view->assign('titulo','Incrementables');
			$btnHeader = array(

				array(
					"titulo" => "Crear incrementable",
					"enlace" => "incrementables/crear_incrementable"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_incre->getIncrementables());
			$this->_view->renderizar('index',"catalogos");
		}
		public function perfil_incrementable($id=false){
			if(!$id){
				$this->redireccionar('segmentos');
				exit();
			}

			$this->_view->assign('titulo','Perfil incrementable');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "incrementables"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			if ($this->getInt('actualizar')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$nombre_incrementable = $this->getSql("nombre_incrementable");
				$errores="";
				if ($nombre_incrementable=="") {
					$errores="Ingrese el segmento";
				}
				if ($errores!="") {
					$this->_view->assign("datos",$this->_incre->getIncrementable($id));
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('perfil_incrementable',"catalogos");
					exit;
				}
				$datosEnviar = array(
					"id_incrementable"=>$id,
					"nombre_incrementable"=>$nombre_incrementable
				);
				$this->_incre->actualizarIncrementable($datosEnviar);
				$this->_view->assign("_mensaje","El incrementable ha sido actualizado");
			}
			$this->_view->assign("identifica",$id);
			$this->_view->assign("datos",$this->_incre->getIncrementable($id));
			$this->_view->renderizar('perfil_incrementable',"catalogos");
		}

		public function eliminarIncrementable()
		{
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_incre->eliminarIncrementableModel($id);
			}
		}

		public function crear_incrementable(){
			$this->_view->assign('titulo','Crear incrementable');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "incrementables"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$nombre_incrementable = $this->getSql("nombre_incrementable");
				$errores="";
				if ($nombre_incrementable=="") {
					$errores="Ingrese el nombre del incrementable";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_incrementable',"catalgos");
					exit;
				}
				$datosEnviar = array(
					"nombre_incrementable"=>$nombre_incrementable
				);
				$this->_incre->crearIncrementable($datosEnviar);
				$this->_view->assign("_mensaje","El incrementable ha sido creado");
				$this->redireccionar('incrementables');

			}
			$this->_view->renderizar('crear_incrementable',"catalogos");
		}

	}
?>
