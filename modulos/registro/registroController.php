<?php
	class registroController extends Controller
	{
		private $_registro;
		public function __construct()
		{
			parent::__construct();
			$this->_registro=$this->loadModel('registro');
		}

		public function index()
		{
			if (Session::get('autenticado')) {
				$this->redireccionar();
			}

			$this->_view->assign("titulo",'registro');

			if ($this->getInt('registrar')==1) {
				$this->_view->assign("datos",$_POST);

				/*if (!$this->getSql('nombre')) { // el nombre puede tener cualquier caracter pero no contener tags
					$this->_view->assign('_error', "Debe introducir su nombre");
					$this->_view->renderizar('index','registro');
					exit;
				}*/

				if (!$this->getAlphaNum('usuario')) { // solo caracteres alfanumericos
					$this->_view->assign('_error', "introducir su nombre de usuario");
					$this->_view->renderizar('index','registro');
					exit;
				}
				if ($this->_registro->verficarUsuario($this->getAlphaNum('usuario'))) { //si el usuaria ya existe en la base de datos
					$this->_view->assign('_error', 'El nombre de usario ' . $this->getAlphaNum('usuario') . ' ya existe');
					$this->_view->renderizar('index','registro');
					exit;
				}
				if (!$this->validarEmail($this->getPostParm('email'))) { //extrae el email tal como fue esrito en la caja de texto
					$this->_view->assign('_error', 'El Email es invalido');
					$this->_view->renderizar('index','registro');
					exit;
				}
				if ($this->_registro->verficarEmail($this->getPostParm('email'))) { // si el email ya ha sido usado
					$this->_view->assign('_error', 'El email ' . $this->getPostParm('email') . ' ya existe');
					$this->_view->renderizar('index','registro');
					exit;
				}
				if (!$this->getSql('pass')) { //cualquier caracter pero no contener tags
					$this->_view->assign('_error', 'Debe introducir su password');
					$this->_view->renderizar('index','registro');
					exit;
				}
				if ($this->getPostParm('pass')!=$this->getPostParm('pass2')) {//las contraseñas deben ser iguales
					$this->_view->assign('_error', 'Los passwords no coinciden');
					$this->_view->renderizar('index','registro');
					exit;
				}
				$this->getLibrary('class.phpmailer');
				$mail = new PHPMailer();

				$this->_registro->registrarUsuario(  // almacenar el usuario
					$this->getSql('nombre'), 
					$this->getAlphaNum('usuario'), 
					$this->getSql('pass'), 
					$this->getPostParm('email'));

				$usuario = $this->_registro->verficarUsuario($this->getAlphaNum('usuario')); //ver si el usuario no se pudo registrar
				if (!$usuario) { 
					$this->_view->assign('_error', 'Error al registrar al usuario');
					$this->_view->renderizar('index','registro');
					exit;
				}

				$mail->From = "www.mvc.naan.com/";
				$mail->FromName = "Primer Framework";
				$mail->Subject = "Activacion de cuenta de usuario";
				$mail->Body = 'Hola <strong>' . $this->getSql('nombre') . '</strong>' .
								'<p> Se ha registrado en esta cosa, para activar ' .
								'su cuenta haga click en el sigueinte enlace:<br>'.
								'<a href "' . BASE_URL . 'registro/activar/'.
								$usuario['id'] . '/' . $usuario['codigo'] . '">' .
								BASE_URL . 'registro/activar/'. // aqui llama el metodo activar
								$usuario['id'] . '/' . $usuario['codigo'] . '</a></p>';
				$mail->AltBody = 'Su servidor de correo no soporta html';
				$mail->AddAddress($this->getPostParm('email'));
				$mail->Send();
				$this->_view->assign('datos', false);
				$this->_view->assign('_mensaje', 'El registro no esta completo, revise su email para  activar su cuenta');
				
			}
			$this->_view->renderizar('index','registro');
		}
		public function activar($id,$codigo)
		{
			if (!$this->filtraInt($id) || !$this->filtraInt($codigo) ) {
				$this->_view->assign('_error', 'Esta cuenta no existe');
				$this->_view->renderizar('activar','registro');
				exit;
			}
			$row = $this->_registro->getUsuario(
				$this->filtraInt($id),
				$this->filtraInt($codigo)
				);
			if (!$row) {
				$this->_view->assign('_error', 'Esta cuenta no existe');
				$this->_view->renderizar('activar','registro');
				exit;
			}
			if (!$row['estado']==1) {
				$this->_view->assign('_error', 'Esta cuenta ya ha sido activada');
				$this->_view->renderizar('activar','registro');
				exit;
			}
			$this->_registro->activarUsuario(
				$this->filtraInt($id),
				$this->filtraInt($codigo)
				);
			$row = $this->_registro->getUsuario(
				$this->filtraInt($id),
				$this->filtraInt($codigo)
				);
			if (!$row['estado']==0) {
				$this->_view->assign('_error', 'Error al activar la cuenta, por favor intente mas tarde');
				$this->_view->renderizar('activar','registro');
				exit;
			}
			$this->_view->_mensaje = 'Su cuenta ha sido activada';
			$this->_view->renderizar('activar','registro');
		}
	}