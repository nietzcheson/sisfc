<?php
	class loginController extends Controller
	{
		private $_login;
		public function __construct()

		{
			parent::__construct();
			$this->_login = $this->loadModel('login');
			$this->_view->setTemplate("accesos");
			$this->getLibrary('validFluent');
		}

		public function index()
		{
			if (Session::get('autenticado')) {
				$this->redireccionar("operaciones");
			}

			$this->_view->assign('titulo',"Iniciar Sesion");
			$this->_view->setJs(array('login'));

			if ($this->getInt('sisfc') == 1) { // si el formulario fue enviado, osea logear es = 1
				$datos = $_POST;
				$this->_view->assign("datos",$datos);

				if (!$this->getAlphaNum('usuario')) {
					$this->_view->assign('error', "Debe introducir el nombre del usuario");
					$this->_view->renderizar('index','login');
					exit;
				}
				if (!$this->getSql('pass')) {
					$this->_view->assign('error',"Debe introducir el password del usuario");
					$this->_view->renderizar('index','login');
					exit;
				}

				$row = $this->_login->getUsuario( // consula en la base de datos
						$this->getAlphaNum('usuario'),
						$this->getAlphaNum('pass')
					);
				if (!$row) {
					$this->_view->assign('_error',"El usuario y/o password incorrecto");
					$this->_view->renderizar('index','login');
					exit;
				}

				if ($row['estado'] !=1) {
					$this->_view->assign('_error',"Este usuario no esta habilitado");
					$this->_view->renderizar('index','login');
					exit;
				}

				Session::set('autenticado',true); // indica que el usuario se ha autenticado
				Session::set('level',$row['role']); //da el nivel de usuario
				Session::set('usuario',$row['usuario']);
				Session::set('nombre_usuario',$row['nombre']);
				Session::set('id_usuario',$row['id']);
				Session::set('tiempo',time());
				$this->redireccionar("kpis");
			}

			if(isset($_POST["secs"]) && isset($_POST["secs"])==1){

				$datos = $_POST;
				$this->_view->assign("datos",$datos);
				$this->_view->assign("secs",1);
				//$this->redireccionar("secs");
				$this->getLibrary('validFluent');
				$this->validador = new ValidFluent($_POST);
				$this->validador->name("email")->required("El Email no puede quedar vacío")->email("El email no es correcto")->minSize("El Email, no debe tener menos de 3 caracteres",3);
				$this->validador->name("pass")->required("La contraseña es requerida")->alfa()->minSize(3);

				if(!$this->validador->isGroupValid()){
					$errores[] = $this->validador->getError('email');
					$errores[] = $this->validador->getError('pass');

					$errores = array_filter($errores);

					$this->_view->assign("_errores",$errores);
				}else{

					$email = $this->getSql("email");
					$pass = $this->getAlphaNum("pass");

					$this->marca = $this->_login->getMarca($email,$pass);

					if(!$this->marca){
						$this->_view->assign("_errores","El usuario y/o la contraseña son incorrectos");
					}else{

						Session::set('autenticado',true); // indica que el usuario se ha autenticado
						Session::set('id_marca',$this->marca['id_u_marca']); //da el nivel de usuario
						Session::set('tiempo',time());
						$this->redireccionar("secs");
					}

				}


			}

			$this->_view->renderizar('index','login');
		}

		public function cerrar()
		{
			Session::destroy();
			$this->redireccionar("login");
		}


	}
