<?php

class recuperarController extends Controller
{

	private $_modelo;
	public function __construct()
	{
		parent::__construct();

		if (Session::get('autenticado')) {
			$this->redireccionar("operaciones");
		}

		$this->_modelo = $this->loadModel("recuperar");
		$this->getLibrary('validFluent');
		$this->_view->setTemplate("accesos");

	}

	public function index(){
		$this->_view->assign("titulo","Recuperar acceso");
		$this->getLibrary("PHPMailer/PHPMailerAutoload");

		if($this->getInt("recuperar")==1){

			$this->validador = new ValidFluent($_POST);
			$this->validador->name('email')->required("No se puede enviar si está vacío")->email("Ingrese por favor un email válido (nombre@ejemplo.com)");

			if(!$this->validador->isGroupValid()){
				$errores = $this->validador->getError("email");
				$this->_view->assign("_errores",$errores);
				//$errores = array_filter($errores); // Si los errores son más de uno
			}else{


				$emailRecuperar = $this->getSql("email");

				$emailBD = $this->_modelo->getEmailsUsuarios($emailRecuperar);


				if(!$emailBD){
					$errores = "Este email no está registrado";
					$this->_view->assign("_errores",$errores);
				}else{

					$mail = new PHPMailer();
					$random = sha1(md5(rand(10,99999999)));
					$this->_modelo->actualizarCodigo($emailRecuperar,$random);

					$mail->From = "no-reply@sinergiafc.com";
					$mail->FromName = "SISFC";
					$mail->Subject = "Reestrablece la contraseña del SISFC";
					$mail->Body = "
						<p style='padding: 10px;'>
							Hola:
						</p>
						<p style='padding: 10px;'>
							Recientemente, alguien solicitó cambiar la contraseña de tu cuenta del SISFC.
							Si fuiste tú, <a href='".BASE_URL."recuperar/cambiar/".$random."'>haz clic aquí</a> para definir una nueva contraseña:
						</p>
						<p>
							<center>
							<a style='background:#0066cc;padding: 10px;border-radius: 3px;color: #fff; font-weight: bold;font-size: 15px;text-decoration: none;' <a href='".BASE_URL."recuperar/cambiar/".$random."'>Restaurar contraseña</a>
							</center>
						</p>

						<p style='padding: 10px;'>
							Si no deseas modificar tu contraseña o no solicitaste hacerlo,
							ignora y elimina este mensaje.
						</p>

						<p style='padding: 10px;'>
							Para preservar la seguridad de tu cuenta,
							no reenvíes este mensaje a nadie.
							Consulta nuestro Centro de ayuda para obtener más sugerencias de seguridad.
						</p>
						<p style='padding: 10px;'>
							Gracias. <br />
							El equipo de TI de Sinergia FC
						</p>

					";

					$mail->AltBody = "Su servidor de correo no soporta html";
					$mail->AddAddress($emailRecuperar);
					$mail->CharSet = 'UTF-8';
					$mail->send();



					$this->_view->assign("_mensajes","Correo enviado. Revisa tu bandeja de entrada");
				}



			}
		}


		$this->_view->renderizar("index","recuperar");
	}

	public function cambiar($codigo)
	{

		$datos = $this->_modelo->getDatosPerfil($codigo);

		if(!$datos){
			echo "No existe";
			$this->redireccionar("recuperar");
			exit();
		}

		$this->_view->assign("titulo","Cambiar de contraseña");



		if($this->getInt("cambiar")==1){

			$this->validador = new ValidFluent($_POST);
			$this->validador->name('pass')->required("La contraseña no puede quedar vacía")->minSize(4);
			$this->validador->name('pass_r')->required("Vuelve a escribir la nueva contraseña")->minSize(4);

			if(!$this->validador->isGroupValid()){

				$errores[] = $this->validador->getError('pass');
				$errores[] = $this->validador->getError('pass_r');

				$errores = array_filter($errores);

				$this->_view->assign("_errores",$errores);

			}else{

				$pass = $this->getSql("pass");
				$pass_r = $this->getSql("pass_r");

				if($pass===$pass_r){


					$pass = sha1(md5($pass));

					$cambio = $this->_modelo->actualizarPass($codigo,$pass);
					$this->_modelo->borrarCodigo($codigo);

					$this->redireccionar("login");


				}else{
					$errores = "Las contraseñas no son iguales. Intenta de nuevo.";
					$this->_view->assign("_errores",$errores);
				}

			}


		}

		$this->_view->assign("email",$datos["email"]);
		$this->_view->renderizar("cambiar","recuperar");
	}

}


?>
