<?php
	class deployController extends Controller{
		private $_modelo;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_modelo = $this->loadModel('deploy');
		}
		public function index(){

			//Alter table de la base de datos
			echo $this->_modelo->deploy();

		}
	}
?>
