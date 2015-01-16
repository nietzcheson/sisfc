<?php
	class Session
	{
		public static function init()
		{
			session_start(); //autoriza a el motor php para que active las variables de sesion
		}
		public static function destroy($clave = false)
		{
			if ($clave) {//si hay variable(s) entonces eliminar de lo contrario eliminar todo
				if (is_array($clave)) { // si hay un arreglo de variables de sesion
					for ($i=0; $i < count($clave); $i++) {
						if(isset($_SESSION[$clave[$i]]))
						{
							unset($_SESSION[$clave[$i]]);
						}
					}
				}
				else
				{
					if(isset($_SESSION[$clave]))//una sola variable de sesionS
					{
						unset($_SESSION[$clave]);
					}
				}
			}
			else
			{
				session_destroy();// se elimina todas las variables de sesion
			}
		}

		public static function set($clave, $valor)
		{
			if (!empty($clave)) {
				$_SESSION[$clave]=$valor; // forma de dar valor a una variavle de session
			}
		}

		public static function get($clave)
		{
			if (isset($_SESSION[$clave])) {
				return $_SESSION[$clave]; // forma de acceder a una variavle de session
			}
		}

		public static function acceso($level) // permite o no acceder a una vista
		{
			if (!Session::get('autenticado')) {
				//header('location:' . BASE_URL . 'error/access/5050');
				header('location:' . BASE_URL . 'login');
				exit;
			}
			Session::tiempo();
			if (Session::getLevel($level)>Session::getLevel(Session::get('level'))) { //compara el nivel que se requier contra el nivel de la actual sesion
				//header('location:' . BASE_URL . 'error/access/5050'); //se envia a la vista access y genera el error 5050
				header('location:' . BASE_URL . 'login');
				exit;
			}
		}

		public static function accesoView($level) // permite o no acceder a una parte de codigo html en una vista
		{
			if (!Session::get('autenticado')) {
				return false;
			}
			if (Session::getLevel($level)>Session::getLevel(Session::get('level'))) { //compara el nivel que se requier contra el nivel de la actual sesion
				return false;
			}
			return true;
		}
		public static function getLevel($level)
		{
			//diferentes niveles de usuario que existe
			$role['admin'] = 3;
			$role['especial'] = 2;
			$role['usuario'] = 1;

			if (!array_key_exists($level, $role))
			{
				throw new Exception("Error de acceso");
			}
			else
			{
				return $role[$level];
			}
		}
		public static function accesoEstricto(array $level, $noAdmin = false)
		{
			if (!Session::get('autenticado')) {
				header('location:' . BASE_URL . 'error/access/5050');
				exit;
			}

			Session::tiempo();

			if ($noAdmin == false) {
				if (Session::get('level') == 'admin') {
					return;
				}
			}
			if (count($level)) {
				if (in_array(Session::get('level'), $level)) {
					return;
				}
			}
			header('location:' . BASE_URL . 'error/access/5050');
		}

		public static function accesoViewEstricto(array $level, $noAdmin = false)
		{
			if (!Session::get('autenticado')) {
				return false;
			}
			if ($noAdmin == false) {
				if (Session::get('level') == 'admin') {
					return true;
				}
			}
			if (count($level)) {
				if (in_array(Session::get('level'), $level)) {
					return true;
				}
			}
			return false;
		}

		public static function tiempo()
		{
			if (!Session::get('tiempo') || !defined('SESSION_TIME'))
			{
				throw new Exception("No se ha definido el tiempo de sesion");
			}
			if (SESSION_TIME == 0)
			{
				return;
			}
			if (time() - Session::get('tiempo')>(SESSION_TIME*7200)) {
				Session::destroy();
				header('location:' . BASE_URL . 'error/access/8080');
			}
			else
			{
				Session::set('tiempo',time());
			}
		}
		public static function dartiempo(){
			Session::set('tiempo',time());
		}
	}
