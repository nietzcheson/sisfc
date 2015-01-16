<?php
	class estatusController extends Controller{
		private $_estatus;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_estatus = $this->loadModel('estatus');
		}
		public function index(){
		  $this->_acl->acceso('todo');
			$this->_view->assign('titulo','Estatus de ventas');
			$btnHeader = array(

				array(
					"titulo" => "Crear estatus",
					"enlace" => "estatus/crear_estatus"
				),
				array(
					"titulo" => "Embudo de operaciones",
					"enlace" => "operaciones/embudo"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_estatus->getEstatus());
			$this->_view->renderizar('index',"catalogos");
		}
		public function perfil_estatus($id=false){
		    $this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('estatus');
				exit();
			}

			$this->_view->assign('titulo','Perfil estatus');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "estatus"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			if ($this->getInt('actualizar')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$estatus = $this->getSql("estatus");
				$posicion = $this->getInt("posicion");

				$errores="";
				if ($estatus=="") {
					$errores="Ingrese el segmento";
				}
				if ($errores!="") {
					$this->_view->assign("datos",$this->_estatus->getIncrementable($id));
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('perfil_segmento');
					exit;
				}
				$datosEnviar = array(
					"id"=>$id,
					"nombre"=>$estatus,
					"posicion"=>$posicion
				);
				$this->_estatus->actualizarEstatus($datosEnviar);
				$this->_view->assign("_mensaje","El estatus ha sido actualizado");
			}
			$this->_view->assign("identifica",$id);

			$this->_view->assign("referencias",$this->_estatus->getReferencias($id));

			$this->_view->assign("estatus",$this->_estatus->getEstatusId($id));
			$this->_view->renderizar('perfil_estatus');
		}
		public function eliminarEstatus()
		{
		    $this->_acl->acceso('todo');
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_estatus->eliminarEstatus($id);
			}
		}
		public function crear_estatus(){
		    $this->_acl->acceso('todo');
			$this->_view->assign('titulo','Crear estatus');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "estatus"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$estatus = $this->getSql("estatus");
				$errores="";
				if ($estatus=="") {
					$errores="Ingrese el nombre del estatus";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_estatus');
					exit;
				}

				$posicion = count($this->_estatus->getEstatus());

				$datosEnviar = array(
					"nombre"=>$estatus,
					"posicion"=>$posicion
				);
				$this->_estatus->crearEstatus($datosEnviar);
				$this->_view->assign("_mensaje","El estatus ha sido creado");
				$this->redireccionar('estatus');

			}
			$this->_view->renderizar('crear_estatus');
		}
	}
?>
