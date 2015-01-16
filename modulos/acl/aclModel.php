<?php
    class aclModel extends Model{
        public function __construct(){
            parent::__construct();
        }
        public function getRole($id_role){
            $role = $this->_db->query("SELECT * FROM roles WHERE id_role='$id_role'");
            return $role->fetch();
        }
        public function getPermiso($id_permiso)
        {
            $permiso = $this->_db->query("SELECT * FROM permisos WHERE id='$id_permiso'");
            return $permiso->fetch();
        }
        public function getRoles(){
            $role = $this->_db->query("SELECT * FROM roles");
            return $role->fetchAll();
        }
        public function getPermisosAll(){
            $permisos = $this->_db->query("SELECT * FROM permisos");
            $permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);
            $data=array();
            for ($i=0; $i <count($permisos) ; $i++) {
                if ($permisos[$i]['llave']=='') {
                    continue;
                }
                $data[$permisos[$i]['llave']] = array(
                    'key'=>$permisos[$i]['llave'],
                    'valor'=>'x',
                    'nombre'=>$permisos[$i]['nombre'],
                    'id' => $permisos[$i]['id']
                );
            }
            return $data;
        }
        public function getPermisosRole($id_role){
            $data = array();
            $permisos = $this->_db->query("SELECT * FROM permiso_role WHERE id_role='$id_role'");
            $permisos = $permisos->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i <count($permisos) ; $i++) {
                $key = $this->getPermisoKey($permisos[$i]['id_permiso']);
                if ($key=='') {
                    continue;
                }
                if ($permisos[$i]['valor']==1) {
                    $v=1;
                }else{
                    $v=0;
                }
                $data[$key] = array(
                    'key'=>$key,
                    'valor'=>$v,
                    'nombre'=> $this->getPermisoNombre($permisos[$i]['id_permiso']),
                    'id' => $permisos[$i]['id_permiso']
                    );
            }
            $data = array_merge($this->getPermisosAll(),$data);
            return $data;
        }
        public function eliminarPermisoRole($id_role,$id_permiso){
            $this->_db->query(
                "DELETE FROM permiso_role " .
                "WHERE id_role=$id_role AND id_permiso='$id_permiso'"
                );
        }
        public function editarPermisoRole($id_role,$id_permiso, $valor){
            $this->_db->query("REPLACE INTO permiso_role " .
            "SET id_role=$id_role, id_permiso='$id_permiso', valor='$valor'"
            );
        }
        public function getPermisoKey($id_permiso){
            $id_permiso = (int) $id_permiso;
            $key = $this->_db->query("SELECT llave FROM permisos " .
            "WHERE id = {$id_permiso}");
            $key = $key->fetch();
            return $key['llave'];
        }
        public function getPermisoNombre($id_permiso){
            $id_permiso = (int) $id_permiso;
            $key = $this->_db->query(
                "SELECT nombre FROM permisos " .
                "WHERE id = '$id_permiso'"
                );
            $key = $key->fetch();
            return $key['nombre'];	
        }
        public function insertarRole($role){
            $this->_db->query("INSERT INTO roles VALUES(null, '{$role}')");
        }
        public function editarRole($id_role,$role){	
            $id = (int) $id_role;
            $this->_db->prepare("UPDATE roles SET role = :nombre_role WHERE id_role = :id")
            ->execute(
                array(
                    'id'=>$id,
                    'nombre_role'=>$role
                )
            );
        }
        public function editarPermiso($id_permiso,$permiso,$llave){
            $id = (int) $id_permiso;
            $this->_db->prepare("UPDATE permisos SET nombre = :nombre_permiso, llave = :llavep WHERE id = :id")
            ->execute(
                array(
                    'id'=>$id,
                    'nombre_permiso'=>$permiso,
                    'llavep'=>$llave
                )
            );
        }
        public function eliminarRole($id_role){
            $id = (int) $id_role;
            $this->_db->query(
                "DELETE FROM roles " .
                "WHERE id_role=$id"	 
            );
        }
        public function eliminarPermiso($id_permiso){
            $id = (int) $id_permiso;
            $this->_db->query("DELETE FROM permisos " .
            "WHERE id='$id_permiso'"
            );
        }
        public function insertarPermiso($datosEnviar){
            $this->insertarSQL($datosEnviar,"permisos");
        }
        public function getPermisos(){
            $permisos = $this->_db->query("SELECT * FROM permisos");
            return $permisos->fetchAll(PDO::FETCH_ASSOC);
        }
    }