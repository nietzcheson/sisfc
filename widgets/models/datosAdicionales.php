<?php

class datosAdicionalesModelWidget extends Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getTiposAdicionales()
	{
		$datos = $this->_db->query("SELECT * FROM t_datos_adicionales");
		return $datos->fetchAll();
	}

	public function setDatosAdicionales($datosEnviar)
	{
		$this->insertarSQL($datosEnviar,"datos_adicionales");
	}

	public function getDatosAdicionales($id)
	{
		$datos = $this->_db->query("SELECT * FROM datos_adicionales WHERE id_prospecto='{$id}'");

		return $datos->fetchAll();
	}

	public function eliminarDatosAdicionales($id)//
	{
			$id = (int) $id;
			$post = $this->_db->query("DELETE FROM datos_adicionales WHERE id = '$id'");
	}

	public function eliminarDatoAdicional($id)//
	{
			$post = $this->_db->query("DELETE FROM datos_adicionales WHERE id_prospecto = '$id'");
	}

	public function actualizarDatosAdicionales($datosEnviar)//
	{
			$this->actualizarSQL($datosEnviar,"datos_adicionales");
	}



}


?>
