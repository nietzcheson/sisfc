<?php
	class postController extends Controller
	{
		private $_post;
		public $__valor;
		public function __construct()
		{
			parent::__construct();
			$this->_post = $this->loadModel('post'); // carga el postModel, usando la funcion de controller
		}

		public function index($pagina = false)
		{
			/*for ($i=0; $i < 300; $i++) { 
				$model = $this->loadModel('post');
				$model->insertarPost('titulo' . $i, 'cuerpo' . $i);
			}*/
			if (!$this->filtrarInt($pagina)) {
				$pagina = false; //VT12 si es falso entoces muestra la primera pagina
			}
			else
			{
				$pagina = (int) $pagina; //VT12 realiza un parse para la pagina cliceada
			}
			$this->getLibrary('paginador');
			$paginador = new Paginador();

			$this->_view->assign('posts',$paginador->paginar($this->_post->getPosts(), $pagina));
			$this->_view->assign('paginacion',$paginador->getView('prueba','post/index'));
			$this->_view->assign('titulo','Post');

			
			$this->_view->assign('elvalor',$this->__valor);

			//VT13 alterado en adlante
			//$this->_view->posts = $paginador->paginar($this->_post->getPosts(), $pagina); //le pasa los valores obtenidos, VT12 agregar el metodo paginar de la classe paginador
			//$this->_view->paginacion = $paginador->getView('prueba','post/index'); //VT12 
			//$this->_view->titulo = 'Post'; //esto es una forma de pasar parametros, aqui esta el objeto view creado en la super clase controller
			$this->_view->renderizar('index','post'); // se llama el metodo de renderizado de views, cuya variable posts luego mediante view es usada
			
		}
		public function nuevo() //valida y guarda los datos del formulario en nuevo post
		{

			//Session::accesoEstricto(array('usuario'),true); //VT14 quitar para trabajar mas rapido
			$this->_view->assign('titulo','Nuevo Post');
			$this->_view->setJs(array('nuevo'));//carga los archivos js para el controlador dado
			if ($this->getInt('guardar')=="1") //Sbe si el es el formulario en cuestion fue activado**
			{
				$this->_view->assign('datos',$_POST); //guarda los valores del formulario para luego reescribirlos y evitar perdida de datos en el caso que la validacion sea incorrecta
				if (!$this->getTexto('titulo')) { //si hay texto en el input titulo
					$this->_view->_error = "Debe introducir el titulo del post";
					$this->_view->renderizar('nuevo','post');
					exit;
				}

				if (!$this->getTexto('cuerpo')) {
					$this->_view->_error = "Debe introducir el cuerpo del post";
					$this->_view->renderizar('nuevo','post');
					exit;
				}

				$imagen = '';

				if (isset($_FILES['imagen']['name'])) {
					$this->getLibrary('upload'. DS . 'class.upload');
					$ruta = ROOT . 'public' . DS . 'img' . DS . 'post' . DS;
					$upload = new upload($_FILES['imagen']);
					$upload->allowed = array('image/*');
					$upload->file_new_name_body = 'upl_' . uniqid();
					$upload->process($ruta);

					if ($upload->processed) {
						$imagen = $upload->file_dst_name;
						$thumb = new upload($upload->file_dst_pathname);
						$thumb->image_resize = true;
						$thumb->image_x = 100;
						$thumb->image_y = 70;
						$thumb->file_name_body_pre = 'thumb_';
						$thumb->process($ruta . 'thumb' . DS);
					}
					else
					{
						$this->_view->assign('_error',$upload->error);
						$this->_view->renderizar('nuevo','post');
						exit;
					}
				}

				$this->_post->insertarPost( // si se logro validar la informacion entonces se almacenan
					$this->getPostParm('titulo'),
					$this->getPostParm('cuerpo'),
					$imagen
				);
				$this->redireccionar('post');
			}
			
			$this->_view->renderizar('nuevo','post');
		}

		public function editar($id)//permite mediante el ID editar el post
		{
			if (!$this->filtrarInt($id)) {
				$this->redireccionar('post');
			}
			if (!$this->_post->getPost($this->filtrarInt($id))) {
				$this->redireccionar('post');
			}
			$this->_view->titulo = 'Editar Post';
			$this->_view->setJs(array('nuevo'));

			if ($this->getInt('guardar')=="1") //Sbe si el es el formulario en cuestion fue activado**
			{
				$this->_view->datos = $_POST; //guarda los valores del formulario para luego reescribirlos y evitar perdida de datos en el caso que la validacion sea incorrecta
				if (!$this->getTexto('titulo')) { //si hay texto en el input titulo
					$this->_view->_error = "Debe introducir el titulo del post";
					$this->_view->renderizar('editar','post');
					exit;
				}

				if (!$this->getTexto('cuerpo')) {
					$this->_view->_error = "Debe introducir el cuerpo del post";
					$this->_view->renderizar('editar','post');
					exit;
				}
				$this->_post->editarPost( // si se logro validar la informacion se envia al modelo con los siguientes parametros para editar
					$this->filtrarInt($id),
					$this->getTexto('titulo'),
					$this->getTexto('cuerpo')
				);
				$this->redireccionar('post');
			}
			$this->_view->datos = $this->_post->getPost($this->filtrarInt($id));
			$this->_view->renderizar('editar','post');
		}

		public function eliminar($id)
		{
			if (!$this->filtrarInt($id)) { // verifica si es un entero
				$this->redireccionar('post');
			}
			if (!$this->_post->getPost($this->filtrarInt($id))) { // verifica si existe el registro
				$this->redireccionar('post');
			}
			$this->_view->titulo = 'Eliminar Post';
			$this->_view->setJs(array('nuevo'));

			
			$this->_post->eliminarPost($this->filtrarInt($id)); // si se logro validar la informacion se envia al modelo el id para eliminar
			$this->redireccionar('post');
			
		}
	}
	