<?php
	require_once ROOT . 'libs' . DS . 'smarty' . DS . 'libs' . DS . 'Smarty.class.php'; //VT13 agregar la libreria para plantillas
	class View extends Smarty // VT13 se extiende a plantillas
	{
		private $_controlador;
		private $_js;
		private $_acl;
		public function __construct(Request $peticion, ACL $_acl) //VT15 nuevo parametro ACL
		{
			parent::__construct();//VT13 constructuro de la clase plantilla
			$this->_controlador=$peticion->getControlador();// obtiene el controlador
			$this->_js=array();
			$this->_acl = $_acl;
		}
		public function renderizar($vista, $item=false)
		{
			//VT13 se agrego el folder tmp, dentro cache y template para almacenar archivos temporales
			$this->template_dir = ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS;
			$this->config_dir =  ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'configs' . DS;
			$this->cache_dir = ROOT . 'tmp' . DS . 'cache' . DS;
			$this->compile_dir = ROOT . 'tmp' . DS . 'template' . DS;

			//inicio de parametros para pasar a html
			$menu = array(
				array(
					'id'=>'inicio',
					'titulo'=>'inicio',
					'enlace'=>BASE_URL
				),
				array(
					'id'=>'post',
					'titulo'=>'post',
					'enlace'=>BASE_URL . 'post'
				)
			);

			if (Session::get('autenticado')) {
				$menu[] = array(
					'id'=>'login',
					'titulo'=>'Cerrar Sesion',
					'enlace'=>BASE_URL . 'login/cerrar'
				);
			}
			else
			{
				$menu[] = array(
					'id'=>'login',
					'titulo'=>'Iniciar Sesion',
					'enlace'=>BASE_URL . 'login'
				);
				$menu[] = array(
					'id'=>'registro',
					'titulo'=>'Registro',
					'enlace'=>BASE_URL . 'registro'
				);
			}
			$js=array();//inicia un arreglo que almacenara los archivos de java script

			if (count($this->_js)) { //carga todos jscript que se necesitan
				$js = $this->_js;
			}
			$_layoutParams = array(
				'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
				'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
				'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
				'menu'=>$menu,
				'item'=>$item,
				'js' => $js,
				'root'=> BASE_URL,
				'configs'=>array(//VT13 se guardan las constantes de configuracion
					'app_name' => APP_NAME,
					'app_slogan' =>APP_ESLOGAN,
					'app_company' => APP_COMPANY
				)
			);
			// fin de parametros
			$rutaview = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.tpl'; // VT13 cmabio de pthl a ptl, por el uso de la libreria de plantillas
			if (is_readable($rutaview)) { // aqui se carga las diferentes partes la vista				
				//include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php'; // VT13 ya no se necesitara por el uso de plantilla
				//include_once $rutaview; //VT13 ahora llamar el metodo assign de smarty
				$this->assign('_contenido', $rutaview);//VT13 llama la vista para que se cargue en el template
				//include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';  // VT13 ya no se necesitara por el uso de plantilla
			}
			else
			{
				throw new Exception("Error de vista");
				
			}
			$this->assign('_acl',$this->_acl);
			$this->assign('_layoutParams',$_layoutParams); // BT13 Assignar los paramentros
			$this->display('template.tpl'); //VT13 llamar el template
		}

		public function setJs (array $js)
		{
			if (is_array($js) && count($js)) 
			{
				for ($i=0; $i < count($js); $i++) { 
					$this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i] . '.js';
				}
			}
			else
			{
				throw new Exception("Error de js");
			}
		}
	} 