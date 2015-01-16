<?php 

require_once "lib/nusoap.php";
require_once "config.inc.php";

class WSSinergia{

	protected $_cliente;
	protected $_clienteError;
	private $_nombreMetodo;
	private $_respuestaMetodo;

	public function __construct(){
		$this->_cliente = new nusoap_client(WS,true);
		$this->_clienteError = $this->_cliente->getError();
		$this->_clienteFault = $this->_cliente->fault;
	}

	public function servicioAdmovil($metodo = false,$datos = false){

		if($metodo == ""){
			echo "Método vacío. No se puede procesar la operación";
			exit;
		}

		$this->_nombreMetodo = $metodo;

		if($datos == ""){
			echo "Datos vacíos. No se puede procesar la operación";
			exit();
		}
		
		if($this->_clienteError){
			echo "Error de conexión con la librería NuSoap";
			exit();
		}

		$this->_respuestaMetodo = $this->_cliente->call($this->_nombreMetodo,$datos);

		if($this->_clienteFault){
			echo "<h2>Error grave</h2>";
			return $this->_respuestaMetodo;
		}else{
			$this->_clienteError = $this->_cliente->getError();
			if($this->_clienteError){
				return "<h2>Error</h2><pre> ". $this->_respuestaMetodo ."</pre>";
			}else{
				return $this->_respuestaMetodo;
			}
		}
	}
}


?>