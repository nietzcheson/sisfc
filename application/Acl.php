<?php
	class ACL
	{
		private $_db;
		private $_id;
		private $_role;
		private $_permisos;
		function __construct($id=false)
		{
			if ($id) {
				$this->_id = (int) $id;
			}
			else{
				if (Session::get('id_usuario')) {
					$this->_id = Session::get('id_usuario');
				}
				else{
					$this->_id = 0; // valor qu restringe el acceso
				}
			}
			$this->_db = new DataBase;
			$this->_role = $this->getRole();
			$this->_permisos = $this->getPermisosRole();
			$this->compilarAcl();
		}
		public function compilarAcl()
		{
			$this->_permisos = array_merge(
				$this->_permisos,
				$this->getPermisoUsuario()
			);
		}
		public function getRole()
		{
			$role = $this->_db->query(
				"SELECT * FROM usuarios " .
				"WHERE id = '$this->_id' "
			);
			$role = $role->fetch();
			return $role['role'];
		}
		public function getPermisosRoleId()
		{
			$ids = $this->_db->query(
				"SELECT id_permiso FROM permiso_role " .
				"WHERE id_role = '$this->_role'"
			);
			$ids = $ids->fetchAll(PDO::FETCH_ASSOC);
			$id = array();
			for ($i=0; $i < count($ids); $i++) {
				$id[] = $ids[$i]['id_permiso'];
			}
			return $id;
		}
		public function getPermisosRole()
		{
			$permisos = $this->_db->query(
				"SELECT * FROM permiso_role " .
				"WHERE id_role = '$this->_role'"
			);
			$permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);
			$data = array();
			for ($i=0; $i < count($permisos); $i++) {
				$key = $this->getPermisoKey($permisos[$i]['id_permiso']);
				if ($key=='') {
					continue;
				}
				if ($permisos[$i]['valor']==1) {
					$v = true;
				}
				else
				{
					$v = false;
				}
				$data[$key] = array(
					'key' => $key,
					'permiso' => $this->getPermisoNombre($permisos[$i]['id_permiso']),
					'valor' => $v,
					'heredado' => true,
					'id'=>$permisos[$i]['id_permiso']
				);
			}
			return $data;
		}
		public function getPermisoKey($id_permiso)
		{
			$id_permiso = (int) $id_permiso;
			$key = $this->_db->query(
				"SELECT llave FROM permisos " .
				"WHERE id = '$id_permiso'"
			);
			$key = $key->fetch();
			return $key['llave'];
		}
		public function getPermisoNombre($id_permiso)
		{
			$id_permiso = (int) $id_permiso;
			$key = $this->_db->query(
				"SELECT nombre FROM permisos " .
				"WHERE id = '$id_permiso'"
			);
			$key = $key->fetch();
			return $key['nombre'];
		}
		public function getPermisoUsuario()
		{
			$id = $this->getPermisosRoleId();
			if (count($id)) {
				$permisos = $this->_db->query(
					"SELECT * FROM permiso_usuario " .
					"WHERE id_usuario = '$this->_id' " .
					"AND id_permiso in (" . implode(",", $id) . ")"
				);
				$permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);
			}
			else
			{
				$permisos = array();
			}
			$data = array();
			for ($i=0; $i < count($permisos); $i++) {
				$key = $this->getPermisoKey($permisos[$i]['id_permiso']);
				if ($key=='') {
					continue;
				}
				if ($permisos[$i]['valor']==1) {
					$v = true;
				}
				else
				{
					$v = false;
				}
				$data[$key] = array(
					'key' => $key,
					'permiso' => $this->getPermisoNombre($permisos[$i]['id_permiso']),
					'valor' => $v,
					'heredado' => false,
					'id'=>$permisos[$i]['id_permiso']
					);
			}
			return $data;
		}
		public function getPermisos()
		{
			if (isset($this->_permisos) && count($this->_permisos)) {
				return $this->_permisos;
			}
		}
		public function permiso ($key)
		{
			if (array_key_exists($key, $this->_permisos)) {
				if ($this->_permisos[$key]['valor'] = true || $this->_permisos[$key]['valor'] = 1) {

					return true;
				}
			}

			return false;
		}
		public function acceso($key)
		{
			if ($this->permiso($key)) {
				return true;
			}
			header('location:' .  BASE_URL);
		}
	}
?>
