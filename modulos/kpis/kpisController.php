<?php
	class kpisController extends Controller{
		private $_model;
		private $_dateUtils;
		private $_time;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_model = $this->loadModel('kpis');
			$this->getLibrary('dateUtils');
			$this->_dateUtils = new dateUtils();
			$this->_time=-60*60*0;
		}
		public function index(){
			$this->_view->assign('titulo','KPIs');
			$this->_view->setJs(array('jquery.circular-carousel','chosen.jquery','circle-progress','kpis','w2ui-fields-1.0.min','fireworks'));
			$this->_view->setCss(array('jquery.circular-carousel','chosen','w2ui-fields-1.0.min'));

			$fecha = explode("/",date('d/m/Y'));
			$ndia = mktime(0, 0, 0, $fecha[1], $fecha[0], $fecha[2]);

			if ($this->getInt('crear')=="1") {
				$kpi_nombre=$this->getSql("nombre_kpi");
				$kpi_descripcion=$this->getTexto("desc_kpi");
				$unidad_kpi=$this->getSql("unidad_kpi");

				if (isset($_POST["area_kpi"])) {
					$area_kpi=$_POST["area_kpi"];
				}else{
					$area_kpi=array();
				}

				if (isset($_POST["puesto_kpi"])) {
					$puesto_kpi=$_POST["puesto_kpi"];
				}else{
					$puesto_kpi=array();
				}
				
				if (isset($_POST["usuario_kpi"])) {
					$usuario_kpi=$_POST["usuario_kpi"];
				}else{
					$usuario_kpi=array();
				}

				
				$id_usuario=Session::get('id_usuario');

				// Crear kpi
				$datosEnviar = array(
					"kpi_nombre"=>$kpi_nombre,
					"kpi_descripcion"=>$kpi_descripcion,
					"id_usuario"=>$id_usuario,
					"id_unidad"=>$unidad_kpi,
					"id_kpi_valor"=>0,
					"fecha_creacion"=>$ndia,
					"activo"=>1,
					"fecha_actual"=>$ndia
				);
				$this->_model->crearKpi($datosEnviar);
				$ultimo = $this->_model->ultimoKpi($id_usuario);

				// Crear valores por default
				$datosEnviar = array(
					"fecha"=>$ndia,
					"id_kpi"=>$ultimo["id_kpi"],
					"v_actual"=>0,
					"v_meta"=>0,
					"id_usuario"=>$id_usuario
				);
				$this->_model->crearKpiValores($datosEnviar);

				// asignar la relacion de los ultimos valores con 
				$ultimoValor = $this->_model->ultimoKpiValor($ndia,$ultimo["id_kpi"]);
				$datosEnviar = array(
					"id_kpi"=>$ultimo["id_kpi"],
					"id_kpi_valor"=>$ultimoValor["id_kpi_valor"]
				);
				$this->_model->actualizarKpi($datosEnviar);

				// almacenar las areas
				$todos=true;
				for ($i=0;$i<count($area_kpi);$i++)    
				{
					if ($todos) {
						$datosEnviar = array(
							"id_kpi"=>$ultimo["id_kpi"],
							"id_area"=>$area_kpi[$i]
						);
						$this->_model->crearKpiArea($datosEnviar);
					}
					if ($area_kpi[$i]==0) {
						$todos=false;
					}
				}
				$todos=true;
				for ($i=0;$i<count($puesto_kpi);$i++)    
				{
					if ($todos) {
						$datosEnviar = array(
							"id_kpi"=>$ultimo["id_kpi"],
							"id_puesto"=>$puesto_kpi[$i]
						);
						$this->_model->crearKpiPuesto($datosEnviar);
					}
					if ($puesto_kpi[$i]==0) {
						$todos=false;
					}
				} 
				$todos=true;
				for ($i=0;$i<count($usuario_kpi);$i++)    
				{
					if ($todos) {
						$datosEnviar = array(
							"id_kpi"=>$ultimo["id_kpi"],
							"id_usuario"=>$usuario_kpi[$i]
						);
						$this->_model->crearKpiUsuario($datosEnviar);
					}
					if ($usuario_kpi[$i]==0) {
						$todos=false;
					}
				}
				$this->_view->assign("_mensaje","Se ha creado un KPI");
			}
			if ($this->getInt('modificar')=="1") {
				$id_kpi=$this->getSql("kpi_c");
				$kpi_nombre=$this->getSql("nombre_kpi_c");
				$kpi_descripcion=$this->getTexto("desc_kpi_c");
				$unidad_kpi=$this->getSql("unidad_kpi_c");
				$area_kpi=$_POST["area_kpi_c"];
				$puesto_kpi=$_POST["puesto_kpi_c"];
				$usuario_kpi=$_POST["usuario_kpi_c"];

				$datosEnviar = array(
					"id_kpi"=>$id_kpi,
					"kpi_nombre"=>$kpi_nombre,
					"kpi_descripcion"=>$kpi_descripcion,
					"id_unidad"=>$unidad_kpi,
					"fecha_actual"=>$ndia
				);
				$this->_model->actualizarKpi($datosEnviar);


				$this->_model->eliminarKpiArea($id_kpi);
				$this->_model->eliminarKpiPuesto($id_kpi);
				$this->_model->eliminarKpiUsuario($id_kpi);

				// almacenar las areas
				$todos=true;
				for ($i=0;$i<count($area_kpi);$i++)    
				{
					if ($todos) {
						$datosEnviar = array(
							"id_kpi"=>$id_kpi,
							"id_area"=>$area_kpi[$i]
						);
						$this->_model->crearKpiArea($datosEnviar);
					}
					if ($area_kpi[$i]==0) {
						$todos=false;
					}
				}
				$todos=true;
				for ($i=0;$i<count($puesto_kpi);$i++)    
				{
					if ($todos) {
						$datosEnviar = array(
							"id_kpi"=>$id_kpi,
							"id_puesto"=>$puesto_kpi[$i]
						);
						$this->_model->crearKpiPuesto($datosEnviar);
					}
					if ($puesto_kpi[$i]==0) {
						$todos=false;
					}
				} 
				$todos=true;
				for ($i=0;$i<count($usuario_kpi);$i++)    
				{
					if ($todos) {
						$datosEnviar = array(
							"id_kpi"=>$id_kpi,
							"id_usuario"=>$usuario_kpi[$i]
						);
						$this->_model->crearKpiUsuario($datosEnviar);
					}
					if ($usuario_kpi[$i]==0) {
						$todos=false;
					}
				} 

				$this->_view->assign("_mensaje","Se ha modificado el KPI");

			}
			$this->_view->assign("datos",$this->_model->getKpis());
			$this->_view->assign("usuarios",$this->_model->getUsuarios());
			$unidades_medida = array(
				"Moneda"=>array(
					"m_1"=>array(
						"signo"=>"MXN",
						"nombre"=>"Pesos Mexicanos",
						"formato"=>"mx-money"
					),
					"m_2"=>array(
						"signo"=>"USD",
						"nombre"=>"Dolares",
						"formato"=>"us-money"
					),
					"m_3"=>array(
						"signo"=>"EUR",
						"nombre"=>"Euros",
						"formato"=>"eu-money"
					),
					"m_4"=>array(
						"signo"=>"COP",
						"nombre"=>"Pesos Colombianos",
						"formato"=>"co-money"
					)
				),
				"Tiempo"=>array(
					"t_1"=>array(
						"signo"=>"H",
						"nombre"=>"Horas",
						"formato"=>"int-format"
					),
					"t_2"=>array(
						"signo"=>"D",
						"nombre"=>"Dias",
						"formato"=>"int-format"
					),
					"t_3"=>array(
						"signo"=>"S",
						"nombre"=>"Semana",
						"formato"=>"int-format"
					),
					"t_4"=>array(
						"signo"=>"M",
						"nombre"=>"Mes",
						"formato"=>"int-format"
					),
					"t_5"=>array(
						"signo"=>"Tr",
						"nombre"=>"Trimestre",
						"formato"=>"int-format"
					),
					"t_6"=>array(
						"signo"=>"Se",
						"nombre"=>"Semestre",
						"formato"=>"int-format"
					),
					"t_7"=>array(
						"signo"=>"Año",
						"nombre"=>"Año",
						"formato"=>"int-format"
					)
				),
				"Volumen"=>array(
					"v_1"=>array(
						"signo"=>"Lt",
						"nombre"=>"Litros",
						"formato"=>"float-format"
					),
					"v_2"=>array(
						"signo"=>"cm3",
						"nombre"=>"Centimetros Cubicos",
						"formato"=>"float-format"
					),
					"v_3"=>array(
						"signo"=>"m3",
						"nombre"=>"Metros Cubicos",
						"formato"=>"float-format"
					)
				),
				"Mercadotecnia"=>array(
					"me_1"=>array(
						"signo"=>"Ld",
						"nombre"=>"Leads",
						"formato"=>"int-format"
					),
					"me_2"=>array(
						"signo"=>"Cl",
						"nombre"=>"Clientes",
						"formato"=>"int-format"
					)
				),
				"Sistemas"=>array(
					"si_1"=>array(
						"signo"=>"Rq",
						"nombre"=>"Requerimientos Informaticos",
						"formato"=>"int-format"
					)
				),
				"Finanzas"=>array(
					"fi_1"=>array(
						"signo"=>"Tp",
						"nombre"=>"Tasa porcentual",
						"formato"=>"percent-format"
					)
				)
			);
			
			$u_m_f=array();
			foreach ($unidades_medida as $key) {
				foreach ($key as $key2=> $value2) {
					$u_m_f[$key2]=array(
						"signo"=>$value2["signo"],
						"nombre"=>$value2["nombre"],
						"formato"=>$value2["formato"]
					);
				}
			}
			$this->_view->assign("unidades_medida",$unidades_medida);
			
			$fechaActual = $this->primerDiaMes(date('d/m/Y'));
			$fechaFormat = explode("/", $fechaActual, 3);
			$nuevoMes = mktime(0, 0, 0, $fechaFormat[1], $fechaFormat[0], $fechaFormat[2]);

			$this->_view->assign("nuevoMes",$nuevoMes);
			$this->_view->assign("u_m_f",$u_m_f);
			$this->_view->renderizar('index');
		}
		private function primerDiaMes($fecha){
			$fechaFormat = $this->_dateUtils->formatearFecha($fecha);
			return "01/" . $fechaFormat["mes"] . "/" . $fechaFormat["anio"];
		}
		private function incrementarMes($fecha){
			$fechaFormat = $this->_dateUtils->formatearFecha($fecha);
			$fechaFormat["dia"]=1;
			$fechaFormat["mes"]+=1;
			if ($fechaFormat["mes"]>12) {
				$fechaFormat["mes"]=1;
				$fechaFormat["anio"]+=1;
			}
			return $fechaFormat["dia"] . "/" . $fechaFormat["mes"] . "/" . $fechaFormat["anio"];
		}
		public function actualizarKpis(){
			$v_actual=$this->getSql("actual");
			$v_meta = $this->getSql('meta');
			$id_kpi = $this->getSql('kpi');
			if ($v_actual!="" && $v_meta!="" && $id_kpi!="") {
				$fecha = explode("/",date('d/m/Y'));
				$ndia = mktime(0, 0, 0, $fecha[1], $fecha[0], $fecha[2]);
				$id_usuario=Session::get('id_usuario');
				$ultimoValor = $this->_model->ultimoKpiValor($ndia,$id_kpi);

				$order   = array("$", "," , "€", "%", ' ');
				$replace = '';
				$v_actual = str_replace($order, $replace, $v_actual);
				$v_meta = str_replace($order, $replace, $v_meta);
				if (is_array($ultimoValor)) {
					// Crear valores por default
					$datosEnviar = array(
						"id_kpi_valor"=>$ultimoValor["id_kpi_valor"],
						"v_actual"=>$v_actual,
						"v_meta"=>$v_meta,
						"id_usuario"=>$id_usuario
					);
					$this->_model->actualizarKpiValores($datosEnviar);
				}else{
					// Crear valores por default
					$datosEnviar = array(
						"fecha"=>$ndia,
						"id_kpi"=>$id_kpi,
						"v_actual"=>$v_actual,
						"v_meta"=>$v_meta,
						"id_usuario"=>$id_usuario
					);
					$this->_model->crearKpiValores($datosEnviar);
				}
				// asignar la relacion de los ultimos valores con 
				$ultimoValor = $this->_model->ultimoKpiValor($ndia,$id_kpi);
				$datosEnviar = array(
					"id_kpi"=>$id_kpi,
					"id_kpi_valor"=>$ultimoValor["id_kpi_valor"],
					"fecha_actual"=>$ndia
				);
				$this->_model->actualizarKpi($datosEnviar);
				$usuario=$this->_model->getNombreUsuario($id_usuario);
				echo json_encode($usuario["nombre"]);
			}else{
				echo json_encode("None");
			}
		}
		public function eliminarKpi(){
	    	$id_kpi = $this->getSql('kpi');
	    	if ($id_kpi!="") {
		    	$datosEnviar = array(
					"id_kpi"=>$id_kpi,
					"activo"=>0
				);
				$this->_model->actualizarKpi($datosEnviar);
				echo json_encode("Good");
			}else{
				echo json_encode("None");
			}
	    }
	    public function obtenerKpi(){
	    	$id_kpi = $this->getSql('kpi');
	    	if ($id_kpi!="") {
				$datos = array(
					"informacion"=>$this->_model->getKpi($id_kpi),
					"kpi_area"=>$this->_model->getKpi_area($id_kpi),
					"kpi_puesto"=>$this->_model->getKpi_puesto($id_kpi),
					"kpi_usuario"=>$this->_model->getKpi_usuario($id_kpi)
					);
				echo json_encode($datos);
			}else{
				echo json_encode("None");
			}
	    }
	    public function buscarKpi(){
	    	$nombre = $this->getSql('nombre');
	    	$unidad = $this->getSql('unidad');
	    	$area = explode(",", $_POST["area"]);
	    	$puesto = explode(",", $_POST["puesto"]);
	    	$usuario = explode(",", $_POST["usuario"]);
	    	$datos="None";
	    	if ($nombre!="") {
	    		$dato1=array();
	    		$dato = $this->_model->getKpi_x_Nombre($nombre);
	    		foreach ($dato as $key ) {
	    			array_push($dato1, $key["id_kpi"]);
	    		}
	    		$datos=$dato1;
	    	}
	    	if ($unidad!="0") {
	    		$dato1=array();
	    		$dato = $this->_model->getKpi_x_Unidad($unidad);
	    		foreach ($dato as $key ) {
	    			array_push($dato1, $key["id_kpi"]);
	    		}
	    		if (is_array($datos)) {
	    			$datos = array_intersect($datos, $dato1);
	    		}else{
	    			$datos = $dato1;
	    		}
	    		
	    	}
	    	if ($area[0]!="null") {
	    		$dato1=array();
	    		$consulta="";
	    		$todo=false;
	    		for ($i=0; $i < count($area); $i++) { 
	    			if ($area[$i]!="0") {
		    			$consulta.="id_area = ".$area[$i];
		    			if ($i<count($area)-1) {
		    				$consulta.=" OR ";
		    			}
		    		}else{
	    				$i = count($area);
	    				$todo=true;
	    			}
	    		}
	    		$consulta= "(".$consulta.")";
	    		if ($todo) {
	    			$dato = $this->_model->getKpis();
	    		}else{
	    			$dato = $this->_model->getKpi_x_Area($consulta);
	    		}
	    		foreach ($dato as $key ) {
	    			array_push($dato1, $key["id_kpi"]);
	    		}
	    		if (is_array($datos)) {
	    			$datos = array_intersect($datos, $dato1);
	    		}else{
	    			$datos = $dato1;
	    		}
	    	}
	    	if ($puesto[0]!="null") {
	    		$dato1=array();
	    		$consulta="";
	    		$todo=false;
	    		for ($i=0; $i < count($puesto); $i++) {
	    			if ($puesto[$i]!="0") {
		    			$consulta.="id_puesto = ".$puesto[$i];
		    			if ($i<count($puesto)-1) {
		    				$consulta.=" OR ";
		    			}
		    		}else{
	    				$i = count($puesto);
	    				$todo=true;
	    			}
	    		}
	    		$consulta= "(".$consulta.")";
	    		if ($todo) {
	    			$dato = $this->_model->getKpis();
	    		}else{
	    			$dato = $this->_model->getKpi_x_Puesto($consulta);
	    		}
	    		foreach ($dato as $key ) {
	    			array_push($dato1, $key["id_kpi"]);
	    		}
	    		if (is_array($datos)) {
	    			$datos = array_intersect($datos, $dato1);
	    		}else{
	    			$datos = $dato1;
	    		}
	    	}
	    	if ($usuario[0]!="null") {
	    		$dato1=array();
	    		$consulta="";
	    		$todo=false;
	    		for ($i=0; $i < count($usuario); $i++) {
	    			if ($usuario[$i]!="0") {
	    				$consulta.="id_usuario=".$usuario[$i];
		    			if ($i<count($usuario)-1) {
		    				$consulta.=" OR ";
		    			}
	    			}else{
	    				$i = count($usuario);
	    				$todo=true;
	    			}
	    			
	    		}
	    		$consulta= "(".$consulta.")";
	    		if ($todo) {
	    			$dato = $this->_model->getKpis();
	    		}else{
	    			$dato = $this->_model->getKpi_x_Usuario($consulta);
	    		}
	    		foreach ($dato as $key ) {
	    			array_push($dato1, $key["id_kpi"]);
	    		}
	    		if (is_array($datos)) {
	    			$datos = array_intersect($datos, $dato1);
	    		}else{
	    			$datos = $dato1;
	    		}
	    	}
			echo json_encode($datos);
	    }
	    public function getKPI_Notas(){
			$id_kpi=$this->getSql("id");
			if ($id_kpi!="") {
				$id_tarea = (int) $id_kpi;
				if ($id_kpi!=0) {
					echo json_encode($this->_model->getKPI_Notas($id_kpi));
				}
			};
		}
	    public function crearKPI_Nota(){
			$id_kpi=$this->getSql("id");
			$comentario=$this->getSql("com");
			if ($id_kpi!="") {
				$id_kpi = (int) $id_kpi;
				if ($id_kpi!=0) {
					$fechahora=date("d/m/Y H:i", mktime()+$this->_time);
					$datosEnviar = array(
						"id_kpi"=>$id_kpi,
						"id_usuario"=>Session::get('id_usuario'),
						"comentario"=>$comentario,
						"fecha_nota"=>$fechahora
					);
					$this->_model->crearKPI_Kpi_Nota($datosEnviar);
					$usuario = $this->_model->getNombreUsuario(Session::get('id_usuario'));
					$datosEnviar = array(
						"fecha_nota"=>$fechahora,
						"nombre"=>$usuario["nombre"]
					);
					echo json_encode($datosEnviar);
				}else{
					echo json_encode("None");
				}
			}else{
				echo json_encode("None");
			}
		}
	}