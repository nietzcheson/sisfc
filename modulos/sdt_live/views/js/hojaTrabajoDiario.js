
var server = "http://"+window.location.hostname;
var tiempo = 3000;
var diaAgenda = "";
var tareas  = new Array();
var AjusteDia = 0;
var calendar = $(document).ready(function() {
    // page is now ready, initialize the calendar...
    $('#calendar').fullCalendar({
        // put your options and callbacks here
        header: {
			left: 'prev,next today',
			center: 'title',
		},
		defaultView: 'agendaDay',
		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay) {
			var title = prompt('Event Title:');
			if (title) {
				eventData = {
					title: title,
					start: start,
					end: end
				};
				start =moment(start).format('YYYY/MM/DD HH:mm:ss');
				end = moment(end).format('YYYY/MM/DD HH:mm:ss');
				$.ajax({
						url: server+'/sdt_live/htd_agregar_eventos',
						data: 'title='+ title+'&start='+ start +'&end='+ end ,
						type: "POST",
						success: function(json) {
							// alert('OK');
						}
				});
				$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
			}
			$('#calendar').fullCalendar('unselect');
		},

		editable: true,
		eventDrop: function(event, delta) {
		 	start =moment(event.start).format('YYYY/MM/DD HH:mm:ss');
			end = moment(event.end).format('YYYY/MM/DD HH:mm:ss');
		 	$.ajax({
				 	url: server+'/sdt_live/htd_modificar_eventos',
				 	data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
				 	type: "POST",
				 	success: function(json) {
				 		//alert("OK");
			 		}
			 	});
			},
		eventResize: function(event) {
			start =moment(event.start).format('YYYY/MM/DD HH:mm:ss');
			end = moment(event.end).format('YYYY/MM/DD HH:mm:ss');
			$.ajax({
			 		url: server+'/sdt_live/htd_modificar_eventos',
				 	data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
				 	type: "POST",
					success: function(json) {
					 	//alert("OK");
					}
				});
			},
		allDaySlot: false,
		events: server+'/sdt_live/htd_eventos',
		eventSources: calendarios_publicos
    });

	var celda =$("#contenedor");
	var u_conte = $('<ul id="sortable"></ul>');
	// crear select
	
	var maxtask =48;
	var numtask=0;
	for (var i = 0; i < numtask; i++) {
		var li_ = $('<li class="tarea ui-state-default"></li>');
		var ul_ = $(construirlistas());
		li_.append(ul_);
		u_conte.append(li_);
	};
	
	for (var i = 0; i < (maxtask-numtask); i++) {
		var li_ = $('<li class="newTask '+i+'">' +
						'<div class="text-center">' +
							'<span class="glyphicon glyphicon-plus" style="font-size: 15px;display:block;"></span>' +
						'</div>' +
					'</li>');
		u_conte.append(li_);
	};
	celda.append(u_conte);

	$( "#sortable" ).sortable({
      placeholder: "ui-state-highlight"
    });
    $( "#sortable" ).disableSelection();

    $('#sortable').on('click', ".delegar", function(e){
    	seleccionarDelegado($(this));
		event.preventDefault();
	});
	$('#sortable').on('click', ".seguimiento", function(e){
		event.preventDefault();
		var clase = $(this).attr("class");
		clase =  clase.split(" ");
		var indi = clase[0].split("_");
		var id_ele = obtenerId($(this));
		if (indi[1]=="2") {
			$("#id_dia").val(id_ele);
			$("#fecha_trans").val(diaAgenda);
			$("#fecha_traslado").val(diaAgenda);
			$("#obj_json").val(buscarIndicePorPos(clase[2],diaAgenda));
		}else{
			var spa = buscarOpciones($(this));
	    	if (spa[0].length) {
				spa[0].removeClass( "seleccionado" );
			};
			if (spa[1].length) {
				spa[1].addClass( "seleccionado" );
			};
			if (spa[2].length) {
				var clase_span = spa[1].attr('class');
				spa[2].attr( "class" , clase_span );
				spa[2].removeClass("seleccionado");
			};
			tareas[diaAgenda][clase[2]].estado = indi[1];
			$("#del_"+id_ele).prop('disabled', true);
			$("#seg_"+id_ele).prop('disabled', true);
			$("#pri_"+id_ele).prop('disabled', true);
			$.post(server+'/sdt/actualizarTareaEstado','dia='+id_ele+'&estado='+indi[1]+"&fecha="+diaAgenda, function(datos){
	  		  	if (datos!="None" && datos!="") {
	  		  		$("#del_"+id_ele).attr("id", "del_"+datos);
		 	       	$("#seg_"+id_ele).attr("id", "seg_"+datos);
		 	       	$("#pri_"+id_ele).attr("id", "pri_"+datos);

		 	       	$("#del_"+id_ele).removeAttr('disabled');
					$("#seg_"+id_ele).removeAttr('disabled');
					$("#pri_"+id_ele).removeAttr('disabled');
		 	    };

		 	   	modificarEstadoCH(id_ele,indi[1],datos);

		 	}, 'json');
		}
	});
	$('#guadar_traslado').click(function(){
		var id_dia = $("#id_dia").val();
		var fecha_tras = $("#fecha_traslado").val();
		var obj_json = $("#obj_json").val();
		$('#guadar_traslado').button('loading');
		$.post(server+'/sdt/trasladarHTDUnidad','dia='+id_dia+"&fecha="+fecha_tras+"&obj_json="+obj_json, function(datos){
  		   if (datos!="None" && datos!="") {
  		   		$('#guadar_traslado').button('reset');
  		   		if (tareas[datos.fecha]!=null) {
  		   			var ind_c = buscarIndLibre(datos.fecha);
  		   			if (ind_c>-1) {
  		  //  				var spa = buscarOpciones($("#seg_"+id_dia).find(".se_2"));
				  //   	if (spa[0].length) {
						// 	spa[0].removeClass( "seleccionado" );
						// };
						// if (spa[1].length) {
						// 	spa[1].addClass( "seleccionado" );
						// };
						// if (spa[2].length) {
						// 	var clase_span = spa[1].attr('class');
						// 	spa[2].attr( "class" , clase_span );
						// 	spa[2].removeClass("seleccionado");
						// };
						tareas[diaAgenda][datos.obj_json].estado = 2;

  		   				tareas[datos.fecha][ind_c] = new Object();
						tareas[datos.fecha][ind_c].pos = buscarPosLibre(datos.fecha);;
						tareas[datos.fecha][ind_c].estado = 0;
						tareas[datos.fecha][ind_c].prioridad = datos.prioridad;
						tareas[datos.fecha][ind_c].id_dia = datos.id_dia;
						tareas[datos.fecha][ind_c].nombre_tarea = datos.tarea;
						tareas[datos.fecha][ind_c].fecha_ant = datos.fecha_anterior;
						tareas[datos.fecha][ind_c].responsable = datos[ind_c].id_responsable;
  		   			};
				}
				tareas[diaAgenda][datos.obj_json].estado = 2;
				tareas[diaAgenda][datos.obj_json].fecha_pos = datos.fecha;

				reiniciarEspacio(); 
				renderizarDatosViejos(datos.fecha_vieja);

				actualizarVistaCH();
	 	    };
	 	}, 'json');
	});
	
	$("#ht_c_view").css("height","213");
	$("#ht_c_view_2").css("height","213");
	$("#ht_c_view_6").css("height","240");

	$('#sortable').on('click', ".gotodate", function(e){
		var clase = $(this).attr("class");
		clase =  clase.split(" ");
		var fe = clase[1].split("/");
		$('#calendar').fullCalendar( 'gotoDate', new Date(parseInt(fe[2]), parseInt(fe[1]-1), parseInt(fe[0]), 0, 0, 0, 0));
	});

	$('#sortable').on('click', ".prioridad", function(e){
		var spa = buscarOpciones($(this));
    	if (spa[0].length) {
			spa[0].removeClass( "seleccionado" );
		};
		if (spa[1].length) {
			spa[1].addClass( "seleccionado" );
		};
		if (spa[2].length) {
			var clase = spa[1].attr("class"); 
			clase =  clase.split(" ");
			// console.log(clase[1]);
			spa[2].attr( "class","glyphicon glyphicon-exclamation-sign " + clase[0]);
		};
		event.preventDefault();
		var clase = $(this).attr("class");
		clase =  clase.split(" ");
		var indi = clase[0].split("_");
		tareas[diaAgenda][clase[2]].prioridad = indi[1];
		
		var id_ele = obtenerId($(this));
		$("#del_"+id_ele).prop('disabled', true);
		$("#seg_"+id_ele).prop('disabled', true);
		$("#pri_"+id_ele).prop('disabled', true);
		$.post(server+'/sdt/actualizarHTD_Prioridad','dia='+id_ele+'&prioridad='+indi[1]+'&fecha='+diaAgenda, function(datos){
  		   if (datos!="None" && datos!="") {
	 	       	$("#del_"+id_ele).attr("id", "del_"+datos);
	 	       	$("#seg_"+id_ele).attr("id", "seg_"+datos);
	 	       	$("#pri_"+id_ele).attr("id", "pri_"+datos);

	 	       	$("#del_"+id_ele).removeAttr('disabled');
				$("#seg_"+id_ele).removeAttr('disabled');
				$("#pri_"+id_ele).removeAttr('disabled');
	 	    };
	 	}, 'json');
	});

	$('#sortable').on('click', ".newTask", function(e){
		if ($(this).hasClass("newTask")) {
			var texto = prompt('Event Title:');
			if (texto!="" && texto!=null) {
				var clase = $(this).attr("class");
				var ind_cl_ =  clase.split(" ");
				var posi = parseInt(ind_cl_[1]);
				$(this).attr("id","temp_"+ind_cl_[1]);
				//clase =  clase.split(" ");
				//console.log($(this).attr("class")+" "+clase[1]);

				$.post(server+'/sdt_live/crearTareaHTD','pos='+posi+'&tarea='+texto+'&fecha='+diaAgenda, function(datos){
		  		   if (datos!="None" && datos!="") {
		  		   		// var ind_cl_ =  clase.split(" ");
			 	       	var ind_c = tareas[diaAgenda].length;
			 	       	if (typeof tareas[datos.fecha][ind_c] === 'object') {

			 	       	}else{
			 	       		ind_c = parseInt(ind_c);
			 	       		tareas[datos.fecha][ind_c] = new Object();
  		   				
  		   					tareas[datos.fecha][ind_c].id_dia = datos.id_dia;
							tareas[datos.fecha][ind_c].pos = posi;
							tareas[datos.fecha][ind_c].estado = "0";
							tareas[datos.fecha][ind_c].nombre_tarea = datos.tarea;
							tareas[datos.fecha][ind_c].prioridad = "0";
							tareas[datos.fecha][ind_c].fecha_ant = "";
							tareas[datos.fecha][ind_c].fecha_pos = "";
							tareas[datos.fecha][ind_c].responsable = 0;

							
							reiniciarEspacio();

							renderizarDatosViejos(datos.fecha);

							actualizarVistaCH();
			 	       	}
  		   				
			 	    };
			 	}, 'json');
			};
		};
	});
});
var modificarEstadoCH = function(id_ele,indi,datos){
	var light='';
	if (dia<ntoday) {
		light="light";
	};
	if (datos!="None") {
		$("#"+id_ele).attr("id",datos);
		id_ele=datos;
	};
	var clact = $("#"+id_ele).attr("class");
	clact = clact.split(" ");
	if (indi==0) {
		$("#"+id_ele).find(".circle").attr("class",ico_null + " circle");
		$("#"+id_ele).attr("class",clact[0] + " orange dia " +"vacio"+light);
	};
	if (indi==1) {
		$("#"+id_ele).find(".circle").attr("class",ico_check + " circle");
		$("#"+id_ele).attr("class",clact[0] + " orange dia " +"chuleado"+light);
	};
	if (indi==2) {
		$("#"+id_ele).find(".circle").attr("class",ico_later + " circle");
		$("#"+id_ele).attr("class",clact[0] + " orange dia " +"transferido"+light);
	};
	if (indi==3) {
		$("#"+id_ele).find(".circle").attr("class",ico_remove + " circle");
		$("#"+id_ele).attr("class",clact[0] + " orange dia " +"nohizo"+light);
	};
}
var reiniciarEspacio = function () {
	$("#sortable").html("");
	var celda = $("#sortable");
	var li_array = [];
	for (var i = 0; i < 48; i++) {
		li_array[i] = $('<li class="newTask '+i+'">' +
						'<div class="text-center">' +
							'<span class="glyphicon glyphicon-plus" style="font-size: 15px;display:block;"></span>' +
						'</div>' +
					'</li>');
		celda.append(li_array[i]);
	};
}
var buscarOpciones =  function(li){
	var objs = [];
	var ul_ = $(li).parent();
    objs[0] = ul_.find(".seleccionado");
    objs[1] = $(li).find('span');
    objs[2] = ul_.parent();
    objs[2] = objs[2].find(".glyphicon:eq(0)");
    return objs;
}

var construirlistas =  function(atributo){
	var cont_menu = $('<div style="float:right"></div>');
	$(cont_menu).drop_down_naan({
		id:atributo.id_dia,
		clase_cabeza:"head-drop-down",
		clase_elemento:"element-drop-down",
		listas: [
			{
				valor_x_defecto:atributo.responsable,
				clase_x_defecto:"glyphicon glyphicon-minus",
				clase_x_texto:"glyphicon glyphicon-user",
				elementos:usuarios_ele,
				elemento_click: function(valor,id){
					return true;
				}
			},
			{
				valor_x_defecto:atributo.estado,
				clase_x_defecto:"glyphicon glyphicon-minus",
				clase_x_texto:false,
				elementos:seguimiento_ele,
				elemento_click: function(valor,id){
					if (valor==2) {
						$("#id_dia").val(id);
						$("#fecha_trans").val(diaAgenda);
						$("#fecha_traslado").val(diaAgenda);
						$("#obj_json").val(buscarIndicePorPos(atributo.pos,diaAgenda));
						$("#transferir").modal('show');
						return false;
					}else{
						$.post(server+'/sdt/actualizarTareaEstado','dia='+id+'&estado='+valor+"&fecha="+diaAgenda, function(datos){
					 	   	modificarEstadoCH(id,valor,datos);
					 	}, 'json').fail(function() {
						});
						return true;
					}
				}
			},
			{
				valor_x_defecto:atributo.prioridad,
				clase_x_defecto:"glyphicon glyphicon-minus",
				clase_x_texto:false,
				elementos:prioridad_ele,
				elemento_click: function(valor,id){
					$.post(server+'/sdt/actualizarHTD_Prioridad','dia='+id+'&prioridad='+valor+'&fecha='+diaAgenda, function(datos){
				 		
				 	}, 'json').fail(function() {
					});
					return true;
				}
			}
		]
	});
	// var i=0;
	// var celda =$("#usuarios");
	// var span_ = $(celda).find("seleccionado");
	// span_.removeClass( "seleccionado" );

	// var ico_estado = 	atributo.estado == 1 ? 'ok' :
 //                    	atributo.estado == 3 ? 'remove' :
 //                    	atributo.estado == 2 ? 'arrow-right' :
 //                    	'minus';

 //    var ico_priodidad = atributo.prioridad == 1 ? 'exclamation-sign rojo' :
 //                    	atributo.prioridad == 2 ? 'exclamation-sign amarillo' :
 //                    	atributo.prioridad == 3 ? 'exclamation-sign verde' :
 //                    	atributo.prioridad == 4 ? 'exclamation-sign azul' :
 //                    	'minus';
	// var listas  =  '<span class="cssmenu" style="width:86px;float:right">' +
	// 		'<ul>' +
	// 		   '<li style="top:-15px;left:-25px;width:15px;" id="del_'+atributo.id_dia+'"><a><span class="glyphicon glyphicon-minus"></span></a>' +
	// 		      '<ul>' +
	// 		         $(celda).html() +
	// 		      '</ul>' +
	// 		   '</li>' +
	// 		   '<li style="top:-15px;left:-25px;width:15px;" id="seg_'+atributo.id_dia+'"><a><span class="glyphicon glyphicon-'+ico_estado+'"></span></a>' +
	// 		      '<ul>' +
	// 		      	 '<li class="se_1 seguimiento '+atributo.pos+'" style="left:-15px;padding-left: 5px;z-index: 100;margin-bottom: 0px;" ><a href=""><span class="glyphicon glyphicon-ok'+(atributo.estado==1 ? " seleccionado" : "")+'"></a></li>' +
	// 		         '<li class="se_3 seguimiento '+atributo.pos+'" style="left:-15px;padding-left: 5px;z-index: 100;margin-bottom: 0px;" ><a href=""><span class="glyphicon glyphicon-remove'+(atributo.estado==3 ? " seleccionado" : "")+'"></a></li>' +
	// 		         '<li class="se_2 seguimiento '+atributo.pos+'" style="left:-15px;padding-left: 5px;z-index: 100;margin-bottom: 0px;" data-toggle="modal" data-target="#transferir"><a href=""><span class="glyphicon glyphicon-arrow-right'+(atributo.estado==2 ? " seleccionado" : "")+'"></a></li>' +
	// 		      '</ul>' +
	// 		   '</li>' +
	// 		   '<li style="top:-15px;left:-25px;width:15px;" id="pri_'+atributo.id_dia+'"><a><span class="glyphicon glyphicon-'+ico_priodidad+'"></span></a>' +
	// 		      '<ul>' +
	// 		         '<li class="pr_1 prioridad '+atributo.pos+'" style="width:100px;left:-90px;padding-left: 5px;z-index: 100;margin-bottom: 0px;"><a style="width:100px;text-decoration: underline" href=""><span class="rojo'+(atributo.prioridad==1 ? " seleccionado" : "")+'"><strong>Alta</strong></a></li>' +
	// 		         '<li class="pr_2 prioridad '+atributo.pos+'" style="width:100px;left:-90px;padding-left: 5px;z-index: 100;margin-bottom: 0px;"><a style="width:100px;text-decoration: underline" href=""><span class="amarillo'+(atributo.prioridad==2 ? " seleccionado" : "")+'"><strong>Media</strong></a></li>' +
	// 		         '<li class="pr_3 prioridad '+atributo.pos+'" style="width:100px;left:-90px;padding-left: 5px;z-index: 100;margin-bottom: 0px;"><a style="width:100px;text-decoration: underline" href=""><span class="verde'+(atributo.prioridad==3 ? " seleccionado" : "")+'"><strong>Baja</strong></a></li>' +
	// 		         '<li class="pr_4 prioridad '+atributo.pos+'" style="width:100px;left:-90px;padding-left: 5px;z-index: 100;margin-bottom: 0px;"><a style="width:100px;text-decoration: underline" href=""><span class="azul'+(atributo.prioridad==4 ? " seleccionado" : "")+'"><strong>Informativa</strong></a></li>' +
	// 		      '</ul>' +
	// 		   '</li>' +
	// 		'</ul>' +
	// 	'</span>';
	return cont_menu;
}
var cargarTareas = function(fecha){
	$.post(server+'/sdt_live/cargarTareasHTD','dia='+fecha, function(datos){
		if (datos!="None") {
			agregarTarea(datos,fecha);

			$("#ht_c_view").css("height",htd_height_px);
			$("#ht_c_view_2").css("height",htd_height_px);
			$("#ht_c_view_6").css("height",htd_height_px);
		};
	}, 'json').fail(function() {
	    console.log("error de conexion");
	});
}
var agregarTarea = function (datos,fecha) {
	var celda =$("#sortable");
	var li_array = [];
	var i=0;
	$(celda).find("li").each(function (index, element) {
		li_array[i] = $(element);
		i+=1;
	});
	for (var i = 0; i < datos.length; i++) {
		if (fecha==datos[i].fecha) {
			tareas[fecha][i] = new Object();
			tareas[fecha][i].id_dia = datos[i].id_dia;
			tareas[fecha][i].pos = i;
			// console.log("posicion tarea en htd "+tareas[fecha][i].pos);
			tareas[fecha][i].estado = datos[i].estado;
			tareas[fecha][i].nombre_tarea = datos[i].tarea;
			tareas[fecha][i].prioridad = datos[i].prioridad;
			tareas[fecha][i].fecha_ant = datos[i].fecha_anterior;
			tareas[fecha][i].fecha_pos = datos[i].fecha_posterior;
			tareas[fecha][i].responsable = datos[i].id_responsable;

			var btn_back = '';
			if (tareas[fecha][i].fecha_ant!="") {
				btn_back = '<button type="button" class="gotodate '+tareas[fecha][i].fecha_ant+'"><span style="top:-1px;" class="glyphicon glyphicon-arrow-left"></span></button>';
			}
			var btn_front = '';
			if (tareas[fecha][i].fecha_pos!="") {
				btn_front = '<button type="button" class="gotodate '+tareas[fecha][i].fecha_pos+'"><span style="top:-1px;" class="glyphicon glyphicon-arrow-right"></span></button>';
			}
			$(li_array[tareas[fecha][i].pos]).attr("class","tarea ui-state-default "+i);
			// $(li_array[tareas[fecha][i].pos]).html(btn_back+btn_front+construirlistas(tareas[fecha][i])+tareas[fecha][i].nombre_tarea);
			$(li_array[tareas[fecha][i].pos]).html(btn_back+btn_front+tareas[fecha][i].nombre_tarea);
			$(li_array[tareas[fecha][i].pos]).append(construirlistas(tareas[fecha][i]));

			var usu_ = $(li_array[tareas[fecha][i].pos]).find(".id_"+tareas[fecha][i].responsable);

			var spa = buscarOpciones($(usu_));
	    	if (spa[0].length) {
				spa[0].removeClass( "seleccionado" );
			};
			if (spa[1].length) {
				spa[1].addClass( "seleccionado" );
			};
			if (spa[2].length) {
				spa[2].addClass( "glyphicon-user" );
				spa[2].removeClass("glyphicon-minus");
			};
		}
	};
}
var formatoDia = function(codigo){
	var date = new Date(codigo);

	tiempo=date.getTime();
    milisegundos=parseInt(AjusteDia*24*60*60*1000);
    total=date.setTime(tiempo+milisegundos);
    AjusteDia=0.5;
	
	
	var dia = ""+date.getUTCDate()+"";
	var mes = ""+(date.getMonth()+1)+"";

	if (dia.length==1) {dia="0"+dia};
	if (mes.length==1) {mes="0"+mes};
	return dia+"/"+mes+"/"+date.getFullYear();
}

var obtenerDia = function(diaVista,fila){
	$("#sortable").html("");
	var u_conte = $("#sortable");
	for (var i = 0; i < 48; i++) {
		var li_ = $('<li class="newTask '+i+'">' +
						'<div class="text-center">' +
							'<span class="glyphicon glyphicon-plus" style="font-size: 15px;display:block;"></span>' +
						'</div>' +
					'</li>');
		u_conte.append(li_);
	};
	// console.log(fila)
	diaAgenda = formatoDia(diaVista);
	
	var dia =  diaAgenda;
	if (tareas[dia]!=null) {
		renderizarDatosViejos(dia);
	}else{
		tareas[dia] = new Array();
		cargarTareas(dia);
	}


}

var renderizarDatosViejos = function(dia){
	var celda =$("#sortable");
	var li_array = [];
	var i=0;
	$(celda).find("li").each(function (index, element) {
		li_array[i] = $(element);
		i+=1;
	});
	for (var i = 0; i < tareas[dia].length; i++) {
		if (typeof tareas[dia][i] === 'object') {
			var btn_back = '';
			if (tareas[dia][i].fecha_ant!="") {
				btn_back = '<button type="button" class="gotodate '+tareas[dia][i].fecha_ant+'"><span style="top:-1px;" class="glyphicon glyphicon-arrow-left"></span></button>';
			}
			var btn_front = '';
			if (tareas[dia][i].fecha_pos!="") {
				btn_front = '<button type="button" class="gotodate '+tareas[dia][i].fecha_pos+'"><span style="top:-1px;" class="glyphicon glyphicon-arrow-right"></span></button>';
			}
			$(li_array[tareas[dia][i].pos]).attr( "class" , "tarea ui-state-default" );
			// $(li_array[tareas[dia][i].pos]).html(btn_back+btn_front+construirlistas(tareas[dia][i])+tareas[dia][i].nombre_tarea);
			$(li_array[tareas[dia][i].pos]).html(btn_back+btn_front+tareas[dia][i].nombre_tarea);
			$(li_array[tareas[dia][i].pos]).append(construirlistas(tareas[dia][i]));
			var usu_ = $(li_array[tareas[dia][i].pos]).find(".id_"+tareas[dia][i].responsable);
			seleccionarDelegado(usu_);
		};
	};
	$("#ht_c_view").css("height",htd_height_px);
	$("#ht_c_view_2").css("height",htd_height_px);
	$("#ht_c_view_6").css("height",htd_height_px);
}
var sleep = function(millis, callback) {
    setTimeout(function()
            { callback(); }
    , millis);
}

var foobar_cont = function (){
    console.log("finished.");
};

var obtenerId = function(e){
	var ul_ = $(e).parent();
	var li__ = $(ul_).parent();
	var id_ = $(li__).attr("id");
	id_ = id_.split("_");
	return id_[1];
}

var buscarIndLibre = function(fecha){
	var indi=-1;
	if (tareas[fecha].length<48) {
		indi=tareas[fecha].length;
	};
	return indi;
}

var buscarPosLibre = function(fecha){
	var cadena_pos = [];
	cadena_pos[48]="finished";
	for (var i = 0; i < tareas[fecha].length; i++) {
		if (typeof tareas[fecha][i] === 'object') {
			cadena_pos[tareas[fecha][i].pos]=true;
		}
	};
	var indi=-1;
	for (var i = 0; i < cadena_pos.length; i++) {
		if (cadena_pos[i]==null) {
			indi=i;
			i=100;
		};
	};
	return indi;
}

var seleccionarDelegado = function (obj_li) {
	var spa = buscarOpciones($(obj_li));
	if (spa[0].length) {
		spa[0].removeClass( "seleccionado" );
	};
	if (spa[1].length) {
		spa[1].addClass( "seleccionado" );
	};
	if (spa[2].length) {
		spa[2].addClass( "glyphicon-user" );
		spa[2].removeClass("glyphicon-minus");
	};
}

var buscarIndicePorPos = function (pos,fecha) {
	for (var i = 0; i < tareas[fecha].length; i++) {
		if (typeof tareas[fecha][i] === 'object') {
			if (tareas[fecha][i].pos==pos) {
				return i;
			};
		}
	};
}
var buscarIndicePorIdDia = function (id_dia,fecha) {
	if (tareas[fecha]!=null) {
		for (var i = 0; i < tareas[fecha].length; i++) {
			if (typeof tareas[fecha][i] === 'object') {
				if (tareas[fecha][i].id_dia==id_dia) {
					return i;
				};
			}
		};
	}else{
		return null;
	}
}