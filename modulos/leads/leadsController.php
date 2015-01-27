<?php
	class leadsController extends Controller{
		private $_leads;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_leads = $this->loadModel('leads');
		}

		public function index(){
			$this->_view->assign('titulo','Leads');
			$btnHeader = array(

				array(
					"titulo" => "Embudo de ventas",
					"enlace" => "leads/embudo"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_leads->getLeads());
			$this->_view->assign("estatus",$this->_leads->getEstatus());
			$this->_view->renderizar('index',"clientes");
		}

		public function embudo(){
			$this->_view->assign('titulo','Embudo de ventas');
			$this->_view->setJs(array("graficas"));
			$this->_view->setCss(array("graficas"));
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "leads"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);

			$estatus = $this->_leads->getEstatus();
			$leads_en_operacion = 0;
			$leads_sin_operacion = 0;
			for($i=0;$i<count($estatus);$i++){
				$ids = $estatus[$i]["id"];
				$estatus[$i]["cantidad_leads"] = count($this->_leads->getProspectoEstatus($ids));
				if($estatus[$i]["acumulado"]==1){
					$leads_en_operacion = $leads_en_operacion + $estatus[$i]["cantidad_leads"];
				}else if($estatus[$i]["acumulado"]==0){
					$leads_sin_operacion = $leads_sin_operacion + $estatus[$i]["cantidad_leads"];
				}
			}

			$this->_view->assign("leads_en_operacion",$leads_en_operacion);
			$this->_view->assign("leads_sin_operacion",$leads_sin_operacion);
			$this->_view->assign("embudo",$estatus);



			$estatus_ventas = array();
			$total_leads = count($this->_leads->getTotalLeads());
			$sin_estatus = count($this->_leads->getProspectoEstatusCero());
			foreach($estatus as $st){
				$estatus_ventas [] = array(
					"estatus" => $st["estatus"],
					"cantidad" => count($this->_leads->getProspectoEstatus($st["id"])),
					"porcentaje" => "1"
				);
			}

			$this->_view->assign("estatus",$estatus_ventas);
			$this->_view->assign("sin_estatus",$sin_estatus);
			$this->_view->assign("total_leads",$total_leads);
			$this->_view->renderizar('embudo',"clientes");
		}

		public function listado_leads(){
			$this->_view->assign('titulo','Listado de leads');
			//$this->_view->setJs(array('index'));
			//$this->_view->assign("datos",$this->_leads->getClasiLeads());
			$this->_view->renderizar('listado_leads');
		}

		public function crearClasificacionLeads(){
			$this->_view->assign('titulo','Clasificación Leads');
			//$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_leads->getClasiLeads());
			$this->_view->renderizar('clasificacion');
		}

		public function eliminarLead()
		{
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_leads->eliminarProspectoModel($id);
			}
		}

		public function perfil_lead($id = false)
		{
			$prospecto = $this->_view->widget('prospecto', 'getProspecto',array($id));

			$this->_view->assign('titulo','Perfil del lead');
			$btnHeader = array(
				array(
					"titulo" => "return",
					"enlace" => "leads"
				),
				array(
					"titulo" => "Calificación",
					"enlace" => "calificacion/calificar/".$id."/2",
					"estilo"  => "danger"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);

			$this->_view->assign("prospecto",$prospecto);
			$this->_view->renderizar('perfil_lead', "clientes");
		}

		// public function perfil_lead($id=false){
		// 	if(!$id){
		// 		$this->redireccionar('leads');
		// 		exit();
		// 	}
		//
		// 	$prospecto = $this->_view->widget('prospecto', 'getProspecto',array($id));
		//
		// 	$this->_view->assign("prospecto",$prospecto);
		//
		// 	$empresasFC = function() use($id){
		// 		$empresas = $this->_leads->empresasFC();
		//
		// 		$getEmpresas = $this->_leads->getEmpresasFC($id);
		//
		// 		for($i=0;$i<count($empresas);$i++){
		// 			for($e=0;$e<count($getEmpresas);$e++){
		// 				if($getEmpresas[$e]["id_empresa"]==$empresas[$i]["id_empresa"]){
		// 					$empresas[$i]["enDB"] = "x";
		// 				}
		// 			}
		//
		// 		}
		// 		$this->_view->assign("empresas",$empresas);
		// 		$this->_view->assign("empresasFC",$getEmpresas);
		// 	};
		//
		// 	$empresasFC();
		//
		// 	$this->_view->assign('datos_perfil', ROOT . 'componentes/perfilcliente/datos.tpl');
		// 	$this->_view->assign('datos_calificacion', ROOT . 'componentes/perfilcliente/datosCalificacion.tpl');
		//
		// 	$this->_view->assign('bitacora', $this->_view->widget('bitacora', 'getBitacora'));
		//
		//
		// 	$tiposDatos = $this->_leads->getTiposDatos();
		// 	$this->_view->assign("tiposDatos",$tiposDatos);
		//
		// 	$datos_adicionales = $this->_leads->getDatosAdicionales($id);
		// 	$this->_view->assign("datos_adicionales",$datos_adicionales);
		// 	$id_datos_adicionales = "";
		//
		// 	for($i=0;$i<count($datos_adicionales);$i++){
		// 		$id_datos_adicionales[$i] = $datos_adicionales[$i]["id"];
		// 	}
		//
		// 	$calificacion = $this->_leads->getCalificacion($id);
		// 	$this->_view->assign('calificacion',$calificacion);
		//
		//
		// 	$this->_view->setJs(array('ajax','calificar'));
		// 	$this->_view->assign('titulo','Perfil del lead');
		// 	$btnHeader = array(
		//
		// 		array(
		// 			"titulo" => "return",
		// 			"enlace" => "leads"
		// 		),
		// 		array(
		// 			"titulo" => "Calificación",
		// 			"enlace" => "calificacion/calificar/".$id."/2",
		// 			"estilo"  => "danger"
		// 		)
		// 	);
		// 	$this->_view->assign("btnHeader",$btnHeader);
		// 	$this->_view->assign("paises",$this->_leads->getPaises());
		// 	$this->_view->assign("perfil_lead",1);
		// 	$this->_view->assign("estatus",$this->_leads->getEstatus());
		// 	$this->_view->assign("campanas",$this->_leads->getCampanas());
		// 	$this->_view->assign("segmentos",$this->_leads->getSegmentos());
		//
		// 	$datos = $this->_leads->getProspectoLead($id);
		// 	$this->_view->assign("datos",$datos);
		//
		// 	if($datos["s_referencias"]=="1")
		// 	{
		// 		$referencias = $this->_leads->getInternos();
		// 		$this->_view->assign("referencias",$referencias);
		// 	}
		//
		// 	if($datos["s_referencias"]=="2")
		// 	{
		// 		$referencias = array("x");
		// 		$this->_view->assign("referencias",$referencias);
		// 	}
		// 	if ($datos["s_referencias"]=="3")
		// 	{
		// 		$referencias = $this->_leads->getEmpresas();
		// 		$this->_view->assign("referencias",$referencias);
		// 	}
		//
		// 	if (count($datos)==1) {
		// 		$this->redireccionar('leads');
		// 		exit();
		// 	}
		// 	$this->_view->assign("datos",$datos);
		// 	if ($datos["s_referencias"]=="1") {
		// 		$this->_view->assign("datos3",$this->_leads->getInternos());
		// 	}
		// 	if ($datos["s_referencias"]=="2") {
		// 		//$this->_view->assign("datos2",$this->_leads->getInternos());
		// 	}
		// 	if ($datos["s_referencias"]=="3") {
		// 		$this->_view->assign("datos3",$this->_leads->getEmpresas());
		// 	}
		// 	$this->_view->assign("activo",1);
		// 	if ($this->getInt('prospecto_lead')=="1")
		// 	{
		//
		// 		$datos_adicionales_ = "";
		// 		if(isset($_POST["id_dato_"])){
		// 			$datos_adicionales_ = $_POST["id_dato_"];
		// 		}
		//
		//
		// 		$datosAdicionales = "";
		// 		$tiposDatos = "";
		// 		if(isset($_POST["id_tipodato"])){
		// 			$selects = $_POST["id_tipodato"];
		// 			$inputs = $_POST["dato"];
		// 			$tiposDatos = $this->_leads->getTiposDatos();
		//
		// 			if($selects!=""){
		// 				if(count($selects)==count($inputs)){
		// 					for($i=0;$i<count($selects);$i++){
		// 						$datosAdicionales[$i]["id_tipodato"] = $selects[$i];
		// 						$datosAdicionales[$i]["dato"] = $inputs[$i];
		// 					}
		// 				}
		// 			}
		// 		}
		//
		// 		$nombre_prospecto= $this->getSql("nombre_prospecto");
		// 		$apellido_prospecto= $this->getSql("apellido_prospecto");
		// 		$estatus = $this->getSql("id_estatus");
		// 		$telefono_prospecto= $this->getSql("telefono_prospecto");
		// 		$celular_prospecto= $this->getSql("celular_prospecto");
		// 		$email_prospecto= $this->getSql("email_prospecto");
		// 		if (!$this->validarEmail($email_prospecto)) {
		// 			$email_prospecto="";
		// 		}
		// 		$web_prospecto= $this->getSql("web_prospecto");
		// 		$pais_prospecto= $this->getSql("pais_prospecto");
		// 		$estado_prospecto= $this->getSql("estado_prospecto");
		// 		$ciudad_prospecto= $this->getSql("ciudad_prospecto");
		// 		$campana_prospecto= $this->getSql("campana_prospecto");
		// 		$segmento_prospecto= $this->getSql("segmento_prospecto");
		// 		$s_referencias= $this->getSql("s_referencias");
		// 		$referencia_prospecto= $this->getSql("referencia_prospecto");
		//
		// 		$errores="";
		// 		if ($nombre_prospecto=="") {
		// 			$errores="Ingrese el nombre del prospecto";
		// 		}
		// 		if ($apellido_prospecto=="") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="Ingrese el apellido del prospecto";
		// 		}
		// 		if ($estatus=="Seleccione") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="Seleccione el estatus";
		// 		}
		// 		if ($estatus=="Seleccione") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="Escoja el estatus";
		// 		}
		// 		if ($telefono_prospecto=="") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="Ingrese el telefono del prospecto";
		// 		}
		// 		if ($email_prospecto=="") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="El email del prospecto es incorrecto";
		// 		}
		// 		if ($pais_prospecto=="Seleccione") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="Seleccione el pais del prospecto";
		// 		}
		// 		if ($campana_prospecto=="Seleccione") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="Seleccione la campaña del prospecto";
		// 		}
		// 		if ($segmento_prospecto=="Seleccione") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="Seleccione el segmento del prospecto";
		// 		}
		// 		if ($s_referencias=="Seleccione" || $referencia_prospecto=="Seleccione") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="Debe seleccionar la referencia";
		// 		}
		// 		if ($errores!="") {
		// 			$this->_view->assign("_error",$errores);
		// 			$this->_view->renderizar('perfil_lead',"clientes");
		// 			$datos = $this->_leads->getProspectoLead($id);
		// 			$this->_view->assign("datos",$datos);
		//
		// 			if($datos["s_referencias"]=="1")
		// 			{
		// 				$referencias = $this->_leads->getInternos();
		// 				$this->_view->assign("referencias",$referencias);
		// 			}
		//
		// 			if($datos["s_referencias"]=="2")
		// 			{
		// 				$referencias = array("x");
		// 				$this->_view->assign("referencias",$referencias);
		// 			}
		// 			if ($datos["s_referencias"]=="3")
		// 			{
		// 				$referencias = $this->_leads->getEmpresas();
		// 				$this->_view->assign("referencias",$referencias);
		// 			}
		//
		// 			exit;
		// 		}
		//
		// 		if(isset($_POST["id_dato_"])){
		//
		// 			$diferencias = array_diff($id_datos_adicionales,$datos_adicionales_);
		// 			$igualdad = array_intersect($id_datos_adicionales, $datos_adicionales_);
		//
		// 			foreach($diferencias as $ide){
		// 				$this->_leads->eliminarDatoAdicional($ide);
		// 			}
		//
		//
		// 			$ids = $_POST["id_dato_"];
		// 			$id_tipos = $_POST["id_tipodato_"];
		// 			$datos = $_POST["dato_"];
		//
		// 			for($i=0;$i<count($igualdad);$i++){
		//
		// 				$datosEnviar = array(
		// 					"id" => $ids[$i],
		// 					"id_tipodato" => $id_tipos[$i],
		// 					"dato" => $datos[$i]
		// 				);
		//
		// 				$this->_leads->actualizarDatosAdicionales($datosEnviar);
		// 			}
		// 		}else{
		//
		// 			if(isset($id_datos_adicionales)){
		// 				if(is_array($id_datos_adicionales)){
		// 					foreach($id_datos_adicionales as $ide){
		// 						$this->_leads->eliminarDatoAdicional($ide);
		// 					}
		// 				}
		//
		// 			}
		//
		// 		}
		//
		// 		$datosEnviar = array(
		// 			"id_u_prospecto"=>$id,
		// 			"rol_prospecto"=>"lead",
		// 			"nombre_prospecto"=>$nombre_prospecto,
		// 			"apellido_prospecto"=>$apellido_prospecto,
		// 			"id_estatus"=>$estatus,
		// 			"telefono_prospecto"=>$telefono_prospecto,
		// 			"celular_prospecto"=>$celular_prospecto,
		// 			"email_prospecto"=>$email_prospecto,
		// 			"web_prospecto"=>$web_prospecto,
		// 			"pais_prospecto"=>$pais_prospecto,
		// 			"estado_prospecto"=>$estado_prospecto,
		// 			"ciudad_prospecto"=>$ciudad_prospecto,
		// 			"campana_prospecto"=>$campana_prospecto,
		// 			"segmento_prospecto"=>$segmento_prospecto,
		// 			"s_referencias"=>$s_referencias,
		// 			"referencia_prospecto"=>$referencia_prospecto,
		// 			"fecha_actualizacion"=>DATE_NOW
		// 		);
		//
		// 		$this->_leads->actualizarProspecto($datosEnviar);
		//
		// 		if($datosAdicionales!=""){
		// 			foreach($datosAdicionales as $datos){
		//
		// 				if($datos["id_tipodato"]!="x" || $datos["dato"]!=""){
		//
		// 					$datosEnviar = array(
		// 						"id_prospecto" => $id,
		// 						"id_tipodato" => $datos["id_tipodato"],
		// 						"dato" =>	$datos["dato"],
		// 					);
		//
		// 					$this->_leads->setDatosAdicionales($datosEnviar);
		// 				}
		//
		// 			}
		// 		}
		// 		$this->_leads->eliminarEmpresasFC($id);
		//
		// 		if(isset($_POST["empresas"])){
		// 			$empresas = $_POST["empresas"];
		// 			foreach($empresas as $empresa=>$key){
		// 				$datosEnviar = array(
		// 					"id_prospecto" => $id,
		// 					"id_empresa" => $key
		// 				);
		//
		// 				$this->_leads->setEmpresasFC($datosEnviar);
		// 			}
		// 		}
		//
		//
		// 		$empresasFC();
		//
		//
		// 		$datos_adicionales = $this->_leads->getDatosAdicionales($id);
		//
		// 		$this->_view->assign("datos_adicionales",$datos_adicionales);
		//
		//
		// 		$this->_view->assign("_mensaje","Los datos personales del lead han sido actualizados");
		// 		$datos = $this->_leads->getProspectoLead($id);
		// 		$this->_view->assign("datos",$datos);
		//
		// 		if($datos["s_referencias"]=="1")
		// 		{
		// 			$referencias = $this->_leads->getInternos();
		// 			$this->_view->assign("referencias",$referencias);
		// 		}
		//
		// 		if($datos["s_referencias"]=="2")
		// 		{
		// 			$referencias = array("x");
		// 			$this->_view->assign("referencias",$referencias);
		// 		}
		// 		if ($datos["s_referencias"]=="3")
		// 		{
		// 			$referencias = $this->_leads->getEmpresas();
		// 			$this->_view->assign("referencias",$referencias);
		// 		}
		//
		//
		// 		$this->_view->assign("datos",$_POST);
		// 	}
		// 	$datos2=$this->_leads->getCalificacion($id);
		// 	//echo print_r($datos2);
		// 	//exit();
		// 	if ($this->getInt('crear2')=="1")
		// 	{
		// 		$this->_view->assign("activo",2);
		// 		$this->_view->assign("datos2",$_POST);
		// 		$importa="";
		// 		if (isset($_POST["importa"])) {
		// 			$importa=$this->getSql("importa");
		// 		}
		// 		$padron="";
		// 		if (isset($_POST["padron"])) {
		// 			$padron=$this->getSql("padron");
		// 		}
		// 		$departamento="";
		// 		if (isset($_POST["departamento"])) {
		// 			$departamento=$this->getSql("departamento");
		// 		}
		// 		$tipo_volumen="";
		// 		if (isset($_POST["tipo_volumen"])) {
		// 			$tipo_volumen=$this->getSql("tipo_volumen");
		// 		}
		// 		$tipo_volumen_r="";
		// 		if (isset($_POST["tipo_volumen_r"])) {
		// 			$tipo_volumen_r=$this->getSql("tipo_volumen_r");
		// 		}
		// 		$que_productos="";
		// 		if (isset($_POST["que_productos"])) {
		// 			$que_productos=$this->getSql("que_productos");
		// 		}
		// 		$que_productos_r="";
		// 		if (isset($_POST["que_productos_r"])) {
		// 			$que_productos_r=$this->getSql("que_productos_r");
		// 		}
		// 		$calificar_forzado="0";
		// 		if (isset($_POST["calificar_forzado"])) {
		// 			$calificar_forzado=$this->getSql("calificar_forzado");
		// 		}
		// 		$justificar=".";
		// 		if (isset($_POST["justificar"])) {
		// 			$justificar=$this->getSql("justificar");
		// 		}
		//
		// 		$puntaje="";
		// 		if (isset($_POST["puntaje"])) {
		// 			$puntaje=$this->getSql("puntaje");
		// 		}
		// 		$errores="";
		// 		if ($importa=="") {
		// 			$errores="¿Actualmente Importa o exporta?";
		// 		}
		// 		if ($padron=="") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="¿Cuenta con padrón de importación?";
		// 		}
		// 		if ($departamento=="") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="¿Cuenta con un departamento interno o una persona que se encargue exclusivamente de sus operaciones de comercio exterior?";
		// 		}
		// 		if ($tipo_volumen=="") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="¿Cuál es su volumen actual de importación o exportación?";
		// 		}else{
		// 			if ($tipo_volumen_r=="0") {
		// 				if ($errores!="") {
		// 					$errores .="<br>";
		// 				}
		// 				$errores.="Seleccione el volumen actual de importacion o exportacion";
		// 			}
		// 		}
		// 		if ($que_productos=="") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="¿Qué productos importa o exporta?";
		// 		}else{
		// 			if ($que_productos_r=="0") {
		// 				if ($errores!="") {
		// 					$errores .="<br>";
		// 				}
		// 				$errores.="Seleccione que productos importa o exporta";
		// 			}
		// 		}
		// 		if ($calificar_forzado=="1") {
		// 			if ($justificar=="") {
		// 				if ($errores!="") {
		// 					$errores .="<br>";
		// 				}
		// 				$errores.="Debe justificar la calificacion forzada";
		// 			}else{
		// 				$palabras = explode(' ', $justificar);
		// 				if (count($palabras)<20) {
		// 					if ($errores!="") {
		// 						$errores .="<br>";
		// 					}
		// 					$errores.="Debe justificar con no menos de 20 palabras";
		// 				}
		// 			}
		// 		}
		//
		// 		if ($errores!="") {
		// 			$this->_view->assign("datos2",$datos2);
		// 			$this->_view->assign("_error",$errores);
		// 			$this->_view->renderizar('perfil_lead',"clientes");
		// 			exit;
		// 		}
		// 		$id_u=$this->_leads->getUsuario_sisfcId(Session::get('id_usuario'));
		// 		$estado="prospecto";
		// 		if ($puntaje>=70 || $calificar_forzado==1) {
		// 			$estado="lead";
		// 		}
		// 		if (count($datos2)==1) {
		// 			$datosEnviar = array(
		// 				"id_u_prospecto" => $id,
		// 				"importa_exporta" => $importa,
		// 				"padron" => $padron,
		// 				"departamento_interno" => $departamento,
		// 				"tipo_volumen" => $tipo_volumen,
		// 				"volumen_operacion" => $tipo_volumen_r,
		// 				"listado" => $que_productos,
		// 				"que_productos" => $que_productos_r,
		// 				"forzada" => $calificar_forzado,
		// 				"razon_forzada" => $justificar,
		// 				"calificacion_porcentaje" => $puntaje,
		// 				"fecha_creacion" => Date("D/M/Y"),
		// 				"creador" =>  $id_u["id_u_usuario"],
		// 				"fecha_actualizacion" => Date("D/M/Y"),
		// 				"actualizador" => $id_u["id_u_usuario"]
		// 				);
		// 			$this->_leads->crearCalificacion($datosEnviar);
		// 			$this->_view->assign("_mensaje","La calificacion ha sido creada");
		//
		//
		// 		}else{
		// 			$datosEnviar = array(
		// 				"id_u_prospecto" => $id,
		// 				"importa_exporta" => $importa,
		// 				"padron" => $padron,
		// 				"departamento_interno" => $departamento,
		// 				"tipo_volumen" => $tipo_volumen,
		// 				"volumen_operacion" => $tipo_volumen_r,
		// 				"listado" => $que_productos,
		// 				"que_productos" => $que_productos_r,
		// 				"forzada" => $calificar_forzado,
		// 				"razon_forzada" => $justificar,
		// 				"calificacion_porcentaje" => $puntaje,
		// 				"fecha_actualizacion" => Date("D/M/Y"),
		// 				"actualizador" => $id_u["id_u_usuario"]
		// 				);
		// 			$this->_leads->actualizarCalificacion($datosEnviar);
		// 			$this->_view->assign("_mensaje","La calificacion ha sido actualizada");
		// 		}
		// 		$datosEnviar = array(
		// 			"id_u_prospecto"=>$id,
		// 			"rol_prospecto"=>$estado
		// 			);
		// 		$this->_leads->actualizarProspecto($datosEnviar);
		// 		if ($estado=="prospecto") {
		// 			$datos4=$this->_leads->getContacto($id);
		// 			$this->_view->assign("datos4",$datos4);
		// 			$this->redireccionar('prospectos/perfil_prospecto/'. $id);
		// 			exit();
		// 		}
		// 		$datos2=$this->_leads->getCalificacion($id);
		// 	}
		// 	$datos4=$this->_leads->getContacto($id);
		// 	if ($this->getInt('crear3')=="1")
		// 	{
		// 		$this->_view->assign("activo",3);
		//
		// 		$telefonica_lead="";
		// 		if (isset($_POST["telefonica_lead"])) {
		// 			$telefonica_lead=$this->getSql("telefonica_lead");
		// 		}
		// 		$personal_lead="";
		// 		if (isset($_POST["personal_lead"])) {
		// 			$personal_lead=$this->getSql("personal_lead");
		// 		}
		// 		$email_lead="";
		// 		if (isset($_POST["email_lead"])) {
		// 			$email_lead=$this->getSql("email_lead");
		// 		}
		// 		$informacion_general=$this->getSql("informacion_general");
		// 		$compromiso_ace=$this->getSql("compromiso_ace");
		// 		$compromiso_lead=$this->getSql("compromiso_lead");
		//
		// 		$errores="";
		// 		if ($telefonica_lead=="" && $personal_lead=="" && $email_lead=="") {
		// 			$errores="Debe selecionar al menos una via de comunicacion";
		// 		}
		// 		if ($informacion_general=="") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="Ingrese la informacion general";
		// 		}
		// 		if ($compromiso_ace=="") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="Ingrese e compromiso del ACE";
		// 		}
		// 		if ($compromiso_lead=="") {
		// 			if ($errores!="") {
		// 				$errores .="<br>";
		// 			}
		// 			$errores.="Ingrese e compromiso del ETA";
		// 		}
		// 		if ($errores!="") {
		// 			$this->_view->assign("datos4",$datos4);
		// 			$this->_view->assign("_error",$errores);
		// 			$this->_view->renderizar('perfil_lead',"clientes");
		// 			exit;
		// 		}
		// 		if (count($datos4)==1) {
		// 			$datosEnviar = array(
		// 				"id_u_prospecto" => $id,
		// 				"telefonica_lead" => $telefonica_lead,
		// 				"personal_lead" => $personal_lead,
		// 				"email_lead" => $email_lead,
		// 				"informacion_general" => $informacion_general,
		// 				"compromiso_ace" => $compromiso_ace,
		// 				"compromiso_lead" => $compromiso_lead
		// 				);
		//
		// 			$this->_leads->crearContacto($datosEnviar);
		// 			$this->_view->assign("_mensaje","El contacto con el lead ha sido creada");
		// 		}else{
		// 			$datosEnviar = array(
		// 				"id_u_prospecto" => $id,
		// 				"telefonica_lead" => $telefonica_lead,
		// 				"personal_lead" => $personal_lead,
		// 				"email_lead" => $email_lead,
		// 				"informacion_general" => $informacion_general,
		// 				"compromiso_ace" => $compromiso_ace,
		// 				"compromiso_lead" => $compromiso_lead
		// 				);
		//
		// 			$this->_leads->actualizarContacto($datosEnviar);
		// 			$this->_view->assign("_mensaje","El contacto con el lead ha sido actualizado");
		// 		}
		// 		$datos4=$this->_leads->getContacto($id);
		// 	}
		// 	$this->_view->assign("datos4",$datos4);
		// 	$this->_view->assign("datos2",$datos2);
		// 	$this->_view->assign("estatus",$this->_leads->getEstatus());
		// 	$this->_view->renderizar('perfil_lead',"clientes");
		// }
		//
		public function crear_prospecto(){
			$this->_view->assign('titulo','Crear prospecto');

			//$this->_view->assign("tipos",$this->_leads->getTipoPersona());
			$this->_view->renderizar('crear_prospecto');
		}

		public function calificar_prospecto(){
			$this->_view->assign('titulo','Calificar prospecto');

			//$this->_view->assign("tipos",$this->_leads->getTipoPersona());
			$this->_view->renderizar('calificar_prospecto');
		}

		public function perfil_contacto()
		{
			$this->_view->assign('titulo','Contacto del proveedor');
			/*$id=$this->getTexto("id");
			if($id!=""){
				$this->_leads->eliminarEmpresaModel($id);
			}*/

			$this->_view->renderizar('perfil_contacto');
		}

		public function crear_contacto()
		{
			$this->_view->assign('titulo','Crear contacto');
			/*$id=$this->getTexto("id");
			if($id!=""){
				$this->_leads->eliminarEmpresaModel($id);
			}*/

			$this->_view->renderizar('crear_contacto');
		}

		public function perfil_producto()
		{
			$this->_view->assign('titulo','Perfil producto');
			/*$id=$this->getTexto("id");
			if($id!=""){
				$this->_leads->eliminarEmpresaModel($id);
			}*/

			$this->_view->renderizar('perfil_producto');
		}

		public function crear_producto()
		{
			$this->_view->assign('titulo','Crear producto');
			/*$id=$this->getTexto("id");
			if($id!=""){
				$this->_leads->eliminarEmpresaModel($id);
			}*/

			$this->_view->renderizar('crear_producto');
		}
		public function getInternas()//
		{
			$id=$this->getTexto("interna");
			if($id=="1"){
				echo json_encode($this->_leads->getInternos());
			}
		}
		public function getExternas()//no usada
		{
			$id=$this->getTexto("externa");
			if($id=="1"){
				echo json_encode($this->_leads->getSubPartidas());
			}
		}
		public function getEmpresas()//
		{
			$id=$this->getTexto("empresa");
			if($id=="1"){
				echo json_encode($this->_leads->getEmpresas());
			}
		}

		public function cambiarEstatus(){

			$datosEnviar = array(
				"id_u_prospecto"=>$this->getSql("id"),
				"id_estatus" => $this->getSql("estatus")
			);

			$this->_leads->actualizarEstatus($datosEnviar);

			//echo json_encode($this->getSql("estatus"));
		}

		public function getEstatus(){
			$estatus = $this->_leads->getEstatus();

			for($i=0;$i<count($estatus);$i++){
				$ids = $estatus[$i]["id"];
				$estatus[$i]["cantidad_leads"] = count($this->_leads->getProspectoEstatus($ids));
			}
			echo json_encode($estatus);
		}
	}
?>
