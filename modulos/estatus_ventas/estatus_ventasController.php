<?php
	class estatus_ventasController extends Controller{
		private $_estatus;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_estatus = $this->loadModel('estatus_ventas');
		}
		public function index(){
		    $this->_acl->acceso('todo');
			$this->_view->assign('titulo','Estatus de ventas');
			$btnHeader = array(

				array(
					"titulo" => "Crear estatus",
					"enlace" => "estatus_ventas/crear_estatus"
				),
				array(
					"titulo" => "Embudo de ventas",
					"enlace" => "leads/embudo"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_estatus->getEstatus());
			$this->_view->renderizar('index',"catalogos");
		}
		public function perfil($id=false){
		    $this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('estatus_ventas');
				exit();
			}

			$this->_view->assign('titulo','Perfil estatus');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "estatus_ventas"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			if($this->getInt('actualizar')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$estatus = $this->getSql("estatus");
				$posicion = $this->getInt("posicion");
				$acumulado = $this->getInt("acumulado");
				$errores = "";

				if($estatus==""){
					$errores="Ingrese el estatus";
				}
				if($posicion==""){
					$errores="Ingrese la posición";
				}
				if($acumulado==-1){
					$errores="Seleccione el acumulado";
				}
				if($errores!="") {
					$this->_view->assign("estatus",$this->_estatus->getEstatusId($id));
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('perfil',"catalogos");
					exit;
				}
				$datosEnviar = array(
					"id"=>$id,
					"estatus"=>$estatus,
					"posicion"=>$posicion,
					"acumulado"=>$acumulado
				);
				$this->_estatus->actualizarEstatus($datosEnviar);
				$this->_view->assign("_mensaje","El estatus ha sido actualizado");
			}
			$this->_view->assign("identifica",$id);
			$this->_view->assign("estatus",$this->_estatus->getEstatusId($id));
			$this->_view->renderizar('perfil',"catalogos");
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
					"enlace" => "estatus_ventas"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);

			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$estatus = $this->getSql("estatus");
				$acumulado = $this->getInt("acumulado");

				$errores="";
				if ($estatus=="") {
					$errores.="Ingrese el nombre del estatus";
				}
				if ($acumulado==-1) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione acumulado";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_estatus',"catalogos");
					exit;
				}

				$posicion = count($this->_estatus->getEstatus());
				$datosEnviar = array(
					"estatus"=>$estatus,
					"posicion"=>$posicion,
					"acumulado"=>$acumulado
				);

				$this->_estatus->crearEstatus($datosEnviar);
				$this->_view->assign("_mensaje","El estatus ha sido creado");
				$this->redireccionar('estatus_ventas');
			}

			$this->_view->renderizar('crear_estatus',"catalogos");
		}
	}
?>
