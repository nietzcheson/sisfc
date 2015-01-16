<?php
	class perfilController extends Controller{
		private $_clientes;
		public function __construct(){
			parent::__construct();
			$this->_acl->acceso('todo');
			$this->_modelo = $this->loadModel('perfil');
		}

		public function index(){
			$this->_view->assign('titulo','Perfil');
			$this->_view->setJs(array('index'));

			$this->getLibrary('validFluent');

			if($this->getInt("perfil")==1){
				$this->validador = new ValidFluent($_POST);
				$this->validador->name("nombre")->required("El Nombre no puede quedar vacío")->alfa()->minSize(3);
				$this->validador->name("usuario")->required("El Usuario está vacío")->alfa()->minSize(3);
				$this->validador->name("email")->required("El Email es obligatorio")->email("El email no es válido")->minSize(3);

				if(!$this->validador->isGroupValid()){

					$errores[] = $this->validador->getError('nombre');
					$errores[] = $this->validador->getError('usuario');
					$errores[] = $this->validador->getError('email');

					$errores = array_filter($errores);

					$this->_view->assign("_errores",$errores);
				}else{

					$nombre = $this->getSql("nombre");
					$usuario = $this->getSql("usuario");
					$email = $this->getSql("email");

					$datosEnviar = array(
						"id" => $_SESSION["id_usuario"],
						"nombre" => $nombre,
						"usuario" => $usuario,
						"email" => $email
					);

					$this->_modelo->actualizarPerfil($datosEnviar);
					Session::set('nombre_usuario',$nombre);
					$this->_view->assign("_mensaje","Datos actualizados");
				}
			}

			if($this->getInt("cambiar_pass")==1){
				$this->validador = new ValidFluent($_POST);
				$this->validador->name("pass")->required("La Contraseña es obligatoria")->alfa()->minSize(3);
				$this->validador->name("new_pass")->required("La Nueva Contraseña es obligatoria")->alfa()->minSize(3);
				$this->validador->name("new_pass_r")->required("Debes repetir la nueva contraseña")->alfa()->minSize(3);

				if(!$this->validador->isGroupValid()){

					$errores[] = $this->validador->getError('pass');
					$errores[] = $this->validador->getError('new_pass');
					$errores[] = $this->validador->getError('new_pass_r');

					$errores = array_filter($errores);

					$this->_view->assign("_errores",$errores);
				}else{

					$new_pass = $this->getSql("new_pass");
					$new_pass_r = $this->getSql("new_pass_r");

					if($new_pass===$new_pass_r){

						$last_pass = sha1(md5($this->getSql("pass")));

						$pass_perfil = $this->_modelo->getPassPerfil($_SESSION["id_usuario"]);

						if($last_pass==$pass_perfil["pass"]){
							$new_pass = sha1(md5($new_pass));

							$datosEnviar = array(
								"id" => $_SESSION["id_usuario"],
								"pass" => $new_pass
							);

							$this->_modelo->actualizarPassPerfil($datosEnviar);

							$this->_view->assign("_mensaje","Contraseña actualizada");
						}else{
							$this->_view->assign("_errores","La contraseña antigua no es correcta");
						}


					}else{
						$this->_view->assign("_errores","Las nuevas contraseñas no son iguales");
					}

				}

			}




			$this->_view->assign("perfil",$this->_modelo->getPerfil($_SESSION["id_usuario"]));
			$this->_view->renderizar('index',"perfil");
		}
	}


?>
