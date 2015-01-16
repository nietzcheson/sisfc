<?php 
	class migracionController extends Controller
	{
	    private $_migracion;
		public function __construct()
		{
			parent::__construct();
			$this->_migracion = $this->loadModel('migracion');
		}

		public function index()
		{
			//$this->_acl->acceso('super_admin');
			$this->_view->assign('titulo','Migración de datos');
			//$this->_view->assign('migracion',$this->_migracion->getUsuarios_sisfc());

			$resultado_migracion = $this->_migracion->getUsuarios_sisfc();

			foreach($resultado_migracion as $param){

				$this->_migracion->registrarUsuario(
					$param['id_usuario'], 
					$param['nombre_usuario']." ".$param['p_apellido_usuario']." ".$param['s_apellido_usuario'], 
					$param['nickname_usuario'], 
					$param['contrasena_usuario'], 
					$param['email_usuario'], 
					$param['fecha_creacion_usuario']
				);
			}

			$this->_view->renderizar('index');
		}
	}