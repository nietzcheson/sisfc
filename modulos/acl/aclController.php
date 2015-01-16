<?php 
	class aclController extends Controller
	{
		private $_aclm;
		public function __construct()
		{
			parent::__construct();
			$this->_aclm = $this->loadModel('acl');
		}
		public function index(){
		    $this->_acl->acceso('todo');
			//$post = $this->loadModel('post'); // carga el postModel, usando la funcion de controller VT13 removido
			//$this->_view->assign('post',$post->getPosts()); //le pasa los valores obtenidos VT13 removido
			
			$this->_view->assign('titulo','ACL | Roles y permisos'); //esto es una forma de pasar parametros, aqui esta el objeto view creado en la super clase controller
			$this->_view->renderizar('index'); // se llama el metodo de renderizado de views, cuya variable posts luego mediante view es usada
		}
		public function roles(){
		    $this->_acl->acceso('todo');
			$this->_view->setJs(array('confirmar'));
			$this->_view->assign('titulo','Administración de roles');
			$this->_view->assign('roles',$this->_aclm->getRoles()); 
			$this->_view->renderizar('roles'); 
		}
		public function permiso_role($id_role=false){
		    $this->_acl->acceso('todo');
			$id = $this->filtrarInt($id_role);
			if ($id<1) {
				$this->redireccionar('acl/roles');
			}
			$row = $this->_aclm->getRole($id);
			if (!$row) {
				$this->redireccionar('acl/roles');
			}
			$this->_view->assign('titulo','Administracion de permisos de role');
			if ($this->getInt('guardar')==1) {
				$values = array_keys($_POST);
				$replace = array();
				$eliminar = array();
				for ($i=0; $i < count($values) ; $i++) { 
					if (substr($values[$i],0,5)=='perm_') {
						if ($_POST[$values[$i]]=='x') {
							$eliminar[] = array(
								'role'=>$id,
								'permiso'=>substr($values[$i],5, strlen($values[$i])-4),
								);
						}
						else
						{
							if ($_POST[$values[$i]]==1) {
								$v=1;
							}
							else
							{
								$v=0;
							}
							$replace[] =array(
								'role'=>$id,
								'permiso'=>substr($values[$i],5, strlen($values[$i])-4),
								'valor'=>$v
							);
						}						
					}
				}
				for ($i=0; $i < count($eliminar); $i++) { 
					$this->_aclm->eliminarPermisoRole(
						$eliminar[$i]['role'],
						$eliminar[$i]['permiso']
						);
				}
				for ($i=0; $i < count($replace); $i++) { 
					$this->_aclm->editarPermisoRole(
						$replace[$i]['role'],
						$replace[$i]['permiso'],
						$replace[$i]['valor']
					);
				}
			}
			$this->_view->assign('role',$row);
			$this->_view->assign('permisos',$this->_aclm->getPermisosRole($id));
			$this->_view->renderizar('permiso_role'); 
		}
		public function nuevo_role(){
	        $this->_acl->acceso('todo');
	        $this->_view->assign('titulo', 'Nuevo Role');
	        if($this->getInt('guardar') == 1){
	            $this->_view->assign('datos', $_POST);
	            
	            if(!$this->getSql('role')){
	                $this->_view->assign('_error', 'Debe introducir el nombre del role');
	                $this->_view->renderizar('nuevo_role', 'acl');
	                exit;
	            }
	            $this->_aclm->insertarRole($this->getSql('role'));
	            $this->redireccionar('acl/roles');
	        }
	        $this->_view->renderizar('nuevo_role', 'acl');
	    }
	    public function permisos(){
	        $this->_acl->acceso('todo');
	    	$this->_view->setJs(array('confirmar'));
	        $this->_view->assign('titulo', 'Administracion de permisos');
	        $this->_view->assign('permisos', $this->_aclm->getPermisos());
	        $this->_view->renderizar('permisos', 'acl');
	    }
	    public function nuevo_permiso(){
	        $this->_acl->acceso('todo');
	        $this->_view->assign('titulo', 'Nuevo Permiso');
	        if($this->getInt('guardar') == 1){
	            $this->_view->assign('datos', $_POST);
	            if(!$this->getSql('permiso')){
	                $this->_view->assign('_error', 'Debe introducir el nombre del permiso');
	                $this->_view->renderizar('nuevo_permiso', 'acl');
	                exit;
	            }
	            
	            if(!$this->getAlphaNum('key')){
	                $this->_view->assign('_error', 'Debe introducir el key del permiso');
	                $this->_view->renderizar('nuevo_permiso', 'acl');
	                exit;
	            }
	            $datosEnviar = array(
					"nombre"=>$this->getSql('permiso'),
					"llave"=>$this->getSql('key')
				);
				$this->_aclm->insertarPermiso($datosEnviar);
	            $this->redireccionar('acl/permisos');
	            exit;
	        }
	        $this->_view->renderizar('nuevo_permiso', 'acl');
	    }
	    public function editar_role($id_role){
	        $this->_acl->acceso('todo');
	    	$id = $this->filtrarInt($id_role);
			if (!$id) {
				$this->redireccionar('acl/roles');
			}
			$row = $this->_aclm->getRole($id);
			if (!$row) {
				$this->redireccionar('acl/roles');
			}
	    	$this->_view->assign('titulo', 'Editar Role');
			if ($this->getInt('editar')==1) {
				if (!$this->getTexto('role')) { //si hay texto en el input titulo
					$this->_view->_error = "Debe introducir el nombre del role";
					$this->_view->renderizar('roles','acl');
					exit;
				}
				$this->_aclm->editarRole($id, $this->getTexto('role'));
			}
			$this->_view->assign('datos',$this->_aclm->getRole($id));
			$this->_view->renderizar('editar_role', 'acl');
	    }
	    public function editar_permiso($id_permiso){
	        $this->_acl->acceso('todo');
	    	$id = $this->filtrarInt($id_permiso);
			if (!$id) {
				$this->redireccionar('acl/permisos');
			}
			$row = $this->_aclm->getPermiso($id_permiso);
			if (!$row) {
				$this->redireccionar('acl/permisos');
			}
	    	$this->_view->assign('titulo', 'Editar Permiso');
			if ($this->getInt('editar')==1) {
				if (!$this->getTexto('permiso')) { 
					$this->_view->_error = "Debe introducir el nombre del permiso";
					$this->_view->renderizar('permisos','acl');
					exit;
				}
				if (!$this->getTexto('key')) {
					$this->_view->_error = "Debe introducir el nombre de la llave permiso";
					$this->_view->renderizar('permisos','acl');
					exit;
				}
				$this->_aclm->editarPermiso($id, $this->getTexto('permiso'),$this->getTexto('key'));
				$this->permisos();
				exit;
			}
			$this->_view->assign('datos',$this->_aclm->getPermiso($id));
			$this->_view->renderizar('editar_permiso', 'acl');
	    }
	    public function eliminar_role($id_role){
	        $this->_acl->acceso('todo');
	    	$id = $this->filtrarInt($id_role);
			if (!$id) {
				$this->redireccionar('acl/roles');
			}
			$row = $this->_aclm->getRole($id);
			if (!$row) {
				$this->redireccionar('acl/roles');
			}
			$this->_aclm->eliminarRole($id);
			$this->roles();
	    }
	    public function eliminar_permiso($id_permiso){
	        $this->_acl->acceso('todo');
	    	$id = $this->filtrarInt($id_permiso);
			if (!$id) {
				$this->redireccionar('acl/permisos');
			}
			$row = $this->_aclm->getPermiso($id);
			if (!$row) {
				$this->redireccionar('acl/permisos');
			}
			$this->_aclm->eliminarPermiso($id);
			$this->permisos();
	    }
	}