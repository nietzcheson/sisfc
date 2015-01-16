<?php

class operacionesModelWidget extends Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getReferencias($empresa)
	{
		$operaciones = $this->_db->query(
		"SELECT r.*, m.nombre_marca, mon.n_espanol, u.nombre_usuario, p.nombre_prospecto,apellido_prospecto
		FROM referencias r LEFT JOIN marcas m
		ON r.cliente = m.id_u_marca
		LEFT JOIN monedas mon
		ON r.moneda = mon.id_moneda
		LEFT JOIN usuarios_sisfc u
		ON r.co = u.id_u_usuario
		LEFT JOIN prospectos p
		ON r.cliente = p.id_u_prospecto
		WHERE r.id_u_empresa = '$empresa'
		");
		return $operaciones->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getMonedas()
	{
		$monedas = $this->_db->query("SELECT * FROM monedas");

		return $monedas->fetchAll();
	}

	public function getEstatus()
	{
		$estatus = $this->_db->query("SELECT * FROM estatus ORDER BY posicion ASC");
		return $estatus->fetchAll();
	}

	public function getUsuarios()
	{
		$usuarios = $this->_db->query("SELECT * FROM usuarios");
		return $usuarios->fetchAll();
	}


}



?>
