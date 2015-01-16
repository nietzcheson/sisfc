<?php
	abstract class Controller{

		protected $_view;
		protected $_acl;

		public function __construct(){
			$this->_registry = Registry::getInstancia();
			$this->_acl = $this->_registry->_acl;
			$this->_request = $this->_registry->_request;
			$this->_view = new View($this->_request, $this->_acl);
		}


		abstract public function index ();

		protected function loadModel ($modelo){
			$nombre_modelo = $modelo;
			$modelo = $nombre_modelo . 'Model';
			$rutamodelo = ROOT . 'modulos' . DS . $nombre_modelo. DS . $modelo . '.php'; //genera la ruta

			if (is_readable($rutamodelo)) {
				require_once $rutamodelo;
				$modelo = new $modelo;
				return $modelo;
			}else{
				throw new Exception("Error de modelo");
			}
		}

		protected function getLibrary($libreria){

			$rutalibreria = ROOT . 'libs' . DS . $libreria . '.php'; //crear la ruta hacia el archivo php en la librearia por defecto
			if (is_readable($rutalibreria)) { //pregunta si el archivo de esa ruta esta disponible y ademas se puede leer
				require_once $rutalibreria; //agrega al codigo el archivo php en cuestion
			}else{
				throw new Exception("Error de Libreria");
			}
		}


		protected function getTexto($clave){ //permite pasar cualquier cadena de texto con racateres espaciales a la notacion de html

			if (isset($_POST[$clave]) && !empty($_POST[$clave])) { //llego mediante post y ademas no esta vacio
				$_POST[$clave] = htmlspecialchars($_POST[$clave],ENT_QUOTES); //convierte caracteres especiales a formato html
				return $_POST[$clave];
			}else{
				return '';
			}
		}


		protected function getInt($clave){ //permite obtener un numero de una cadena de texto "090" o '989' o 090, son numeros

			if(isset($_POST[$clave])){

				$int1 = $_POST[$clave];
				$int2 = $int1;
				$int1 = preg_replace("/[^-0-9\.]/", '', $int1);

				if(strlen($int1)==strlen($int2)){
					return (int) $int1;
				}else{
					return -1;
				}

			}else{
				return -1;
			}
		}


		protected function getFloat($clave){

			if(isset($_POST[$clave])){
				$int1 = $_POST[$clave];
				$int2 = $int1;
				$int1 = preg_replace("/[^-0-9\.]/", '', $int1);

				if(strlen($int1)==strlen($int2)){
					return (float) $int1;
				}else{
					return -1;
				}
			}else{
				return -1;
			}
		}

		protected function redireccionar($ruta = false){ //redireccionar al controlador si eexiste la ruta

			if ($ruta){
				header('location:' . BASE_URL . $ruta);
				exit;
			}else{
				header('location:' . BASE_URL);
				exit;
			}
		}

		protected function filtrarInt($clave){

			$clave = (int) $clave;
			if (is_int($clave)) {
				return $clave;
			}else{
				return 0;
			}
		}

		protected function getPostParm($clave){

			if (isset($_POST[$clave])) {
				return $_POST[$clave];
			}
		}

		protected function getSql($clave){ // adecua la clave para que pueda ser usado en SQl

			if (isset($_POST[$clave]) && !empty($_POST[$clave])) { // si la clave tiene algun valor
				$_POST[$clave] = strip_tags($_POST[$clave]); //quita todos tag que se usan en html dejando solo el texto plano
			}

			if (!get_magic_quotes_gpc()) {
				$_POST[$clave] = mysql_escape_string($_POST[$clave]); // adecua el contenido del post[clave] para que pueda se usado en sql
			}
			return trim($_POST[$clave]); //quita los valors nulos tanto a derecha como a izquierda del valor
		}

		protected function getAlphaNum($clave){

			if (isset($_POST[$clave]) && !empty($_POST[$clave])){
				$_POST[$clave] = (string) preg_replace('/[^A-Z0-9_]/i', '', $_POST[$clave]); //filtra y devuelve solo valores ala numericos
				return $_POST[$clave];
			}
		}

		public function validarEmail($email){
			if (!filter_var($email,FILTER_VALIDATE_EMAIL)) { // verifica si es una direccion de email valida
				return false;
			}
			return true;
		}
}
