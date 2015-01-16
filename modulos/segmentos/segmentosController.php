<?php
	class segmentosController extends Controller{
		private $_segmentos;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_segmentos = $this->loadModel('segmentos');
		}

		public function index(){
			$this->_view->assign('titulo','Segmentos');
			$btnHeader = array(

				array(
					"titulo" => "Crear segmento",
					"enlace" => "segmentos/crear_segmento"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_segmentos->getSegmentos());
			$this->_view->renderizar('index',"catalogos");
		}
		public function perfil_segmento($id){
			if(!$id){
				$this->redireccionar('segmentos');
				exit();
			}

			$this->_view->assign('titulo','Perfil segmento');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "segmentos"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			if ($this->getInt('actualizar')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$nombre_segmento = $this->getSql("nombre_segmento");
				$datos_segmento = $this->getSql("datos_segmento");
				$errores="";
				if ($nombre_segmento=="") {
					$errores="Ingrese el segmento";
				}
				if ($datos_segmento=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese datos del segmento";
				}

				if ($errores!="") {
					$this->_view->assign("datos",$this->_segmentos->getSegmento($id));
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('perfil_segmento',"catalogos");
					exit;
				}
				$datosEnviar = array(
					"id_u_segmento"=>$id,
					"nombre_segmento"=>$nombre_segmento,
					"datos_segmento"=>$datos_segmento
				);
				$this->_segmentos->actualizarSegmento($datosEnviar);
				$this->_view->assign("_mensaje","El segmento ha sido actualizado");
			}
			$this->_view->assign("identifica",$id);
			$this->_view->assign("datos",$this->_segmentos->getSegmento($id));
			$this->_view->renderizar('perfil_segmento',"catalogos");
		}

		public function eliminarSegmento()
		{
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_segmentos->eliminarSegmentoModel($id);
			}
		}

		public function crear_segmento(){
			$this->_view->assign('titulo','Crear segmento');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "segmentos"
				),
			);
			$this->_view->assign("btnHeader",$btnHeader);
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$nombre_segmento = $this->getSql("nombre_segmento");
				$datos_segmento = $this->getSql("datos_segmento");
				$errores="";
				if ($nombre_segmento=="") {
					$errores="Ingrese el segmento";
				}
				if ($datos_segmento=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese datos del segmento";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_segmento',"catalogos");
					exit;
				}
				$datosEnviar = array(
					"id_u_segmento"=>"dummy",
					"nombre_segmento"=>$nombre_segmento,
					"datos_segmento"=>$datos_segmento
				);
				$this->_segmentos->crearSegmento($datosEnviar);
				$id = $this->_segmentos->ultimoSegmento();
				$datosEnviar = array(
						"id_segmento"=>$id["id_segmento"],
						"id_u_segmento"=>strtoupper(substr($id["nombre_segmento"],0,2)).$id["id_segmento"]
					);
				$this->_segmentos->actualizarSegmento($datosEnviar);
				$this->_view->assign("_mensaje","El segmento ha sido creado");
				$this->redireccionar('segmentos');

			}
			$this->_view->renderizar('crear_segmento',"catalogos");
		}

	}
?>
