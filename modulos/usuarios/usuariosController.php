<?php 
	class usuariosController extends Controller
	{
	    private $_usuarios;
		public function __construct()
		{
			parent::__construct();
			$this->_usuarios = $this->loadModel('usuarios');
		}
		public function index()
		{
			$this->_view->assign('titulo','Usuarios');
			$this->_view->assign('usuarios',$this->_usuarios->getUsuarios());
			$this->_view->renderizar('index');

		}


		public function permisos($id_usuario)
		{
			$id = $this->filtrarInt($id_usuario);
			if (!$id) {
				$this->redireccionar('usuarios');
			}
			if ($this->getInt('guardar')==1) {
				
				$values = array_keys($_POST);
				$replace = array();
				$eliminar = array();
				for ($i=0; $i < count($values) ; $i++) { 
					if (substr($values[$i],0,5)=='perm_') {

						if ($_POST[$values[$i]]=='x') {
							$eliminar[] = array(
								'usuario'=>$id,
								'permiso'=>substr($values[$i],-strlen($values[$i])+5),
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
								'usuario'=>$id,
								'permiso'=>substr($values[$i],-strlen($values[$i])+5),
								'valor'=>$v
							);
							
						}		

					}

				}
				for ($i=0; $i < count($eliminar); $i++) { 
					$this->_usuarios->eliminarPermiso(
						$eliminar[$i]['usuario'],
						$eliminar[$i]['permiso']
						);
				}
				for ($i=0; $i < count($replace); $i++) { 
					$this->_usuarios->editarPermiso(
						$replace[$i]['usuario'],
						$replace[$i]['permiso'],
						$replace[$i]['valor']
						);

				}
			}
			$permisosUsuario = $this->_usuarios->getPermisosUsuario($id);
			$permisosRole = $this->_usuarios->getPermisosRole($id);
			if (!$permisosUsuario || !$permisosRole) {
				$this->redireccionar('usuarios');
			}
			$entro=array_keys($permisosUsuario);
			$this->_view->assign('titulo','Permisos de usuario');
			$this->_view->assign('permisos',array_keys($permisosUsuario));
			$this->_view->assign('usuario',$permisosUsuario);
			$this->_view->assign('role',$permisosRole);
			$this->_view->assign('info',$this->_usuarios->getUsuario($id));
			$this->_view->renderizar('permisos');
		}
		public function editar_role($id_usuario)
		{
			$id = $this->filtrarInt($id_usuario);
			if (!$id) {
				$this->redireccionar('usuarios');
			}
			$row = $this->_usuarios->getUsuario($id);
			if (!$row) {
				$this->redireccionar('usuarios');
			}
			if ($this->getInt('editar')==1) {
				$values = array_keys($_POST);
				$id_role=0;
				for ($i=0; $i < count($values) ; $i++) { 
					if (substr($values[$i],0,5)=='usur_') {
						$id_role= (int) $_POST[$values[$i]];
					}
				}
				if ($id_role) {
					$this->_usuarios->editarUsuarioRole($id,$id_role);
				}
			}
			$this->_view->assign('titulo','Editar Role');
			$this->_view->assign('actualrol',$id);
			$this->_view->assign('info',$this->_usuarios->getUsuario($id));
			$this->_view->assign('roles',$this->_usuarios->getRoles());
			$this->_view->renderizar('editar_role');
		}

		public function crear_usuario(){
			$this->_view->assign('titulo','Crear usuario');
			//$this->_view->assign('usuarios',$this->_usuarios->getUsuarios());
			$this->_view->renderizar('crear_usuario');
		}
	}