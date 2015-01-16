<?php
	class Bootstrap
	{
		public static function run(Request $peticion)
		{
			$nombre_controlador = $peticion->getControlador();
			$controller = $nombre_controlador . 'Controller'; // genera el nombre del comtrolador en especifico
			$rutaControlador = ROOT . 'modulos' . DS . $nombre_controlador. DS . $controller . '.php'; //genera la ruta donde se encuentra el controlador en especifico
			$metodo = $peticion->getMetodo(); //trae de request el metodo(segundo parametro en la url despues de mvc)

			if (is_readable($rutaControlador))//verifica si se encuentra el controlador y ademas si es posible leerlo
			{
				require_once $rutaControlador; // incluye la classe que esta en la ruta (el controlador)
				$controlador = new $controller; //instancia la clase del controlador llamado
				
				$args = $peticion->getArgs(); // de la clase request llama los argumentos ( todos los valores apartir del tercer separador en la url)

				if(is_callable(array($controlador,$metodo))) // verifica si en la clase del controlador exite el metodo que esta en la funcion metodo
				{
					$metodo = $peticion->getMetodo(); 
				}
				else
				{
					$metodo = 'index'; // metodo por defecto
				}
				if(isset($args)) // verifica si al menos hay un argumento, y ejecuta el metodo en la clase
				{
					call_user_func_array(array($controlador, $metodo),$args); // si el metodo existe en la clase entonces le pasa los argumentos, y llama al metodo
				}
				else
				{
					call_user_func_array(array($controlador, $metodo)); //no le pasa los argumentos al metodo de la clase, y llama al metodo
				}
			}
			else
			{
				throw new Exception("No encontrado ".$rutaControlador); // en el 
				
			}
		}
	}