<?php 
	/**
	* 
	*/
	class siicexModel extends Model
	{
		
		function __construct()
		{
			parent::__construct();
		}

		public function getSeccion($codigo){
	    	$post = $this->_db->query("SELECT * FROM secciones WHERE codigo = '$codigo'");
	    	return $post->fetch();
	    }
	    public function crearSeccion($datosEnviar){
	        $this->insertarSQL($datosEnviar,"secciones");
	    }
	    public function actualizarSeccion($datosEnviar){
	        $this->actualizarSQL($datosEnviar,"secciones");
	    }

	    public function getCapitulo($codigo_capitulo,$codigo_seccion){
	    	$post = $this->_db->query("SELECT * FROM capitulos WHERE codigo_capitulo = '$codigo_capitulo' AND codigo_seccion='$codigo_seccion'");
	    	return $post->fetch();
	    }
	    public function crearCapitulo($datosEnviar){
	        $this->insertarSQL($datosEnviar,"capitulos");
	    }
	    public function actualizarCapitulo($datosEnviar){
	        $this->actualizarSQL($datosEnviar,"capitulos");
	    }

	    public function getPartida($codigo_partida,$codigo_capitulo){
	    	$post = $this->_db->query("SELECT * FROM partidas WHERE codigo_partida = '$codigo_partida' AND codigo_capitulo='$codigo_capitulo'");
	    	return $post->fetch();
	    }
	    public function crearPartida($datosEnviar){
	        $this->insertarSQL($datosEnviar,"partidas");
	    }
	    public function actualizarPartida($datosEnviar){
	        $this->actualizarSQL($datosEnviar,"partidas");
	    }

	    public function getSubPartida($codigo_subpartida,$codigo_partida){
	    	$post = $this->_db->query("SELECT * FROM subpartidas WHERE codigo_subpartida = '$codigo_subpartida' AND codigo_partida='$codigo_partida'");
	    	return $post->fetch();
	    }
	    public function crearSubPartida($datosEnviar){
	        $this->insertarSQL($datosEnviar,"subpartidas");
	    }
	    public function actualizarSubPartida($datosEnviar){
	        $this->actualizarSQL($datosEnviar,"subpartidas");
	    }

	    public function getFraccion($codigo_fraccion,$codigo_subpartida){
	    	$post = $this->_db->query("SELECT * FROM fracciones_arancelarias WHERE codigo_subpartida = '$codigo_subpartida' AND codigo_fraccion='$codigo_fraccion'");
	    	return $post->fetch();
	    }
	    public function crearFraccion($datosEnviar){
	        $this->insertarSQL($datosEnviar,"fracciones_arancelarias");
	    }
	    public function actualizarFraccion($datosEnviar){
	        $this->actualizarSQL($datosEnviar,"fracciones_arancelarias");
	    }
	}