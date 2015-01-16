<?php 
	class usuariosModel extends Model
	{
	    public function __construct() 
	    {
	        parent::__construct();
	    }
	    
	    public function getUsuarios()
	    {
	       $usuarios = $this->_db->query(
	       		"SELECT u.*,r.role FROM usuario u, roles r " .
	       		"WHERE u.role = r.id_role"
	       		);
	      	return $usuarios->fetchAll(PDO::FETCH_ASSOC);
	    }
	     public function getUsuario($id_usuario)
	    {
	    	$usuarios = $this->_db->query(
	       		"SELECT u.usuario,r.role FROM usuario u, roles r " .
	       		"WHERE u.role = r.id_role AND u.id = $id_usuario"
	       		);
	      	return $usuarios->fetchAll(PDO::FETCH_ASSOC);
	    }
	    public function getPermisosUsuario($id_usuario)
	    {
	    	$acl = new ACL($id_usuario);
	    	return $acl->getPermisos();
	    }
	    public function getPermisosRole($id_usuario)
	    {
	    	$acl = new ACL($id_usuario);
	    	return $acl->getPermisosRole();
	    }
	    public function eliminarPermiso($id_usuario, $id_permiso)
	    {
	    	$this->_db->query(
	       		"DELETE FROM permiso_usuario WHERE " .
	       		"id_usuario = $id_usuario AND id_permiso = $id_permiso"
	       		);
	    }
	    public function editarPermiso($id_usuario, $id_permiso, $valor)
	    {
	    	$this->_db->query(
	       		"REPLACE INTO permiso_usuario SET " .
	       		"id_usuario = $id_usuario, id_permiso = $id_permiso, valor = '$valor'"
	       		);
	    }
	    public function getRoles()
	    {
	    	$role = $this->_db->query("select * from roles");
	      	return $role->fetchAll();
	    }
	    public function editarUsuarioRole($id_usuario,$id_role)
	    {
	    	$id = (int) $id_usuario;
	    	$id_r = (int) $id_role;
			$this->_db->prepare("UPDATE usuario SET role = :roleu WHERE id = :id")
					->execute(
						array(
							'id'=>$id_usuario,
							'roleu'=>$id_role
						)
					);
	    }
	}