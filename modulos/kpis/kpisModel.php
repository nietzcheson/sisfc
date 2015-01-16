<?php
	/**
	*
	*/
	class kpisModel extends Model
	{

		function __construct()
		{
			parent::__construct();
		}
		public function crearKpi($datosEnviar){
	        $this->insertarSQL($datosEnviar,"kpis");
	    }
	    public function ultimoKpi($usuario){
	        $linea = $this->_db->query("SELECT * FROM kpis WHERE id_usuario ='$usuario' ORDER BY id_kpi DESC LIMIT 1");
	        return $linea->fetch();
	    }
	    public function crearKpiValores($datosEnviar){
	        $this->insertarSQL($datosEnviar,"kpi_valores");
	    }
	    public function ultimoKpiValor($fecha,$id_kpi){
	        $linea = $this->_db->query("SELECT * FROM kpi_valores WHERE fecha ='$fecha' AND id_kpi = '$id_kpi' ORDER BY id_kpi_valor DESC LIMIT 1");
	        return $linea->fetch();
	    }
	    public function actualizarKpi($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"kpis");
	    }
	    public function getKpis(){
			$usuarios_sisfc = $this->_db->query(
                "SELECT * FROM kpis u INNER JOIN kpi_valores r ON u.id_kpi_valor = r.id_kpi_valor INNER JOIN usuarios w ON r.id_usuario = w.id WHERE u.activo=1"
            );
        	return $usuarios_sisfc->fetchAll(PDO::FETCH_ASSOC);
		}
		public function actualizarKpiValores($datosEnviar)
	    {
	        $this->actualizarSQL($datosEnviar,"kpi_valores");
	    }
	    public function getNombreUsuario($id){
			$usuario = $this->_db->query(
                "SELECT * FROM usuarios WHERE id='$id'"
            );
        	return $usuario->fetch();
		}
		public function getUsuarios(){
			$usuarios_sisfc = $this->_db->query(
                "SELECT * FROM usuarios ORDER BY usuario"
            );
        	return $usuarios_sisfc->fetchAll(PDO::FETCH_ASSOC);
		}
		public function crearKpiArea($datosEnviar){
			$this->insertarSQL($datosEnviar,"kpi_areas");
		}
		public function crearKpiPuesto($datosEnviar){
			$this->insertarSQL($datosEnviar,"kpi_puesto");
		}
		public function crearKpiUsuario($datosEnviar){
			$this->insertarSQL($datosEnviar,"kpi_usuario");
		}
		public function getKpi($id_kpi){
			$linea = $this->_db->query(
                "SELECT * FROM kpis WHERE id_kpi = '$id_kpi'"
            );
        	return $linea->fetch();
		}
		public function getKpi_area($id_kpi){
			$linea = $this->_db->query(
                "SELECT id_area FROM kpi_areas WHERE id_kpi = '$id_kpi'"
            );
        	return $linea->fetchAll(PDO::FETCH_ASSOC);
		}
		public function getKpi_puesto($id_kpi){
			$linea = $this->_db->query(
                "SELECT id_puesto FROM kpi_puesto WHERE id_kpi = '$id_kpi'"
            );
        	return $linea->fetchAll(PDO::FETCH_ASSOC);
		}
		public function getKpi_usuario($id_kpi){
			$linea = $this->_db->query(
                "SELECT id_usuario FROM kpi_usuario WHERE id_kpi = '$id_kpi'"
            );
        	return $linea->fetchAll(PDO::FETCH_ASSOC);
		}
		public function eliminarKpiArea($id_kpi){
			$post = $this->_db->query("DELETE FROM `kpi_areas` WHERE id_kpi = '$id_kpi'");
		}
		public function eliminarKpiPuesto($id_kpi){
			$post = $this->_db->query("DELETE FROM `kpi_puesto` WHERE id_kpi = '$id_kpi'");
		}
		public function eliminarKpiUsuario($id_kpi){
			$post = $this->_db->query("DELETE FROM `kpi_usuario` WHERE id_kpi = '$id_kpi'");
		}
		public function getKpi_x_Nombre($nombre){
			$linea = $this->_db->query(
                "SELECT id_kpi FROM kpis WHERE kpi_nombre LIKE '%$nombre%' AND activo=1"
            );
        	return $linea->fetchAll(PDO::FETCH_ASSOC);
		}
		public function getKpi_x_Unidad($unidad){
			$linea = $this->_db->query(
                "SELECT id_kpi FROM kpis WHERE id_unidad = '$unidad' AND activo=1"
            );
        	return $linea->fetchAll(PDO::FETCH_ASSOC);
		}
		public function getKpi_x_Area($consulta){
			$linea = $this->_db->query(
                "SELECT id_kpi FROM kpi_areas WHERE " . $consulta
            );
        	return $linea->fetchAll(PDO::FETCH_ASSOC);
		}
		public function getKpi_x_Puesto($consulta){
			$linea = $this->_db->query(
                "SELECT id_kpi FROM kpi_puesto WHERE " . $consulta
            );
        	return $linea->fetchAll(PDO::FETCH_ASSOC);
		}
		public function getKpi_x_Usuario($consulta){
			$linea = $this->_db->query(
                "SELECT id_kpi FROM kpi_usuario WHERE " . $consulta
            );
        	return $linea->fetchAll(PDO::FETCH_ASSOC);
		}
		public function getKPI_Notas($id_kpi){
			$lineas = $this->_db->query(
	            "SELECT u.*,r.nombre FROM kpis_kpi_notas u LEFT JOIN usuarios r " .
	            "ON u.id_usuario=r.id WHERE u.id_kpi = '$id_kpi'"
            );
            return $lineas->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function crearKPI_Kpi_Nota($datos)
	    {
	    	$this->insertarSQL($datos,"kpis_kpi_notas");
	    }
	}