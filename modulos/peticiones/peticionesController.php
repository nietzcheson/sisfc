<?php 
class peticionesController extends Controller{

	private $_peticion;

	public function __construct(){
		parent::__construct();
		$this->_peticion = $this->loadModel('peticiones');
	}

	public function index(){
	  	$this->_view->assign('titulo','Peticiones');
	  	$this->_view->setJs(array('peticiones'));
		$this->_view->assign("peticiones",$this->_peticion->getPeticiones());
		$this->_view->renderizar('index');
	}

	public function crear_peticion(){
		$this->_view->assign('titulo','Crear petición');
		$this->_view->assign("prioridades",$this->_peticion->getPrioridades());

		if(isset($_POST["crear"])==1){
			$this->_view->assign('post',$_POST);

			$prioridad = $this->getSql("prioridad");
			$peticion = $this->getSql("peticion");

			$errores="";
			if ($prioridad=="Seleccione") {
				$errores.="Seleccione la prioridad";
			}
			if ($peticion=="") {
				if ($errores!="") {
					$errores .="<br>Haga su petición";
				}
			}
			if ($errores!="") {
				$this->_view->assign("_error",$errores);
				$this->_view->renderizar('crear_peticion');
				exit;
			}

			$datosEnviar = array(
				"idprioridad" => $prioridad,
				"peticion" => $peticion,
				"idusuario" => $_SESSION["id_usuario"],
				"fecha" => DATE_NOW
				);

			$this->_peticion->crearPeticion($datosEnviar);
			$this->_view->assign("_mensaje","Se ha creado la petición");
			$this->redireccionar('peticiones');

		}

		$this->_view->renderizar('crear_peticion');
	}

	public function enviar(){
		echo json_encode($this->getSql("id"));
	}

}