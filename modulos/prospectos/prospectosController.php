<?php
	class prospectosController extends Controller{
		private $_prospectos;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_prospectos = $this->loadModel('prospectos');
		}

		public function index(){
			$this->_view->assign('titulo','Prospectos');
			$btnHeader = array(

				array(
					"titulo" => "Crear prospecto",
					"enlace" => "prospectos/crear_prospecto"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_prospectos->getProspectos());
			$this->_view->renderizar('index',"clientes");
		}

		public function listado_prospectos(){
			$this->_view->assign('titulo','Listado de prospectos');
			//$this->_view->setJs(array('index'));
			//$this->_view->assign("datos",$this->_prospectos->getClasiProveedores());
			$this->_view->renderizar('listado_prospectos');
		}
		public function crearClasificacionProveedores(){
			$this->_view->assign('titulo','Clasificación proveedores');
			//$this->_view->setJs(array('index'));
			$this->_view->assign("datos",$this->_prospectos->getClasiProveedores());
			$this->_view->renderizar('clasificacion');
		}
		public function eliminarProspecto()//
		{
			$id=$this->getTexto("id");
			if($id!=""){
				$this->_prospectos->eliminarProspectoModel($id);
			}
		}
		public function perfil_prospecto($id=false){

			if(!$id){
				$this->redireccionar('prospectos');
				exit();
			}

			$empresasFC = function() use($id){
				$empresas = $this->_prospectos->empresasFC();

				$getEmpresas = $this->_prospectos->getEmpresasFC($id);

				for($i=0;$i<count($empresas);$i++){
					for($e=0;$e<count($getEmpresas);$e++){
						if($getEmpresas[$e]["id_empresa"]==$empresas[$i]["id_empresa"]){
							$empresas[$i]["enDB"] = "x";
						}
					}

				}
				$this->_view->assign("empresas",$empresas);
				$this->_view->assign("empresasFC",$getEmpresas);
			};

			$empresasFC();

			$this->_view->setJs(array('ajax'));
			$this->_view->assign('datos_perfil', ROOT . 'componentes/perfilcliente/datos.tpl');
			$this->_view->assign('datos_calificacion', ROOT . 'componentes/perfilcliente/datosCalificacion.tpl');
			$this->_view->assign('calificacion_perfil', ROOT . 'componentes/perfilcliente/calificacion.tpl');

			$calificacion = $this->_prospectos->getCalificacion($id);
			$tiposDatos = $this->_prospectos->getTiposDatos();

			$this->_view->assign("tiposDatos",$tiposDatos);

			$datos_adicionales = $this->_prospectos->getDatosAdicionales($id);
			$this->_view->assign("datos_adicionales",$datos_adicionales);
			$id_datos_adicionales = "";

			for($i=0;$i<count($datos_adicionales);$i++){
				$id_datos_adicionales[$i] = $datos_adicionales[$i]["id"];
			}

			$this->_view->assign('calificacion',$calificacion);

			$this->_view->assign('titulo','Perfil del prospecto');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "prospectos"
				),
				array(
					"titulo" => "Calificación",
					"enlace" => "calificacion/calificar/".$id."/1",
					"estilo"  => "danger"
				)
			);
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("paises",$this->_prospectos->getPaises());
			$this->_view->assign("campanas",$this->_prospectos->getCampanas());
			$this->_view->assign("segmentos",$this->_prospectos->getSegmentos());

			$datos = $this->_prospectos->getProspecto($id);
			$this->_view->assign("datos",$datos);


			if($datos["s_referencias"]=="1")
			{
				$referencias = $this->_prospectos->getInternos();
				$this->_view->assign("referencias",$referencias);
			}

			if($datos["s_referencias"]=="2")
			{
				$referencias = array("x");
				$this->_view->assign("referencias",$referencias);
			}
			if ($datos["s_referencias"]=="3")
			{
				$referencias = $this->_prospectos->getEmpresas();
				$this->_view->assign("referencias",$referencias);
			}

			$this->_view->assign("activo",1);
			if($this->getInt('prospecto_lead')=="1")
			{

				$datos_adicionales_ = "";
				if(isset($_POST["id_dato_"])){
					$datos_adicionales_ = $_POST["id_dato_"];
				}


				$datosAdicionales = "";
				$tiposDatos = "";
				if(isset($_POST["id_tipodato"])){
					$selects = $_POST["id_tipodato"];
					$inputs = $_POST["dato"];
					$tiposDatos = $this->_prospectos->getTiposDatos();


					if($selects!=""){
						if(count($selects)==count($inputs)){
							for($i=0;$i<count($selects);$i++){
								$datosAdicionales[$i]["id_tipodato"] = $selects[$i];
								$datosAdicionales[$i]["dato"] = $inputs[$i];
							}
						}
					}
				}

				$nombre_prospecto= $this->getSql("nombre_prospecto");
				$apellido_prospecto= $this->getSql("apellido_prospecto");
				$telefono_prospecto= $this->getSql("telefono_prospecto");
				$email_prospecto= $this->getSql("email_prospecto");

				if (!$this->validarEmail($email_prospecto)) {
					$email_prospecto="";
				}

				$pais_prospecto= $this->getSql("pais_prospecto");
				$estado_prospecto= $this->getSql("estado_prospecto");
				$ciudad_prospecto= $this->getSql("ciudad_prospecto");
				$campana_prospecto= $this->getSql("campana_prospecto");
				$segmento_prospecto= $this->getSql("segmento_prospecto");
				$s_referencias = $this->getSql("s_referencias");
				$referencia_prospecto= $this->getSql("referencia_prospecto");


				$errores="";
				if ($nombre_prospecto=="") {
					$errores="Ingrese el nombre del prospecto";
				}
				if ($apellido_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el apellido del prospecto";
				}
				if ($telefono_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el telefono del prospecto";
				}
				if ($email_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="El email del prospecto es incorrecto";
				}
				if ($pais_prospecto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el pais del prospecto";
				}
				if ($campana_prospecto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione la campaña del prospecto";
				}
				if ($segmento_prospecto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el segmento del prospecto";
				}
				if ($s_referencias=="Seleccione" || $referencia_prospecto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Debe seleccionar la referencia";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);

					if($datosAdicionales!=""){
						$this->_view->assign("datosAdicionales",$datosAdicionales);
						$this->_view->assign("tiposDatos",$tiposDatos);
					}

					$this->_view->renderizar('perfil_prospecto',"clientes");
					exit();
				}


				if(isset($_POST["id_dato_"])){

					$diferencias = array_diff($id_datos_adicionales,$datos_adicionales_);
					$igualdad = array_intersect($id_datos_adicionales, $datos_adicionales_);

					foreach($diferencias as $ide){
						$this->_prospectos->eliminarDatoAdicional($ide);
					}


					$ids = $_POST["id_dato_"];
					$id_tipos = $_POST["id_tipodato_"];
					$datos = $_POST["dato_"];

					for($i=0;$i<count($igualdad);$i++){

						$datosEnviar = array(
							"id" => $ids[$i],
							"id_tipodato" => $id_tipos[$i],
							"dato" => $datos[$i]
						);

						$this->_prospectos->actualizarDatosAdicionales($datosEnviar);
					}
				}else{

					if(isset($id_datos_adicionales)){
						if(is_array($id_datos_adicionales)){
							foreach($id_datos_adicionales as $ide){
								$this->_prospectos->eliminarDatoAdicional($ide);
							}
						}

					}

				}

				$datosEnviar = array(
					"id_u_prospecto"=>$id,
					"nombre_prospecto"=>$nombre_prospecto,
					"apellido_prospecto"=>$apellido_prospecto,
					"telefono_prospecto"=>$telefono_prospecto,
					"email_prospecto"=>$email_prospecto,
					"pais_prospecto"=>$pais_prospecto,
					"estado_prospecto"=>$estado_prospecto,
					"ciudad_prospecto"=>$ciudad_prospecto,
					"campana_prospecto"=>$campana_prospecto,
					"segmento_prospecto"=>$segmento_prospecto,
					"s_referencias"=>$s_referencias,
					"referencia_prospecto"=>$referencia_prospecto,
					"fecha_actualizacion"=>DATE_NOW
				);
				$this->_prospectos->actualizarProspecto($datosEnviar);
				$datos = $this->_prospectos->getProspecto($id);
				$this->_view->assign("datos",$datos);
				if($datos["s_referencias"]=="1")
				{
					$referencias = $this->_prospectos->getInternos();
					$this->_view->assign("referencias",$referencias);
				}

				if($datos["s_referencias"]=="2")
				{
					$referencias = array("x");
					$this->_view->assign("referencias",$referencias);
				}
				if ($datos["s_referencias"]=="3")
				{
					$referencias = $this->_prospectos->getEmpresas();
					$this->_view->assign("referencias",$referencias);
				}

				if($datosAdicionales!=""){
					foreach($datosAdicionales as $datos){

						if($datos["id_tipodato"]!="x" || $datos["dato"]!=""){

							$datosEnviar = array(
								"id_prospecto" => $id,
								"id_tipodato" => $datos["id_tipodato"],
								"dato" =>	$datos["dato"],
							);

							$this->_prospectos->setDatosAdicionales($datosEnviar);
						}

					}
				}

				$this->_prospectos->eliminarEmpresasFC($id);


				if(isset($_POST["empresas"])){
					$empresas = $_POST["empresas"];
					foreach($empresas as $empresa=>$key){
						$datosEnviar = array(
							"id_prospecto" => $id,
							"id_empresa" => $key
						);

						$this->_prospectos->setEmpresasFC($datosEnviar);
					}
				}


				$empresasFC();


				$datos_adicionales = $this->_prospectos->getDatosAdicionales($id);

				$this->_view->assign("datos_adicionales",$datos_adicionales);

				$this->_view->assign("_mensaje","Los datos personales del prospecto han sido actualizados");
		}

			$this->_view->renderizar('perfil_prospecto',"clientes");
		}

		public function crear_prospecto(){//

			//$this->_view->assign('datos_adicionales', $this->_view->widget('datosAdicionales', 'getDatos',array($id_marca)));
			$this->_view->assign('w_perfil', $this->_view->widget('perfilCliente', 'getPerfil'));

			$this->_view->assign('datos_perfil', ROOT . 'componentes/perfilcliente/datos.tpl');
			$this->_view->setJs(array('ajax'));
			$this->_view->assign('titulo','Crear prospecto');
			$btnHeader = array(

				array(
					"titulo" => "return",
					"enlace" => "prospectos"
				)
			);


			$empresasFC = function(){
				$empresas = $this->_prospectos->empresasFC();
				$this->_view->assign("empresas",$empresas);
			};

			$empresasFC();

			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->assign("paises",$this->_prospectos->getPaises());
			$this->_view->assign("campanas",$this->_prospectos->getCampanas());
			$this->_view->assign("segmentos",$this->_prospectos->getSegmentos());
			if ($this->getInt('prospecto_lead')=="1")
			{


				$this->_view->assign("datos",$_POST);

				$datosAdicionales = "";
				$tiposDatos = "";
				if(isset($_POST["id_tipodato"])){
					$selects = $_POST["id_tipodato"];
					$inputs = $_POST["dato"];
					$tiposDatos = $this->_prospectos->getTiposDatos();


					if($selects!=""){
						if(count($selects)==count($inputs)){
							for($i=0;$i<count($selects);$i++){
								$datosAdicionales[$i]["id_tipodato"] = $selects[$i];
								$datosAdicionales[$i]["dato"] = $inputs[$i];
							}
						}
					}
				}

				$nombre_prospecto= $this->getSql("nombre_prospecto");
				$apellido_prospecto= $this->getSql("apellido_prospecto");
				$telefono_prospecto= $this->getSql("telefono_prospecto");
				$celular_prospecto= $this->getSql("celular_prospecto");
				$email_prospecto= $this->getSql("email_prospecto");
				if (!$this->validarEmail($email_prospecto)) {
					$email_prospecto="";
				}
				$web_prospecto= $this->getSql("web_prospecto");
				$pais_prospecto= $this->getSql("pais_prospecto");
				$estado_prospecto= $this->getSql("estado_prospecto");
				$ciudad_prospecto= $this->getSql("ciudad_prospecto");
				$campana_prospecto= $this->getSql("campana_prospecto");
				$segmento_prospecto= $this->getSql("segmento_prospecto");
				$s_referencias= $this->getSql("s_referencias");
				$referencia_prospecto= $this->getSql("referencia_prospecto");

				$errores="";
				if ($nombre_prospecto=="") {
					$errores="Ingrese el nombre del prospecto";
				}
				if ($apellido_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el apellido del prospecto";
				}
				if ($telefono_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese el telefono del prospecto";
				}
				if ($email_prospecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="El email del prospecto es incorrecto";
				}
				if ($pais_prospecto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el pais del prospecto";
				}
				if ($campana_prospecto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione la campaña del prospecto";
				}
				if ($segmento_prospecto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el segmento del prospecto";
				}
				if ($s_referencias=="Seleccione" || $referencia_prospecto=="Seleccione") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Debe seleccionar la referencia";
				}
				if ($s_referencias=="1") {
					$this->_view->assign("datos2",$this->_prospectos->getInternos());
				}
				if ($s_referencias=="2") {
					//$this->_view->assign("datos2",$this->_prospectos->getInternos());
				}
				if ($s_referencias=="3") {
					$this->_view->assign("datos2",$this->_prospectos->getEmpresas());
				}
				if ($errores!="") {

					$this->_view->assign("_error",$errores);

					if($datosAdicionales!=""){
						$this->_view->assign("datosAdicionales",$datosAdicionales);
						$this->_view->assign("tiposDatos",$tiposDatos);
					}

					$this->_view->renderizar('crear_prospecto',"clientes");
					exit;
				}
				$id_u=$this->_prospectos->getUsuario_sisfcId(Session::get('id_usuario'));
				$datosEnviar = array(
					"id_u_prospecto"=>"dummy",
					"rol_prospecto"=>"prospecto",
					"nombre_prospecto"=>$nombre_prospecto,
					"apellido_prospecto"=>$apellido_prospecto,
					"telefono_prospecto"=>$telefono_prospecto,
					"celular_prospecto"=>$celular_prospecto,
					"email_prospecto"=>$email_prospecto,
					"web_prospecto"=>$web_prospecto,
					"pais_prospecto"=>$pais_prospecto,
					"estado_prospecto"=>$estado_prospecto,
					"ciudad_prospecto"=>$ciudad_prospecto,
					"campana_prospecto"=>$campana_prospecto,
					"segmento_prospecto"=>$segmento_prospecto,
					"s_referencias"=>$s_referencias,
					"referencia_prospecto"=>$referencia_prospecto,
					"fecha_registro"=>DATE_NOW,
					"creador"=>$id_u["id_u_usuario"]
				);
				$this->_prospectos->crearProspecto($datosEnviar);
				$id = $this->_prospectos->ultimoProspecto();
				$id_prospecto = strtoupper(substr($id["nombre_prospecto"],0,2)).$id["id_prospecto"];

				if($datosAdicionales!=""){
					foreach($datosAdicionales as $datos){

						if($datos["selects"]!="x" || $datos["inputs"]!=""){

							$datosEnviar = array(
								"id_prospecto" => $id_prospecto,
								"id_tipodato" => $datos["id_tipodato"],
								"dato" =>	$datos["dato"],
							);

							$this->_prospectos->setDatosAdicionales($datosEnviar);
						}
					}
				}


				$datosEnviar = array(
					"id_prospecto"=>$id["id_prospecto"],
					"id_u_prospecto"=>$id_prospecto
				);

				$this->_prospectos->actualizarProspecto($datosEnviar);
				$this->_view->assign("datos","");
				$this->_view->assign("_mensaje","El prospecto ha sido creado");

				$btnHeader = array(

					array(
						"titulo" => "return",
						"enlace" => "prospectos"
					),

					array(
						"titulo" => "Calificar prospecto",
						"enlace" => "calificacion/calificar/".$id_prospecto."/1",
						"estilo" => "danger"
					),

					array(
						"titulo" => "Ver perfil",
						"enlace" => "prospectos/perfil_prospecto/".$id_prospecto."/1"
					)
				);
				$this->_view->assign("btnHeader",$btnHeader);


				$empresas = $_POST["empresas"];

				//Eliminar empresas relacionadas

				$this->_prospectos->eliminarEmpresasFC($id_prospecto);

				foreach($empresas as $empresa=>$key){
					$datosEnviar = array(
						"id_prospecto" => $id_prospecto,
						"id_empresa" => $key
					);

					$this->_prospectos->setEmpresasFC($datosEnviar);
				}

			}
			$this->_view->renderizar('crear_prospecto',"clientes");
		}

		public function getDatosAdicionales(){

			$tipos_datos = $this->_prospectos->getTiposDatos();

			echo json_encode($tipos_datos);
		}

	}
?>
