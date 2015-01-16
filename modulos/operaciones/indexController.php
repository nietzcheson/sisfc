<?php
	class IndexController extends Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function index()
		{

			//$this->_view->assign('titulo','Inicio'); //esto es una forma de pasar parametros, aqui esta el objeto view creado en la super clase controller
			//
			//$this->_acl->acceso('todo');
			$this->redireccionar("login"); // se llama el metodo de renderizado de views, cuya variable posts luego mediante view es usada
		}
	}
?>
