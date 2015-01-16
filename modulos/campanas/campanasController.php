<?php

class campanasController extends Controller{

	private $_campanas;
	public function __construct(){
		parent::__construct();
		$this->_acl->acceso('todo');
		$this->_campanas = $this->loadModel('campanas');
	}

	public function index(){
		$this->_view->assign("titulo",'Campañas');
		$this->_view->setJs(array('index'));
		$this->_view->assign("campanas",$this->_campanas->getTiposAso());
		$this->_view->renderizar('index');
	}
	public function crear_campana(){
		$this->_view->assign("titulo",'Crear campaña');
		$this->_view->assign("tipos",$this->_campanas->get_tipos());
		if ($this->getInt('crear')=="1")
		{
			$this->_view->assign("datos",$_POST);
			$nombre_campana = $this->getSql("nombre_campana");
			$tipo_campana = $this->getInt("tipo_campana");
			$fecha_inicio = $this->getTexto("fecha_inicio");
			$fecha_fin = $this->getTexto("fecha_fin");
			$costo_p = $this->getFloat("costo_p");
			$costo_r = $this->getFloat("costo_r");
			$ingreso_previsto = $this->getFloat("ingreso_previsto");
			$descripcion_campana = $this->getTexto("descripcion_campana");
			$errores="";
			$this->getLibrary('dateUtils');
			$dateUtils = new dateUtils();
			if ($nombre_campana=="") {
				$errores="Ingrese un nombre de campaña";
			}
			if ($tipo_campana==0) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Elija un tipo de campaña";
			}
			if ($fecha_inicio=="") {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Selecione fecha de inicio";
			}
			if (count($dateUtils->formatearFecha($fecha_inicio))==0) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="La fecha de inicio es incorrecta";
			}

			if ($fecha_fin=="") {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Seleccione fecha final";
			}
			if (count($dateUtils->formatearFecha($fecha_fin))==0) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="La fecha final es incorrecta";
			}
			if ($costo_p==0) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Ingrese el costo presupuestado";
			}
			if ($costo_r==0) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Ingrese el costo real";
			}
			if ($ingreso_previsto==0) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Ingrese el costo previsto";
			}
			if (!$descripcion_campana) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Ingrese la descripción de la campaña";
			}
			if ($errores!="") {
				$this->_view->assign("tipos",$this->_campanas->get_tipos());
				$this->_view->assign("_error",$errores);
				$this->_view->renderizar('crear_campana');
				exit;
			}
			$datosEnviar = array(
					"id_u_campana"=>"dummy",
					"nombre_campana"=>$nombre_campana,
					"tipo_campana"=>$tipo_campana ,
					"fecha_inicio"=>$fecha_inicio,
					"fecha_fin"=>$fecha_fin,
					"costo_presupuestado"=>$costo_p,
					"costo_real"=>$costo_r,
					"ingreso_previsto"=>$ingreso_previsto,
					"descripcion_campana"=>$descripcion_campana
				);
			$this->_campanas->crearCampana($datosEnviar);
			$id = $this->_campanas->ultimoCampana();
			$datosEnviar = array(
					"id_campana"=>$id["id_campana"],
					"id_u_campana"=>strtoupper(substr($id["nombre_campana"],0,1)).$id["id_campana"]
				);
			$this->_campanas->actualizarCampana($datosEnviar);
			$this->_view->assign("_mensaje","La campaña ha sido creada");
			$this->redireccionar('campanas');
			exit;
		}
		$this->_view->renderizar('crear_campana');
	}
	public function perfil_campana($id=false){
		$this->_view->assign("titulo",'Perfil de campaña');
		if(!$id){
			$this->redireccionar('campanas');
			exit();
		}
		$id = (string) $id;
		if ($this->getInt('actualizar')=="1")
		{
			$nombre_campana = $this->getSql("nombre_campana");
			$tipo_campana = $this->getInt("tipo_campana");
			$fecha_inicio = $this->getTexto("fecha_inicio");
			$fecha_fin = $this->getTexto("fecha_fin");
			$costo_p = $this->getFloat("costo_p");
			$costo_r = $this->getFloat("costo_r");
			$ingreso_previsto = $this->getFloat("ingreso_previsto");
			$descripcion_campana = $this->getTexto("descripcion_campana");
			$errores="";
			$this->getLibrary('dateUtils');
			$dateUtils = new dateUtils();
			if ($nombre_campana=="") {
				$errores="Ingrese un nombre de campaña";
			}
			if ($tipo_campana==0) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Elija un tipo de campaña";
			}
			if ($fecha_inicio=="") {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Selecione fecha de inicio";
			}
			if (count($dateUtils->formatearFecha($fecha_inicio))==0) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="La fecha de inicio es incorrecta";
			}

			if ($fecha_fin=="") {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Seleccione fecha final";
			}
			if (count($dateUtils->formatearFecha($fecha_fin))==0) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="La fecha final es incorrecta";
			}
			if ($costo_p==0) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Ingrese el costo presupuestado";
			}
			if ($costo_r==0) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Ingrese el costo real";
			}
			if ($ingreso_previsto==0) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Ingrese el costo previsto";
			}
			if (!$descripcion_campana) {
				if ($errores!="") {
					$errores .="<br>";
				}
				$errores.="Ingrese la descripción de la campaña";
			}
			if ($errores!="") {
				$this->_view->assign("identifica",$id);
				$this->_view->assign("datos",$this->_campanas->getCampana($id));
				$this->_view->assign("tipos",$this->_campanas->get_tipos());
				$this->_view->assign("_error",$errores);
				$this->_view->renderizar('perfil_campana');
				exit;
			}
			$datosEnviar = array(
					"id_u_campana"=>$id,
					"nombre_campana"=>$nombre_campana,
					"tipo_campana"=>$tipo_campana,
					"fecha_inicio"=>$fecha_inicio,
					"fecha_fin"=>$fecha_fin,
					"costo_presupuestado"=>$costo_p,
					"costo_real"=>$costo_r,
					"ingreso_previsto"=>$ingreso_previsto,
					"descripcion_campana"=>$descripcion_campana
				);
			$this->_campanas->actualizarCampana($datosEnviar);
			$this->_view->assign("_mensaje","Perfil campañia actualizada");
		}
		$this->_view->assign("identifica",$id);
		$this->_view->assign("datos",$this->_campanas->getCampana($id));
		$this->_view->assign("tipos",$this->_campanas->get_tipos());
		$this->_view->renderizar('perfil_campana');
	}

	public function tipos_campana(){
		$this->_view->assign("titulo",'Tipos de campañas');
		$this->_view->setJs(array('tipos_campanas'));
		$this->_view->assign("datos",$this->_campanas->get_tipos());
		$this->_view->renderizar('tipos_campana');
	}

	public function tipos_campana_crear(){
		if($this->getTexto('nombre_tipo')){
			$nombre_tipo = $this->getSql("nombre_tipo");
			if($nombre_tipo==""){
				exit;
			}
			if(!$nombre_tipo){
				exit;
			}
			$this->_campanas->crear_tipo($nombre_tipo);
			echo json_encode($this->_campanas->ultimo_tipo());
		}else{
			echo json_encode("");
		}

	}

	public function tipos_campana_actualizar(){
		$id = (int) $_POST["id"];
		$valor = (string) $_POST["valor"];
		if($this->getInt("id") && $this->getTexto("valor")){
			$this->_campanas->actualizar_tipos($id,$valor);
		}
	}

	public function tipos_campana_eliminar(){
		$id = (int) $_POST["id"];
		if($this->getInt("id")){
			$this->_campanas->eliminar_tipos($id);
		}
	}

	public function actualizar_lista(){
		echo json_encode($this->_campanas->get_tipos());
	}

	public function eliminarCampana()
	{
		$id=$this->getTexto("id");
		if($id){
			$this->_campanas->eliminarCampanaModel($id);
		}
	}
}


?>
