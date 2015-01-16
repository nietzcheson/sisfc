<?php //VT14
	class ajaxController extends Controller
	{
		private $_ajax;
		private $__valor;
		public function __construct()
		{
			parent::__construct();
			$this->_ajax = $this->loadModel('ajax');
		}
		public function index()
		{
			$this->_view->assign('titulo',"Ejemplo de ajax");
			$this->_view->setJs(array('ajax')); //VT14 carga libreria de la vista ajax
			$this->_view->assign('paises',$this->_ajax->getPaises()); // obtiene paises del modelo
			$this->__valor="un valor al azar";
			$this->_view->assign('elvalor',$this->__valor);
			$this->_view->renderizar('index');
		}
		public function getCiudades()
		{
			

			$this->_view=$this->__valor . " asdasdasd";
			if ($this->getInt('pais')) {
				echo json_encode($this->_ajax->getCiudades($this->getInt('pais')));
			}
			//echo json_encode("Nuevo Dato");			
		}
		public function insertarCiudad()
		{
			if ($this->getInt('pais') && $this->getSql('ciudad')) {
				$this->_ajax->insertarCiudad(
					$this->getSql('ciudad'),
					$this->getInt('pais')
					);
			}
		}
	}