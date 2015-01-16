<?php

	define('DEFAULT_CONTROLLER', 'index');
	define('DEFAULT_LAYOUT', 'responsive');
	//define('BASE_URL', 'http://elwebsite.loc/');
	define('BASE_URL', 'http://sisfc.loc/');

	define('APP_NAME', 'SISFC');
	define('APP_ESLOGAN', 'Sinergia Fc. Expertos en Comercio Exterior');
	define('APP_COMPANY', 'www.artesan.us');
	define('SESSION_TIME',1);
	define('HASH_KEY', 'zsecftbhu');
    define('NUMBER_FORMAT',"2,'.', ''");

	//para base de datos
	define('DB_HOST', 'localhost');
	define('DB_USER', 'sisfc');
	define('DB_PASS', 'sisfc');
	define('DB_NAME', 'sinergi2_sisfc');
	// define('DB_USER', 'sinergi2_sisfc');
	// define('DB_PASS', 'T{%0u8vOQ)@6');
	// define('DB_NAME', 'sinergi2_sisfc');
	define('DB_CHAR', 'utf8');
	define('BTN_CREATE','primary');
	define('BTN_RETURN','default');
	define('BTN_REMOVE','danger');
		define('ICON_REMOVE',"trash");

	define('BTN_VIEW','success');
	define('ICON_VIEW',"eye-open");
	define('ICON_SAVED',"saved");
	date_default_timezone_set("UTC");
	define("DATE_NOW",date("d/m/Y"));

$entorno = "prod";

if($entorno == "dev"){
	define("WS","http://www.admovil.net/adconnectionbeta/webservice_soap.asmx?WSDL");
	define("USER","administrador");
	define("PASS",10101010);
}elseif($entorno == "prod"){
	define("WS","http://www.admovil.net/adconnection/webservice_soap.asmx?WSDL");
	define("USER","COF070627R60");
	define("PASS","rtg98sqw7");
	define("WS_TIPO","produccion");
}

?>
