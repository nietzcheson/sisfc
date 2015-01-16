<?php
	class serviciosController extends Controller{
		private $_servicios;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_servicios = $this->loadModel('servicios');
		}
		public function index(){
		    $this->_acl->acceso('todo');
			$this->_view->assign('titulo','Servicios');
			$btnHeader = array(

				array(
					"titulo" => "Crear servicio",
					"enlace" => "servicios/crear_servicio"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_servicios->getServicios());
			$this->_view->renderizar('index',"catalogos");
		}


		public function perfil_servicio($id=false){
		    $this->_acl->acceso('todo');
			if(!$id){
				$this->redireccionar('servicios');
				exit();
			}

			$this->_view->assign('titulo','Perfil servicio');
			if ($this->getInt('actualizar')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$servicio = $this->getSql("servicio");
				$iso = $this->getSql("iso");

				$errores="";
				if ($iso=="Seleccione") {
					$errores="Seleccione el ISO";
				}
				if ($servicio=="") {
					$errores="Ingrese el servicio";
				}
				if ($errores!="") {
					$this->_view->assign("_servicios",$this->_servicios->getServicio($id));
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('perfil_servicio',"catalogos");
					exit;
				}
				$datosEnviar = array(
					"id"=>$id,
					"servicio"=>$servicio,
					"iso" => $iso
				);
				$this->_servicios->actualizarServicio($datosEnviar);
				$this->_view->assign("_mensaje","El servicio ha sido actualizado");
			}
			$this->_view->assign("identifica",$id);

			$this->_view->assign("referencias",$this->_servicios->getReferencias($id));

			$this->_view->assign("servicio",$this->_servicios->getServicio($id));
			$this->_view->renderizar('perfil_servicio',"catalogos");
		}
		public function eliminarServicio()
		{
		    $this->_acl->acceso('todo');
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_servicios->eliminarServicio($id);
			}
		}
		public function crear_servicio(){
		    $this->_acl->acceso('todo');
			$this->_view->assign('titulo','Crear servicio');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "servicios"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$servicio = $this->getSql("servicio");
				$errores="";
				if ($servicio=="") {
					$errores="Ingrese el nombre del servicio";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_servicio',"catalogos");
					exit;
				}

				//$posicion = count($this->_servicios->getEstatus());

				$datosEnviar = array(
					"servicio"=>$servicio,
					"folio" => "dummy"
				);

				$this->_servicios->crearServicio($datosEnviar);

				$id = $this->_servicios->getIDServicios();

				if($id["id"]==""){
					$folio = 1;
				}else{
					$folio = (int) $id["id"];
				}

				if(strlen($folio)==1){
					$folio = "S-00".$folio;
				}else if(strlen($folio)==2){
					$folio = "S-0".$folio;
				}else if(strlen($folio)==3){
					$folio = "S-".$folio;
				}

				$datosEnviar = array(
					"id"=>$id["id"],
					"folio" => $folio
				);

				$this->_servicios->actualizarServicio($datosEnviar);

				$this->_view->assign("_mensaje","El servicio ha sido creado");
				$this->redireccionar('servicios');

			}
			$this->_view->renderizar('crear_servicio',"catalogos");
		}
	}
?>
