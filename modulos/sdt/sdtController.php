<?php 
	class sdtController extends Controller{
		private $_sdt;
		private $_time;
		private $_dateUtils;
		public function __construct(){
			parent::__construct();
			$this->_sdt = $this->loadModel('sdt');
			$this->getLibrary('dateUtils');
			$this->_dateUtils = new dateUtils();
			$this->_time=-60*60*0;
		}
		public function index(){
			$this->_view->assign('titulo','SDT');
			$this->_view->renderizar('index');
		}
		public function rm($dia=false,$mes=false,$anio=false,$dife=""){
			$this->_acl->acceso('todo');
			$fechahoy = date('d/m/Y', mktime()+$this->_time);

			$fecha = $dia . "/" . $mes . "/" . $anio;
			if (!$dia || !$mes || !$anio) {
				$fecha = $fechahoy;
			}
			if (count($this->_dateUtils->formatearFecha($fecha))==0) {
				$this->_view->renderizar('index');
				exit();
			}

			$oper=0;
			if ($dife=="add") {
				$oper=1.1;
			}else if ($dife=="rest") {
				$oper=-1;
			}

			$datos = $this->_sdt->getSDTFormat_Etiquetas(Session::get('id_usuario'));
			if (count($datos)>0 && isset($datos)) {

			}else {
				$datos = $this->defaultEtiquetas();
			}

			$fecha=$this->_dateUtils->operarAFecha($fecha,$oper);
			$this->_view->setJs(array('buscarRM','registroMaestro','colpick','holdS','jquery.bpopup.min'));
			$this->_view->setCss(array('colpick','stylePopups','style.min'));
			$this->_view->assign('titulo','Registro Maestro');
			$id_u=$this->_sdt->getUsuarioSisfcId(Session::get('id_usuario'));
			$this->_view->assign('user',$id_u["nickname_usuario"]);
			$this->_view->assign('fecha',$fecha);
			
			$this->_view->assign('datos',$this->_sdt->getSDT_RM_Lines(Session::get('id_usuario'),$fecha));
			$etiquetas = $this->_sdt->getSDTFormat_Etiquetas(Session::get('id_usuario'));
			$this->_view->assign('etiquetas',$etiquetas);
			$this->_view->renderizar('sdt_rm');
		}
		public function check_list($dia=false,$mes=false,$anio=false,$dife="",$rango="mes",$id_usuario=false){
			$this->_acl->acceso('todo');
			$fechahoy = date('d/m/Y', mktime()+$this->_time);
			$fecha = $dia . "/" . $mes . "/" . $anio;
			if (!$dia || !$mes || !$anio) {
				$fecha = $fechahoy;
			}

			# Se podra recivir un usuario diferente a quien se logeo para ver su checklist
			# Pero no modificar nada.
			$real_user=Session::get('id_usuario');
			$do_changes=true;
			if ($id_usuario) {
				if ($real_user!=$id_usuario) {
					$do_changes=false;
				}
			}else{
				$id_usuario=$real_user;
			}
			$this->_view->assign('id_usuario',$id_usuario);
			$this->_view->assign('real_user',$real_user);
			
			$ruta="";
			$ulr_other="";
			if ($dia) {
				$ruta.="/".$dia;
				if ($mes) {
					$ruta.="/".$mes;
					if ($anio) {
						$ruta.="/".$anio;
						if ($dife!="") {
							$ruta.="/".$dife."/".$rango;
							$ulr_other="/".$id_usuario;
						}
					}
				}
			}
			$this->_view->assign('refrescar',$ruta);
			$this->_view->assign('ulr_other',$ulr_other);

			$dia=date("d");
			$mes=date("m");
			$anio=date("Y");
			
			$oper=0;
			if ($dife=="add") {
				$oper=0;
			}else if ($dife=="rest") {
				$oper=-1.1;
			}
			
			$fecha=$this->_dateUtils->operarAFecha($fecha,$oper);
			$fecha=$this->_dateUtils->formatearFecha($fecha);
			$this->_view->assign('titulo','CheckList');
			$this->_view->setJs(array('jCProgress-1.0.3','redips-drag-min','redips-table-min','checklist','jquery.bpopup.min','filtrarCheckList','crearRepetir'));
			$this->_view->setCss(array('jCProgress','checklist','style.min','stylePopups'));
			$dates=$this->encontrarRango($rango, $fecha["dia"], $fecha["mes"], $fecha["anio"]);

			$this->_view->assign('dates',$dates);
			$this->_view->assign('utime',"dia");
			$this->_view->assign('vtime',$rango);
			$this->_view->assign('ndays',$this->_dateUtils->restarFechas($dates['inicio'],$dates['fin']));

			$tiempo = $this->_dateUtils->formatearFecha($dates['inicio']);
			$this->_view->assign('anio1',$tiempo['anio']);
			$this->_view->assign('mes1',$tiempo['mes']-1);
			$this->_view->assign('dia1',$tiempo['dia']);
			$ntoday=$this->_dateUtils->restarFechas($dates['inicio'],$fechahoy);
			$this->_view->assign('ntoday',$ntoday);
			$this->_view->assign('nrows',"0");
			$this->_view->assign('unidadTiempo',"dia");
			if ($this->getInt('nuevatarea')=="1") {
				if ($do_changes) {
					$tarea=$this->getSql("nombre_tarea");
					$descripcion=$this->getTexto("descripcion");
					$repetir=$this->getInt('repetir');
					$fechainicial=$this->getSql('fechainicial');
					$fechafinal=$this->getSql('fechafinal');
					$dias=$this->getSql("dias");
					$errores="";
					if ($tarea=="") {
						$errores="Ingrese el nombre de la tarea";
					}
					if ($dias=="") {
						if ($repetir==1 || $repetir==2) {
							if ($errores!="") {
								$errores .="<br>";
							}
							$errores="Seleccione al menos un dia de la semana";
						}
					}
					if ($fechainicial=="") {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Ingrese la fecha inicial";
					}
					if ($errores!="") {
						$this->_view->assign("_error",$errores);
					}else{
						$datosEnviar = array(
							"id_director"=>0,
							"tarea"=>$tarea,
							"tipo"=>"periodico",
							"estado_tarea"=>1,
							"tarea_ultimo"=>$real_user,
							"tarea_personal"=>$real_user
						);
						$this->_sdt->crearSDT_CL_NewTask($datosEnviar);
						$ultimo = $this->_sdt->ultimoSDT_Task($real_user);
						
						$datosEnviar = array(
							"id_tarea"=>$ultimo["id_tarea"],
							"id_usuario"=>$id_usuario
						);
						$this->_sdt->crearSDT_Tarea_Usuario($datosEnviar);

						$datosEnviar = array(
							"id_tarea"=>$ultimo["id_tarea"],
							"descripcion"=>$descripcion
						);
						$this->_sdt->crearSDT_CL_NewTaskDescription($datosEnviar);

						$posi=array(
							"0"=>7,
							"1"=>1,
							"2"=>2,
							"3"=>3,
							"4"=>4,
							"5"=>5,
							"6"=>6,
						);

						$resl="";
						$fecha1 = explode("/", $fechainicial);
						$ndia = date('w', mktime(0, 0, 0, $fecha1[1], $fecha1[0], $fecha1[2]));
						if ($repetir=="1") {
							if ($dias!="") {
								// Para cada dia de la semana se generara una fecha igual o superor a la fecha de inicio, luego con una periodicidad de 7 dias
								$dia = explode(",", $dias);
								for ($i=0; $i < count($dia); $i++) {
									if (trim($dia[$i])!="") {
										if ($posi[$dia[$i]]>=$posi[$ndia]) {
											// Encontramos que el dia de es superior al dia del inicio de la fecha de inicio 
											$nuevaFeche = $this->_dateUtils->operarAFecha($fechainicial,$posi[$dia[$i]]-$posi[$ndia]);
										}else{
											// Encontramos que el dia de es inferior al dia del inicio de la fecha de inicio 
											$nuevaFeche = $this->_dateUtils->operarAFecha($fechainicial,7-($posi[$ndia]-$posi[$dia[$i]]));
										}
										// se almacena la fecha a una periocidad de 7 dias 
										$datosEnviar2 = array(
											"id_tarea"=>$ultimo["id_tarea"],
											"fecha_ini"=>$nuevaFeche,
											"fecha_fin"=>"".$fechafinal."",
											"repetir"=>7
										);
										$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
									}
								}
							}
						}
						if ($repetir=="2") {
							//La tarea se repite apartir del inicio del mes
							if ($dias!="") {
								//en el caso que se halla elegido algun dia, sera, por ejemplo el primero lunes o domingo del mes.
								$dia = explode(",", $dias);
								for ($i=0; $i < count($dia); $i++) {
									if (trim($dia[$i])!="") {
										$datosEnviar2 = array(
											"id_tarea"=>$ultimo["id_tarea"],
											"fecha_ini"=>$fechainicial,
											"fecha_fin"=>"".$fechafinal."",
											"repetir"=>$dia[$i],
											"opcion"=>"primes"
										);
										$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
									}
								}
							}
						}
						if ($repetir=="3") {
							$inicio1=$this->getSql("inicio1");
							if (trim($inicio1)=="" || trim($inicio1)=="0") {
								$inicio1=1;
							}
							$datosEnviar2 = array(
								"id_tarea"=>$ultimo["id_tarea"],
								"fecha_ini"=>$fechainicial,
								"fecha_fin"=>"".$fechafinal."",
								"repetir"=>$inicio1,
								"opcion"=>"inimes"
							);
							$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
						}
						if ($repetir=="4") {
							$inicio1=$this->getSql("inicio2");
							if (trim($inicio1)=="" || trim($inicio1)=="0") {
								$inicio1=1;
							}
							$datosEnviar2 = array(
								"id_tarea"=>$ultimo["id_tarea"],
								"fecha_ini"=>$fechainicial,
								"fecha_fin"=>"".$fechafinal."",
								"repetir"=>$inicio1,
								"opcion"=>"finmes"
							);
							$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
						}
					}
				}
			}
			if ($this->getInt('formc2')=="1") {
				$id_tarea= $this->getSql("taread");
				$tarrrr = $this->_sdt->getTarea($id_tarea);
				if (is_array($tarrrr)) {
					if ($tarrrr["id_responsable"]==$id_usuario) {
						$respuesta= $this->getSql("respues");
						$comentario= $this->getSql("comentario");
						if ($respuesta=="0") {
							if (trim($comentario)!="") {
								$datosEnviar = array(
									"id_tarea"=>$id_tarea,
									"estado_tarea"=>2,
								);
								$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);

								$datosEnviar = array(
									"id_tarea"=>$id_tarea,
									"comentario"=>$comentario,
								);
								$datco = $this->_sdt->getSDT_Tarea_Comentario($id_tarea);
								if (is_array($datco)) {
									$this->_sdt->actualizarSDT_Tarea_Comentario($datosEnviar);
								}else{
									$this->_sdt->crearSDT_Tarea_Comentario($datosEnviar);
								}
							}
						}
						if ($respuesta=="1") {
							$datosEnviar = array(
								"id_tarea"=>$id_tarea,
								"estado_tarea"=>1,
							);
							$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);
						}
					}
				}
			}
			
			# Para poder ver las tareas de otros usurios en el mismo proyecto
			# Sacar los proyectos en los cuales esta involucrado el usuario
			// $datos = $this->_sdt->getSDT_CL_Tasks($id_usuario);
			// $datos2 = $this->_sdt->getSDT_CL_TasksDias($id_usuario);

			$MainData = $this->SDT_CheckList_MainData($id_usuario);
			$datos = $MainData[0];
			$datos2 = $MainData[1];
			$consulta_tareas = $MainData[2];
			
			$this->_view->assign('nrows',count($datos));

			for ($i=0; $i < count($datos) ; $i++) {
				$usuario = $this->_sdt->getUsuario($datos[$i]["id_responsable"]);
				$datos[$i]["nickname_responsable"]=$usuario["nickname_usuario"];
				if ($id_usuario!=$datos[$i]["id_responsable"] && $id_usuario!=$datos[$i]["id_director"]) {
					$datos[$i]["estado_tarea"]=3;
				}
			}

			$this->_view->assign('datos',$datos);
			$this->_view->assign('datos2',$this->diasCiclos($ntoday, $dates['inicio'],$dates['fin'],$datos2,$consulta_tareas));
			
			$this->_view->assign('hoy',$fechahoy);
			$this->_view->assign('nameday',date('w', mktime(0, 0, 0, $tiempo['mes'], $tiempo['dia'], $tiempo['anio'])));

			$this->_view->assign('ico_null',"minus");
			$this->_view->assign('ico_check',"ok");
			$this->_view->assign('ico_later',"arrow-right");
			$this->_view->assign('ico_remove',"remove");


			$estados["0"] = array(
				"clase"=>"primary",
				"palabra"=>"Aceptar o Rechazar"
				);
			$estados["1"] = array(
				"clase"=>"success",
				"palabra"=>"Activa"
				);
			$estados["2"] = array(
				"clase"=>"danger",
				"palabra"=>"Rechazada"
				);
			$estados["3"] = array(
				"clase"=>"warning",
				"palabra"=>"Observador"
				);
			$this->_view->assign('estados',$estados);

			$etiquetas = $this->_sdt->getSDTFormat_Etiquetas($id_usuario);
			$etiquetas[]=array(
				"id_etiqueta" => "0",
				"ffamily" => "Klavika",
				"fsize" => "14",
				"fcolor" => "#000000",
				"fcback" => "transparent"
			);
			$this->_view->assign('etiquetas',$etiquetas);

			# Por ahora se mostraran todos los usuarios del sistema
			# Despues de programar que usarios son asignados a la responsabilidad de otro
			# hay se mostraran los usuarios desigandos al usuario.
			$this->_view->assign('usuariosSistema',$this->_sdt->getUsuarios());
			$this->_view->renderizar('check_list');
		}

		private function diasCiclos($ntoday, $fecha_ini,$fecha_fin,$dias_fijos,$cade_tarea){
			//Dias que no deben ser incluidos
			$nodays=array();
			for ($i=0; $i <  count($dias_fijos) ; $i++) {
				if (trim($dias_fijos[$i]["fecha"])!="") {
					$dias_fijos[$i]["numero"] = $this->_dateUtils->restarFechas($fecha_ini, $dias_fijos[$i]["fecha"]);
					$light="";
					if ($dias_fijos[$i]["numero"]<$ntoday) {
						$light="light";
					}
					if ($dias_fijos[$i]["estado"]=="0") {
						$dias_fijos[$i]["color"]="vacio".$light;
					}elseif ($dias_fijos[$i]["estado"]=="1") {
						$dias_fijos[$i]["color"]="chuleado".$light;
					}elseif ($dias_fijos[$i]["estado"]=="2") {
						$dias_fijos[$i]["color"]="transferido".$light;
					}elseif ($dias_fijos[$i]["estado"]=="3") {
						$dias_fijos[$i]["color"]="nohizo".$light;
					}
					$nodays[$dias_fijos[$i]["id_tarea"].$dias_fijos[$i]["fecha"]]=true;
				}
			}


			// Calculo de Unidad de tiempo repetitivas
			$repetir = $this->_sdt->getSDT_CL_Tareas_Repetitivas($cade_tarea);
			if (is_array($repetir)) {
				// Calcular los dias que hay que avanzar para estar en el rango de tiempo
				$idnum=0;
				for ($i=0; $i < count($repetir) ; $i++) { 
					// Numero de veces que se repiten el ciclo para llegar al la fecha inicial del rango de tiempo
					$numciclos = $this->_dateUtils->restarFechas($fecha_ini, $repetir[$i]["fecha_ini"]);
					// Si la resta es positiva, entonces la fecha es supero al limite inferior
					//if ($numciclos<=0) {
					if ($numciclos<=0) {
						if ($repetir[$i]["repetir"]!="0") {
							$numciclos=-1*$numciclos;
							$numciclos = ceil($numciclos/$repetir[$i]["repetir"]);
							$sun=1;
						}else {
							//$numciclos=$numciclos;
						}
					}else{
						$numciclos = 0;
						$sun=1;
					}
					// Ahora generar los objetos apartir de esta fecha inicial hasta que termine o bien el rango de tiempo de vision o la fecha final
					$estar=true;
					
					// Tareas que iniciar el mes o algun dia de la semana seÒalado
					if ($repetir[$i]["opcion"]=="primes") {
						$fecha = $repetir[$i]["fecha_ini"];
						while ($estar) {
							$num=0;
							if ($repetir[$i]["fecha_fin"]!="") {
								$num = $this->_dateUtils->restarFechas($fecha, $repetir[$i]["fecha_fin"]);
							}
							$num2 = $this->_dateUtils->restarFechas($fecha, $fecha_fin);
							if ($num<0 || $num2<0)	 {
								$estar=false;
							}else{
								$idnum+=1;
								if (!array_key_exists($repetir[$i]["id_tarea"].$fecha, $nodays)) {
									$numero=$this->_dateUtils->restarFechas($fecha_ini, $fecha);
									$light="";
									if ($numero<$ntoday) {
										$light="light";
									}
									// En el caso que sea mas de una semana
									// otra nueva fecha agregandole el numero de dias para llegar a la nueva semana
									$fechaDummy=$fecha;
									if ($repetir[$i]["t_repetir"]==1) {
										$fechaDummy = $this->_dateUtils->operarAFecha($fecha,7*($repetir[$i]["n_repetir"]-1));
									}
									$dias_fijos[] = array(
										"id_dia"=>$idnum."r".$repetir[$i]["id_tarea"],
										"id_tarea"=>$repetir[$i]["id_tarea"],
										"fecha"=>$fechaDummy,
										"estado"=>0,
										"numero"=> $numero,
										"mover"=>"nodrag",
										"color"=>"vacio".$light,
										"fecha_anterior"=>"",
										"fecha_posterior"=>"",
										"id_dia_anterior"=> "0",
										"id_dia_posterior"=> "0",
										"tarea"=>$repetir[$i]["tarea"]

									);
									$nodays[$repetir[$i]["id_tarea"].$fecha]=true;
								}
							}
							$fecha =$this->incrementarMes($fecha);
							$fecha =$this->primerDiaMes($fecha);
							if ($repetir[$i]["repetir"]!="7") {
								$fecha = $this->primerDia($fecha,$repetir[$i]["repetir"]);
								if ($repetir[$i]["t_repetir"]==1) {
									$fecha = $this->_dateUtils->operarAFecha($fecha,7*($repetir[$i]["n_repetir"]-1));
								}
							}
						}

					}else if ($repetir[$i]["opcion"]=="inimes") {
						$fecha = $this->primerDiaMes($repetir[$i]["fecha_ini"]);
						$dife = $this->_dateUtils->restarFechas($fecha,$repetir[$i]["fecha_ini"]);
						if ($dife>0) {
							$fecha =$this->incrementarMes($repetir[$i]["fecha_ini"]);
						}
						while ($estar) {
							$fecha = $this->_dateUtils->operarAFecha($fecha,($repetir[$i]["repetir"]-1));
							$num=0;
							if ($repetir[$i]["fecha_fin"]!="") {
								$num = $this->_dateUtils->restarFechas($fecha, ($repetir[$i]["fecha_fin"]-1));
							}
							$num2 = $this->_dateUtils->restarFechas($fecha, $fecha_fin);
							if ($num<0 || $num2<0)	 {
								$estar=false;
							}else{
								$idnum+=1;
								if (!array_key_exists($repetir[$i]["id_tarea"].$fecha, $nodays)) {
									$numero=$this->_dateUtils->restarFechas($fecha_ini, $fecha);
									$light="";
									if ($numero<$ntoday) {
										$light="light";
									}
									$dias_fijos[] = array(
										"id_dia"=>$idnum."r".$repetir[$i]["id_tarea"],
										"id_tarea"=>$repetir[$i]["id_tarea"],
										"fecha"=>$fecha,
										"estado"=>0,
										"numero"=> $numero,
										"mover"=>"nodrag",
										"color"=>"vacio".$light,
										"fecha_anterior"=>"",
										"fecha_posterior"=>"",
										"id_dia_anterior"=> "0",
										"id_dia_posterior"=> "0",
										"tarea"=>$repetir[$i]["tarea"]
									);
									$nodays[$repetir[$i]["id_tarea"].$fecha]=true;
								}
							}
							$fecha =$this->incrementarMes($fecha);
						}
					}else if ($repetir[$i]["opcion"]=="finmes") {
						$dife = $this->_dateUtils->restarFechas($repetir[$i]["fecha_ini"],$fecha_ini);

						$fechaFormat = $this->_dateUtils->formatearFecha($fecha_ini);
						if ($dife<0) {
							// debo incrementar en un mes la fecha inicial
							$dife = $this->_dateUtils->restarFechas($repetir[$i]["fecha_ini"],$fecha_fin);

							if ($dife<0) {
								$estar=false;
							}else{
								$fecha = $this->incrementarMes($repetir[$i]["fecha_ini"]);
							}
						}else{
							$fecha=$this->primerDiaMes($fecha_ini);
						}
						while ($estar) {
							$fecha2 = $this->_dateUtils->operarAFecha($fecha,-($repetir[$i]["repetir"]));

							$num=0;
							if ($repetir[$i]["fecha_fin"]!="") {
								$num = $this->_dateUtils->restarFechas($fecha2, $repetir[$i]["fecha_fin"]);
							}
							$num2 = $this->_dateUtils->restarFechas($fecha2, $fecha_fin);
							if ($num<0 || $num2<0)	 {
								$estar=false;
							}else{
								$idnum+=1;
								if (!array_key_exists($repetir[$i]["id_tarea"].$fecha2, $nodays)) {
									$numero=$this->_dateUtils->restarFechas($fecha_ini, $fecha2);
									$light="";
									if ($numero<$ntoday) {
										$light="light";
									}
									$dias_fijos[] = array(
										"id_dia"=>$idnum."r".$repetir[$i]["id_tarea"],
										"id_tarea"=>$repetir[$i]["id_tarea"],
										"fecha"=>$fecha2,
										"estado"=>0,
										"numero"=> $numero,
										"mover"=>"nodrag",
										"color"=>"vacio".$light,
										"fecha_anterior"=>"",
										"fecha_posterior"=>"",
										"id_dia_anterior"=> "0",
										"id_dia_posterior"=> "0",
										"tarea"=>$repetir[$i]["tarea"]
									);
									$nodays[$repetir[$i]["id_tarea"].$fecha2]=true;
								}
							}
							$fecha =$this->incrementarMes($fecha);
						}
					}else{
						while ($estar) {
							// Obtengo la siguientes fechas
							$fecha = $this->_dateUtils->operarAFecha($repetir[$i]["fecha_ini"], $numciclos*$repetir[$i]["repetir"],"dias",5000);
							$num =0;
							if ($repetir[$i]["fecha_fin"]!="") {
								$num = $this->_dateUtils->restarFechas($fecha, $repetir[$i]["fecha_fin"]);
							}
							$num2 = $this->_dateUtils->restarFechas($fecha, $fecha_fin);
							if ($num<0 || $num2<0)	 {
								$estar=false;
							}else{
								//echo "<br> xx " . $fecha . " " . ($numciclos*$repetir[$i]["repetir"]+$sun);
								$idnum+=1;
								if (!array_key_exists($repetir[$i]["id_tarea"].$fecha, $nodays)) {
									$numero=$this->_dateUtils->restarFechas($fecha_ini, $fecha);
									$light="";
									if ($numero<$ntoday) {
										$light="light";
									}
									$dias_fijos[] = array(
										"id_dia"=>$idnum."r".$repetir[$i]["id_tarea"],
										"id_tarea"=>$repetir[$i]["id_tarea"],
										"fecha"=>$fecha,
										"estado"=>0,
										"numero"=> $numero,
										"mover"=>"nodrag",
										"color"=>"vacio".$light,
										"fecha_anterior"=>"",
										"fecha_posterior"=>"",
										"id_dia_anterior"=> "0",
										"id_dia_posterior"=> "0",
										"tarea"=>$repetir[$i]["tarea"]
									);
									//echo $fecha ."<br/>";
									$nodays[$repetir[$i]["id_tarea"].$fecha]=true;
								}
							}
							$numciclos+=1;
						};
					}
				}
			}
			return $dias_fijos;
		}

		private function primerDiaMes($fecha){
			$fechaFormat = $this->_dateUtils->formatearFecha($fecha);
			return "01/" . $fechaFormat["mes"] . "/" . $fechaFormat["anio"];
		}
		private function incrementarMes($fecha){
			$fechaFormat = $this->_dateUtils->formatearFecha($fecha);
			$fechaFormat["dia"]=1;
			$fechaFormat["mes"]+=1;
			if ($fechaFormat["mes"]>12) {
				$fechaFormat["mes"]=1;
				$fechaFormat["anio"]+=1;
			}
			return $fechaFormat["dia"] . "/" . $fechaFormat["mes"] . "/" . $fechaFormat["anio"];
		}
		private function primerDia($fecha,$ndiaValor){
			$fechaFormat = $this->_dateUtils->formatearFecha($fecha);
			$ndia = date('w',mktime(0, 0, 0, $fechaFormat['mes'], $fechaFormat['dia'], $fechaFormat['anio']));
			if ($ndiaValor>=$ndia) {
				//encontramos que el dia de es superior al dia del inicio de la fecha de inicio 
				$nuevaFeche = $this->_dateUtils->operarAFecha($fecha,$ndiaValor-$ndia);
			}else{
				//encontramos que el dia de es inferior al dia del inicio de la fecha de inicio 
				$nuevaFeche = $this->_dateUtils->operarAFecha($fecha,7-($ndia-$ndiaValor));
			}
			return $nuevaFeche;

		}
		public function etiquetas($reset=false){
			$this->_acl->acceso('todo');
			$this->_view->assign('titulo','Etiquetas');
			$this->_view->setJs(array('etiqueta','jquery-simplecolorpicker'));
			$this->_view->setCss(array('jquery-simplecolorpicker'));

			$id_us = Session::get('id_usuario');
			$datosEnviar = array();
			$datosEnviar[1] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Importante",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#ffe527"
				);
			$datosEnviar[2] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Operacion",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#dc6519"
				);
			$datosEnviar[3] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Administrativo",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#293cff"
				);
			$datosEnviar[4] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Actividades Extra",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#771edc"
				);
			$datosEnviar[5] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Personal",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#287d17"
				);
			$datosEnviar[6] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Proyectos de mejora",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#f0a7a5"
				);
			$datosEnviar[7] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Otros",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#7d7980"
				);
			if ($reset) {
				$datos = $this->_sdt->getSDTFormat_Etiquetas(Session::get('id_usuario'));
				if (count($datos)>0 && isset($datos)) {
					for ($i=1; $i <= count($datos); $i++) { 
						$actualizar["id_etiqueta"] = $datos[$i-1]["id_etiqueta"];
						$actualizar["nombre_etiqueta"] = $datosEnviar[$i]["nombre_etiqueta"];
						$actualizar["ffamily"] = $datosEnviar[$i]["ffamily"];
						$actualizar["fsize"] = $datosEnviar[$i]["fsize"];
						$actualizar["fcolor"] = $datosEnviar[$i]["fcolor"];
						$actualizar["fcback"] = $datosEnviar[$i]["fcback"];
						$this->_sdt->actualizarEtiqueta($actualizar);
					}
					//$this->_sdt->deleteSDTFormat_Etiquetas(Session::get('id_usuario'));
				}
			}
			$datos = $this->_sdt->getSDTFormat_Etiquetas(Session::get('id_usuario'));
			if (count($datos)>0 && isset($datos)) {

			}else{
				$datos = $this->defaultEtiquetas();
			}
			$this->_view->assign('datos',$datos);
			$this->_view->renderizar('etiquetas');
		}
		public function proyecto(){
			$this->_acl->acceso('todo');
			$btnHeader = array(
				array(
					"titulo" => "Crear proyecto",
					"enlace" => "sdt/crearProyecto"
				)
			);

			$this->_view->assign('titulo','Proyectos');
			$this->_view->setJs(array('eliminarDato'));
			$this->_view->assign("modelo","sdt");
			$this->_view->assign("accion","eliminarProyecto");

			$this->_view->assign("btnHeader",$btnHeader);
			$datos =  $this->_sdt->getProyectos();
			$this->_view->assign("datos",$datos);
			$this->_view->renderizar('indexProyectos');
		}
		public function crearProyecto(){
			$this->_acl->acceso('todo');
			$this->_view->assign('titulo','Crear Proyecto');
			$this->_view->setJs(array('crearProyecto'));
			$fechahoy = date('d/m/Y', mktime()+$this->_time);
			$id_usuario = Session::get('id_usuario');
			if ($this->getInt('crear')=="1")
			{
				// $director= $this->getSql("director");
				$this->_view->assign("posteo",$_POST);

				$nombre_proyecto= $this->getSql("nombre_proyecto");
				$siglas_proyecto= $this->getSql("siglas_proyecto");
				$seleccionados=$this->getSql("seleccionados");
				$errores="";
				if ($nombre_proyecto=="") {
					$errores="ingrese el nombre del proyecto";
				}
				if ($siglas_proyecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese las tres siglas del proyecto";
				}else if (strlen($siglas_proyecto)<2 || (strlen($siglas_proyecto)>4)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese una, dos o tres letras para conformar las siglas del proyecto";
				}else{
					$info= $this->_sdt->getProyectoSiglas($siglas_proyecto);
					if (is_array($info)) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Otro proyecto ya se encuentra identificado con esas siglas";
					}
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
				}else{
					$p_descripcion= $this->getTexto("p_descripcion");
					$datosEnviar = array(
						"id_director"=>$id_usuario,
						"proyecto"=>$nombre_proyecto,
						"siglas_proyecto"=>strtoupper($siglas_proyecto),
						"creado"=>Session::get('id_usuario'),
						"p_descripcion"=>$p_descripcion
					);
					$this->_sdt->crearSDT_newProyect($datosEnviar);
					$ultimo = $this->_sdt->ultimoSDT_newProyect($id_usuario);

					$porciones = explode(",", $seleccionados);
					for ($i=0; $i <count($porciones) ; $i++) { 
						$datosEnviar = array(
							"id_proyecto"=>$ultimo["id_proyecto"],
							"id_recurso"=>$porciones[$i]
						);
						$this->_sdt->crearSDT_Proyecto_Recurso($datosEnviar);
					}

					$this->redireccionar("sdt/verProyecto/".$ultimo["id_proyecto"]);
					exit();
				}
			}
			if ($this->getInt('clonar')=="1")
			{
				$this->_view->assign("pt",$_POST);
				$id_proyecto= $this->getSql("proyectos");
				$s_n_p= $this->getSql("s_n_p");
				$f_i= $this->getSql("f_i");

				$errores="";
				if ($id_proyecto=="" || $id_proyecto=="0") {
					$errores="Seleciones el proyecto";
				}
				if ($s_n_p=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese las tres siglas del proyecto";
				}else if (strlen($s_n_p)<1 || (strlen($s_n_p)>3)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese una, dos o tres letras para conformar las siglas del proyecto";
				}else{
					$info= $this->_sdt->getProyectoSiglas($s_n_p);
					if (is_array($info)) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Otro proyecto ya se encuentra identificado con esas siglas";
					}
				}
				if ($f_i=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la fecha de inicio del proyecto";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
				}else{
					# Se crea un registro del nuevo proyecto
					$proyecto = $this->_sdt->getProyect($id_proyecto);
					$id_usuario = Session::get('id_usuario');
					$p_descripcion= $this->getTexto("p_descripcion");
					$datosEnviar = array(
						"id_director"=>$id_usuario,
						"proyecto"=>$proyecto["proyecto"],
						"siglas_proyecto"=>$s_n_p,
						"creado"=>$id_usuario,
						"p_descripcion"=>$proyecto["p_descripcion"]
					);
					$this->_sdt->crearSDT_newProyect($datosEnviar);
					$ultimo = $this->_sdt->ultimoSDT_newProyect($id_usuario);

					# No se asignan recursos a este nuevo proyecto
					# Solo el director como recurso

					# Encontrar la fecha de inicio del proyecto
					$tareas = $this->_sdt->getTareasProyecto($id_proyecto);
					$fecha_inicial="";
					$nume_ini=0;
					foreach ($tareas as $tarea) {
						if ($tarea["fecha_ini_tarea"]!="") {
							$fecha = explode("/", $tarea["fecha_ini_tarea"]);
							$nume = mktime(0, 0, 0, $fecha[1], $fecha[0], $fecha[2]);
							if ($fecha_inicial=="") {
								$fecha_inicial=$tarea["fecha_ini_tarea"];
								$nume_ini=$nume;
							}else if ($nume_ini>$nume) {
								$fecha_inicial=$tarea["fecha_ini_tarea"];
								$nume_ini=$nume;
							}
						}
					}
					# Encontrar la diferencia entre el numero de dias de la fecha inicial y la fecha minima de la tarea
					# Dias que avanzaran cada unidad de tiempo
					$dias_avan=0;
					if ($fecha_inicial!="") {
						$dias_avan = $this->_dateUtils->restarFechas($fecha_inicial, $f_i);
					}
					foreach ($tareas as $tarea) {
						$datosEnviar = array(
							"id_director"=>$id_usuario,
							"id_responsable"=>$id_usuario,
							"tarea"=>$tarea["tarea"],
							"tipo"=>"proyecto",
							"estado_tarea"=>1,
							"siglas"=>$s_n_p,
							"tarea_ultimo"=>$id_usuario
						);
						$this->_sdt->crearSDT_CL_NewTask($datosEnviar);

						# obtenemos el id de esta nueva tarea
						$ultimaTarea = $this->_sdt->ultimoSDT_Task($id_usuario);

						# obtener la descripcion de la tarea
						$tareaDes = $this->_sdt->getSDT_CL_NewTaskDescription($tarea["id_tarea"]);
						# relacion tarea descripcion
						$datosEnviar = array(
							"id_tarea"=>$ultimaTarea["id_tarea"],
							"descripcion"=>$tareaDes["descripcion"]
						);
						$this->_sdt->crearSDT_CL_NewTaskDescription($datosEnviar);

						# se crea la relacion entre la tarea y el proyecto
						$datosEnviar = array(
							"id_proyecto"=>$ultimo["id_proyecto"],
							"id_tarea"=>$ultimaTarea["id_tarea"]
						);
						$this->_sdt->crearSDT_Proyecto_Tarea($datosEnviar);

						# se crea la relacion entre la tarea y el director
						$datosEnviar = array(
							"id_tarea"=>$ultimaTarea["id_tarea"],
							"id_usuario"=>$id_usuario
						);
						$this->_sdt->crearSDT_Tarea_Usuario($datosEnviar);

						# Asociaar las unidades de tiempo a las tareas respectivas
						$dias = $this->_sdt->getDaysTask($tarea["id_tarea"]);
						foreach ($dias as $dia) {
							$fechaNew = $this->_dateUtils->operarAFecha($dia["fecha"],$dias_avan);
							$datosEnviar = array(
								"id_tarea"=>$ultimaTarea["id_tarea"],
								"fecha"=>$fechaNew,
								"estado"=>0,
								"mover"=>"drag"
							);
							$this->_sdt->crearSDT_CL_Task_Dia($datosEnviar);
						}
						# Asociar los objetivos a las nuevas tareas
						$Objetivos = $this->_sdt->getItems($tarea["id_tarea"]);
						foreach ($Objetivos as $Objetivo) {
							$datosEnviar = array(
								"id_tarea"=>$ultimaTarea["id_tarea"],
								"nombre_item"=>$Objetivo["nombre_item"]
							);
							$this->_sdt->crearSDT_Tarea_Item($datosEnviar);
						}
					}
				}
			}
			$usuarios =  $this->_sdt->getUsuarios();
			$this->_view->assign("id_director",$id_usuario);
			$this->_view->assign("usuarios",$usuarios);
			$this->_view->assign("fechahoy",$fechahoy);

			$proyectos =  $this->_sdt->getProyectos();
			$this->_view->assign("proyectos",$proyectos);

			$this->_view->renderizar('crearProyecto');
		}
		public function verProyecto($proyecto=false){
			$this->_acl->acceso('todo');
			if (!$proyecto) {
				$this->redireccionar("sdt/proyecto");
				exit();
			}
			$id_usuario= Session::get('id_usuario');
			$proyect = $this->_sdt->getProyect($proyecto);
			if ($proyect["id_director"]!=$id_usuario) {
				$this->redireccionar("sdt/proyecto");
				exit();
			}

			$this->_view->assign('titulo','Ver Proyecto');
			$this->_view->assign('proyecto',$proyecto);

			$this->_view->setJs(array('eliminarDato','crearProyecto'));
			$this->_view->assign("modelo","sdt");
			$this->_view->assign("accion","eliminarTareaProyecto");

			if ($this->getInt('modificar')=="1")
			{
				$this->_view->assign("posteo",$_POST);

				$nombre_proyecto= $this->getSql("nombre_proyecto");
				$siglas_proyecto= $this->getSql("siglas_proyecto");
				$seleccionados= $this->getSql("seleccionados");
				
				$director = $this->getSql("director");
				$errores="";
				if (!$nombre_proyecto) {
					$errores="ingrese el nombre del poryecto";
				}
				if ($siglas_proyecto=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese las tres siglas del proyecto";
				}else if (strlen($siglas_proyecto)<1 || (strlen($siglas_proyecto)>3)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese una, dos o tres letras para conformar las siglas del proyecto";
				}else{
					$info= $this->_sdt->getProyectoSiglas($siglas_proyecto);
					if (is_array($info) && $proyecto!=$info["id_proyecto"]) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Otro proyecto ya se encuentra identificado con esas siglas";
					}
				}
				if ($director=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Seleccione el director del proyecto";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
				}else{
					# saber si el director es diferente
					if ($proyect["id_director"]!=$director && $director!=0) {
						# Cambiar en cada tarea el director
						$proyects = $this->_sdt->getTareasProyecto($proyecto);
						foreach ($proyects as $key) {
							$estado=0;
							if ($key["id_responsable"]==$director) {
								$estado=1;
							}
							$datosEnviar = array(
								"id_tarea"=>$key["id_tarea"],
								"id_director"=>$director,
								"estado_tarea"=>$estado
							);
							$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);
						}
						# se debe actualizar la relacion recurso proyecto, del antiguo director
						$rela= $this->_sdt->getSDT_Proyecto_Recurso_Id($proyecto,$director);
						if (is_array($rela)) {
							$datosEnviar = array(
								"id_proyecto_recurso"=>$rela["id_proyecto_recurso"],
								"id_recurso"=>$proyect["id_director"]
							);
							$this->_sdt->actualizarSDT_Proyecto_Recurso($datosEnviar);
							# de esta forma elimina la anterior relacion y el nuevo director no es un recurso en si.
						}
					}else{
						$director=$proyect["id_director"];
					}

					$p_descripcion= $this->getTexto("p_descripcion");
					$datosEnviar = array(
						"id_proyecto"=>$proyecto,
						"id_director"=>$director,
						"proyecto"=>$nombre_proyecto,
						"siglas_proyecto"=>strtoupper($siglas_proyecto),
						"p_descripcion"=>$p_descripcion
					);
					$this->_sdt->actualizarSDT_Proyecto($datosEnviar);


					if (isset($seleccionados)) {
						if ($seleccionados!="") {
							$s_original = $this->getTexto("s_original");
							$crear=true;
							if (isset($s_original)) {
								if ($seleccionados==$s_original) {
									$crear=false;
								}
							}
							if ($crear) {
								# Eliminar todas las anteriores relaciones de recursos del proyecto
								$this->_sdt->eliminarSDT_Proyecto_Recursos($proyecto);
								
								# Agregar las nuevas relaciones
								$porciones = explode(",", $seleccionados);
								for ($i=0; $i <count($porciones) ; $i++) { 
									$datosEnviar = array(
										"id_proyecto"=>$proyecto,
										"id_recurso"=>$porciones[$i]
									);
									$this->_sdt->crearSDT_Proyecto_Recurso($datosEnviar);
								}
							}
						}else{
							# Eliminar todas las anteriores relaciones de recursos del proyecto
							$this->_sdt->eliminarSDT_Proyecto_Recursos($proyecto);
						}
					}else{
						# Eliminar todas las anteriores relaciones de recursos del proyecto
						$this->_sdt->eliminarSDT_Proyecto_Recursos($proyecto);
					}
					//$this->redireccionar("sdt/proyecto");
					//exit();
					$this->_view->assign("_mensaje","Se ha modificado el proyecto");
				}
			}
			if ($this->getInt('eliminar')=="1")
			{
				#Ocultar el proyecto
				$datosEnviar = array(
					"id_proyecto"=>$proyecto,
					"proyecto_visible"=>1
				);
				$this->_sdt->actualizarSDT_Proyecto($datosEnviar);

				# ocultar las tareas del proyecto
				$proyects = $this->_sdt->getTareasProyecto($proyecto);
				foreach ($proyects as $key) {
					$datosEnviar = array(
						"id_tarea"=>$key["id_tarea"],
						"estado_tarea"=>10
					);
					$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);
				}
				$this->_view->assign("_mensaje","Se ha eliminado el proyecto");
				$this->redireccionar("sdt/proyecto");
				exit();
			}
			if ($this->getInt('creaLinea')=="1")
			{
				$this->_view->assign("posteo",$_POST);

				//crear la linea en el checklist tipo proyecto
				$tarea=$this->getSql("nombre_tarea");
				//se crean la relaciones entre los usuarios y la tarea
				$responsable=$this->getSql("responsable");
				$prioridad=$this->getSql("prioridad");
				$errores="";
				if (!$tarea) {
					$errores="Ingrese el nombre de la tarea";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
				}else{
					//El director sera otro miembro del proyecto
					$datos = $this->_sdt->getProyect($proyecto);
					$responsablet=$responsable;
					$estado=0;
					if ($responsable=="0") {
						$responsablet= $datos["id_director"];
						$estado=1;
					}
					$datosEnviar = array(
						"id_director"=>$datos["id_director"],
						"id_responsable"=>$responsablet,
						"tarea"=>$tarea,
						"tipo"=>"proyecto",
						"siglas"=>$datos["siglas_proyecto"],
						"estado_tarea"=>$estado,
						"tarea_ultimo"=>$id_usuario,
						"tarea_prioridad"=>$prioridad,
						"id_proyecto"=>$proyecto
					);
					$this->_sdt->crearSDT_CL_NewTask($datosEnviar);
					# obtenemos el id de esta nueva tarea
					$ultimo = $this->_sdt->ultimoSDT_Task($id_usuario);
					$descripcion=$this->getTexto("descripcion");
					$datosEnviar = array(
						"id_tarea"=>$ultimo["id_tarea"],
						"descripcion"=>$descripcion
					);
					$this->_sdt->crearSDT_CL_NewTaskDescription($datosEnviar);

					# se crea la relacion entre la tarea y el proyecto
					$datosEnviar = array(
						"id_proyecto"=>$proyecto,
						"id_tarea"=>$ultimo["id_tarea"]
					);
					$this->_sdt->crearSDT_Proyecto_Tarea($datosEnviar);

					# se crea la relacion entre la tarea y el director
					$datosEnviar = array(
						"id_tarea"=>$ultimo["id_tarea"],
						"id_usuario"=>$datos["id_director"]
					);
					$this->_sdt->crearSDT_Tarea_Usuario($datosEnviar);

					# se crea la relacion entre la tarea y el responsable siempre y cuando no sea igual al director
					if ($responsable!="0") {
						$datosEnviar = array(
							"id_tarea"=>$ultimo["id_tarea"],
							"id_usuario"=>$responsable
						);
						$this->_sdt->crearSDT_Tarea_Usuario($datosEnviar);
					}

					# Asignar un orden desde ya
					$datosEnviar = array(
						"id_tarea"=>$ultimo["id_tarea"],
						"id_usuario"=>$datos["id_director"],
						"orden"=>0
					);
					$this->_sdt->crearSDT_chlist_orden($datosEnviar);
					if ($responsablet!=$datos["id_director"]) {
						$datosEnviar = array(
							"id_tarea"=>$ultimo["id_tarea"],
							"id_usuario"=>$responsablet,
							"orden"=>0
						);
						$this->_sdt->crearSDT_chlist_orden($datosEnviar);
					}
					
					$this->_view->assign("posteo",null);
					$this->_view->assign("_mensaje","Se ha creado la tarea");
				}
			}
			$datos = $this->_sdt->getProyect($proyecto);
			$this->_view->assign("datos",$datos);
			$usuarios = $this->_sdt->getProyecto_Recurso($proyecto);
			$this->_view->assign("usuarios",$usuarios);
			$usuariosAll =  $this->_sdt->getUsuarios();
			$sele_Recu="";
			for ($i=0; $i < count($usuariosAll) ; $i++) { 
				if ($this->searchForIdKey($usuariosAll[$i]["id_usuario"], "id_usuario", "id_usuario", $usuarios)) {
					$sele_Recu.=$usuariosAll[$i]["id_usuario"].",";
					unset($usuariosAll[$i]);
				}
			}
			if ($sele_Recu!="") {
				$sele_Recu=substr($sele_Recu, 0, strlen($sele_Recu)-1);
			}
			$this->_view->assign("usuariosRecursos",$sele_Recu);
			$this->_view->assign("usuariosAll",$usuariosAll);

			$resul = $this->_sdt->getUsuario($datos["id_director"]);


			$this->_view->assign("id_director",$datos["id_director"]);
			$this->_view->assign("p_descripcion",$datos["p_descripcion"]);
			$this->_view->assign("nick_director",$resul["nickname_usuario"]);

			$datos2 = $this->_sdt->getTareasProyecto($proyecto);

			$estados["0"] = array(
					"clase"=>"primary",
					"palabra"=>"En espera"
				);
			$estados["1"] = array(
					"clase"=>"success",
					"palabra"=>"Activo"
				);
			$estados["2"] = array(
					"clase"=>"danger",
					"palabra"=>"Rechazado"
				);

			$this->_view->assign("datos2",$datos2);
			$this->_view->assign("estados",$estados);
			$this->_view->renderizar('verProyecto');
		}
		public function verTarea($proyecto=false,$tarea=false){
			$this->_acl->acceso('todo');
			if (!$proyecto) {
				$this->redireccionar("sdt/proyecto");
				exit();
			}
			if (!$tarea) {
				$this->redireccionar("sdt/verProyecto/".$proyecto);
				exit();
			}
			$this->_view->setJs(array('eliminarDato','tareaItems'));

			$fechahoy = date('d/m/Y', mktime()+$this->_time);
			$datos = $this->_sdt->getTarea($tarea);
			$this->_view->assign('nombreTarea',$datos["tarea"]);
			$datoss = $this->_sdt->getProyect($proyecto);
			$id_director = $datoss["id_director"];
			$id_usuario= Session::get('id_usuario');

			
			if ($this->getInt('camres')=="1")
			{
				$responsable=$this->getSql("responsable");
				$fechacambio=$this->getSql("fechacambio");
				# Partir la actividad de tal forma que hasta donde el anterior responsable
				# se crea una nueva tarea si aun hay unidades que asignar
				//$fechacambio="02/08/2014";
				$fecha1 = explode("/", $fechacambio);
				$diapas = mktime(0, 0, 0, $fecha1[1], $fecha1[0], $fecha1[2]);

				# Como regla se establece que el corte no puede ser inferior al dia hoy (desabilitada)
				$fecha0 = explode("/", $fechahoy);
				$diapa0 = mktime(0, 0, 0, $fecha0[1], $fecha0[0], $fecha0[2]);
				//El director sera otro miembro del proyecto
				if ($datos["id_responsable"]!=$responsable) {
					$id_tarea = $tarea;
					$id_responsable0 = $datos["id_responsable"];
					$estado=0;
					if ($responsable=="0") {
						$responsable=$id_director;
						$estado=1;
					}
					$opcion=1;
					if ($datos["fecha_ini_tarea"]=="") {
						$opcion=0;
					}
					if ($opcion==0) {
						$this->cambioResponsable($responsable,$id_tarea,$nombre_tarea,$estado,$id_responsable0);
					}elseif ($opcion==1) {
						$fecha1 = explode("/", $datos["fecha_ini_tarea"]);
						$diaini = mktime(0, 0, 0, $fecha1[1], $fecha1[0], $fecha1[2]);
						$fecha1 = explode("/", $datos["fecha_fin_tarea"]);
						$diafin = mktime(0, 0, 0, $fecha1[1], $fecha1[0], $fecha1[2]);
						# si la fecha de cambio esta antes, del limite inferior de la tarea, entonces
						# Se asignara todas las actividades
						if ($diapas<=$diaini) {
							# cambiar de tarea y no habra particion de la tarea.
							$this->cambioResponsable($responsable,$id_tarea,$nombre_tarea,$estado,$id_responsable0);
						}elseif ($diapas>$diafin) {
							# no vale la pena crear una nueva tarea, se deja las cosas como estan.
						}else {
							# realizar la particion de la tarea.
							# Se identifican que unidades de tiempo son superiores a la fecha
							# de particion para otorgaselas al nuevo responsable. Habran dos responsables.
							# Que se hara con el nombre de la tarea? Nombre por defaul de la 
							# nueva tarea es: Particion de <<nombre tarea origen>>.

							# actualizar la nueva fecha final de la tarea original
							$datosEnviar = array(
								"id_tarea"=>$tarea,
								"fecha_fin_tarea"=>$fechacambio
							);
							$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);

							# se crea la nueva tarea con su responsable.
							$datosEnviar = array(
								"tarea"=>$nombre_tarea,
								"estado_tarea"=>$estado,
								"id_director"=>$id_usuario,
								"id_responsable"=>$responsable,
								"tipo"=>"proyecto",
								"fecha_ini_tarea"=>$fechacambio,
								"fecha_fin_tarea"=>$datos["fecha_fin_tarea"],
								"siglas"=>$datoss["siglas_proyecto"],
								"tarea_ultimo"=>$id_usuario,
								"id_proyecto"=>$proyecto
							);
							$this->_sdt->crearSDT_CL_NewTask($datosEnviar);
							# obtener el id de la ultima tarea
							$ultimo = $this->_sdt->ultimoSDT_Task($id_usuario);

							# almacenar la descripcion de la tarea, como son hermanas tendran la misma descripcion
							$descripcion=$this->getTexto("descripcion");
							$datosEnviar = array(
								"id_tarea"=>$ultimo["id_tarea"],
								"descripcion"=>$descripcion
							);
							$this->_sdt->crearSDT_CL_NewTaskDescription($datosEnviar);

							# se crea la relacion entre la tarea y el proyecto
							$datosEnviar = array(
								"id_proyecto"=>$proyecto,
								"id_tarea"=>$ultimo["id_tarea"]
							);
							$this->_sdt->crearSDT_Proyecto_Tarea($datosEnviar);

							# se crea la relacion entre la tarea y el director
							$datosEnviar = array(
								"id_tarea"=>$ultimo["id_tarea"],
								"id_usuario"=>$datos["id_director"]
							);
							$this->_sdt->crearSDT_Tarea_Usuario($datosEnviar);

							# se crea la relacion entre la tarea y el responsable siempre y cuando no sea igual al director
							if ($responsable!="0") {
								$datosEnviar = array(
									"id_tarea"=>$ultimo["id_tarea"],
									"id_usuario"=>$responsable
								);
								$this->_sdt->crearSDT_Tarea_Usuario($datosEnviar);
							}

							$datos2 = $this->_sdt->getSDT_CL_TasksDias($datos["id_responsable"]);
							foreach ($datos2 as $key) {
								$fecha1 = explode("/", $key["fecha"]);
								$udia = mktime(0, 0, 0, $fecha1[1], $fecha1[0], $fecha1[2]);
								if ($udia>=$diapas) {
									# desvicular la unidad de tiempo a la tarea partida y unirla a la tarea nueva.
									$datosEnviar = array(
										"id_dia"=>$key["id_dia"],
										"id_tarea"=>$ultimo["id_tarea"]
									);
									$this->_sdt->actualizarSDT_CL_Task_Dia($datosEnviar);
								}
							}
							$this->porcentajeTarea($ultimo["id_tarea"]);
							$this->porcentajeTarea($tarea);

							# Clonar los objetivos de la tarea
							$Objetivos = $this->_sdt->getItems($tarea);
							foreach ($Objetivos as $key) {
								$datosEnviar = array(
									"id_tarea"=>$ultimo["id_tarea"],
									"nombre_item"=>$key["nombre_item"],
									"estado_item"=>$key["estado_item"]
								);
								$this->_sdt->crearSDT_Tarea_Item($datosEnviar);
							}
							
							# Clonar comentarios
							$Objetivos = $this->_sdt->getNotas($tarea);
							foreach ($Objetivos as $key) {
								$datosEnviar = array(
									"id_tarea"=>$ultimo["id_tarea"],
									"id_usuario"=>$key["id_usuario"],
									"comentario"=>$key["comentario"],
									"fecha_nota"=>$key["fecha_nota"]
								);
								$this->_sdt->crearSDT_Tarea_Nota($datosEnviar);
							}
						}
						$this->_view->assign("_mensaje","Se ha modificado el responsable de la tarea");
					}
				}
			}
			if ($this->getInt('modificar')=="1")
			{
				$nombre_tarea=$this->getSql("nombre_tarea");
				$descripcion=$this->getTexto("descripcion");
				# almacenar las nuevas relaciones entre tarea y usuarios
				
				$errores="";
				if (!$nombre_tarea) {
					$errores="Ingrese el nombre de la tarea";
				}
				
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
				}else{
					//borrar todos los registros de esa tarea con usuarios

					$datosEnviar = array(
						"id_tarea"=>$tarea,
						"tarea"=>$nombre_tarea
					);
					$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);

					$datosEnviar = array(
						"id_tarea"=>$tarea,
						"descripcion"=>$descripcion
					);
					$this->_sdt->actualizarSDT_CL_NewTaskDescription($datosEnviar);

					$this->_view->assign("_mensaje","Se ha modificado la tarea");
					$this->redireccionar("sdt/verProyecto/".$proyecto);
					exit();
				}
			}
			if ($this->getInt('creaItem')=="1")
			{
				//almacenar las nuevas relaciones entre tarea y usaurios
				$nombre_item=$this->getSql("nombre_item");
				$errores="";
				if (!$nombre_item) {
					$errores="Ingrese el objetivo";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
				}else{
					$datosEnviar = array(
						"id_tarea"=>$tarea,
						"nombre_item"=>$nombre_item
					);
					$this->_sdt->crearSDT_Tarea_Item($datosEnviar);
					$this->_view->assign("_mensaje","Se ha agregado un nuevo objetivo");
				}

			}
			$datos = $this->_sdt->getTarea($tarea);
			$usuarios = $this->_sdt->getProyecto_Recurso($proyecto);
			$descrip = $this->_sdt->getSDT_CL_NewTaskDescription($tarea);

			# Obtener los objetivos de esta tarea
			$items = $this->_sdt->getItems($tarea);

			$this->_view->assign("modelo","sdt");
			$this->_view->assign("accion","eliminarTareaItem");

			$this->_view->assign('datos',$datos);
			$this->_view->assign('items',$items);
			$this->_view->assign('proyecto',$proyecto);
			$this->_view->assign('descrip',$descrip);
			$this->_view->assign('usuarios',$usuarios);
			$this->_view->assign('id_director',$id_director);
			$this->_view->assign('titulo','Ver Tarea');
			$this->_view->assign('fechahoy',$fechahoy);
			$this->_view->assign('fechaini',$datos["fecha_ini_tarea"]);
			$this->_view->assign('fechafin',$datos["fecha_fin_tarea"]);

			$resul = $this->_sdt->getUsuario($datoss["id_director"]);
			$this->_view->assign("nick_director",$resul["nickname_usuario"]);

			
			$this->_view->assign('es_responsable',$this->searchForIdKey($datos["id_responsable"], "id_usuario", "nickname_usuario", $usuarios));
			
			$resul = $this->_sdt->getUsuario($datos["id_responsable"]);
			$this->_view->assign("responsable",$resul);

			$this->_view->renderizar('verTarea');
		}
		private function cambioResponsable($responsable,$id_tarea,$nombre_tarea,$estado,$id_responsable0){
			$id_responsable1 = $responsable;
			$datosEnviar = array(
				"id_tarea"=>$id_tarea,
				"tarea"=>$nombre_tarea,
				"estado_tarea"=>$estado,
				"id_responsable"=>$responsable
			);
			$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);
			
			# consultar si ya existe la relacion con el anterior responsable // no deberia preguntar ya que se creara una nueva tarea
			$rela0 = $this->_sdt->getSDT_Tarea_Uruario($id_tarea, $id_responsable0);
			if (is_array($rela0)) {
				$rela1 = $this->_sdt->getSDT_Tarea_Uruario($id_tarea, $id_responsable1);
				if (!is_array($rela1)) {
					$datosEnviar = array(
						"id_tar_usu"=>$rela0["id_tar_usu"],
						"id_usuario"=>$id_responsable1
					);
					$this->_sdt->actualizarSDT_Tarea_Usuario($datosEnviar);
					$tarea = $this->_sdt->getTarea($id_tarea);
					$rela1 = $this->_sdt->getSDT_Tarea_Uruario($id_tarea, $tarea["id_director"]);
					if (!is_array($rela1)) {
						$datosEnviar = array(
							"id_tarea"=>$id_tarea,
							"id_usuario"=>$tarea["id_director"]
						);
						$this->_sdt->crearSDT_Tarea_Usuario($datosEnviar);
					}
				}else{
					# eliminar relacion, evitar la duplicidad 
					if ($id_responsable0!=$id_responsable1) {
						$this->_sdt->eliminarSDT_Tarea_Usuario($rela0["id_tar_usu"]);
					}
				}
			}
		}
		public function verTareaComentario($proyecto=false,$tarea=false){
			$this->_acl->acceso('todo');
			if (!$proyecto) {
				$this->redireccionar("sdt/proyecto");
				exit();
			}
			if (!$tarea) {
				$this->redireccionar("sdt/verProyecto/".$proyecto);
				exit();
			}
			if ($this->getInt('modificar')=="1")
			{
				$datosEnviar = array(
					"id_tarea"=>$tarea,
					"estado_tarea"=>0
				);
				$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);
				$this->redireccionar("sdt/verProyecto/".$proyecto);
			}
			$this->_view->assign('titulo','Tarea Rechazada');
			$datos = $this->_sdt->getTarea($tarea);
			$nickname_usuario = $this->_sdt->getUsuario($datos["id_responsable"]);
			$comentario = $this->_sdt->getSDT_Tarea_Comentario($tarea);

			$this->_view->assign('datos',$datos);
			$this->_view->assign('id_proyecto',$proyecto);
			$this->_view->assign('nickname_usuario',$nickname_usuario["nickname_usuario"]);
			$this->_view->assign('comentario',$comentario["comentario"]);
			$this->_view->renderizar('verTareaComentario');
		}
		public function crearTarea(){
			$this->_acl->acceso('todo');
			$this->_view->assign('titulo','Crear Tarea');
			$this->_view->setJs(array('crearRepetir'));
			///////////
			$dia=date("d");
			$mes=date("m");
			$anio=date("Y");
			$fechaini = $dia . "/" . $mes . "/" . $anio;
			if ($this->getInt('crearRepetir')=="1")
			{
				$posi=array(
					"0"=>7,
					"1"=>1,
					"2"=>2,
					"3"=>3,
					"4"=>4,
					"5"=>5,
					"6"=>6,
					);

				// obtener lo paramentro del formulario
				$tarea=$this->getSql("nombre_tarea");
				$repetir=$this->getSql("repetir");
				$dias=$this->getSql("dias");
				$fechaini=$this->getSql("inicio");
				$fechafin=$this->getSql("fin");
				//crear la linea que contendra la tarea
				$datosEnviar = array(
					"id_director"=>0,
					"tarea"=>$tarea,
					"tipo"=>"periodico",
					"tarea_ultimo"=>$id_usuario
				);
				$this->_sdt->crearSDT_CL_NewTask($datosEnviar);
				//Codigo agregado para relacionar la atera con el usuario
				//obtenemos el id de esta nueva tarea
				$ultimo = $this->_sdt->ultimoSDT_Task($id_usuario);
				$datosEnviar = array(
					"id_tarea"=>$ultimo["id_tarea"],
					"id_usuario"=>Session::get('id_usuario')
				);
				$this->_sdt->crearSDT_Tarea_Usuario($datosEnviar);


				
				$resl="";
				$fecha1 = explode("/", $fechaini);
				$ndia = date('w', mktime(0, 0, 0, $fecha1[1], $fecha1[0], $fecha1[2]));

				if ($repetir=="1") {
					if ($dias!="") {
						//Para cada dia de la semana se generara una fecha igual o superor a la fecha de inicio, luego con una periodicidad de 7 dias
						$dia = explode(",", $dias);
						for ($i=0; $i < count($dia); $i++) {
							if (trim($dia[$i])!="") {
								if ($posi[$dia[$i]]>=$posi[$ndia]) {
									//encontramos que el dia de es superior al dia del inicio de la fecha de inicio 
									$nuevaFeche = $this->_dateUtils->operarAFecha($fechaini,$posi[$dia[$i]]-$posi[$ndia]);
								}else{
									//encontramos que el dia de es inferior al dia del inicio de la fecha de inicio 
									$nuevaFeche = $this->_dateUtils->operarAFecha($fechaini,7-($posi[$ndia]-$posi[$dia[$i]]));
								}
								//se almacena la fecha a una periocidad de 7 dias 
								$datosEnviar2 = array(
									"id_tarea"=>$ultimo["id_tarea"],
									"fecha_ini"=>$nuevaFeche,
									"fecha_fin"=>"".$fechafin."",
									"repetir"=>7
								);
								$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
							}
						}
					}
				}
				if ($repetir=="2") {
					//La tarea se repite apartir del inicio del mes
					if ($dias!="") {
						//en el caso que se halla elegido algun dia, sera, por ejemplo el primero lunes o domingo del mes.
						$dia = explode(",", $dias);
						for ($i=0; $i < count($dia); $i++) {
							if (trim($dia[$i])!="") {
								$datosEnviar2 = array(
									"id_tarea"=>$ultimo["id_tarea"],
									"fecha_ini"=>$fechaini,
									"fecha_fin"=>"".$fechafin."",
									"repetir"=>$dia[$i],
									"opcion"=>"primes"
								);
								$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
							}
						}
					}else{
						$datosEnviar2 = array(
							"id_tarea"=>$ultimo["id_tarea"],
							"fecha_ini"=>$fechaini,
							"fecha_fin"=>"".$fechafin."",
							"repetir"=>7,
							"opcion"=>"primes"
						);
						$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
					}
				}
				if ($repetir=="3") {
					$inicio1=$this->getSql("inicio1");
					if (trim($inicio1)=="") {
						$inicio1=0;
					}
					$datosEnviar2 = array(
						"id_tarea"=>$ultimo["id_tarea"],
						"fecha_ini"=>$fechaini,
						"fecha_fin"=>"".$fechafin."",
						"repetir"=>$inicio1,
						"opcion"=>"inimes"
					);
					$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
				}
				if ($repetir=="4") {
					$inicio1=$this->getSql("inicio2");
					if (trim($inicio1)=="") {
						$inicio1=0;
					}
					$datosEnviar2 = array(
						"id_tarea"=>$ultimo["id_tarea"],
						"fecha_ini"=>$fechaini,
						"fecha_fin"=>"".$fechafin."",
						"repetir"=>$inicio1,
						"opcion"=>"finmes"
					);
					$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
				}
			}
			$this->_view->assign('fechaini',$fechaini);
			$this->_view->renderizar('crearTarea');
		}
		public function indexGrupo(){
			$this->_acl->acceso('todo');
			$btnHeader = array(
				array(
					"titulo" => "Crear Paquete de tareas",
					"enlace" => "sdt/crearGrupo"
				)
			);
			$this->_view->assign("titulo","Crear paquete de tareas");
			$this->_view->assign("btnHeader",$btnHeader);
			$this->_view->setJs(array('eliminarDato'));
			$this->_view->assign("modelo","sdt");
			$this->_view->assign("accion","eliminarGrupo");

			$datos1 =  $this->_sdt->getGrupo();
			$datos2 = $this->_sdt->getSDT_Grupo_Usuario(Session::get('id_usuario'));

			$cadena = ",";
			$cadena2 = ",";
			foreach ($datos2 as $key) {
				$cadena = $cadena . $key["id_grupo"] . ",";
				if ($key["estado"]==1) {
					$cadena2 = $cadena2 . $key["id_grupo"] . ",";
				}
			}
			$inc=-1;
			$datos=null;
			foreach ($datos1 as $key) {
				$inc+=1;
				$datos[$inc]["id_grupo"]=$key["id_grupo"];
				$datos[$inc]["nombre_grupo"]=$key["nombre_grupo"];
				$datos[$inc]["siglas_grupo"]=$key["siglas_grupo"];
				if (strpos($cadena2, ",". $key["id_grupo"] . ",")===false) {
					$datos[$inc]["icono"]="arrow-down";
					$datos[$inc]["ruta"]="bajarGrupo/".$key["id_grupo"];
				}else{
					$datos[$inc]["icono"]="arrow-up";
					$datos[$inc]["ruta"]="subirGrupo/".$key["id_grupo"];
				}
			}

			$this->_view->assign("datos",$datos);
			$this->_view->renderizar('indexGrupos');
		}
		public function crearGrupo(){
			$this->_acl->acceso('todo');
			$this->_view->assign('titulo','Crear Paquete de tareas');
			if ($this->getInt('crear')=="1")
			{
				$this->_view->assign('posteo',$_POST);
				$nombre_grupo= $this->getSql("nombre_grupo");
				$siglas_grupo= $this->getSql("siglas_grupo");
				$errores="";
				if ($nombre_grupo=="") {
					$errores="Ingrese el nombre del grupo";
				}
				if ($siglas_grupo=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese las siglas del paquete de tareas";
				}else if (strlen($siglas_grupo)<2 || (strlen($siglas_grupo)>4)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese dos, tres o cuatro letras para conformar las siglas del paquete de tareas";
				}else{
					$info= $this->_sdt->getGrupoSiglas($siglas_grupo);
					if (is_array($info)) {
						if ($errores!="") {
							$errores .="<br>";
						}
						$errores.="Otro paquete de tareas ya se encuentra identificado con esas siglas";
					}
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
				}else{
					$id_usuario = Session::get('id_usuario');
					$g_descripcion = $this->getTexto("g_descripcion");
					$datosEnviar = array(
						"id_creador"=>$id_usuario,
						"nombre_grupo"=>$nombre_grupo,
						"siglas_grupo"=>strtoupper($siglas_grupo),
						"g_descripcion"=>$g_descripcion
					);
					$this->_sdt->crearSDT_Grupo($datosEnviar);
					$ultimo = $this->_sdt->ultimoSDT_grupo($id_usuario);
					$this->redireccionar("sdt/verGrupo/".$ultimo["id_grupo"]);
					exit();
				}
			}
			$datos = $this->_sdt->getSDT_CL_TaskCiclo_Model();
			$this->_view->assign("datos",$datos);
			$this->_view->renderizar('crearGrupo');
		}
		public function verGrupo($id=false){
			$this->_acl->acceso('todo');
			if (!$id) {
				$this->redireccionar("sdt/indexGrupo") ;
				exit();
			}
			$id_usuario= Session::get('id_usuario');
			$grupo = $this->_sdt->getSDT_Grupo($id);
			if ($grupo["id_creador"]!=$id_usuario) {
				$this->redireccionar("sdt/indexGrupo");
				exit();
			}
			$this->_view->setJs(array('crearProyecto','eliminarDato'));
			$this->_view->assign("modelo","sdt");
			$this->_view->assign("accion","eliminarTareaGrupo");
			if ($this->getInt('modificar')=="1"){
				$nombre_grupo= $this->getSql("nombre_grupo");
				$siglas_grupo= $this->getSql("siglas_grupo");
				$id_creador= $this->getSql("administrador");
				
				$errores="";
				if ($nombre_grupo=="") {
					$errores="Ingrese el nombre del grupo";
				}
				if ($siglas_grupo=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese las siglas del paquete de tareas";
				}else if (strlen($siglas_grupo)<2 || (strlen($siglas_grupo)>4)) {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese dos, tres o cuatro letras para conformar las siglas del paquete de tareas";
				}else{
					$info= $this->_sdt->getGrupoSiglas($siglas_grupo);
					if (is_array($info)) {
						if ($info["id_grupo"]!=$id) {
							if ($errores!="") {
								$errores .="<br>";
							}
							$errores.="Otro paquete de tareas ya se encuentra identificado con esas siglas";
						}
					}
				}

				if ($errores!="") {
					$this->_view->assign("_error",$errores);
				}else{
					$g_descripcion = $this->getTexto("g_descripcion");
					$datosEnviar = array(
						"id_grupo"=>$id,
						"id_creador"=>$id_creador,
						"nombre_grupo"=>$nombre_grupo,
						"siglas_grupo"=>strtoupper($siglas_grupo),
						"g_descripcion"=>$g_descripcion
					);
					$this->_sdt->actualizarSDT_Grupo($datosEnviar);
					if ($id_usuario!=$id_creador) {
						$this->redireccionar("sdt/indexGrupo");
						exit();
					}
					$this->_view->assign("_mensaje","Se ha modificado el paquete de tareas");
				}
			}
			if ($this->getInt('crear')=="1"){
				$nombre_tarea= $this->getSql("nombre_tarea");
				$errores="";
				if ($nombre_tarea=="") {
					$errores="Ingrese el nombre de la tarea";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
				}else{
					$datos = $this->_sdt->getSDT_Grupo($id);

					$datosEnviar = array(
						"id_director"=>-1,
						"tarea"=>$nombre_tarea,
						"tipo"=>"periodico",
						"estado_tarea"=>1,
						"siglas"=>strtoupper($datos["siglas_grupo"]),
						"tarea_ultimo"=>$id_usuario
					);

					$this->_sdt->crearSDT_CL_NewTask($datosEnviar);

					$ultimo = $this->_sdt->ultimoSDT_Task($id_usuario);
					$datosEnviar = array(
						"id_grupo"=>$id,
						"id_tarea"=>$ultimo["id_tarea"]
					);
					$this->_sdt->crearSDT_Tarea_Grupo($datosEnviar);
					$descripcion= $this->getTexto("descripcion");

					$datosEnviar = array(
						"id_tarea"=>$ultimo["id_tarea"],
						"descripcion"=>$descripcion
					);
					$this->_sdt->crearSDT_CL_NewTaskDescription($datosEnviar);
					
					# la nueva tarea debe verse en cada usuario que tenga asociado al grupo
					$usuarios = $this->_sdt->getSDT_Usuarios_Grupo($id);
					$grupo = $this->_sdt->getSDT_Grupo($id);
					$fechahoy = date('d/m/Y', mktime()+$this->_time);
					foreach ($usuarios as $key) {
						$datosEnviar = array(
							"id_director"=>0,
							"tarea"=>$nombre_tarea,
							"tipo"=>"periodico",
							"siglas"=>$grupo["siglas_grupo"],
							"estado_tarea"=>1,
							"fecha_ini_tarea"=>$fechahoy, # en dudas, establecer la fecha de inicio.
							"tarea_ultimo"=>$id_usuario,
							"id_grupo"=>$id
						);
						$this->_sdt->crearSDT_CL_NewTask($datosEnviar);
						// Codigo agregado para relacionar la atera con el usuario
						// obtenemos el id de esta nueva tarea
						$ultimo2 = $this->_sdt->ultimoSDT_Task($id_usuario);
						// Esta relacion es creada para actualizar las tareas clonadas del modelo
						$datosEnviar = array(
							"id_tarea"=>$ultimo2["id_tarea"],
							"id_modelo"=>$ultimo["id_tarea"]
						);
						$this->_sdt->crearSDT_Tareas_Modelo($datosEnviar);

						$datosEnviar = array(
							"id_tarea"=>$ultimo2["id_tarea"],
							"id_usuario"=>$key["id_usuario"]
						);
						$this->_sdt->crearSDT_Tarea_Usuario($datosEnviar);
					}

					$this->redireccionar("sdt/crearTareaModelo/".$id."/".$ultimo["id_tarea"]);
					exit();
				}
			}
			$datos = $this->_sdt->getSDT_Grupo($id);
			$tareas = $this->_sdt->getSDT_Tarea_Grupo($id);

			$this->_view->assign('titulo','Ver paquete de tareas');
			$this->_view->assign("nombre_grupo",$datos["nombre_grupo"]);
			$this->_view->assign("siglas_grupo",$datos["siglas_grupo"]);
			$this->_view->assign("g_descripcion",$datos["g_descripcion"]);
			$this->_view->assign("tareas",$tareas);

			$usuariosAll =  $this->_sdt->getUsuarios();
			$this->_view->assign("usuariosAll",$usuariosAll);
			$this->_view->assign("administrador",$id_usuario);

			$this->_view->renderizar('verGrupo');
		}
		public function crearTareaModelo($id_grupo=false,$id_tarea=false) {
			$this->_acl->acceso('todo');
			if (!$id_grupo) {
				$this->redireccionar("sdt/check_list") ;
				exit();
			}
			if (!$id_tarea) {
				$this->redireccionar("sdt/check_list") ;
				exit();
			}
			$this->_acl->acceso('todo');
			$this->_view->assign('titulo','Ver Tarea Modelo');
			$this->_view->setJs(array('crearRepetir'));
			
			$dia=date("d");
			$mes=date("m");
			$anio=date("Y");
			$fechaini = $dia . "/" . $mes . "/" . $anio;
			if ($this->getInt('modificar')=="1") {
				$tarea=$this->getSql("nombre_tarea");
				$errores="";
				if ($tarea=="") {
					$errores="Ingrese el nombre de la tarea";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
				}else{
					$datosEnviar = array(
						"id_tarea"=>$id_tarea,
						"tarea"=>$tarea,
					);
					$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);
					
					$descripcion=$this->getTexto("descripcion");
					$datosEnviar = array(
						"id_tarea"=>$id_tarea,
						"descripcion"=>$descripcion
					);
					$this->_sdt->actualizarSDT_CL_NewTaskDescription($datosEnviar);
					$this->_view->assign("_mensaje","Se ha modificado la informacion de la tarea");

					$arrTarea = $this->_sdt->getSDT_Tarea_Modelo($id_tarea);

					if (is_array($arrTarea)) {
						foreach ($arrTarea as $key) {
							$datosEnviar = array(
								"id_tarea"=>$key["id_tarea"],
								"tarea"=>$tarea
							);
							$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);
							
							$this->_sdt->eliminarSDT_CL_NewTaskDescription($key["id_tarea"]);
							$datosEnviar = array(
								"id_tarea"=>$key["id_tarea"],
								"descripcion"=>$descripcion
							);
							$this->_sdt->crearSDT_CL_NewTaskDescription($datosEnviar);
						}
					}
				}
			}
			if ($this->getInt('crearRepetir')=="1")
			{
				// obtener lo paramentros del formulario
				$repetir=$this->getSql("repetir");
				$dias=$this->getSql("dias");
				$fechaini=$this->getSql("inicio");
				$fechafin=$this->getSql("fin");
				$n_repetir=$this->getSql("n_repetir");
				$t_repetir=$this->getSql("t_repetir");

				$errores="";
				if ($repetir=="") {
					$errores="Seleccione el tipo de repeticion";
				}
				if ($fechaini=="") {
					if ($errores!="") {
						$errores .="<br>";
					}
					$errores.="Ingrese la fecha inicial";
				}
				if ($errores!="") {
					$this->_view->assign("_error",$errores);
				}else{
					$this->_view->assign("_mensaje","Se ha modificado los dias de la tarea");
					//Guardar configuracion del formulario
					$cant_dias=0;
					if ($repetir=="3") {
						$cant_dias = $this->getSql("inicio1");
					}else if ($repetir=="4") {
						$cant_dias = $this->getSql("inicio2");
					}
					if (trim($cant_dias)=="" || trim($cant_dias)=="0") {
						$cant_dias=1;
					}
					$datosEnviar = array(
						"id_tarea"=>$id_tarea,
						"repetir"=>$repetir,
						"dias"=>$dias,
						"cant_dias"=>$cant_dias,
						"cant_semana"=>0,
						"fecha_ini"=>$fechaini,
						"fecha_fin"=>"".$fechafin."",
						"n_repetir"=>$n_repetir,
						"t_repetir"=>$t_repetir
					);
					$this->_sdt->crearSDT_Tareas_Model_Config($datosEnviar);
					$posi=array(
						"0"=>7,
						"1"=>1,
						"2"=>2,
						"3"=>3,
						"4"=>4,
						"5"=>5,
						"6"=>6,
					);
					$arrTarea = $this->_sdt->getSDT_Tarea_Modelo($id_tarea);

					if (is_array($arrTarea)) {
						$fecha_final = $this->_dateUtils->operarAFecha($fechaini,-1);
						foreach ($arrTarea as $key) {
							// Primero borrar el contenido de dias
							// Eliminar todas las unidades de tiempo que sean igual o menor a la fecha inicial 
							$diasSS = $this->_sdt->getSDT_Tareas_Repetir($key["id_tarea"]);
							foreach ($diasSS as $key2) {
								$nume = $this->_dateUtils->restarFechas($key2["fecha_ini"],$fechaini);
								if ($nume<=0) {
									# Borrar el registro
									$this->_sdt->eliminarSDT_Tareas_Repetir($key2["id_dia"]);
								}else{
									// Actualizar la fecha final
									$datosEnviar = array(
										"id_dia"=>$key2["id_dia"],
										"fecha_fin"=>"".$fecha_final.""
									);
									$this->_sdt->actualizarSDT_Tareas_Repetir($datosEnviar);
								}
							}
							$diasSS = $this->_sdt->getDaysTask($key["id_tarea"]);
							foreach ($diasSS as $key2) {
								$nume = $this->_dateUtils->restarFechas($key2["fecha"],$fechaini);
								if ($nume<=0) {
									# Borrar el registro
									$this->_sdt->eliminarSDT_Dias($key2["id_dia"]);
								}
							}
							//$this->_sdt->eliminarSDT_CL_Task_2();
							//$this->_sdt->eliminarSDT_CL_Task_3($key["id_tarea"]);
						}
					}

					$resl="";
					$fecha1 = explode("/", $fechaini);
					$ndia = date('w', mktime(0, 0, 0, $fecha1[1], $fecha1[0], $fecha1[2]));

					// Eliminar las unidades de tiempo del modelo para no generar registros basura
					$this->_sdt->eliminarSDT_Tareas_Repetir_Clone($id_tarea);

					if ($repetir=="1") {
						if ($dias!="") {
							$eliminar_anterior=true;
							// Para cada dia de la semana se generara una fecha igual o superor a la fecha de inicio, luego con una periodicidad de 7 dias
							$dia = explode(",", $dias);
							for ($i=0; $i < count($dia); $i++) {
								if (trim($dia[$i])!="") {
									if ($posi[$dia[$i]]>=$posi[$ndia]) {
										// Encontramos que el dia de es superior al dia del inicio de la fecha de inicio 
										$nuevaFeche = $this->_dateUtils->operarAFecha($fechaini,$posi[$dia[$i]]-$posi[$ndia]);
									}else{
										// Encontramos que el dia de es inferior al dia del inicio de la fecha de inicio 
										$nuevaFeche = $this->_dateUtils->operarAFecha($fechaini,7-($posi[$ndia]-$posi[$dia[$i]]));
										// para cuando es semana
										// if ($t_repetir==1 && $n_repetir>1) {
										// 	$nuevaFeche = $this->_dateUtils->operarAFecha($nuevaFeche,7*($n_repetir-1));
										// }
									}
									$reprtir=
									// se almacena la fecha a una periocidad de 7 dias 
									$datosEnviar2 = array(
										"id_tarea"=>$id_tarea,
										"fecha_ini"=>$nuevaFeche,
										"fecha_fin"=>"".$fechafin."",
										"repetir"=>7*$n_repetir,
										"n_repetir"=>$n_repetir,
										"t_repetir"=>$t_repetir
									);
									$this->_sdt->crearSDT_CL_NewTaskCiclo_Model($datosEnviar2);


									if (is_array($arrTarea)) {
										foreach ($arrTarea as $key) {
											if ($eliminar_anterior) {
												$eliminar_anterior=false;
												// Eliminar el registro de las unidades de tiempo repetitivas
												$this->_sdt->eliminarSDT_CL_Task_3($key["id_tarea"]);
											}

											// almacenar para cada tarea los dias 
											$datosEnviar2 = array(
												"id_tarea"=>$key["id_tarea"],
												"fecha_ini"=>$nuevaFeche,
												"fecha_fin"=>"".$fechafin."",
												"repetir"=>7*$n_repetir,
												"n_repetir"=>$n_repetir,
												"t_repetir"=>$t_repetir
											);
											$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
										}
									}
								}
							}
						}
					}
					if ($repetir=="2") {
						//La tarea se repite apartir del inicio del mes
						if ($dias!="") {
							//en el caso que se halla elegido algun dia, sera, por ejemplo el primero lunes o domingo del mes.
							$dia = explode(",", $dias);
							for ($i=0; $i < count($dia); $i++) {
								if (trim($dia[$i])!="") {

									$fechaDummy = $fechaini;
									// Saco el primer "lunes" del mes
									$fechaDummy = $this->primerDiaMes($fechaDummy);
									$fechaDummy = $this->primerDia($fechaDummy,$dia[$i]);
									// Le sumo las semnas
									$fechaDummy = $this->_dateUtils->operarAFecha($fechaDummy,7*($n_repetir-1));
									// Si el dia excede al dia de hoy paso al siguiente mes
									$dife = $this->_dateUtils->restarFechas($fechaini,$fechaDummy);
									if ($dife<0) {
										$t_repetir = ($t_repetir=='0')?'1':$t_repetir;
										for ($j=0; $j < $t_repetir ; $j++) {
											$fechaDummy = $this->incrementarMes($fechaDummy);
										}
										$fechaDummy = $this->primerDiaMes($fechaDummy,$dia[$i]);
										$fechaDummy = $this->primerDia($fechaDummy,$dia[$i]);
										$fechaDummy = $this->_dateUtils->operarAFecha($fechaDummy,7*($n_repetir-1));
									}
									$datosEnviar2 = array(
										"id_tarea"=>$id_tarea,
										"fecha_ini"=>$fechaDummy,
										"fecha_fin"=>"".$fechafin."",
										"repetir"=>$dia[$i],
										"opcion"=>"primes",
										"n_repetir"=>$n_repetir,
										"t_repetir"=>$t_repetir
									);
									$this->_sdt->crearSDT_CL_NewTaskCiclo_Model($datosEnviar2);

									if (isset($arrTarea)) {
										foreach ($arrTarea as $key) {
											// almacenar para cada tarea los dias 
											$datosEnviar2 = array(
												"id_tarea"=>$key["id_tarea"],
												"fecha_ini"=>$fechaDummy,
												"fecha_fin"=>"".$fechafin."",
												"repetir"=>$dia[$i],
												"opcion"=>"primes",
												"n_repetir"=>$n_repetir,
												"t_repetir"=>$t_repetir
											);
											$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
										}
									}
								}
							}
						}else{
							$datosEnviar2 = array(
								"id_tarea"=>$id_tarea,
								"fecha_ini"=>$fechaini,
								"fecha_fin"=>"".$fechafin."",
								"repetir"=>7,
								"opcion"=>"primes",
								"n_repetir"=>$n_repetir,
								"t_repetir"=>$t_repetir
							);
							$this->_sdt->crearSDT_CL_NewTaskCiclo_Model($datosEnviar2);

							if (isset($arrTarea)) {
								foreach ($arrTarea as $key) {
									// almacenar para cada tarea los dias 
									$datosEnviar2 = array(
										"id_tarea"=>$key["id_tarea"],
										"fecha_ini"=>$fechaini,
										"fecha_fin"=>"".$fechafin."",
										"repetir"=>7,
										"opcion"=>"primes",
										"n_repetir"=>$n_repetir,
										"t_repetir"=>$t_repetir
									);
									$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
								}
							}
						}
					}
					if ($repetir=="3") {
						$inicio1=$this->getSql("inicio1");
						if (trim($inicio1)=="" || trim($inicio1)=="0") {
							$inicio1=1;
						}
						$datosEnviar2 = array(
							"id_tarea"=>$id_tarea,
							"fecha_ini"=>$fechaini,
							"fecha_fin"=>"".$fechafin."",
							"repetir"=>$inicio1,
							"opcion"=>"inimes",
							"n_repetir"=>$n_repetir,
							"t_repetir"=>$t_repetir
						);
						$this->_sdt->crearSDT_CL_NewTaskCiclo_Model($datosEnviar2);

						if (isset($arrTarea)) {
							foreach ($arrTarea as $key) {
								// almacenar para cada tarea los dias 
								$datosEnviar2 = array(
									"id_tarea"=>$key["id_tarea"],
									"fecha_ini"=>$fechaini,
									"fecha_fin"=>"".$fechafin."",
									"repetir"=>$inicio1,
									"opcion"=>"inimes",
									"n_repetir"=>$n_repetir,
									"t_repetir"=>$t_repetir
								);
								$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
							}
						}
					}
					if ($repetir=="4") {
						$inicio1=$this->getSql("inicio2");
						if (trim($inicio1)=="" || trim($inicio1)=="0") {
							$inicio1=1;
						}
						$datosEnviar2 = array(
							"id_tarea"=>$id_tarea,
							"fecha_ini"=>$fechaini,
							"fecha_fin"=>"".$fechafin."",
							"repetir"=>$inicio1,
							"opcion"=>"finmes",
							"n_repetir"=>$n_repetir,
							"t_repetir"=>$t_repetir
						);
						$this->_sdt->crearSDT_CL_NewTaskCiclo_Model($datosEnviar2);

						if (isset($arrTarea)) {
							foreach ($arrTarea as $key) {
								// almacenar para cada tarea los dias 
								$datosEnviar2 = array(
									"id_tarea"=>$key["id_tarea"],
									"fecha_ini"=>$fechaini,
									"fecha_fin"=>"".$fechafin."",
									"repetir"=>$inicio1,
									"opcion"=>"finmes",
									"n_repetir"=>$n_repetir,
									"t_repetir"=>$t_repetir
								);
								$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
							}
						}
					}
				}
			
			}
			$repetir="";
			$CodehHtml='<div class="col-md-12" ><label for="dias_semana">Seleccione los dias</label><br/><label class="btn btn-primary active"><input type="checkbox" class="select" name="lunes" value="1"> Lunes</label><label class="btn btn-primary active"><input type="checkbox" class="select" name="martes" value="2"> Martes</label><label class="btn btn-primary active"><input type="checkbox" class="select" name="miercoles" value="3"> Miercoles</label><label class="btn btn-primary active"><input type="checkbox" class="select" name="jueves" value="4"> Jueves</label><label class="btn btn-primary active"><input type="checkbox" class="select" name="viernes" value="5"> Viernes</label><label class="btn btn-primary active"><input type="checkbox" class="select" name="sabado" value="6"> Sabado</label><label class="btn btn-primary active"><input type="checkbox" class="select" name="domingo" value="0"> Domingo</label></div>';
			$dias="";
			$dia=date("d");
			$mes=date("m");
			$anio=date("Y");
			$fechaini = $dia . "/" . $mes . "/" . $anio;
			$cant_dias="";
			$fechafin="";
			$n_repetir=1;
			$t_repetir=1;
			$dato = $this->_sdt->getSDT_Tareas_Model_Config($id_tarea);
			$opcion1="none";
			$opcion2="none";
			$opcion3="none";
			$diasX="";
			$numeroDia1="";
			$numeroDia2="";
			if ($dato["fecha_ini"]!="") {
				$mensajeBoton="Modificar periodicidad de la Tarea";
				$diasX[0]="";
				$diasX[1]="";
				$diasX[2]="";
				$diasX[3]="";
				$diasX[4]="";
				$diasX[5]="";
				$diasX[6]="";
				
				$fechaini = $dato["fecha_ini"];
				$fechafin = $dato["fecha_fin"];
				$repetir = $dato["repetir"];
				$n_repetir= $dato["n_repetir"];
				$t_repetir= $dato["t_repetir"];
				
				
				if ($dato["repetir"]==1 || $dato["repetir"]==2) {
					$dia = explode(",", $dato["dias"]);
					$dias=$dato["dias"];
					for ($i=0; $i < count($dia); $i++) {
						if (trim($dia[$i])!="") {
							$diasX[$dia[$i]]="checked";
						}
					}
					$opcion1="inline";
				}else if ($dato["repetir"]==3) {
					$opcion2="inline";
					$numeroDia1=$dato["cant_dias"];
				}else{
					$opcion3="inline";
					$numeroDia2=$dato["cant_dias"];
				}
			}else{
				$opcion1="inline";
				$mensajeBoton="Crear periodicidad de la Tarea";
			}

			$descrip = $this->_sdt->getSDT_CL_NewTaskDescription($id_tarea);
			$this->_view->assign('descrip',$descrip["descripcion"]);

			$this->_view->assign('mensajeBoton',$mensajeBoton);
			$this->_view->assign('opcion1',$opcion1);
			$this->_view->assign('opcion2',$opcion2);
			$this->_view->assign('opcion3',$opcion3);

			$this->_view->assign('diasX',$diasX);
			$this->_view->assign('numeroDia1',$numeroDia1);
			$this->_view->assign('numeroDia2',$numeroDia2);

			$this->_view->assign('dias',$dias);
			$this->_view->assign('repetir',$repetir);
			$this->_view->assign('CodehHtml',$CodehHtml);
			$this->_view->assign('fechaini',$fechaini);
			$this->_view->assign('fechafin',$fechafin);

			$this->_view->assign('n_repetir',($n_repetir=='0')?'1':$n_repetir);
			$this->_view->assign('t_repetir',$t_repetir);

			$tarea = $this->_sdt->getTarea($id_tarea);
			$this->_view->assign('nombre_tarea',$tarea["tarea"]);
			
			$this->_view->assign('grupo',$id_grupo);
			$this->_view->renderizar('crearTareaModelo');
		}
		public function eliminarGrupo(){
			$id=$this->getSql("id");
			if ($id!="") {
				$this->_acl->acceso('todo');
				$tareas = $this->_sdt->getSDT_Tarea_Grupo($id);

				$this->_sdt->eliminarSDT_Tarea_Grupo($id);
				$this->_sdt->eliminarSDT_Grupo($id);
			}
		}
		public function bajarGrupo($id=false){
			$grupo = $this->_sdt->getSDT_Grupo($id);
			

			$this->_acl->acceso('todo');
			if (!$id) {
				$this->redireccionar('sdt/indexGrupos');
				exit();
			}

			$fechahoy = date('d/m/Y', mktime()+$this->_time);
			//$fechahoy = "25/09/2014";

			$id_usuario=Session::get('id_usuario');
			$dat  = $this->_sdt->getSDT_Id_Grupo_Usuario($id,$id_usuario);
			if (is_array($dat)) {
				// almacenar la relacion del grupo con el usuario, asi se podria evitar que baje varias veces el mismo grupo
				$datosEnviar = array(
					"id_grupo_usuario"=>$dat["id_grupo_usuario"],
					"estado"=>1
				);
				$this->_sdt->actualizarSDT_Grupo_Usuario($datosEnviar);
			}else{
				// almacenar la relacion del grupo con el usuario, asi se podria evitar que baje varias veces el mismo grupo
				$datosEnviar = array(
					"id_grupo"=>$id,
					"id_usuario"=>$id_usuario,
					"estado"=>1
				);
				$this->_sdt->crearSDT_Grupo_Usuario($datosEnviar);
			}

			$tareas = $this->_sdt->getSDT_Tarea_Grupo($id);
			foreach ($tareas as $key) {
				$tarea = $this->_sdt->getSDT_Tarea($key["id_tarea"]);
				$dat = $this->_sdt->getSDT_Tarea_Modelo_Usuario($key["id_tarea"],$id_usuario);
				// Obtener la descripcion de las tareas para almacenarlas en las nuevas
				$descrip = $this->_sdt->getSDT_CL_NewTaskDescription($key["id_tarea"]);
				if (!is_array($dat)) {
					// crear la copia de la tarea
					$datosEnviar = array(
						"id_director"=>0,
						"tarea"=>$tarea["tarea"],
						"tipo"=>$tarea["tipo"],
						"siglas"=>$grupo["siglas_grupo"],
						"estado_tarea"=>1,
						"fecha_ini_tarea"=>$fechahoy,
						"tarea_ultimo"=>$id_usuario,
						"id_grupo"=>$id
					);
					$this->_sdt->crearSDT_CL_NewTask($datosEnviar);
					// Codigo agregado para relacionar la atera con el usuario
					// obtenemos el id de esta nueva tarea
					$ultimo = $this->_sdt->ultimoSDT_Task($id_usuario);

					// Esta relacion es creada para actualizar las tareas clonadas del modelo
					$datosEnviar = array(
						"id_tarea"=>$ultimo["id_tarea"],
						"id_modelo"=>$tarea["id_tarea"]
					);
					$this->_sdt->crearSDT_Tareas_Modelo($datosEnviar);

					$datosEnviar = array(
						"id_tarea"=>$ultimo["id_tarea"],
						"id_usuario"=>Session::get('id_usuario')
					);
					$this->_sdt->crearSDT_Tarea_Usuario($datosEnviar);

					// Crear descripcion
					$datosEnviar = array(
						"id_tarea"=>$ultimo["id_tarea"],
						"descripcion"=>$descrip["descripcion"]
					);
					$this->_sdt->crearSDT_CL_NewTaskDescription($datosEnviar);

				}else{
					$ultimo = $dat;
					$datosEnviar = array(
						"id_tarea"=>$ultimo["id_tarea"],
						"estado_tarea"=>1
					);
					$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);
				}

				// Obtener la configuracion de la tarea
				$clone = $this->_sdt->getSDT_Tareas_Repetir_Clone($tarea["id_tarea"]);
				foreach ($clone as $key2) {
					$resu = $this->_dateUtils->restarFechas($fechahoy,$key2["fecha_ini"]);
					$fechaInicial=$key2["fecha_ini"];
					if ($resu<0) {
						//$fechahoy=$key2["fecha_ini"];

						$numciclos = $this->_dateUtils->restarFechas($fechahoy, $key2["fecha_ini"]);
						// Si la resta es positiva, entonces la fecha es supero al limite inferior
						//if ($numciclos<=0) {
						if ($numciclos<=0) {
							if ($key2["repetir"]!="0") {
								$numciclos=-1*$numciclos;
								$numciclos = ceil($numciclos/$key2["repetir"]);
							}
						}else{
							$numciclos = 0;
						}

						$estar=true;
						if ($key2["opcion"]=="") {
							// Obtengo la siguientes fechas
							$fecha = $this->_dateUtils->operarAFecha($key2["fecha_ini"], $numciclos*$key2["repetir"]);
							$num =0;
							if ($key2["fecha_fin"]!="") {
								$num = $this->_dateUtils->restarFechas($fecha, $key2["fecha_fin"]);
							}
							if ($num<0)	 {
								$fechaInicial="";
							}else{
								$fechaInicial=$fecha;
							}
						}elseif ($key2["opcion"]=="primes") {

							$fechaDummy = $fechahoy;
							if ($key2["t_repetir"]==1) {
								//Saco el primer "lunes" del mes
								$fechaDummy = $this->primerDiaMes($fechaDummy);
								$fechaDummy = $this->primerDia($fechaDummy,$key2["repetir"]);
								// le sumo las semnas
								$fechaDummy = $this->_dateUtils->operarAFecha($fechaDummy,7*($key2["n_repetir"]-1));
								// si el dia excede al dia de hoy paso al siguiente mes
								$dife = $this->_dateUtils->restarFechas($fechahoy,$fechaDummy);
								if ($dife<0) {
									$fechaDummy = $this->incrementarMes($fechaDummy);
									$fechaDummy = $this->primerDiaMes($fechaDummy,$key2["repetir"]);
									$fechaDummy = $this->primerDia($fechaDummy,$key2["repetir"]);
									$fechaDummy = $this->_dateUtils->operarAFecha($fechaDummy,7*($n_repetir-1));
								}
							}


							// $dife = $this->_dateUtils->restarFechas($key2["fecha_ini"],$fechahoy);
							// // $fechaFormat = $this->_dateUtils->formatearFecha($fechahoy);
							// if ($dife<0) {
							// 	// debo incrementar en un mes la fecha inicial
							// 	$fecha = $this->incrementarMes($fechahoy);
							// }else{
							// 	$fecha=$this->primerDiaMes($fechahoy);
							// }							
							// if ($key2["repetir"]!="7") {
							// 	$fecha = $this->primerDia($fecha,$key2["repetir"]);
							// }
							// $num=0;
							$fecha = $fechaDummy;
							if ($key2["fecha_fin"]!="") {
								$num = $this->_dateUtils->restarFechas($fecha, $key2["fecha_fin"]);
							}
							if ($num<0)	 {
								$fechaInicial="";
							}else{
								$fechaInicial=$fecha;
							}
						}else if ($key2["opcion"]=="inimes") {
							$dife = $this->_dateUtils->restarFechas($key2["fecha_ini"],$fechahoy);
							$fechaFormat = $this->_dateUtils->formatearFecha($fechahoy);
							if ($dife<0) {
								$fecha = $this->incrementarMes($fechahoy);
							}else{
								$fecha = $this->primerDiaMes($fechahoy);
								$dife = $this->_dateUtils->restarFechas($key2["fecha_ini"],$fecha);
								if ($dife>0) {
									$fecha = $this->incrementarMes($fechahoy);
								}
							}
							$fecha = $this->_dateUtils->operarAFecha($fecha,($key2["repetir"]-1));
							$num=0;
							if ($repetir[$i]["fecha_fin"]!="") {
								$num = $this->_dateUtils->restarFechas($fecha, $key2["fecha_fin"]);
							}
							if ($num<0)	 {
								$fechaInicial="";
							}else{
								$fechaInicial=$fecha;
							}
						}else if ($key2["opcion"]=="finmes") {
							$dife = $this->_dateUtils->restarFechas($key2["fecha_ini"],$fechahoy);
							$fechaFormat = $this->_dateUtils->formatearFecha($fechahoy);
							if ($dife<0) {
								// debo incrementar en un mes la fecha inicial
								$fecha = $this->incrementarMes($fechahoy);
							}else{
								$fecha = $this->primerDiaMes($fechahoy);
							}
							$fecha2 = $this->_dateUtils->operarAFecha($fecha,-($key2["repetir"]-1));
							$num=0;
							if ($key2["fecha_fin"]!="") {
								$num = $this->_dateUtils->restarFechas($fecha2, $key2["fecha_fin"]);
							}
							if ($num<0)	 {
								$fechaInicial="";
							}else{
								$fechaInicial=$fecha;
							}
						}
					}
					if ($fechaInicial!="") {
						# evitar que se dupliquen las caracteristicas de la tarea
						$datosEnviar2 = array(
							"id_tarea"=>$ultimo["id_tarea"],
							"fecha_ini"=>$fechaInicial, //$key2["fecha_ini"],
							"fecha_fin"=>"".$key2["fecha_fin"]."",
							"repetir"=>$key2["repetir"],
							"opcion"=>$key2["opcion"],
							"n_repetir"=>$key2["n_repetir"],
							"t_repetir"=>$key2["t_repetir"]
						);
						$this->_sdt->crearSDT_CL_NewTaskCiclo($datosEnviar2);
					}
				}
			}
			$this->redireccionar('sdt/indexGrupo');
			exit();
		}
		public function subirGrupo($id=false){
			$this->_acl->acceso('todo');
			if (!$id) {
				$this->redireccionar('sdt/indexGrupos');
				exit();
			}

			
			$id_usuario = Session::get('id_usuario');
			$fechahoy = date('d/m/Y', mktime()+$this->_time);
			//$fechahoy = "08/09/" . $anio;
			$fechaayer = $this->_dateUtils->operarAFecha($fechahoy,-1);

			$tareas = $this->_sdt->getSDT_Tarea_Grupo_Usuario($id,$id_usuario);
			foreach ($tareas as $key) {
				// Primero borrar el contenido de dias
				// Eliminar todas las unidades de tiempo que sean igual o menor a la fecha inicial 
				$diasSS = $this->_sdt->getSDT_Tareas_Repetir($key["id_tarea"]);
				foreach ($diasSS as $key2) {
					$nume = $this->_dateUtils->restarFechas($fechahoy, $key2["fecha_ini"]);
					if ($nume>0) {
						# Borrar el registro
						$this->_sdt->eliminarSDT_Tareas_Repetir($key2["id_dia"]);
					}else{
						if ($key2["fecha_fin"]=="") {
							# Actualizar la fecha final
							$datosEnviar = array(
								"id_dia"=>$key2["id_dia"],
								"fecha_fin"=>"".$fechaayer.""
							);
							$this->_sdt->actualizarSDT_Tareas_Repetir($datosEnviar);
						}else{
							$nume = $this->_dateUtils->restarFechas($fechahoy, $key2["fecha_fin"]);
							if ($nume>0) {
								# Actualizar la fecha final
								$datosEnviar = array(
									"id_dia"=>$key2["id_dia"],
									"fecha_fin"=>"".$fechaayer.""
								);
								$this->_sdt->actualizarSDT_Tareas_Repetir($datosEnviar);
							}
						}
					}
				}
				$datosEnviar = array(
					"id_tarea"=>$key["id_tarea"],
					"estado_tarea"=>9
				);
				$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);
			}
			$relac = $this->_sdt->getSDT_Id_Grupo_Usuario($id,$id_usuario);
			$datosEnviar = array(
				"id_grupo_usuario"=>$relac["id_grupo_usuario"],
				"estado"=>0
			);
			$this->_sdt->actualizarSDT_Grupo_Usuario($datosEnviar);
			$this->redireccionar('sdt/indexGrupo');
			exit();


		}
		private function defaultEtiquetas(){
			$numero = $this->_sdt->getSDTLast_Etiquetas();
			if ($numero["id_etiqueta"]=="") {
				$numero["id_etiqueta"]=0;
			}
			$id_us = Session::get('id_usuario');
			$datosEnviar[1] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Importante",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#ffe527"
				);
			$datosEnviar[2] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Operacion",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#dc6519"
				);
			$datosEnviar[3] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Administrativo",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#293cff"
				);
			$datosEnviar[4] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Actividades Extra",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#771edc"
				);
			$datosEnviar[5] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Personal",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#287d17"
				);
			$datosEnviar[6] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Proyectos de mejora",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#f0a7a5"
				);
			$datosEnviar[7] = array(
					"id_usuario" => $id_us,
					"nombre_etiqueta"=>"Otros",
					"ffamily"=>"Klavika",
					"fsize"=>14,
					"fcolor"=>"#000000",
					"fcback"=>"#7d7980"
				);

				$this->_sdt->crearSDT_Etiqueta($datosEnviar[1]);

				$numero["id_etiqueta"]+=1;
				$arreglo[1]["id_etiqueta"]=$numero["id_etiqueta"];
				$arreglo[1]["nombre_etiqueta"]="Importante";
				$arreglo[1]["ffamily"]="Klavika";
				$arreglo[1]["fsize"]=14;
				$arreglo[1]["fcolor"]="#000000";
				$arreglo[1]["fcback"]="#ffe527";

				
				$this->_sdt->crearSDT_Etiqueta($datosEnviar[2]);

				$numero["id_etiqueta"]+=1;
				$arreglo[2]["id_etiqueta"]=$numero["id_etiqueta"];
				$arreglo[2]["nombre_etiqueta"]="Operacion";
				$arreglo[2]["ffamily"]="Klavika";
				$arreglo[2]["fsize"]=14;
				$arreglo[2]["fcolor"]="#000000";
				$arreglo[2]["fcback"]="#dc6519";

				$this->_sdt->crearSDT_Etiqueta($datosEnviar[3]);

				$numero["id_etiqueta"]+=1;
				$arreglo[3]["id_etiqueta"]=$numero["id_etiqueta"];
				$arreglo[3]["nombre_etiqueta"]="Administrativo";
				$arreglo[3]["ffamily"]="Administrativo";
				$arreglo[3]["fsize"]=14;
				$arreglo[3]["fcolor"]="#000000";
				$arreglo[3]["fcback"]="#293cff";

				
				$this->_sdt->crearSDT_Etiqueta($datosEnviar[4]);

				$numero["id_etiqueta"]+=1;
				$arreglo[4]["id_etiqueta"]=$numero["id_etiqueta"];
				$arreglo[4]["nombre_etiqueta"]="Actividades Extra";
				$arreglo[4]["ffamily"]="Klavika";
				$arreglo[4]["fsize"]=14;
				$arreglo[4]["fcolor"]="#000000";
				$arreglo[4]["fcback"]="#771edc";

				
				$this->_sdt->crearSDT_Etiqueta($datosEnviar[5]);

				$numero["id_etiqueta"]+=1;
				$arreglo[5]["id_etiqueta"]=$numero["id_etiqueta"];
				$arreglo[5]["nombre_etiqueta"]="Personal";
				$arreglo[5]["ffamily"]="Klavika";
				$arreglo[5]["fsize"]=14;
				$arreglo[5]["fcolor"]="#000000";
				$arreglo[5]["fcback"]="#287d17";

				
				$this->_sdt->crearSDT_Etiqueta($datosEnviar[6]);

				$numero["id_etiqueta"]+=1;
				$arreglo[6]["id_etiqueta"]=$numero["id_etiqueta"];
				$arreglo[6]["nombre_etiqueta"]="Proyectos de mejora";
				$arreglo[6]["ffamily"]="Klavika";
				$arreglo[6]["fsize"]=14;
				$arreglo[6]["fcolor"]="#000000";
				$arreglo[6]["fcback"]="#f0a7a5";

				
				$this->_sdt->crearSDT_Etiqueta($datosEnviar[7]);

				$numero["id_etiqueta"]+=1;
				$arreglo[7]["id_etiqueta"]=$numero["id_etiqueta"];
				$arreglo[7]["nombre_etiqueta"]="Otros";
				$arreglo[7]["ffamily"]="Klavika";
				$arreglo[7]["fsize"]=14;
				$arreglo[7]["fcolor"]="#000000";
				$arreglo[7]["fcback"]="#7d7980";
			return $arreglo;
		}
		private function encontrarRango($rango="dia",$dia=false, $mes=false, $anio=false){
			
			if (!$dia || !$mes || !$anio) {
				$dia=date("d");
				$mes=date("m");
				$anio=date("Y");
			}
			$dates = array();
			if ($rango=="trimestre") {
				if ($mes<4) {
					$trimetre=1;
					$dates['inicio']='01/01/' . $anio;
					$dates['fin']='01/04/' . $anio;
					$dates['titulo_vista'] = "Trimestre 1 " . $anio;
				}else if ($mes<7) {
					$trimetre=2;
					$dates['inicio']='01/04/'. $anio;
					$dates['fin']='01/07/'. $anio;
					$dates['titulo_vista'] = "Trimestre 2 " . $anio;
				}else if ($mes<10) {
					$trimetre=3;
					$dates['inicio']='01/07/'. $anio;
					$dates['fin']='01/10/'. $anio;
					$dates['titulo_vista'] = "Trimestre 3 " . $anio;
				}else{
					$trimetre=4;
					$dates['inicio']='01/10/'. $anio;
					$dates['fin']='01/01/'. ($anio+1);
					$dates['titulo_vista'] = "Trimestre 4 " . $anio;
				}
			}else if ($rango=="mes") {
				$dates['inicio']='01/'.$mes.'/'. $anio;
				$mesD["01"]="Enero";
				$mesD["02"]="Febrero";
				$mesD["03"]="Marzo";
				$mesD["04"]="Abril";
				$mesD["05"]="Mayo";
				$mesD["06"]="Junio";
				$mesD["07"]="Julio";
				$mesD["08"]="Agosto";
				$mesD["09"]="Septiembre";
				$mesD["10"]="Octubre";
				$mesD["11"]="Noviembre";
				$mesD["12"]="Diciembre";
				$dates['titulo_vista'] = $mesD[$mes]. " " . $anio;
				if ($mes+1>12) {
					$mes=0;
					$anio+=1;
				}
				$dates['fin']="01".'/'.($mes+1).'/'. $anio;
			}else if ($rango=="semana") {
				$numdia = date('w', mktime(0, 0, 0, $mes, $dia, $anio));
				$dife1=0;
				$dife1=1-($numdia);
				$dife2=8-$numdia;
				$fecha = $dia . "/" . $mes . "/" . $anio;
				$tiempo1 = $this->_dateUtils->operarAFecha($fecha,$dife1);
				$dates['inicio']= $tiempo1;
				$tiempo2 = $this->_dateUtils->operarAFecha($dates['inicio'],7,"dias",10000);
				$dates['fin']=$tiempo2;

				$tiempo2 = $this->_dateUtils->operarAFecha($tiempo2,-1);
				$fecha = $this->_dateUtils->formatearFecha($tiempo2);
				$semana = date('W', mktime(0, 0, 0, $fecha["mes"], $fecha["dia"], $fecha["anio"]));
				$dates['titulo_vista'] = "Semana " . $semana . " " . $fecha["anio"];
			}
			return $dates;
		}
		private function encontrarMes(){
			//f = k + [(13*m-1)/5] + D + [D/4] + [C/4] - 2*C
		}
		public function crearLinea(){
			$fecha=$this->getSql("fecha");
			$numeracion=$this->getSql("numeracion");
			$orden=$this->getSql("orden");
			$texto=$this->getTexto("texto");
			$texto = $this->trans_ch_special($texto);
			$tachado=$this->getSql("tachado");
			$etiqueta=$this->getTexto("etiqueta");
			if ($fecha!="" && $numeracion!="" && $tachado!="") {
				$orden = (int) $orden;
				$datosEnviar = array(
					"usuario"=>Session::get('id_usuario'),
					"fecha"=>$fecha,
					"numeracion"=>$numeracion,
					"orden"=>$orden,
					"texto"=>trim($texto),
					"tachado"=>$tachado,
					"id_etiqueta"=>$etiqueta
				);
				$this->_sdt->crearSDT_RM_NewLine($datosEnviar);
				$id_n = $this->_sdt->ultimoSDT_RM_Line(Session::get('id_usuario'));
				echo json_encode($id_n["id"]);
			}else{
				echo json_encode("None");
			}
		}
		// Transforma a caractarees especiales el mensaje
		// que fueron cambiados en el plugin
		private function trans_ch_special($texto=""){
			$SpecialCh = array(
				'||igu||' => "=", 
				'||mas||' => "+",
				'||ans||' => "&",
				);
			foreach ($SpecialCh as $key => $value) {
				$texto = str_replace($key, $value, $texto);
			}
			return $texto;
		}
		public function actualizarLineaTexto(){
			$id=$this->getSql("id");
			$numeracion=$this->getSql("numeracion");
			$orden=$this->getSql("orden");
			$texto=$this->getTexto("texto");

			$texto = $this->trans_ch_special($texto);

			$tachado=$this->getSql("tachado");
			$etiqueta=$this->getTexto("etiqueta");
			if ($id!="" && $numeracion!="" && $tachado!="") {
				$orden = (int) $orden;
				$datosEnviar = array(
					"id"=>$id,
					"numeracion"=>$numeracion,
					"orden"=>$orden,
					"texto"=>trim($texto),
					"tachado"=>$tachado,
					"id_etiqueta"=>$etiqueta
				);
				$this->_sdt->actualizarSDT_RM_Line($datosEnviar);
			}
		}
		public function eliminarRMLinea(){
			$id=$this->getSql("id");
			if ($id!=""){
				$this->_sdt->eliminarSDT_RM_Line($id);
			}
		}
		public function getDias(){
			$fecha=$this->getSql("fecha");
			if ($fecha!=""){
				$datos=$this->_sdt->getDias_SDT_RM(Session::get('id_usuario'),$fecha);
				$cadena="-";
				$cadena2="-";
				foreach ($datos as $dato) {
					$dia = substr($dato["fecha"],0,2);
					if (strstr($cadena, "-".$dia."-")==0) {
						$cadena=$cadena.$dia."-";
					}
					if ($dato["tachado"]=="0") {
						if (strstr($cadena2, "-".$dia."-")==0) {
							$cadena2=$cadena2.$dia."-";
						}
					}
				}
				echo json_encode($cadena."+".$cadena2);
			}
		}
		public function actualizarOrdenTarea(){
			$id=$this->getSql("id");
			$orden=$this->getSql("orden");
			if ($id!="" && $orden!="") {
				$orden = (int) $orden;
				$id = (int) $id;
				$id_usuario = Session::get('id_usuario');
				# Ver si el registro en la tabla de orden fue creado
				$ordenR = $this->_sdt->getSDT_chlist_orden($id,$id_usuario);
				if (is_array($ordenR)) {
					$datosEnviar = array(
						"id_ch_orden"=>$ordenR["id_ch_orden"],
						"orden"=>$orden
					);
					$this->_sdt->actualizarSDT_chlist_orden($datosEnviar);
				}else{
					$datosEnviar = array(
						"id_tarea"=>$id,
						"id_usuario"=>$id_usuario,
						"orden"=>$orden
					);
					$this->_sdt->crearSDT_chlist_orden($datosEnviar);
				}
			}
		}
		public function guardarTareaDia(){
			$id=$this->getSql("tarea");
			$fecha=$this->getSql("fecha");
			$estado=$this->getSql("estado");
			if ($id!="" && $fecha!="" && $estado!="") {
				$id = (int) $id;
				$estado = (int) $estado;
				$prioridad = $this->_sdt->getTarea($id);
				$datosEnviar = array(
					"id_tarea"=>$id,
					"fecha"=>$fecha,
					"estado"=>$estado,
					"mover"=>"drag",
					"prioridad"=>$prioridad["tarea_prioridad"]
				);
				$this->_sdt->crearSDT_CL_Task_Dia($datosEnviar);

				$id_n = $this->_sdt->ultimoSDT_CL_Days_Line($id);
				echo json_encode($id_n["id_dia"]);
			}else{
				echo json_encode("None");
			}
		}
		public function guardarTareaDiaClone(){
			$id=$this->getSql("tarea");
			$idtemp=$this->getSql("idtemp");
			$fecha=$this->getSql("fecha");
			$estado=$this->getSql("estado");
			if ($id!="" && $idtemp!="" && $fecha!="" && $estado!="") {
				$id = (int) $id;
				$estado = (int) $estado;
				if ($id!=0) {
					$datosEnviar = array(
						"id_tarea"=>$id,
						"fecha"=>$fecha,
						"estado"=>$estado,
						"mover"=>"drag"
					);
					$this->_sdt->crearSDT_CL_Task_Dia($datosEnviar);

					$id_n = $this->_sdt->ultimoSDT_CL_Days_Line($id);
					echo json_encode($id_n["id_dia"]."_".$idtemp);
				}else{
					echo json_encode("None");
				}
			}else{
				echo json_encode("None");
			}
		}
		public function actualizarTareaDia(){
			$id_dia=$this->getSql("dia");
			$id_tarea=$this->getSql("tarea");
			$fecha=$this->getSql("fecha");
			if ($id_dia!="" && $id_tarea!="" && $fecha!="") {
				$id_dia = (int) $id_dia;
				$id_tarea = (int) $id_tarea;
				if ($id_dia!=0 && $id_tarea!=0) {
					$datosEnviar = array(
						"id_dia"=>$id_dia,
						"id_tarea"=>$id_tarea,
						"fecha"=>$fecha
					);
					$this->_sdt->actualizarSDT_CL_Task_Dia($datosEnviar);
				}
			}
		}
		public function actualizarTareaEstado(){
			$id_dia=$this->getSql("dia");
			$estado=$this->getSql("estado");
			$fecha=$this->getSql("fecha");
			if ($id_dia!="" && $estado!="") {
				$pos = strpos($id_dia, "r");
				$id_usuario = Session::get('id_usuario');
				if ($pos === false) {
					$id_dia = (int) $id_dia;
					$estado = (int) $estado;

					$permitir=false;
					$diaaa = $this->_sdt->getSDT_Dia($id_dia);
					$tarrrr = $this->_sdt->getTarea($diaaa["id_tarea"]);
					if (is_array($tarrrr)) {
						$estado_tarea=$tarrrr["estado_tarea"];
						if ($tarrrr["id_director"]==0) {
							$permitir=true;
						}elseif ($tarrrr["id_director"]==$id_usuario) {
							$permitir=true;
							if ($tarrrr["id_responsable"]!=$tarrrr["id_director"]) {
								$estado_tarea=0;
							}
						}elseif ($tarrrr["id_responsable"]==$id_usuario && $tarrrr["estado_tarea"]==1) {
							$permitir=true;
						}
						if ($permitir) {
							// es aqui en donde se debe actualizar el porcentaje
							$datosEnviar = array(
								"id_dia"=>$id_dia,
								"estado"=>$estado
							);
							$this->_sdt->actualizarSDT_CL_Task_Dia($datosEnviar);
						}
					}
					echo json_encode("None");
				}else{
					$pos = strpos($id_dia, "r");

					$permitir=false;
					$tarrrr = $this->_sdt->getTarea(substr($id_dia, $pos+1));
					$estado_tarea=$tarrrr["estado_tarea"];
					if (is_array($tarrrr)) {
						$estado_tarea=$tarrrr["estado_tarea"];
						if ($tarrrr["id_director"]==0) {
							$permitir=true;
						}elseif ($tarrrr["id_director"]==$id_usuario) {
							$permitir=true;
							if ($tarrrr["id_responsable"]!=$tarrrr["id_director"]) {
								$estado_tarea=0;
							}
						}elseif ($tarrrr["id_responsable"]==$id_usuario && $tarrrr["estado_tarea"]==1) {
							$permitir=true;
						}
						if ($permitir) {
							$datosEnviar = array(
								"id_tarea"=>substr($id_dia, $pos+1),
								"fecha"=>$fecha,
								"estado"=>$estado,
								"mover"=>"nodrag"
							);
							$this->_sdt->crearSDT_CL_Task_Dia($datosEnviar);
							$id_n = $this->_sdt->ultimoSDT_CL_Days_Line(substr($id_dia, $pos+1));
							echo json_encode($id_n["id_dia"]);
						}
					}
					if (!$permitir) {
						echo json_encode("None");
					}
				}
			}else{
				echo json_encode("None");
			}
			// $pos = strpos($id_dia, "r");
			// echo json_encode($pos);
		}
		public function actualizarHTD_Prioridad(){
			$id_dia=$this->getSql("dia");
			$prioridad=$this->getSql("prioridad");
			if ($id_dia!="" && $prioridad!="") {
				$datosEnviar = array(
					"id_dia"=>$id_dia,
					"prioridad"=>$prioridad
				);
				$this->_sdt->actualizarSDT_CL_Task_Dia($datosEnviar);
				echo "Good";
			}else{
				echo json_encode("None");
			}
		}
		public function trasladarHTDUnidad(){
			$id_dia=$this->getSql("dia");
			$fecha_traslado=$this->getSql("fecha");
			$obj_json=$this->getSql("obj_json");
			if ($id_dia!="" && $fecha_traslado!="") {
				$dia = $this->_sdt->getSDT_Dia($id_dia);
				$tarea = $this->_sdt->getTarea($dia["id_tarea"]);

				$datosEnviar = array(
					"id_tarea"=>$tarea["id_tarea"],
					"fecha"=>$fecha_traslado,
					"estado"=>0,
					"mover"=>"drag",
					"prioridad"=>$dia["prioridad"],
					"fecha_anterior"=>$dia["fecha"],
					"id_dia_anterior"=>$id_dia
				);
				$this->_sdt->crearSDT_CL_Task_Dia($datosEnviar);
				$id_n = $this->_sdt->ultimoSDT_CL_Days_Line($tarea["id_tarea"]);

				$datosEnviar = array(
					"id_dia"=>$id_dia,
					"estado"=>2,
					"fecha_posterior"=>$fecha_traslado,
					"id_dia_posterior"=>$id_n["id_dia"]
				);
				$this->_sdt->actualizarSDT_CL_Task_Dia($datosEnviar);

				$newDaro = array(
					"id_dia"=>$id_n["id_dia"],
					"fecha"=>$fecha_traslado,
					"fecha_vieja"=>$dia["fecha"],
					"estado"=>0,
					"texto"=>$tarea["tarea"],
					"prioridad"=>$dia["prioridad"],
					"obj_json"=>$obj_json
					);
				echo json_encode($newDaro);
			}else{
				echo json_encode("None");
			}
		}
		public function darporcenTarea(){
			$id_tarea=$this->getSql("tarea");
			$inc=$this->getSql("inc");
			if ($id_tarea!="") {
				$id_tarea = (int) $id_tarea;
				$inc = (int) $inc;
				if ($id_tarea!=0) {
					$porcen="00.00";
					$datos = $this->_sdt->getDaysTask($id_tarea);
					$con=0;
					$con2=0;

					# econtrar el rango de vida de la tarea
					$nume1="inicio";
					$nume2="inicio";
					$fecha1="";
					$fecha2="";
					foreach ($datos as $key) {
						if ($key["id_dia"]!=$inc) {

							$fecha = explode("/", $key["fecha"]);
							$nume = mktime(0, 0, 0, $fecha[1], $fecha[0], $fecha[2]);
							if ($nume1=="inicio") {
								$nume1=$nume;
								$nume2=$nume;
								$fecha1=$key["fecha"];
								$fecha2=$key["fecha"];
							}elseif ($nume<$nume1) {
								$nume1=$nume;
								$fecha1=$key["fecha"];
							}elseif ($nume>$nume2) {
								$nume2=$nume;
								$fecha2=$key["fecha"];
							}

							$con+=1;
							if ($key["estado"]!=0 && $key["estado"]!=3) {
								$con2+=1;
							}
						}
					}
					if ($con>0 && $con2>0) {
						$porcen=number_format($con2/$con*100, 2);
					}

					$tarrrr = $this->_sdt->getTarea($id_tarea);
					if (is_array($tarrrr)) {
						$estado_tarea=$tarrrr["estado_tarea"];
						if ($tarrrr["id_director"]==Session::get('id_usuario')) {
							if ($tarrrr["id_responsable"]!=$tarrrr["id_director"]) {
								$estado_tarea=0;
							}
						}
						$datosEnviar = array(
							"id_tarea"=>$id_tarea,
							"porcentaje"=>$porcen,
							"estado_tarea"=>$estado_tarea,
							"fecha_ini_tarea"=>$fecha1,
							"fecha_fin_tarea"=>$fecha2
						);
						$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);
					}else{
						$datosEnviar = array(
							"id_tarea"=>$id_tarea,
							"porcentaje"=>$porcen,
							"fecha_ini_tarea"=>$fecha1,
							"fecha_fin_tarea"=>$fecha2
						);
						$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);
					}
					echo json_encode($porcen."_".$estado_tarea);
				}else{
					echo json_encode("None");
				}
			}else{
				echo json_encode("None");
			}
		}
		private function porcentajeTarea($id_tarea){
			$datos = $this->_sdt->getDaysTask($id_tarea);
			$con=0;
			$con2=0;
			foreach ($datos as $key) {
				$con+=1;
				if ($key["estado"]!=0 && $key["estado"]!=3) {
					$con2+=1;
				}
			}
			$porcen="00.00";
			if ($con>0 && $con2>0) {
				$porcen=number_format($con2/$con*100, 2);
			}
			$datosEnviar = array(
				"id_tarea"=>$id_tarea,
				"porcentaje"=>$porcen
			);
			$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);
		}
		public function eliminarTareaDia(){
			$id_dia=$this->getSql("objeto");
			if ($id_dia!="") {
				$id_dia = (int) $id_dia;
				if ($id_dia!=0) {
					$this->_sdt->eliminarSDT_CL_Task_Day($id_dia);
				}
			};
		}
		public function eliminarTareaProyecto(){
			$id_tarea=$this->getSql("id");
			if ($id_tarea!="") {
				$id_tarea = (int) $id_tarea;
				$this->_sdt->eliminarSDT_CL_Task_1($id_tarea);
				$this->_sdt->eliminarSDT_CL_Task_2($id_tarea);
				$this->_sdt->eliminarSDT_CL_Task_3($id_tarea);
				$this->_sdt->eliminarSDT_CL_Task_4($id_tarea);
				$this->_sdt->eliminarSDT_CL_Task_5($id_tarea);
			};
		}
		public function eliminarTareaGrupo(){
			$id_tarea=$this->getSql("id");
			if ($id_tarea!="") {
				$id_tarea = (int) $id_tarea;
				$tareas = $this->_sdt->getSDT_Tarea_Modelo($id_tarea);
				foreach ($tareas as $key) {
					$this->_sdt->eliminarSDT_CL_Task_1($key["id_tarea"]);
					$this->_sdt->eliminarSDT_CL_Task_2($key["id_tarea"]);
					$this->_sdt->eliminarSDT_CL_Task_3($key["id_tarea"]);
					$this->_sdt->eliminarSDT_CL_Task_4($key["id_tarea"]);
					$this->_sdt->eliminarSDT_CL_Task_6($key["id_tarea"]);
				}
				$this->_sdt->eliminarSDT_CL_Task_1($id_tarea);
				$this->_sdt->eliminarSDT_CL_Task_2($id_tarea);
				$this->_sdt->eliminarSDT_CL_Task_3($id_tarea);
				$this->_sdt->eliminarSDT_CL_Task_4($id_tarea);
				$this->_sdt->eliminarSDT_CL_Task_6($id_tarea);
			};
		}
		public function eliminarProyecto(){
			// $id_proyecto=$this->getSql("id");
			// if ($id_proyecto!="") {
			// 	$id_proyecto = (int) $id_proyecto;
			// 	$variable = $this->_sdt->getTareasProyecto2($id_proyecto);
			// 	foreach ($variable as $key) {
			// 		$this->_sdt->eliminarSDT_CL_Task_1($key["id_tarea"]);
			// 		$this->_sdt->eliminarSDT_CL_Task_2($key["id_tarea"]);
			// 		$this->_sdt->eliminarSDT_CL_Task_3($key["id_tarea"]);
			// 		$this->_sdt->eliminarSDT_CL_Task_4($key["id_tarea"]);
			// 		$this->_sdt->eliminarSDT_CL_Task_5($key["id_tarea"]);
			// 	}
			// 	$this->_sdt->eliminarProyecto_Tarea($id_proyecto);
			// 	$this->_sdt->eliminarProyecto($id_proyecto);
			// };
		}
		public function actualizarEtiquetaNombre(){
			$id_etiqueta=$this->getSql("iden");
			$nombre=$this->getSql("nombre");
			if ($id_etiqueta!="") {
				$id_etiqueta = (int) $id_etiqueta;
				$datosEnviar = array(
					"id_etiqueta"=>$id_etiqueta,
					"nombre_etiqueta"=>$nombre
				);
				$this->_sdt->actualizarEtiqueta($datosEnviar);
			};
		}
		public function actualizarEtiquetaBcolor(){
			$id_etiqueta=$this->getSql("iden");
			$color_fondo=$this->getTexto("bcolor");
			if ($id_etiqueta!="") {
				$id_etiqueta = (int) $id_etiqueta;
				$datosEnviar = array(
					"id_etiqueta"=>$id_etiqueta,
					"fcback"=>$color_fondo
				);
				$this->_sdt->actualizarEtiqueta($datosEnviar);
			};
		}
		public function actualizarEtiquetaColor(){
			$id_etiqueta=$this->getSql("iden");
			$color_letra=$this->getTexto("color");
			if ($id_etiqueta!="") {
				$id_etiqueta = (int) $id_etiqueta;
				$datosEnviar = array(
					"id_etiqueta"=>$id_etiqueta,
					"fcolor"=>$color_letra
				);
				$this->_sdt->actualizarEtiqueta($datosEnviar);
			};
		}
		public function actualizarEtiquetaFamily(){
			$id_etiqueta=$this->getSql("iden");
			$fuente=$this->getTexto("family");
			if ($id_etiqueta!="") {
				$id_etiqueta = (int) $id_etiqueta;
				$datosEnviar = array(
					"id_etiqueta"=>$id_etiqueta,
					"ffamily"=>$fuente
				);
				$this->_sdt->actualizarEtiqueta($datosEnviar);
			};
		}
		public function actualizarEtiquetaSize(){
			$id_etiqueta=$this->getSql("iden");
			$tamanio=$this->getTexto("size");
			if ($id_etiqueta!="") {
				$id_etiqueta = (int) $id_etiqueta;
				$datosEnviar = array(
					"id_etiqueta"=>$id_etiqueta,
					"fsize"=>$tamanio
				);
				$this->_sdt->actualizarEtiqueta($datosEnviar);
			};
		}

		public function getEtiquet(){
			$id_etiqueta=$this->getSql("eti");
			if ($id_etiqueta!="") {
				$id_etiqueta = (int) $id_etiqueta;
				echo json_encode($this->_sdt->getEtiquetaById($id_etiqueta));
			}else{
				echo json_encode("None");
			}
		}
		public function cambiarResponsable(){
			$ids=$this->getSql("id");
			$id_re = explode("_", $ids);
			if ($ids!="" && count($id_re)==3) {
				$id_tarea = (int) $id_re[0];
				$id_responsable0 = (int) $id_re[1];
				$id_responsable1 = (int) $id_re[2];
				$datosEnviar = array(
					"id_tarea"=>$id_tarea,
					"id_responsable"=>$id_responsable1
				);
				$this->_sdt->actualizarSDT_CL_Task_Orden($datosEnviar);

				# consultar si ya existe la relacion con el anterior responsable
				$rela0 = $this->_sdt->getSDT_Tarea_Uruario($id_tarea, $id_responsable0);
				if (is_array($rela0)) {
					$rela1 = $this->_sdt->getSDT_Tarea_Uruario($id_tarea, $id_responsable1);
					if (!is_array($rela1)) {
						$datosEnviar = array(
							"id_tar_usu"=>$rela0["id_tar_usu"],
							"id_usuario"=>$id_responsable1
						);
						$this->_sdt->actualizarSDT_Tarea_Usuario($datosEnviar);
						$tarea = $this->_sdt->getTarea($id_tarea);
						$rela1 = $this->_sdt->getSDT_Tarea_Uruario($id_tarea, $tarea["id_director"]);
						if (!is_array($rela1)) {
							$datosEnviar = array(
								"id_tarea"=>$id_tarea,
								"id_usuario"=>$tarea["id_director"]
							);
							$this->_sdt->crearSDT_Tarea_Usuario($datosEnviar);
						}
					}else{
						# eliminar y crear otro
						$this->_sdt->eliminarSDT_Tarea_Usuario($rela0["id_tar_usu"]);
					}
					echo json_encode($ids);
				}else{
					$datosEnviar = array(
						"id_tarea"=>$id_tarea,
						"id_usuario"=>$id_responsable1
					);
					$this->_sdt->crearSDT_Tarea_Usuario($datosEnviar);
				}
			}else{
				echo json_encode("None");
			}
		}
		public function ennviarEmailRM(){
			$dia= $this->getSql("dia");
			$correo= $this->getSql("correo");
			$asunto= $this->getSql("asunto");
			$mesaje="None";
			if ($dia!="" && $asunto!="")
			{
				$correo= $this->getSql("correo");
				$asunto= $this->getSql("asunto");
				// echo $dia . "</br>";
				// echo $correo . "</br>";
				// echo $asunto . "</br>";

				$id_usuario=Session::get('id_usuario');
				$user = $this->_sdt->getUsuario($id_usuario);
				$datos = $this->_sdt->getSDT_RM_Lines($id_usuario,$dia);

				if (is_array($datos)) {
					$html="";
					$html.='<table>';
					foreach ($datos as $dato) {
						$html.='<tr style="';
						if ($dato["tachado"]==1){
							$html.='background-color:#f1f1f1';
						}
						$html.='">';
			            	$html.='<td width="10px">';
				                $html.='<div class="btn-group text-center" data-toggle="buttons">';
				                	$html.='<label class="btn btn-default ';
				                	if ($dato["tachado"]==1) {
				                		$html.='active';
				                	}
				                	$html.='">';
				                  	$html.='</label>';
				                $html.='</div>';
			              	$html.='</td>';
			              	$html.='<td>';
			                	$html.='<div style="float:left;">';
			                		$niv = explode(".", $dato["numeracion"]);
			                		$niv= 12*(count($niv)-1);
			                  		$html.='<div class="numerar" style="margin-left:'.$niv.'px">'.$dato["numeracion"].'</div>';
			                	$html.='</div>';
			                	$niv2 = explode(".", $dato["numeracion"]);
			                	$niv2= 20+30*(count($niv2)-1);
			                	if (!isset($dato["fcolor"])) {
			                		$html.='<div class="conpizarron" style="margin-left:'.$niv2.'px;color:#000000;border-radius:3px;">';
			                			$html.='<div class="pizarron" style="margin-left:5px;font-family:Klavika;font-size:14;font-weight:boldword-break: break-all;';
			                	}else{
			                		$html.='<div class="conpizarron" style="margin-left:'.$niv2.'px;color:'.$dato["fcolor"].';background-color:'.$dato["fcback"].';border-radius:3px">';
			                			$html.='<div class="pizarron" style="margin-left:5px;font-family:'.$dato["ffamily"].';font-size:'.$dato["fsize"].'px;word-break: break-all;';
			                	}
			                  			if ($dato["tachad`o"]==0){
			                  				$html.='font-weight: bold';
			                  			}
			                  		$html.='" contenteditable="true">'.trim(htmlspecialchars_decode($dato["texto"]));
			                  		$html.='</div>';
			                	$html.='</div>';
			              	$html.='</td>';
			            $html.='</tr>';
					}
					$html.='</table>';

					$this->getLibrary('class.phpmailer');
					
					$mail = new PHPMailer();
					$mail->CharSet = 'UTF-8'; // caracteres especiales
					$mail->From = "www.sisfc.artesan.us/";
					$mail->FromName = $user["nickname_usuario"]." RM ".$dia;
					$mail->Subject = $asunto;
					$mail->Body = $html;
					$mail->AltBody = 'Su servidor de correo no soporta html';
					// multiples correos
					$correos = explode(",", $correo);
					for ($i=0; $i < count($correos); $i++) {
						if ($correos[$i]!="") {
							$mail->AddAddress($correos[$i]);
						}
					}
					$mail->Send();
					$mesaje="Enviado";
				}
			}
			echo json_encode($mesaje);
		}
		public function session (){
			Session::dartiempo();
			echo json_encode("Online");
		}
		public function limpiarSDTChecklist(){
			$this->_sdt->limpiarChecklist();
		}
		public function eliminarTareaItem(){
			$id_tarea_item=$this->getSql("id");
			if ($id_tarea_item!="") {
				$id_tarea_item = (int) $id_tarea_item;
				if ($id_tarea_item!=0) {
					$this->_sdt->eliminarSDT_Tarea_Item($id_tarea_item);
				}
			};
		}
		public function actualizarTareaItem1(){
			$id_tarea_item=$this->getSql("id");
			$nombre_item=$this->getSql("name");
			if ($id_tarea_item!="") {
				$id_tarea_item = (int) $id_tarea_item;
				if ($id_tarea_item!=0) {
					$datosEnviar = array(
						"id_tarea_item"=>$id_tarea_item,
						"nombre_item"=>$nombre_item
					);
					$this->_sdt->actualizarSDT_Tarea_Item($datosEnviar);
				}
			};
		}
		public function actualizarTareaItem2(){
			$id_tarea_item=$this->getSql("id");
			$estado_item=$this->getSql("estado");
			if ($id_tarea_item!="") {
				$id_tarea_item = (int) $id_tarea_item;
				if ($id_tarea_item!=0) {
					$datosEnviar = array(
						"id_tarea_item"=>$id_tarea_item,
						"estado_item"=>$estado_item
					);
					$this->_sdt->actualizarSDT_Tarea_Item($datosEnviar);
				}
			};
		}
		public function getSDTItems(){
			$id_tarea=$this->getSql("id");
			if ($id_tarea!="") {
				$id_tarea = (int) $id_tarea;
				if ($id_tarea!=0) {
					echo json_encode($this->_sdt->getItems($id_tarea));
				}
			};
		}
		public function getSDTNotas(){
			$id_tarea=$this->getSql("id");
			if ($id_tarea!="") {
				$id_tarea = (int) $id_tarea;
				if ($id_tarea!=0) {
					echo json_encode($this->_sdt->getNotas($id_tarea));
				}
			};
		}
		public function crearSDTNota(){
			$id_tarea=$this->getSql("id");
			$comentario=$this->getSql("com");
			if ($id_tarea!="") {
				$id_tarea = (int) $id_tarea;
				if ($id_tarea!=0) {
					$fechahora=date("d/m/Y H:i", mktime()+$this->_time);
					$datosEnviar = array(
						"id_tarea"=>$id_tarea,
						"id_usuario"=>Session::get('id_usuario'),
						"comentario"=>$comentario,
						"fecha_nota"=>$fechahora
					);
					$this->_sdt->crearSDT_Tarea_Nota($datosEnviar);
					$usuario = $this->_sdt->getUsuario(Session::get('id_usuario'));
					$datosEnviar = array(
						"fecha_nota"=>$fechahora,
						"nickname_usuario"=>$usuario["nickname_usuario"]
					);
					echo json_encode($datosEnviar);
				}else{
					echo json_encode("None");
				}
			}else{
				echo json_encode("None");
			}
		}

		public function getSDTInfoTarea(){
			$id_tarea=$this->getSql("id");
			if ($id_tarea!="") {
				$id_tarea = (int) $id_tarea;
				if ($id_tarea!=0) {
					$id_usuario = Session::get('id_usuario');
					

					$resultado = $this->_sdt->getSDT_Tarea_Descripcion($id_tarea);
					$etiqueta =  $this->_sdt->getSDT_Tarea_Etiqueta($id_tarea,$id_usuario);
					if (is_array($etiqueta)) {
						$resultado["id_etiqueta"]=$etiqueta["id_etiqueta"];
					}else{
						$resultado["id_etiqueta"]=0;
					}

					$tarea = $this->_sdt->getTarea($id_tarea);
					$resultado["ir_a"]="";
					if ($tarea["id_director"]==$id_usuario) {
						$proyecto = $this->_sdt->getTareasProyecto3($id_tarea);
						$resultado["ir_a"]="Ir a la tarea del proyecto";
						$resultado["url"]=BASE_URL . "sdt/verTarea/".$proyecto["id_proyecto"]."/".$id_tarea;
					}else if ($tarea["id_director"]==0){
						$grupo = $this->_sdt->getSDTGrupo_Tarea_Tarea_Tarea($id_tarea);
						if (is_array($grupo)) {
							if ($grupo["id_creador"]==$id_usuario) {
								$resultado["ir_a"]="Ir a la tarea del paquetes de tareas";
								$resultado["url"]=BASE_URL . "sdt/crearTareaModelo/".$grupo["id_grupo"]."/".$grupo["id_modelo"];
							}
						}
					}
					echo json_encode($resultado);
				}else{
					echo json_encode("None");
				}
			}else{
				echo json_encode("None");
			}
		}
		public function actualizarSDTTareaEtiqueta(){
			$id_tarea=$this->getSql("id");
			$etiqueta=$this->getSql("etiqueta");
			$id_tarea = (int) $id_tarea;
			$etiqueta = (int) $etiqueta;
			if ($id_tarea!=0) {
				$id_usuario = Session::get('id_usuario');

				# Ver si el registro en la tabla de etiqueta fue creado
				$etiquetaX = $this->_sdt->getSDT_chlist_etiqueta($id_tarea,$id_usuario);
				if (is_array($etiquetaX)) {
					$datosEnviar = array(
						"id_ch_etiqueta"=>$etiquetaX["id_ch_etiqueta"],
						"id_etiqueta"=>$etiqueta
					);
					$this->_sdt->actualizarSDT_chlist_etiqueta($datosEnviar);
				}else{
					$datosEnviar = array(
						"id_tarea"=>$id_tarea,
						"id_usuario"=>$id_usuario,
						"id_etiqueta"=>$etiqueta
					);
					$this->_sdt->crearSDT_chlist_etiqueta($datosEnviar);
				}

				if ($etiqueta!=0) {
					$formato=$this->_sdt->getEtiquetaById($etiqueta);
				}else{
					$miarray = array();
					$miarray["ffamily"] = "Klavika";
					$miarray["fsize"] = "14";
					$miarray["fcolor"] = "#000000";
					$miarray["fcback"] = "transparent";
					$formato = (object) $miarray;
				}
				echo json_encode($formato);
			}else{
				echo json_encode("None");
			}
		}


		private function searchForIdKey($value, $keyIn, $keyOut, $array) {
		   foreach ($array as $key => $val) {
		       if ($val[$keyIn] === $value) {
		           return $val[$keyOut];
		       }
		   }
		   return null;
		}

		private function SDT_CheckList_MainData($id_usuario){
			$MainDatos=array();
			$MainDatos[0]=array();
			$MainDatos[1]=array();
			# construir una cadena donde se indique que proyectos buscar
			$proyectos = $this->_sdt->getSDT_Proyectos_Usuario($id_usuario);
			$cade_proyecto="(";
			foreach ($proyectos as $proyecto) {
				if ($cade_proyecto=="(") {
					$cade_proyecto.="u.id_proyecto = ".$proyecto["id_proyecto"];
				}else{
					$cade_proyecto.=" OR u.id_proyecto = ".$proyecto["id_proyecto"];
				}
			}
			$cade_proyecto.=") OR";
			if ($cade_proyecto=="() OR") {
				$cade_proyecto="";
			}
			# construir una cadena donde se indique que grupos buscar
			$grupos = $this->_sdt->getSDT_Grupos_Usuario($id_usuario);
			$cade_grupo="(";
			foreach ($grupos as $grupo) {
				if ($cade_grupo=="(") {
					$cade_grupo.="u.id_grupo = ".$grupo["id_grupo"];
				}else{
					$cade_grupo.=" OR u.id_grupo = ".$grupo["id_grupo"];
				}
			}
			$cade_grupo.=") OR";
			if ($cade_grupo=="() OR") {
				$cade_grupo="";
			}
			$MainDatos[0] = $this->_sdt->getSDT_Tareas_Proyectos($cade_proyecto,$cade_grupo ,$id_usuario);
			$dat = $this->_sdt->getSDT_Tareas_Dias($MainDatos[0]);
			$MainDatos[1] = $dat[0];
			$MainDatos[2] = $dat[1];
			return $MainDatos;
		}

		// private function SDT_CheckList_MainData($id_usuario){
		// 	$proyectos = $this->_sdt->getSDT_Proyectos_Usuario($id_usuario);
		// 	$MainDatos=array();
		// 	$MainDatos[0]=array();
		// 	$MainDatos[1]=array();
		// 	# construir una cadena donde se indique que proyectos buscar
		// 	$cade="(";
		// 	foreach ($proyectos as $proyecto) {
		// 		if ($cade=="(") {
		// 			$cade.="r.id_proyecto = ".$proyecto["id_proyecto"];
		// 		}else{
		// 			$cade.=" OR r.id_proyecto = ".$proyecto["id_proyecto"];
		// 		}
		// 	}
		// 	$cade.=") OR ";
		// 	if ($cade=="() OR ") {
		// 		$cade="";
		// 	}
		// 	$MainDatos[0] = $this->_sdt->getSDT_Tareas_Proyectos($cade,$id_usuario);
		// 	$MainDatos[1] = $this->_sdt->getSDT_Tareas_Dias($MainDatos[0]);
		// 	return $MainDatos;
		// }

		public function analytics(){

			$this->_view->setJs(array('morris.min','raphael-min','analytics'));
			$this->_view->setCss(array('morris'));

			// total de lineas hechas en el RM
			$RM = $this->_sdt->getSDT_All_RM();
			// CUantos diferentes usuarios han realizado un registro en el RM

			// Cuota porcentual de participacion de los usuarios frente al total de los registros almacenados

			// Numero de registros por dia
			$cont=0;
			$users=array();
			$ConUsers=array();
			$DiasUsados=array();
			$DiasSemana=array();
			foreach ($RM as $key) {
				if (trim($key["texto"])!="") {
					$cont+=1;
					if (!in_array($key["usuario"], $users, true)) {
						array_push($users, $key["usuario"]);
						$ConUsers[$key["usuario"]]=0;
					}
					$ConUsers[$key["usuario"]]+=1;

					if (!array_key_exists($key["fecha"], $DiasUsados)) {
						$DiasUsados[$key["fecha"]]=0;
					}
					$DiasUsados[$key["fecha"]]+=1;

					$fecha = $this->_dateUtils->formatearFecha($key["fecha"]);
					$dia = date('w', mktime(0, 0, 0, $fecha["mes"], $fecha["dia"], $fecha["anio"]));
					if (!array_key_exists($dia, $DiasSemana)) {
						$DiasSemana[$dia]=0;
					}
					$DiasSemana[$dia]+=1;
				}
			}

			// echo "Total registro :" . $cont . "<br>";
			// echo "Usuarios que usan el RM :" . count($users) . "<br>";
			// echo "Usuarios <br>";
			$datos_1 = array();
			$inc=0;
			foreach ($ConUsers as $key => $value) {
				//$ConUsers[$key]= round($ConUsers[$key]/$cont * 100 * 100) / 100; 
				//echo $ConUsers[$key] . "<br>";
				$datos_1[$inc]=array(
					"value"=>round($ConUsers[$key]/$cont * 100 * 100) / 100,
					"label"=> "Usuario " . ($inc+1)
				);
				$inc+=1;
			}
			// echo "<br>";
			$datos_2 = array();
			$inc=0;
			foreach ($DiasUsados as $key => $value) {
				// $DiasUsados[$key]= round($DiasUsados[$key]/$cont * 100 * 100); 
				// $fecha = $this->_dateUtils->formatearFecha($key);
				$datos_2[$inc]=array(
					"y"=>$key,
					"a"=>  round($DiasUsados[$key]/$cont * 100 * 100)
				);
				$inc+=1;
				// echo mktime(0, 0, 0, $fecha["mes"], $fecha["dia"], $fecha["anio"]) . "<br>";
			}
			// echo "<br>";
			$datos_3 = array();
			$inc=0;
			krsort($DiasSemana);
			$diasS=array(
				"1"=>"Lunes",
				"2"=>"Martes",
				"3"=>"Miercoles",
				"4"=>"Jueves",
				"5"=>"Viernes",
				"6"=>"Sabado",
				"0"=>"Domingo"
			);
			foreach ($DiasSemana as $key => $value) {
				// $DiasSemana[$key]= round($DiasSemana[$key]/$cont * 100 * 100) / 100; 
				// echo $key . "<br>";
				$datos_3[$inc]=array(
					"value"=> round($DiasSemana[$key]/$cont * 100 * 100) / 100,
					"label"=> $diasS[$key]
				);
				$inc+=1;
			}
			$this->_view->assign('TotalRegistros',$cont);
			$this->_view->assign('UsoUsuarios',count($users));
			$this->_view->assign('datos1',json_encode($datos_1));
			$this->_view->assign('datos2',json_encode($datos_2));
			$this->_view->assign('datos3',json_encode($datos_3));
			$this->_view->assign('titulo',"SDT Analytics");
			$this->_view->renderizar('analytics');
		}
		# Hoja de trabajo diario
		public function jerarquia(){
			$this->_view->assign('titulo','Jerarquia');
			$this->_view->assign('usuariosSistema',$this->_sdt->getUsuarioSisfcIdSisFC());
			$this->_view->renderizar('jerarquia');
		}

		public function buscar_palabras_RM(){
			$palabra=$this->getSql("palabra");
			$id_usuario = Session::get('id_usuario');
			if ($palabra!="" && $id_usuario!=0) {
				$registros = $this->_sdt->getSDT_All_Words_RM($id_usuario,$palabra);
				$lineas = array();
				for ($i=0; $i < count($registros); $i++) {
					$text_temp1 = trim(htmlspecialchars_decode($registros[$i]["texto"]));
					$text_temp2 = strip_tags($text_temp1);
					$posi = strpos(strtolower($text_temp2), strtolower($palabra));
					if ($posi=== false) {
					}else{
						$txt_ini="";
						if ($posi>40) {
							$pos_ini=$posi-30;
							$txt_ini="...";
						}else{
							$pos_ini=0;
						}
						$txt_fin="";
						if ((strlen($text_temp2)-$pos_ini)>60) {
							$pos_fin=60;
							$txt_fin="...";
						}else{
							$pos_fin=strlen($text_temp2)-$pos_ini+1;
						}
						$text_temp1 = $txt_ini.substr ($text_temp2,$pos_ini, $pos_fin).$txt_fin;
						// $diviciones = explode($palabra, $text_temp1);
						$diviciones = preg_split("/".$palabra."/i", $text_temp1);
						$text_temp1="";
						for ($j=0; $j < count($diviciones); $j++) { 
							if ($j<count($diviciones)-1) {
								$text_temp1.=$diviciones[$j].'<span style="background-color:#efd43e;">'.strtolower($palabra).'</span>';
							}else{
								$text_temp1.=$diviciones[$j];
							}
						}
						$lineas[] = array(
							"texto"=>$text_temp1,
							"fecha"=>$registros[$i]["fecha"],
							"url"=>BASE_URL."sdt/rm/".$registros[$i]["fecha"]
						);
					}
				}
				echo json_encode($lineas);
			}else{
				echo json_encode("None");
			}
		}

		# Hoja de trabajo diario
		public function htd(){
			$this->_view->assign('titulo','Hoja de Trabajo Diario');
			
			$this->_view->setJs(array('moment.min','fullcalendar','hojaTrabajoDiario'));
			$this->_view->setCss(array('fullcalendar','jqueryui','dropdown'));

			$this->_view->assign("usuarios",$this->_sdt->getUsuarios2());
			$this->_view->renderizar('sdt_htd');
		}

		public function cargarTareasHTD(){
			$dia=$this->getSql("dia");
			if ($dia!="") {
				$fechaFormat = $this->_dateUtils->formatearFecha($dia);
				if (is_array($fechaFormat)) {
					$datos = $this->SDT_HTD_MainData(Session::get('id_usuario'),$dia);
					$datos = $this->diasCiclos(0,$dia,$dia,$datos[1],$datos[2]);
					//echo json_encode($this->_sdt->obtener_Tareas_de_Usuario_por_Dia(Session::get('id_usuario'),$dia));
					echo json_encode($datos);
				}else{
					echo json_encode("None");
				}
			}else{
				echo json_encode("None");
			}
		}

		private function SDT_HTD_MainData($id_usuario,$fecha){
			$MainDatos=array();
			$MainDatos[0]=array();
			$MainDatos[1]=array();
			
			# construir una cadena donde se indique que grupos buscar
			$grupos = $this->_sdt->getSDT_Grupos_Usuario($id_usuario);
			$cade_grupo="(";
			foreach ($grupos as $grupo) {
				if ($cade_grupo=="(") {
					$cade_grupo.="u.id_grupo = ".$grupo["id_grupo"];
				}else{
					$cade_grupo.=" OR u.id_grupo = ".$grupo["id_grupo"];
				}
			}
			$cade_grupo.=") OR";
			if ($cade_grupo=="() OR") {
				$cade_grupo="";
			}
			$MainDatos[0] = $this->_sdt->getSDT_Tareas_Proyectos_HTD($cade_grupo ,$id_usuario);
			$dat = $this->_sdt->getSDT_Tareas_Dias_HTD($MainDatos[0],$fecha);
			$MainDatos[1] = $dat[0];
			$MainDatos[2] = $dat[1];
			return $MainDatos;
		}
	}