<?php 
	class dummy extends Controller{
		private $_sdt;
		private $_time;
		private $_dateUtils;

		private function diasCiclos($fecha_ini,$fecha_fin,$dias_fijos,$cade_tarea){
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
	}