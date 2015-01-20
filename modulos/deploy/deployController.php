<?php
	class deployController extends Controller{
		private $_modelo;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_modelo = $this->loadModel('deploy');
		}
		public function index(){


			$this->_view->assign("deploy", $this->_modelo->deploy());
			$this->_view->renderizar('deploy',"");

		}
	}
?>
