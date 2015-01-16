<?php
	class Request
	{
		private $_controlador;
		private $_metodo;
		private $_argumentos;

		public function __construct()
		{
			if (isset($_GET['url'])) // si la url contiene valores
			{
				$url = filter_input(INPUT_GET, 'url',FILTER_SANITIZE_URL); //** toma la url via GET y le realiza un filtro de limpieza 
				$url = explode('/', $url); //genera un arreglo devidiendo por "/"
				$url = array_filter($url); //++ genera un nuevo arreglo, aun no le veo la utilidad

				$this->_controlador = strtolower(array_shift($url));//almacena el primer valor en el arreglo en minusculas y lo quita del arreglo
				$this->_metodo = strtolower(array_shift($url));//almacena el primer valor en el arreglo en minusculas y lo quita del arreglo
				$this->_argumentos = $url; // el resto del arreglo que queda
			}
			

			if (!$this->_controlador) { //si no tiene valor
				$this->_controlador = DEFAULT_CONTROLLER;	//le da el valor que por defecto se le dio en Config.php
			}
			if (!$this->_metodo) {
				$this->_metodo = 'index';	//su valor por defecto sera index
			}
			if (!isset($this->_argumentos)) { // si no hay argumentos
				$this->_argumentos = array();	// lo iguala a un arreglo
			}
		}
		public function getControlador()
		{
			return $this->_controlador;
		}
		public function getMetodo()
		{
			return $this->_metodo;
		}
		public function getArgs()
		{
			return $this->_argumentos;
		}
	}
?>