<?php 
	class siicexController extends Controller{
		private $_model;
		public function __construct(){
			parent::__construct();
			$this->_model = $this->loadModel('siicex');
		}
		public function index(){
			$this->_view->assign('titulo','Robot para Siicex');
			if ($this->getInt('crear')=="1") {

				$session_code=$this->getSql("session_code");
				$session_name=$this->getSql("session_name");

				$capitulo_code=$this->getSql("capitulo_code");
				$capitulo_name=$this->getSql("capitulo_name");

				$partida_code=$this->getSql("partida_code");
				$partida_name=$this->getSql("partida_name");

				$subpartida_code=$this->getSql("subpartida_code");
				$subpartida_name=$this->getSql("subpartida_name");

				$fraccion_code=$this->getSql("fraccion_code");
				$fraccion_name=$this->getSql("fraccion_name");

				$v_1_1 = $this->getSql("v_1_1");
				$v_1_2 = $this->getSql("v_1_2");
				$v_1_3 = $this->getSql("v_1_3");
				$v_1_4 = $this->getSql("v_1_4");
				$v_1_5 = $this->getSql("v_1_5");
				$v_1_6 = $this->getSql("v_1_6");

				$v_2_1 = $this->getSql("v_2_1");
				$v_2_2 = $this->getSql("v_2_2");
				$v_2_3 = $this->getSql("v_2_3");
				$v_2_4 = $this->getSql("v_2_4");
				$v_2_5 = $this->getSql("v_2_5");
				$v_2_6 = $this->getSql("v_2_6");
				
				$res_imp = $this->getTexto("res_imp");
				$res_exp = $this->getTexto("res_exp");
				$anexos = $this->getTexto("anexos");
				
				// Actualizar o crear session
				$session = $this->_model->getSeccion($session_code);
				$datosEnviar = array(
					"codigo"=>$session_code,
					"seccion"=>$session_name
				);
				if (is_array($session)) {
					$this->_model->actualizarSeccion($datosEnviar);
				}else{
					$this->_model->crearSeccion($datosEnviar);
				}

				// Actualizar capitulo
				$capitulo = $this->_model->getCapitulo($capitulo_code,$session_code);
				if (is_array($capitulo)) {
					$datosEnviar = array(
						"id_capitulo"=>$capitulo["id_capitulo"],
						"codigo_capitulo"=>$capitulo_code,
						"codigo_seccion"=>$session_code,
						"capitulo"=>$capitulo_name
					);
					$this->_model->actualizarCapitulo($datosEnviar);
				}else{
					$datosEnviar = array(
						"codigo_capitulo"=>$capitulo_code,
						"codigo_seccion"=>$session_code,
						"capitulo"=>$capitulo_name
					);
					$this->_model->crearCapitulo($datosEnviar);
				}

				// Actualizar partida
				$partida = $this->_model->getPartida($partida_code,$capitulo_code);
				if (is_array($partida)) {
					$datosEnviar = array(
						"id_partida"=>$partida["id_partida"],
						"codigo_partida"=>$partida_code,
						"codigo_capitulo"=>$capitulo_code,
						"partida"=>$partida_name
					);
					$this->_model->actualizarPartida($datosEnviar);
				}else{
					$datosEnviar = array(
						"codigo_partida"=>$partida_code,
						"codigo_capitulo"=>$capitulo_code,
						"partida"=>$partida_name
					);
					$this->_model->crearPartida($datosEnviar);
				}

				// Actualizar Subpartida
				$subpartida = $this->_model->getSubPartida($subpartida_code,$partida_code);
				if (is_array($subpartida)) {
					$datosEnviar = array(
						"id_subpartida"=>$subpartida["id_subpartida"],
						"codigo_subpartida"=>$subpartida_code,
						"codigo_partida"=>$partida_code,
						"subpartida"=>$subpartida_name
					);
					$this->_model->actualizarSubPartida($datosEnviar);
				}else{
					$datosEnviar = array(
						"codigo_subpartida"=>$subpartida_code,
						"codigo_partida"=>$partida_code,
						"subpartida"=>$subpartida_name
					);
					$this->_model->crearSubPartida($datosEnviar);
				}

				// Actualizar Fraccion
				$fraccion = $this->_model->getFraccion($fraccion_code,$subpartida_code);
				if (is_array($fraccion)) {
					$datosEnviar = array(
						"id_fraccion"=>$fraccion["id_fraccion"],
						"codigo_subpartida"=>$subpartida_code,
						"codigo_fraccion"=>$fraccion_code,
						"fraccion"=>$subpartida_name,
						"int_arancel_imp"=>$v_1_1,
						"int_iva_imp"=>$v_1_2,
						"fran_arancel_imp"=>$v_1_3,
						"fran_iva_imp"=>$v_1_4,
						"reg_arancel_imp"=>$v_1_5,
						"reg_iva_imp"=>$v_1_6,
						"int_arancel_exp"=>$v_2_1,
						"int_iva_exp"=>$v_2_2,
						"fran_arancel_exp"=>$v_2_3,
						"fran_iva_exp"=>$v_2_4,
						"reg_arancel_exp"=>$v_2_5,
						"reg_iva_exp"=>$v_2_6,
						"restric_imp"=>$res_imp,
						"restric_exp"=>$res_exp,
						"anexos"=>$anexos
					);
					$this->_model->actualizarFraccion($datosEnviar);

					$this->_view->assign("_mensaje","Se ha actualizado la fraccion " . $fraccion_code);
				}else{
					$datosEnviar = array(
						"codigo_subpartida"=>$subpartida_code,
						"codigo_fraccion"=>$fraccion_code,
						"fraccion"=>$subpartida_name,
						"int_arancel_imp"=>$v_1_1,
						"int_iva_imp"=>$v_1_2,
						"fran_arancel_imp"=>$v_1_3,
						"fran_iva_imp"=>$v_1_4,
						"reg_arancel_imp"=>$v_1_5,
						"reg_iva_imp"=>$v_1_6,
						"int_arancel_exp"=>$v_2_1,
						"int_iva_exp"=>$v_2_2,
						"fran_arancel_exp"=>$v_2_3,
						"fran_iva_exp"=>$v_2_4,
						"reg_arancel_exp"=>$v_2_5,
						"reg_iva_exp"=>$v_2_6,
						"restric_imp"=>$res_imp,
						"restric_exp"=>$res_exp,
						"anexos"=>$anexos
					);
					$this->_model->crearFraccion($datosEnviar);

					$this->_view->assign("_mensaje","Se ha creado la fraccion " . $fraccion_code);
				}

				
			}
			$this->_view->renderizar('index');
		}
	}