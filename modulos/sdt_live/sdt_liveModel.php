<?php 
	/**
	* 
	*/
	class sdt_liveModel extends Model
	{
		
		function __construct()
		{
			parent::__construct();
		}

		public function getUsuarioSisfcId($id){
			$usuarios_sisfc = $this->_db->query(
                "SELECT * FROM usuarios_sisfc WHERE id_usuario = $id"
            );
        	return $usuarios_sisfc->fetch();
		}
		public function getUsuarioSisfcId2($id){
			$usuarios_sisfc = $this->_db->query(
                "SELECT * FROM usuarios WHERE id = $id"
            );
        	return $usuarios_sisfc->fetch();
		}
		public function getUsuarioSisfcIdSisFC(){
			$usuarios_sisfc = $this->_db->query(
                "SELECT * FROM usuarios ORDER BY nombre"
            );
        	return $usuarios_sisfc->fetchAll(PDO::FETCH_ASSOC);
		}
		public function crearSDT_RM_NewLine($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_rm");
	    }
	    public function ultimoSDT_RM_Line($usuario){
	        $linea = $this->_db->query("SELECT * FROM sdt_rm WHERE usuario ='$usuario' ORDER BY id DESC LIMIT 1");
	        return $linea->fetch();
	    }
	    public function getSDT_RM_Lines($usuario,$fecha){
			
			// $lineas = $this->_db->query("
			// SELECT *
			// FROM sdt_rm WHERE usuario = '$usuario' AND fecha = '$fecha' ORDER BY orden ASC
			// ");
			// return $lineas->fetchAll(PDO::FETCH_ASSOC);

			$lineas = $this->_db->query(
	            "SELECT * FROM sdt_rm u LEFT JOIN sdt_etiquetas r " .
	            "ON u.id_etiqueta = r.id_etiqueta WHERE u.usuario = '$usuario' AND u.fecha = '$fecha' ORDER BY u.orden ASC"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);

		}
		public function actualizarSDT_RM_Line($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"sdt_rm");
	    }
	    public function eliminarSDT_RM_Line($id){
	    	$post = $this->_db->query("DELETE FROM `sdt_rm` WHERE id = '$id'");
	    }
	    
	    public function getDias_SDT_RM($usuario,$fecha){
	    	$post = $this->_db->query("SELECT fecha, tachado FROM sdt_rm WHERE usuario = '$usuario' AND fecha LIKE '%$fecha';");
	    	return $post->fetchAll(PDO::FETCH_ASSOC);
	    }
	    //Nueva tarea
	    public function crearSDT_CL_NewTask($datosEnviar){
	        $this->insertarSQL($datosEnviar,"sdt_chlist_tareas");
	    }
	    public function crearSDT_CL_NewTaskDescription($datosEnviar){
	        $this->insertarSQL($datosEnviar,"sdt_tarea_descripcion");
	    }
	    public function getSDT_CL_NewTaskDescription($id){
	        $linea = $this->_db->query("SELECT * FROM sdt_tarea_descripcion WHERE id_tarea = '$id'");
	        return $linea->fetch();
	    }
	    public function actualizarSDT_CL_NewTaskDescription($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"sdt_tarea_descripcion");
	    }
	    public function eliminarSDT_CL_NewTaskDescription($id){
	    	$post = $this->_db->query("DELETE FROM `sdt_tarea_descripcion` WHERE id_tarea = '$id'");
	    }
	    public function getSDT_Tarea_Descripcion($id_tarea){
	    	// $linea = $this->_db->query("SELECT w.id_etiqueta, r.descripcion FROM sdt_chlist_tareas u, sdt_tarea_descripcion r, sdt_chlist_etiqueta w ".
	    	// 	"WHERE u.id_tarea = '$id_tarea' AND u.id_tarea = r.id_tarea AND w.id_tarea = u.id_tarea AND w.id_usuario = '$id_usuario'");
	     //    return $linea->fetch();
	    	$linea = $this->_db->query("SELECT descripcion FROM sdt_tarea_descripcion ".
	    		"WHERE id_tarea = '$id_tarea'");
	        return $linea->fetch();
	    }
	    public function getSDT_Tarea_Etiqueta($id_tarea,$id_usuario){
	    	$linea = $this->_db->query("SELECT id_etiqueta FROM sdt_chlist_etiqueta ".
	    		"WHERE id_tarea = '$id_tarea' AND id_usuario='$id_usuario'");
	        return $linea->fetch();
	    }
	    public function getSDT_CL_Tasks($usuario){
			
			// $lineas = $this->_db->query(
	  //           "SELECT * FROM sdt_tarea_usuario u LEFT JOIN sdt_chlist_tareas r " .
	  //           "ON u.id_tarea = r.id_tarea WHERE r.estado_tarea <= 1 AND u.id_usuario = '$usuario' ORDER BY r.orden"
   //          );
            $lineas = $this->_db->query(
	            "SELECT * FROM sdt_tarea_usuario u LEFT JOIN sdt_chlist_tareas r " .
	            "ON u.id_tarea = r.id_tarea WHERE u.id_usuario = '$usuario' AND r.estado_tarea <> 2 ORDER BY r.orden, r.siglas, r.tarea"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
		}
		public function actualizarSDT_CL_Task_Orden($datosEnviar){
			$this->actualizarSQL($datosEnviar,"sdt_chlist_tareas");
		}
		public function crearSDT_CL_Task_Dia($datosEnviar){
			$this->insertarSQL($datosEnviar,"sdt_chlist_dias");
		}
		public function getSDT_CL_TasksDias($usuario){
	  		//   	$dias = $this->_db->query(
	  		//      		"SELECT r.* FROM sdt_chlist_tareas u, sdt_chlist_dias r " .
	  		//      		"WHERE u.usuario = '$usuario' AND u.id_tarea = r.id_tarea "
	  		//      		);
			// return $dias->fetchAll(PDO::FETCH_ASSOC);

			$lineas = $this->_db->query(
	            "SELECT * FROM sdt_tarea_usuario u LEFT JOIN sdt_chlist_tareas r " .
	            "ON u.id_tarea = r.id_tarea LEFT JOIN sdt_chlist_dias z ON u.id_tarea = z.id_tarea WHERE u.id_usuario = '$usuario'"
            );
            if ($lineas) {
            	return $lineas->fetchAll(PDO::FETCH_ASSOC);
            }else{
            	$arra = array();
            	return $arra;
            }
	    }
	    public function actualizarSDT_CL_Task_Dia($datosEnviar){
	    	$this->actualizarSQL($datosEnviar,"sdt_chlist_dias");
	    }
	    public function ultimoSDT_CL_Days_Line($id_tarea){
	    	$linea = $this->_db->query("SELECT * FROM sdt_chlist_dias WHERE id_tarea = '$id_tarea' ORDER BY id_dia DESC LIMIT 1");
	        return $linea->fetch();
	    }
	    public function getDaysTask($id_tarea){
	    	$dias = $this->_db->query(
	       		"SELECT * FROM `sdt_chlist_dias` WHERE id_tarea = '$id_tarea'"
	       		);
			return $dias->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getSDT_Dia($id){
	    	$dias = $this->_db->query(
	       		"SELECT * FROM `sdt_chlist_dias` WHERE id_dia = '$id'"
	       		);
			return $dias->fetch();
	    }
	    public function eliminarSDT_CL_Task_Day($id_dia){
	    	$post = $this->_db->query("DELETE FROM `sdt_chlist_dias` WHERE id_dia = '$id_dia'");
	    }
	    //Tareas repetitivas
	    public function getSDT_CL_Repeats(){
	    	$lineas = $this->_db->query("
			SELECT *
			FROM sdt_chlist_repetir 
			");
			return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getSDT_CL_Tareas_Repetitivas($cade){
	    	if ($cade!="") {
	    		$lineas = $this->_db->query(" SELECT u.*, r.tarea FROM sdt_chlist_repetir u ".
	    			"LEFT JOIN sdt_chlist_tareas r ON u.id_tarea = r.id_tarea ".
	    			"WHERE ".$cade."
				");
				return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    	}else{
	    		return false;
	    	}
	    	
	    }
	    public function crearSDT_CL_NewTaskCiclo($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_chlist_repetir");
	    }
	    public function ultimoSDT_CL_NewTaskCiclo($datosEnviar){
	    	$linea = $this->_db->query("SELECT * FROM sdt_chlist_repetir ORDER BY id_dia DESC LIMIT 1");
	        return $linea->fetch();
	    }
	    public function eliminarSDT_CL_Task_1($id_tarea){
	    	$post = $this->_db->query("DELETE FROM `sdt_chlist_tareas` WHERE id_tarea = '$id_tarea'");
	    }
	    public function eliminarSDT_CL_Task_2($id_tarea){
	    	$post = $this->_db->query("DELETE FROM `sdt_chlist_dias` WHERE id_tarea = '$id_tarea'");
	    }
	    public function eliminarSDT_CL_Task_3($id_tarea){
	    	$post = $this->_db->query("DELETE FROM `sdt_chlist_repetir` WHERE id_tarea = '$id_tarea'");
	    }
	    public function eliminarSDT_CL_Task_4($id_tarea){
	    	$post = $this->_db->query("DELETE FROM `sdt_tarea_usuario` WHERE id_tarea = '$id_tarea'");
	    }
	    public function eliminarSDT_CL_Task_5($id_tarea){
	    	$post = $this->_db->query("DELETE FROM `sdt_tarea_proyecto` WHERE id_tarea = '$id_tarea'");
	    }
	    public function eliminarSDT_CL_Task_6($id_tarea){
	    	$post = $this->_db->query("DELETE FROM `sdt_tarea_grupo` WHERE id_tarea = '$id_tarea'");
	    }
	    public function ultimoSDT_Task($id_usuario){
	    	$linea = $this->_db->query("SELECT * FROM sdt_chlist_tareas WHERE tarea_ultimo = '$id_usuario' ORDER BY id_tarea DESC LIMIT 1");
	        return $linea->fetch();
	    }
	    //Etiqueta
	    public function getSDTFormat_Etiquetas($id_usuario){
	    	$etiquetas = $this->_db->query(
	       		"SELECT * FROM `sdt_etiquetas` WHERE id_usuario = '$id_usuario'"
	       		);
			return $etiquetas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getSDTLast_Etiquetas(){
	    	$etiqueta = $this->_db->query("SELECT id_etiqueta FROM sdt_etiquetas ORDER BY id_etiqueta DESC LIMIT 1");
	        return $etiqueta->fetch();
	    }
	    public function crearSDT_Etiqueta($datosEnviar){
			$this->insertarSQL($datosEnviar,"sdt_etiquetas");
		}
		public function actualizarEtiqueta($datosEnviar){
			$this->actualizarSQL($datosEnviar,"sdt_etiquetas");
		}
		public function deleteSDTFormat_Etiquetas($id_usuario){
			$post = $this->_db->query("DELETE FROM `sdt_etiquetas` WHERE id_usuario = '$id_usuario'");
		}
		public function getEtiquetaById($id_etiqueta){
			$etiqueta = $this->_db->query("SELECT * FROM `sdt_etiquetas` WHERE id_etiqueta = '$id_etiqueta'");
			return $etiqueta->fetch();
		}

		//Proyectos
		public function crearSDT_newProyect($datosEnviar){
			$this->insertarSQL($datosEnviar,"sdt_proyectos");
		}
		public function crearSDT_Proyecto_Recurso($datosEnviar){
			$this->insertarSQL($datosEnviar,"sdt_proyecto_recursos");
		}
		public function actualizarSDT_Proyecto_Recurso($datosEnviar){
			$this->actualizarSQL($datosEnviar,"sdt_proyecto_recursos");
		}
		public function getSDT_Proyecto_Recurso_Id($id_proyecto,$id_recurso){
			$linea = $this->_db->query(
	       		"SELECT * FROM sdt_proyecto_recursos " .
	       		"WHERE id_recurso = '$id_recurso' AND id_proyecto='$id_proyecto'"
	       		);
			return $linea->fetch();
		}
		public function eliminarSDT_Proyecto_Recurso($id){
			$post = $this->_db->query("DELETE FROM `sdt_proyecto_recursos` WHERE id_proyecto_recurso = '$id'");
		}
		public function eliminarSDT_Proyecto_Recursos($id_proyecto){
			$post = $this->_db->query("DELETE FROM `sdt_proyecto_recursos` WHERE id_proyecto = '$id_proyecto'");
		}
		public function ultimoSDT_newProyect($id_director){
			$linea = $this->_db->query("SELECT * FROM sdt_proyectos WHERE id_director='$id_director' ORDER BY id_proyecto DESC LIMIT 1");
	        return $linea->fetch();
		}
		public function actualizarSDT_Proyecto($datosEnviar){
			$this->actualizarSQL($datosEnviar,"sdt_proyectos");
		}
		public function getProyecto_Recurso($id){
	    	$proyecto = $this->_db->query(
	       		"SELECT u.*, r.* FROM sdt_proyecto_recursos u, usuarios_sisfc r " .
	       		"WHERE u.id_recurso = r.id_usuario AND id_proyecto='$id' ORDER BY r.nickname_usuario"
	       		);
			return $proyecto->fetchAll(PDO::FETCH_ASSOC);
	    }

		public function getProyectos(){
	    	$dias = $this->_db->query(
	       		"SELECT u.*, r.* FROM sdt_proyectos u, usuarios_sisfc r " .
	       		"WHERE u.id_director = r.id_usuario AND proyecto_visible=0 ORDER BY u.proyecto"
	       		);
			return $dias->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getUsuarios(){
	    	$dias = $this->_db->query(
	       		"SELECT * FROM usuarios_sisfc " .
	       		"ORDER BY nickname_usuario ASC"
	       		);
			return $dias->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getUsuarios2(){
	    	$dias = $this->_db->query(
	       		"SELECT * FROM usuarios " .
	       		"ORDER BY nombre ASC"
	       		);
			return $dias->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getUsuario($id){
	    	$proyecto = $this->_db->query(
	       		"SELECT * FROM usuarios_sisfc " .
	       		"WHERE id_usuario='$id' "
	       		);
			return $proyecto->fetch();
	    }
	    public function getProyect($id){
	    	$proyecto = $this->_db->query("SELECT * FROM `sdt_proyectos` WHERE id_proyecto = '$id'");
			return $proyecto->fetch();
	    }
	    public function getProyectoSiglas($id){
	    	$proyecto = $this->_db->query("SELECT * FROM `sdt_proyectos` WHERE siglas_proyecto = '$id'");
			return $proyecto->fetch();
	    }
	    public function getGrupoSiglas($id){
	    	$proyecto = $this->_db->query("SELECT * FROM `sdt_grupos` WHERE siglas_grupo = '$id'");
			return $proyecto->fetch();
	    }
	    public function crearSDT_Proyecto_Tarea($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_tarea_proyecto");
	    }
	    public function crearSDT_Tarea_Usuario($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_tarea_usuario");
	    }
	    
	    public function eliminarSDT_Tarea_Usuario($id){
	    	$post = $this->_db->query("DELETE FROM `sdt_tarea_usuario` WHERE id_tar_usu = '$id'");
	    }
	    public function getTareasProyecto($id){
	    	$lineas = $this->_db->query(
	            "SELECT u.*,r.*,z.* FROM sdt_tarea_proyecto u, sdt_chlist_tareas r, usuarios_sisfc z " .
	            "WHERE r.id_responsable = z.id_usuario AND u.id_tarea = r.id_tarea AND u.id_proyecto = '$id' ORDER BY r.tarea"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getTareasProyecto2($id){
	    	$lineas = $this->_db->query(
	            "SELECT * FROM sdt_tarea_proyecto " .
	            "WHERE id_proyecto = '$id'"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getTareasProyecto3($id_tarea){
	    	$lineas = $this->_db->query(
	            "SELECT * FROM sdt_tarea_proyecto " .
	            "WHERE id_tarea = '$id_tarea'"
            );
            return $lineas->fetch();
	    }
	    public function eliminarProyecto($id){
	    	$post = $this->_db->query("DELETE FROM `sdt_proyectos` WHERE id_proyecto = '$id'");
	    }
	    public function eliminarProyecto_Tarea($id){
	    	$post = $this->_db->query("DELETE FROM `sdt_tarea_proyecto` WHERE id_proyecto = '$id'");
	    }
	    public function getTarea($id){
	    	$lineas = $this->_db->query(
	            "SELECT * FROM sdt_chlist_tareas " .
	            "WHERE id_tarea = '$id'"
            );
            return $lineas->fetch();
	    }
	    public function getUsersTasks($id){
	    	$lineas = $this->_db->query(
	            "SELECT * FROM sdt_tarea_usuario u LEFT JOIN usuarios_sisfc r " .
	            "ON u.id_usuario=r.id_usuario WHERE u.id_tarea = '$id'"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getSDT_Tarea_Uruario($id_tarea, $id_usuario){
	    	$lineas = $this->_db->query(
	            "SELECT * FROM sdt_tarea_usuario  " .
	            "WHERE id_tarea = '$id_tarea' AND id_usuario = '$id_usuario'"
            );
            return  $lineas->fetch();
	    }
	    public function delectTask_User($id){
	    	$post = $this->_db->query("DELETE FROM `sdt_tarea_usuario` WHERE id_tarea = '$id'");
	    }

	    //Administracion de grupos de trabajo
	    public function getGrupo(){
	    	$dias = $this->_db->query(
	       		"SELECT * FROM sdt_grupos ORDER BY nombre_grupo"
	       	);
			return $dias->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getSDTGrupo_Tarea($id){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_tarea_grupo WHERE id_grupo='$id'"
	       	);
			return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getSDTGrupo_Tarea_Tarea($id_tarea){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_tarea_grupo WHERE id_tarea='$id_tarea'"
	       	);
			return $lineas->fetch();
	    }
	    public function getSDTGrupo_Tarea_Tarea_Tarea($id_tarea){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_tarea_grupo u, sdt_tarea_modelo r, sdt_grupos w ".
	       		"WHERE w.id_grupo = u.id_grupo AND u.id_tarea = r.id_modelo AND r.id_tarea='$id_tarea'"
	       	);
			return $lineas->fetch();
	    }
	    
	    public function crearSDT_CL_NewTaskCiclo_Model($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_chlist_repetir_model");
	    }
	    public function getSDT_CL_TaskCiclo_Model(){
	    	$lineas = $this->_db->query(
	            "SELECT * FROM sdt_chlist_tareas " .
	            "WHERE id_director = '-1'"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function crearSDT_Grupo($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_grupos");
	    }
	    public function crearSDT_Tarea_Grupo($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_tarea_grupo");
	    }
	    public function ultimoSDT_grupo($id_creador){
	    	$linea = $this->_db->query("SELECT * FROM sdt_grupos ORDER BY id_grupo DESC LIMIT 1");
	        return $linea->fetch();
	    }
	    public function getSDT_Grupo($id){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_grupos WHERE id_grupo='$id'"
	       	);
			return $lineas->fetch();
	    }
	    public function getSDT_Tarea_Grupo($id){
	    	$lineas = $this->_db->query(
	       		"SELECT u.*,r.tarea FROM sdt_tarea_grupo u LEFT JOIN sdt_chlist_tareas r ".
	       		"ON u.id_tarea = r.id_tarea WHERE u.id_grupo='$id' ORDER BY r.tarea"
	       	);
	    	return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function actualizarSDT_Grupo($datosEnviar){
	    	$this->actualizarSQL($datosEnviar,"sdt_grupos");
	    }
	    public function eliminarSDT_Tarea_Grupo($id){
	    	$post = $this->_db->query("DELETE FROM `sdt_tarea_grupo` WHERE id_grupo = '$id'");
	    }
	    public function eliminarSDT_Grupo($id){
	    	$post = $this->_db->query("DELETE FROM `sdt_grupos` WHERE id_grupo = '$id'");
	    }
	    public function getSDT_Tarea($id){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_chlist_tareas WHERE id_tarea='$id'"
	       	);
			return $lineas->fetch();
	    }
	    public function getSDT_Tareas_Repetir_Clone($id){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_chlist_repetir_model WHERE id_tarea='$id'"
	       	);
			return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function eliminarSDT_Tareas_Repetir_Clone($id){
	    	$post = $this->_db->query("DELETE FROM `sdt_chlist_repetir_model` WHERE id_tarea = '$id'");
	    }
	    public function crearSDT_Grupo_Usuario($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_grupo_usuario");
	    }
	    public function getSDT_Grupo_Usuario($id){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_grupo_usuario WHERE id_usuario='$id'"
	       	);
			return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getSDT_Tarea_Grupo_Usuario($id_grupo,$id_usuario){
	    	$lineas = $this->_db->query(
	            "SELECT u.*,r.* FROM sdt_tarea_modelo u, sdt_tarea_usuario r, sdt_tarea_grupo z  " .
	            "WHERE u.id_tarea = r.id_tarea AND r.id_usuario = '$id_usuario' AND z.id_grupo = '$id_grupo' AND u.id_modelo = z.id_tarea"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function actualizarSDT_Grupo_Usuario($datosEnviar){
	    	$this->actualizarSQL($datosEnviar,"sdt_grupo_usuario");
	    }
	    public function crearSDT_Tareas_Model_Config($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_chlist_tarea_model_config");
	    }
	    public function getSDT_Tareas_Model_Config($id){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_chlist_tarea_model_config WHERE id_tarea='$id' ORDER BY id_tarea_model_config DESC LIMIT 1"
	       	);
			return $lineas->fetch();
	    }
	    public function crearSDT_Tareas_Modelo($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_tarea_modelo");
	    }
	    public function getSDT_Tarea_Modelo($id){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_tarea_modelo WHERE id_modelo='$id'"
	       	);
			return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getSDT_Tareas_Repetir($id){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_chlist_repetir WHERE id_tarea='$id'"
	       	);
			return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function actualizarSDT_Tareas_Repetir($datosEnviar){
	    	$this->actualizarSQL($datosEnviar,"sdt_chlist_repetir");
	    }
	    public function eliminarSDT_Tareas_Repetir($id){
	    	$post = $this->_db->query("DELETE FROM `sdt_chlist_repetir` WHERE id_dia = '$id'");
	    }
	    public function eliminarSDT_Dias($id){
	    	$post = $this->_db->query("DELETE FROM `sdt_chlist_dias` WHERE id_dia = '$id'");
	    }
	    public function getSDT_Tarea_Modelo_Igual(){
	    	
	    }
	    public function crearSDT_Tarea_Comentario($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_tarea_comentario");
	    }
	    public function getSDT_Tarea_Comentario ($id){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_tarea_comentario WHERE id_tarea='$id'"
	       	);
			return $lineas->fetch();
	    }
	    public function actualizarSDT_Tarea_Comentario($datosEnviar){
	    	$this->actualizarSQL($datosEnviar,"sdt_tarea_comentario");
	    }
	    public function getSDT_Id_Grupo_Usuario($id_grupo,$id_usuario){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_grupo_usuario WHERE id_grupo='$id_grupo' AND id_usuario='$id_usuario'"
	       	);
			return $lineas->fetch();
	    }
	    public function getSDT_Usuarios_Grupo($id_grupo){
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_grupo_usuario WHERE id_grupo='$id_grupo'"
	       	);
			return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getSDT_Tarea_Modelo_Usuario($id_tarea,$id_usuario){
	    	$lineas = $this->_db->query(
	            "SELECT u.*,r.* FROM sdt_tarea_modelo u, sdt_tarea_usuario r  " .
	            "WHERE u.id_tarea = r.id_tarea AND r.id_usuario = '$id_usuario' AND u.id_modelo = '$id_tarea'"
            );
            return $lineas->fetch();
	    }
	    
	    # funciones para HTD

	    public function crearSDT_Tarea_Item($datos)
	    {
	    	$this->insertarSQL($datos,"sdt_tarea_items");
	    }
	    public function getItems($id_tarea)
	    {
	    	$lineas = $this->_db->query(
	       		"SELECT * FROM sdt_tarea_items WHERE id_tarea='$id_tarea'"
	       	);
			return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getNotas($id_tarea)
	    {
			$lineas = $this->_db->query(
	            "SELECT u.*,r.nickname_usuario FROM sdt_tarea_notas u LEFT JOIN usuarios_sisfc r " .
	            "ON u.id_usuario=r.id_usuario WHERE u.id_tarea = '$id_tarea'"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function crearSDT_Tarea_Nota($datos)
	    {
	    	$this->insertarSQL($datos,"sdt_tarea_notas");
	    }
	    public function eliminarSDT_Tarea_Item($id_tarea_item)
	    {
	    	$post = $this->_db->query("DELETE FROM `sdt_tarea_items` WHERE id_tarea_item = '$id_tarea_item'");
	    }
	    public function actualizarSDT_Tarea_Item($datos)
	    {
	    	$this->actualizarSQL($datos,"sdt_tarea_items");
	    }
	    public function limpiarChecklist(){
	    	$post = $this->_db->query("TRUNCATE `sdt_chlist_dias`");
	    	$post = $this->_db->query("TRUNCATE `sdt_chlist_repetir`");
	    	$post = $this->_db->query("TRUNCATE `sdt_chlist_repetir_model`");
	    	$post = $this->_db->query("TRUNCATE `sdt_chlist_tareas`");
	    	$post = $this->_db->query("TRUNCATE `sdt_chlist_tarea_model_config`");
	    	# $post = $this->_db->query("TRUNCATE `sdt_etiquetas`");
	    	$post = $this->_db->query("TRUNCATE `sdt_grupos`");
	    	$post = $this->_db->query("TRUNCATE `sdt_grupo_usuario`");
	    	$post = $this->_db->query("TRUNCATE `sdt_proyectos`");
	    	$post = $this->_db->query("TRUNCATE `sdt_tarea_grupo`");
	    	$post = $this->_db->query("TRUNCATE `sdt_tarea_modelo`");
	    	$post = $this->_db->query("TRUNCATE `sdt_tarea_proyecto`");
	    	$post = $this->_db->query("TRUNCATE `sdt_tarea_usuario`");
	    	$post = $this->_db->query("TRUNCATE `sdt_tarea_descripcion`");
	    	$post = $this->_db->query("TRUNCATE `sdt_proyecto_recursos`");
	    	$post = $this->_db->query("TRUNCATE `sdt_tarea_comentario`");
	    	$post = $this->_db->query("TRUNCATE `sdt_tarea_items`");
	    	$post = $this->_db->query("TRUNCATE `sdt_tarea_notas`");
	    	$post = $this->_db->query("TRUNCATE `sdt_chlist_orden`");
	    	$post = $this->_db->query("TRUNCATE `sdt_chlist_etiqueta`");
	    	
	    }

	    
	    public function getSDT_Proyectos_Usuario($id_usuario){
	    	$lineas = $this->_db->query(
	            "SELECT id_proyecto FROM sdt_proyecto_recursos " .
	            "WHERE id_recurso = '$id_usuario' ".
	            "UNION ".
	            "SELECT id_proyecto FROM sdt_proyectos " .
	            "WHERE id_director = '$id_usuario' AND proyecto_visible = 0"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }

	    public function getSDT_Grupos_Usuario($id_usuario){
	    	$lineas = $this->_db->query(
	            "SELECT id_grupo FROM sdt_grupo_usuario " .
	            "WHERE id_usuario = '$id_usuario' AND estado = 1"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }

	  //   public function getSDT_Tareas_Proyectos($cadena,$id_usuario){
	  //   	$lineas = $this->_db->query( 
	  //           "SELECT DISTINCT w.id_tarea FROM sdt_chlist_tareas u ". 
	  //           "LEFT JOIN sdt_tarea_proyecto r  ON r.id_tarea = u.id_tarea " .
	  //           "LEFT JOIN sdt_tarea_usuario w  ON w.id_tarea = u.id_tarea " .
	  //           "WHERE (" . $cadena ." w.id_usuario = '$id_usuario' ) AND u.estado_tarea <> 2 AND u.estado_tarea < 9"
   //          );
   //          $lineas1 = $lineas->fetchAll(PDO::FETCH_ASSOC);
   //          $cade="(";
			// foreach ($lineas1 as $key) {
			// 	if ($cade=="(") {
			// 		$cade.="u.id_tarea = ".$key["id_tarea"];
			// 	}else{
			// 		$cade.=" OR u.id_tarea = ".$key["id_tarea"];
			// 	}
			// }
			// $cade.=")";
			// // echo $cade . "<br>";

			// if ($cade=="()") {
			// 	return $lineas1;
			// }else{
			// 	$lineas = $this->_db->query(
		 //            "SELECT u.*,r.orden,w.id_etiqueta FROM sdt_chlist_tareas u " .
		 //            "LEFT JOIN sdt_chlist_orden r ON ('$id_usuario' = r.id_usuario AND u.id_tarea = r.id_tarea)".
		 //            "LEFT JOIN sdt_chlist_etiqueta w ON ('$id_usuario' = w.id_usuario AND u.id_tarea = w.id_tarea)".
		 //            "WHERE ".$cade." ORDER BY r.orden, u.siglas, u.tarea"
	  //           );

	  //           $lineas2 = $lineas->fetchAll(PDO::FETCH_ASSOC);

	  //           // echo print_r($lineas2) . "<br>";
	  //           // exit();
	  //           // return array_merge((array)$lineas1, (array)$lineas2);
	  //           return $lineas2;
			// }
	  //   }

	    public function getSDT_Tareas_Proyectos($proyecto,$grupo,$id_usuario){
	    	$lineas = $this->_db->query( 
	            "SELECT u.*, r.orden FROM sdt_chlist_tareas u ". 
	            "LEFT JOIN sdt_chlist_orden r ON ('$id_usuario' = r.id_usuario AND u.id_tarea = r.id_tarea) ".
	            "WHERE (" . $proyecto . $grupo .  " u.tarea_personal = '$id_usuario' ) AND u.estado_tarea <> 2 AND u.estado_tarea < 9 ORDER BY r.orden, u.siglas, u.tarea"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getSDT_Tareas_Proyectos_HTD($grupo,$id_usuario){
	    	$lineas = $this->_db->query( 
	            "SELECT u.*, r.orden FROM sdt_chlist_tareas u ". 
	            "LEFT JOIN sdt_chlist_orden r ON ('$id_usuario' = r.id_usuario AND u.id_tarea = r.id_tarea) ".
	            "WHERE (" . $grupo .  " u.tarea_personal = '$id_usuario' OR u.id_responsable = '$id_usuario' OR u.id_director = '$id_usuario') AND u.estado_tarea <> 2 AND u.estado_tarea < 9 ORDER BY r.orden, u.siglas, u.tarea"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getSDT_Tareas_Dias($tareas){
	    	$cade="";
	    	$cade2="";
			foreach ($tareas as $key) {
				if ($cade=="") {
					$cade="id_tarea = ".$key["id_tarea"];
					$cade2="u.id_tarea = ".$key["id_tarea"];
				}else{
					$cade.=" OR id_tarea = ".$key["id_tarea"];
					$cade2.=" OR u.id_tarea = ".$key["id_tarea"];
				}
			}
			$arra = array();
			$arra[1]=$cade2;
			$lineas = $this->_db->query(
	            "SELECT * FROM sdt_chlist_dias ".
	            "WHERE " . $cade ." "
            );
            if ($lineas) {
            	$arra[0] =  $lineas->fetchAll(PDO::FETCH_ASSOC);
            }else{
            	$arra[0] = array();
            }
            return $arra;
	    }
	    public function getSDT_Tareas_Dias_HTD($tareas,$fecha){
	    	$cade="";
	    	$cade2="(";
			foreach ($tareas as $key) {
				if ($cade=="") {
					$cade="u.id_tarea = ".$key["id_tarea"];
					$cade2.="r.id_tarea = ".$key["id_tarea"];
				}else{
					$cade.=" OR u.id_tarea = ".$key["id_tarea"];
					$cade2.=" OR r.id_tarea = ".$key["id_tarea"];
				}
			}
			$cade2.=") AND";
			if ($cade2=="() AND") {
				$cade2="";
			}
			$arra = array();
			$arra[1]=$cade;
			$lineas = $this->_db->query(
	            "SELECT u.*,r.tarea FROM sdt_chlist_dias u ".
	            "LEFT JOIN sdt_chlist_tareas r ON (u.id_tarea = r.id_tarea) " .
	            "WHERE " . $cade2 ." u.fecha = '$fecha'"
            );
           
            if ($lineas) {
            	$arra[0] =  $lineas->fetchAll(PDO::FETCH_ASSOC);

            }else{
            	$arra[0] = array();
            }
            return $arra;
	    }

	    public function getSDT_chlist_orden($id_tarea,$id_usuario){
	    	$lineas = $this->_db->query(
	            "SELECT * FROM sdt_chlist_orden " .
	            "WHERE id_tarea = '$id_tarea' AND id_usuario = '$id_usuario'"
            );
            return $lineas->fetch();
	    }
	    public function actualizarSDT_chlist_orden($datosEnviar){
	    	$this->actualizarSQL($datosEnviar,"sdt_chlist_orden");
	    }
	    public function crearSDT_chlist_orden($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_chlist_orden"); 
	    }
	    public function eliminarSDT_chlist_orden($id_tarea)
	    {
	    	$post = $this->_db->query("DELETE FROM `sdt_chlist_orden` WHERE id_tarea = '$id_tarea'");
	    }

	    public function actualizarSDT_Tarea_Usuario($datosEnviar){
	    	$this->actualizarSQL($datosEnviar,"sdt_tarea_usuario");
	    }

	    public function getSDT_chlist_etiqueta($id_tarea,$id_usuario){
	    	$lineas = $this->_db->query(
	            "SELECT * FROM sdt_chlist_etiqueta " .
	            "WHERE id_tarea = '$id_tarea' AND id_usuario = '$id_usuario'"
            );
            return $lineas->fetch();
	    }
	    public function actualizarSDT_chlist_etiqueta($datosEnviar){
	    	$this->actualizarSQL($datosEnviar,"sdt_chlist_etiqueta");
	    }
	    public function crearSDT_chlist_etiqueta($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"sdt_chlist_etiqueta"); 
	    }
	    public function eliminarSDT_chlist_etiqueta($id_tarea)
	    {
	    	$post = $this->_db->query("DELETE FROM `sdt_chlist_etiqueta` WHERE id_tarea = '$id_tarea'");
	    }

	    // Analytics
	    public function getSDT_All_RM(){
	    	$lineas = $this->_db->query(
	            "SELECT * FROM sdt_rm "
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }

	    //Buscar una palabra en el rm
	    public function getSDT_All_Words_RM($id_usuario, $palabra){
	    	$lineas = $this->_db->query(
	            "SELECT * FROM sdt_rm WHERE usuario = '$id_usuario' AND texto LIKE '%$palabra%' ORDER BY fecha, orden"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }

	    // HTD
	    public function obtener_Tareas_de_Usuario_por_Dia ($id_usuario,$fecha){
            $lineas = $this->_db->query(
	            "SELECT u.*, r.*, w.* FROM sdt_chlist_dias u ".
	            "LEFT JOIN sdt_tarea_usuario r ON u.id_tarea = r.id_tarea ".
	            "LEFT JOIN sdt_chlist_tareas w ON w.id_tarea = u.id_tarea ".
	            "WHERE u.fecha = '$fecha' AND r.id_usuario = '$id_usuario' AND w.estado_tarea <> 0 AND w.estado_tarea <> 2 AND w.estado_tarea < 9"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getHTD_Eventos($id_usuario){
	    	$eventos = $this->_db->query(
	            "SELECT id,title,start,end FROM htd_eventos WHERE id_usuario = '$id_usuario' ORDER BY id"
            );
            return $eventos->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function addHTD_Eventos($datosEnviar){
	    	$this->insertarSQL($datosEnviar,"htd_eventos"); 
	    }
	    public function updateHTD_Eventos($datosEnviar){
	    	$this->actualizarSQL($datosEnviar,"htd_eventos"); 
	    }
	    public function crearHTD_calendario_publico($datos){
	    	$this->insertarSQL($datos,"sdt_htd_calenario_publico"); 
	    }
	    public function getHTD_calendario_publico_x_usuario($id_usuario){
	    	$calendarios = $this->_db->query(
	            "SELECT * FROM sdt_htd_calenario_publico WHERE id_usuario = '$id_usuario'"
            );
            return $calendarios->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getHTD_calendario_publico_x_usuario_x_activado($id_usuario){
	    	$calendarios = $this->_db->query(
	            "SELECT * FROM sdt_htd_calenario_publico WHERE id_usuario = '$id_usuario' AND activado = 1"
            );
            return $calendarios->fetchAll(PDO::FETCH_ASSOC);
	    }
	}