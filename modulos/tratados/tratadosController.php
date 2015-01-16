<?php
	class tratadosController extends Controller{
		private $_tratados;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_tratados = $this->loadModel('tratados');
		}

		public function index(){
			$this->_view->assign('titulo','Tratados');
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_tratados->getTratados());
			$this->_view->renderizar('index');
		}
		public function perfil_tratado($id=false){
			if(!$id){
				$this->redireccionar('tratados');
				exit();
			}

			$this->_view->assign('titulo','Perfil tratado');
			if ($this->getInt('actualizar')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$sigla = $this->getSql("sigla");
				$nombre_tratado = $this->getSql("nombre_tratado");
				$fecha_firma = $this->getSql("fecha_firma");
				$fecha_vigor = $this->getSql("fecha_vigor");
				$errores="";
				if ($sigla=="") {
					$errores="Ingrese la sigla";
				}
				if ($nombre_tratado=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el nombre del tratado";
				}
				if ($fecha_firma=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la fecha de la firma";
				}
				if ($fecha_vigor=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la fecha de entrada en vigor";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_tratado');
					exit;
				}
				$datosEnviar = array(
					"id_u_tratado"=>$id,
					"sigla"=>$sigla,
					"nombre_tratado"=>$nombre_tratado,
					"fecha_firma"=>$fecha_firma,
					"fecha_vigor"=>$fecha_vigor
				);
				$this->_tratados->actualizarSTratado($datosEnviar);
				$this->_tratados->eliminarTratadoPaisesModel($id);
				$values = array_keys($_POST);
				for ($i=0; $i < count($values) ; $i++) {
					if (substr($values[$i],0,5)=='pais_') {
						if ($_POST[$values[$i]]) {
							$datosEnviar = array(
								"id_u_tratado"=>$id,
								"id_pais"=>substr($values[$i],5, strlen($values[$i])-4)
							);
							$this->_tratados->crearTratadoPais($datosEnviar);
						}
					}
				}

				$this->_view->assign("_mensaje","El tratado ha sido actualizado");
			}
			$this->_view->assign("identifica",$id);
			$this->_view->assign("datos",$this->_tratados->getTratado($id));
			$this->_view->assign("paises",$this->_tratados->getPaises());

			$paisesarr = $this->_tratados->getTratadoPaises($id);
			$paisesli = array();
			foreach ($paisesarr as $key=>$value) {
				array_push($paisesli,$value["id_pais"]);
			}
			//echo print_r($paisesli);
			//exit();
			$this->_view->assign("paises2",$paisesli);
			$this->_view->renderizar('perfil_tratado');
		}

		public function eliminarTratado()
		{
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_tratados->eliminarTratadoModel($id);
				$this->_tratados->eliminarTratadoPaisesModel($id);
			}
		}

		public function crear_tratado(){
			$this->_view->assign('titulo','Crear tratado');
			$this->_view->assign("paises",$this->_tratados->getPaises());
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign("datos",$_POST);
				$sigla = $this->getSql("sigla");
				$nombre_tratado = $this->getSql("nombre_tratado");
				$fecha_firma = $this->getSql("fecha_firma");
				$fecha_vigor = $this->getSql("fecha_vigor");
				$errores="";
				if ($sigla=="") {
					$errores="Ingrese la sigla";
				}
				if ($nombre_tratado=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el nombre del tratado";
				}
				if ($fecha_firma=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la fecha de la firma";
				}
				if ($fecha_vigor=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la fecha de entrada en vigor";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
					$this->_view->renderizar('crear_tratado');
					exit;
				}

				$datosEnviar = array(
					"id_u_tratado"=>"dummy",
					"sigla"=>$sigla,
					"nombre_tratado"=>$nombre_tratado,
					"fecha_firma"=>$fecha_firma,
					"fecha_vigor"=>$fecha_vigor
				);
				$this->_tratados->crearTratado($datosEnviar);
				$id = $this->_tratados->ultimoTratado();
				$datosEnviar = array(
						"id_tratado"=>$id["id_tratado"],
						"id_u_tratado"=>strtoupper(substr($id["nombre_tratado"],0,2)).$id["id_tratado"]
					);
				$this->_tratados->actualizarSTratado($datosEnviar);
				$id = strtoupper(substr($id["nombre_tratado"],0,2)).$id["id_tratado"];
				$values = array_keys($_POST);
				for ($i=0; $i < count($values) ; $i++) {
					if (substr($values[$i],0,5)=='pais_') {
						if ($_POST[$values[$i]]) {
							$datosEnviar = array(
								"id_u_tratado"=>$id,
								"id_pais"=>substr($values[$i],5, strlen($values[$i])-4)
							);
							$this->_tratados->crearTratadoPais($datosEnviar);

						}
					}
				}
				$this->_view->assign("_mensaje","El tratado ha sido creado");
				$this->redireccionar('tratados');
			}
			$this->_view->renderizar('crear_tratado');
		}

	}
?>
