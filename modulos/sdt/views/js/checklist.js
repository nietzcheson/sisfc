/*jslint white: true, browser: true, undef: true, nomen: true, eqeqeq: true, plusplus: false, bitwise: true, regexp: true, strict: true, newcap: true, immed: true, maxerr: 14 */
/*global window: false, REDIPS: true */




/* enable strict mode */
"use strict";
var server = "http://"+window.location.hostname;
var lastrd=null;
var offset = null;
var offsetG = null;
var offset1 = null;
var offset2 = null;
var offset3 = null;
var myprogress = [];
$(document).ready(function(){
	
	//$("#tb0").css("position","absolute");
	
	$("#drag").css("display","absolute");
	$("#tb0").width(anchoTabla);
	$("#tbl").width(anchoTabla);
	$("#cargando").remove();
	
	$(".panel-body").removeClass();
	$("#contenido").removeClass();
	
	offsetG = $( "#tb0" ).offset();

	$("#tabla").scroll(function() {
		$( ".fijar2" ).css("background-color","#FFFFFF");
		$( ".fijar3" ).css("background-color","#FFFFFF");
		fijarFilasColumnas();
	});

	
	
	$("#tb").width($("#main_container").width()-10);
	$("#tb0").css( "zIndex", 2 );
	$(".fijar1").css( "zIndex", 1 );
	$(".fijar2").css( "zIndex", 1 );
	$(".fijar3").css( "zIndex", 1 );
	

	var dias = new Array();
	dias[0] = "Do";
	dias[1] = "Lu";
	dias[2] = "Ma";
	dias[3] = "Mi";
	dias[4] = "Ju";
	dias[5] = "Vi";
	dias[6] = "Sa";

	var diasCom = new Array();
	diasCom[0] = "Domingo";
	diasCom[1] = "Lunes";
	diasCom[2] = "Martes";
	diasCom[3] = "Miercoles";
	diasCom[4] = "Jueves";
	diasCom[5] = "Viernes";
	diasCom[6] = "Sabado";

	var meses = new Array();
	meses["01"] = "Enero";
	meses["02"] = "Febrero";
	meses["03"] = "Marzo";
	meses["04"] = "Abril";
	meses["05"] = "Mayo";
	meses["06"] = "Junio";
	meses["07"] = "Julio";
	meses["08"] = "Agosto";
	meses["09"] = "Septiembre";
	meses["10"] = "Octubre";
	meses["11"] = "Noviembre";
	meses["12"] = "Diciembre";

	$('#bt-searchRM').tooltip('show');
	$("#bt-searchRM").tooltip({
		placement: 'bottom',
		template: '<div class="tooltip" style="width: 100px;background-color:#ef0d0a;" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
	});


	var dayx=0;
	var objini=null;
	var cellini=null;
	var textdif="";
	var numCells=0;
	$("#tb0 .cdark_top").each(function (index, element) {
		var newTexto = NewDate_Month_Year(meses, dayx);
		var divc = $('<div>'+newTexto+'</div>');
		// codigo para combinar celdas
		$(element).append(divc);
		if (textdif!=newTexto) {
			textdif=newTexto;
			if (objini) {
				$(cellini).attr('colspan',''+parseInt(numCells)+'');
				$(objini).attr("data-toggle","tooltip");
				$(objini).attr("title",$(objini).text());
				if (parseInt(numCells)==3) {
					$(objini).text($(objini).text().slice(0,6));
				}else if (parseInt(numCells)==2) {
					$(objini).text($(objini).text().slice(0,4));
				}else if (parseInt(numCells)==2) {
					$(objini).text($(objini).text().slice(0,2));
				}
				$(objini).tooltip({
					placement: 'bottom',
					template: '<div class="tooltip" style="width: 100px;" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
				});
				numCells=0;
			};
			objini=$(divc);
			cellini=$(element);
		}else{
			$(element).remove();
		}
		numCells+=1;
		dayx+=1;
	});
	$(cellini).attr('colspan',''+parseInt(numCells)+'');
	$(objini).attr("data-toggle","tooltip");
	$(objini).attr("title",$(objini).text());
	if (parseInt(numCells)==3) {
		$(objini).text($(objini).text().slice(0,6));
	}else if (parseInt(numCells)==2) {
		$(objini).text($(objini).text().slice(0,4));
	}else if (parseInt(numCells)==2) {
		$(objini).text($(objini).text().slice(0,2));
	}
	$(objini).tooltip({
		placement: 'bottom',
		template: '<div class="tooltip" style="width: 100px;" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
	});
			
	var dayx=0;
	var dayx2=parseInt(nameday);
	var cellini=null;
	var numtr = $('#tbl >tbody >tr').length;
	$("#tb0 .cdark_bottom").each(function (index, element) {
		var divs = $('<div style="position: relative;"></div>');

		var opcion1= $('<option value="Todo">Todo</option>');
		var opcion2= $('<option value="circle">Cualquier estado</option>');
		var opcion3= $('<option value="minus">Sin resolver</option>');
		var opcion4= $('<option value="ok">Checkado</option>');
		var opcion5= $('<option value="arrow-right">Transferido</option>');
		var opcion6= $('<option value="remove">No realizado</option>');
		var select = $('<select id="p_d_'+(dayx+4)+'" class="filtro_dia" style="width: 20px;height: 10px;">');
		
		$(select).append(opcion1);
		$(select).append(opcion2);
		$(select).append(opcion3);
		$(select).append(opcion4);
		$(select).append(opcion5);
		$(select).append(opcion6);
		$(divs).append(select);

		$(element).append(divs);

		var divc = $('<div class="conten_dia">'+NewDate_NumDay(dayx)+'</div>');
		$(divs).append(divc);

		$(divc).attr("data-toggle","tooltip");
		$(divc).attr("title",diasCom[dayx2] + "  " + NewDate_Complete(meses, dayx));
		$(divc).tooltip({
			placement: 'bottom',
			template: '<div class="tooltip" style="width: 100px;" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
		});

		$(select).attr("data-toggle","tooltip");
		$(select).attr("title","Filtrar por Estado del dia");
		$(select).tooltip({
			placement: 'bottom',
			template: '<div class="tooltip" style="width: 100px;" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
		});
		// Encontrar el lunes
		if (dayx2==1) {
			// buscamos la celda de la columna de abajo
			//var element_botton = $("#tbl").find(" tr:eq(0) > td:eq("+(3+dayx)+")");
			$("#tbl").find("tr").each(function (index2, element2) {
				var element_botton = $(element2).find('td:eq('+(3+dayx)+')');
				// Bucar si la celta contiene otro elemento
				var time_u = element_botton.find(".circle");
				if ($(time_u).length==0) {
					time_u = element_botton.find(".circlemas");
				}
				// esto con el fin de ajustar la altura
				if ($(time_u).length==0) {
					var div_down = $('<div class="beginweek" style="height:'+($(element2).height())+'px"></div>');

				}else{
					var div_down = $('<div class="beginweek" style="height:'+($(element2).height())+'px;top:-28px;"></div>');
				}
				var divr = $('<div style="position: relative;"></div>');
				$(divr).append(div_down);
				element_botton.append(divr);
			});
			
			// division para la tabla cabecera
			var div_top = $('<div class="beginweek" style="height:36px"></div>');
			$(divs).append(div_top);
		};

		dayx+=1;
		dayx2+=1;
		if (dayx2>6) {
			dayx2=0;
		};
	});
	// Funcionalidad ocultar y mostrar barra de lateral de Menu
	var posleftwrap=null;
	$("#btn_all_screen").attr("data-toggle","tooltip");
	$("#btn_all_screen").attr("title","Ocultar Menu de Navegacion");
	$("#btn_all_screen").tooltip({
		placement: 'bottom',
		template: '<div class="tooltip" style="width: 100px;" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
	});
	$("#btn_all_screen").click(function(){
		var span = $(this).find('span');
		var postb =0;
		var widthtb =0;
		if ($(span).attr('class').indexOf('left')>-1) {
			$(span).attr('class','glyphicon glyphicon-arrow-right');
			$("#side-bar").fadeOut();
			if (!posleftwrap) {
				posleftwrap = $("#wrap-contenido").offset();
				posleftwrap = posleftwrap.left;
			};
			$("#wrap-contenido").offset({ left: 0  });
			$("#header-contenido").offset({ left: 0  });
			postb=30;
			widthtb="100%";
			$(this).attr("data-original-title","Mostrar Menu de Navegacion");
		}else{
			$(span).attr('class','glyphicon glyphicon-arrow-left');
			$("#side-bar").fadeIn();
			$("#wrap-contenido").offset({ left: posleftwrap  });
			$("#header-contenido").offset({ left: posleftwrap  });
			postb=posleftwrap+30;
			widthtb="80%";
			$(this).attr("data-original-title","Ocultar Menu de Navegacion");
		}
		$('#wrap-contenido').css('width', widthtb);
		$('#header-contenido').css('width', '100%');
		$('#tb').css('width', '100%');
		$('#tb').offset({ left: postb  });
		offsetG = $( "#tb" ).offset();
		fijarFilasColumnas();
	});

	// Funcionalidad mostrar formulario para crear una tarea
	$("#btn_add_task").tooltip({
		placement: 'right',
		template: '<div class="tooltip" style="width: 80px;" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
	});

	// Funcionalidad ver el checklist de otros usuarios
	$("#btn_see_users").tooltip({
		placement: 'left',
		template: '<div class="tooltip" style="width: 110px;" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
	});
	$("#other_user").change(function(){
		window.location="http://"+window.location.hostname+"/sdt/check_list/"+$(this).val();
	});

	// Agrergar tooltip a los dias del cuadro de dialogo en la creacion de tareas individuales.
	$(".select").tooltip({
		placement: 'top',
		template: '<div class="tooltip" style="width: 80px;" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
	});
	
	$("#btn_add_task").click(function(){
		//$('#popupnewtarea').bPopup();

		// $('#popupnewtarea').modal()                      // initialized with defaults
		// $('#popupnewtarea').modal({ keyboard: false })   // initialized with no keyboard
		// $('#popupnewtarea').modal('show')
	});

	$('#unidadTiempo').change(function(){
		var aaa = $("#tb tr:eq(0) td:eq(2) .clone");
		aaa.attr("class", "drag clone orange "+$('#unidadTiempo').val()+" vacio");

	});
	$('#tabla').on('click', '.circle', function(){
		// alert("Cambia de figura")
		var estado=1;
		var estadoclass = "chuleado";
		if ($(this).attr("class")==(ico_check+ " circle")) {
			$(this).attr("class",ico_later + " circle");
			estado=2;
			estadoclass = "transferido";
		}else if ($(this).attr("class")==(ico_later+ " circle")) {
			$(this).attr("class",ico_remove + " circle");
			estado=3;
			estadoclass = "nohizo";
		}else if ($(this).attr("class")==(ico_remove+ " circle")) {
			$(this).attr("class",ico_null + " circle");
			estado=0;
			estadoclass = "vacio";
		}else{
			$(this).attr("class",ico_check + " circle");
		}

		var div1=$(this).parent();
		var div2=$(div1).parent();

		var div3=$(div2).parent(".mark");
		// update state for each day

		var id = $(div3).attr("id");
		var dia = id.split("_");
		dia = parseInt(dia[1]);

		var light='';
		if (dia<ntoday) {
			light="light";
		};
		
		var clact = $(div2).attr("class");
		clact = clact.split(" ");
		$(div2).attr("class",clact[0] + " orange dia " +estadoclass+light);

		// $.post(server+'/sdt/actualizarTareaEstado','dia='+$(div2).attr("id")+'&estado='+estado+"&fecha="+NewDate(dia-4));
		// alert(NewDate(dia-4));
		$.post(server+'/sdt/actualizarTareaEstado','dia='+$(div2).attr("id")+'&estado='+estado+"&fecha="+NewDate(dia-4), function(datos){
        	if (datos!="None" && datos!="") {
	        	$(div2).attr("id",datos);
	        };
	    }, 'json');

		var td=$(div2).parent();
		var tr=$(td).parent();
		var hijo1 = $(tr).find("td[class^='only cligth2']");
		calculate(tr,hijo1,0);
		
		// hijo1.text(calculate(tr));
	});
	$('#tb').on('click', '#rangoVista', function(){

	});
	$("#rangoVista").change(function() {
		window.location="http://"+window.location.hostname+"/sdt/check_list/"+dia1+"/"+(parseInt(mes1)+1)+"/"+ anio1+"/NaN/"+$(this).val();
	});
	

	//Validar valores para tareas periodicas.
	$('#submit_respuesta').attr("disabled", true);
	$('#respuesta_si').click(function(){
		$('#submit_respuesta').attr("disabled", false);
		$('#comentario').fadeOut();
	});
	$('#respuesta_no').change(function(){
		var valor1 = $('#comentario').text();
		$('#comentario').fadeIn();
		if (valor1.trim()!="") {
			$('#submit_respuesta').attr("disabled", false);
		}else{
			$('#submit_respuesta').attr("disabled", true);
		}
	});
	$('#comentario').keyup(function(){
		var valor1 = $('#comentario').val();
		if (valor1.trim()!="") {
			$('#submit_respuesta').attr("disabled", false);
		}else{
			$('#submit_respuesta').attr("disabled", true);
		}
	});

	// Si se encuentra aceptada la tarea se mostraran los objetivos
	$("span[id^='re_']").click(function(){
		var ide = $(this).attr("id");
		ide = ide.slice(3,ide.length);
		if ( $(this).attr("class").indexOf("respuesta")>-1) {
			$("#taread").val(ide);
			$('#popup2').bPopup();
		}else if ( ($(this).attr("class").indexOf("success")>-1 || $(this).attr("class").indexOf("primary")>-1 ) && $(this).attr("class").indexOf("mas")==-1) { 
			$("label[id^='rObj_']").attr("id","rObj_"+ide);
			$("label[id^='rCom_']").attr("id","rCom_"+ide);
			$("button[id^='crearCom_']").attr("id","crearCom_"+ide);
			if ( $("label[id^='rObj_']").attr("class").indexOf("active")>-1){
				listaObjetivos(ide);
			}else{
				listaComentarios(ide);
			}
			$('#popobje').bPopup();
		}
	});
	$("label[id^='rObj_']").click(function(){
		$("#comentarioMenu").fadeOut();
		var ide = $(this).attr("id");
		ide = ide.slice(5,ide.length);
		listaObjetivos(ide);
	});
	$("label[id^='rCom_']").click(function(){
		$("#comentarioMenu").fadeIn();
		var ide = $(this).attr("id");
		ide = ide.slice(5,ide.length);
		listaComentarios(ide);
	});
	$("#objetivostarea").on("click","input[id^='chek']", function(e){
		var estado=0;
		if ($(this).is(':checked')) {
			estado=1;
		}
		var id = $(this).attr("id");
	    id = id.slice(5,id.length);
		$.post(server+'/sdt/actualizarTareaItem2','id='+id+'&estado='+estado).fail(function() {
		    console.log("error de conexion");
		});
	});

	$("button[id^='crearCom_']").click(function(){
		var ide = $(this).attr("id");
		ide = ide.slice(9,ide.length);
		$.post(server+'/sdt/crearSDTNota','id='+ide+'&com='+$("#newCom").val(), function(datos){
			if (datos!="None") {
				$("#vacio").remove();
				var tr = $('<tr style="display: none;"></tr>');
				var label = $('<span class="label label-default">'+datos.fecha_nota+'</span>')
				var span =$('<span> <strong>'+datos.nickname_usuario+' : </strong></span>')
				var div =$('<div style="width:350px;word-break: keep-all">'+$("#newCom").val()+'</div>')
				var td = $('<td></td>');
				td.append(label);
				td.append(span);
				td.append(div);
				tr.append(td);
				$("#objetivostarea").append(tr);
				$("#newCom").val('');
				$(tr).fadeIn();
			};
		}, 'json').fail(function() {
		    console.log("error de conexion");
		});
	});

	$("#Setiqueta").change(function(){
		var valore = $("#Setiqueta").val();
		$.post(server+'/sdt/actualizarSDTTareaEtiqueta','id='+$("#tareaid").val()+'&etiqueta='+valore, function(datos){
			if (datos!="None") {
				var elemen = $("#tx_"+$("#tareaid").val());
				$(elemen).css("font-family",datos.ffamily);
				$(elemen).css("font-size",datos.fsize+"px");
				$(elemen).css("color",datos.fcolor);
				$(elemen).css("background-color",datos.fcback);

				var heightTR =$("#tr_"+$("#tareaid").val()).height();
				console.log("aqui hay una cosa "+heightTR);
				$("#tr_"+$("#tareaid").val()).find(".beginweek").each(function (index2, element2) {
					$(element2).css("height",heightTR+"px");
					console.log($(element2).css("height"));
				})
				
			}
		}, 'json').fail(function() {
		    console.log("error de conexion");
		});
		
	});

	// Etiquetas
	$("div[id^='tx_']").click(function(){
		var ide = $(this).attr("id");
		ide = ide.slice(3,ide.length);
		$.post(server+'/sdt/getSDTInfoTarea','id='+ide, function(datos){
			if (datos!="None") {
				$("#popuptareatitle").text($("#tx_"+ide).text());
				$("#popuptareatext").text(datos.descripcion);
				$("#Setiqueta").val(datos.id_etiqueta);
				$("#tareaid").val(ide);
				$('#popuptarea').bPopup();
				$("#url_access").html('');
				if (datos.ir_a!="") {
					var link = $('<a href="'+datos.url+'">'+datos.ir_a+'</a>');
					$("#url_access").append(link);
				};

			};
		}, 'json').fail(function() {
		    console.log("error de conexion");
		});
	});
	//eliminar unidad de tiempo en el caso de no almacenarse
	fijarFilasColumnas();


	$('#formulario1').css("visibility", "none");

	var time=setInterval(ajustarPosicion, 500);


	

	// Desplazar scroll al dia hoy
	var leftPos = $('#tabla').scrollLeft(); 
    if (parseInt(ntoday)>23 && (parseInt(ntoday)-3)<=parseInt(ndays)) {
    	$("#tabla").animate({
	        scrollLeft: leftPos + (parseInt(ntoday)-23)*30+36+250+10
	    }, 800);
    }


    //actualizar los porcentajes de las filas periodicas.
	$("#tbl").find("tr").each(function (index, element) {
		var id_tr = $(element).attr("id");
		id_tr = id_tr.split("_");
		id_tr=id_tr[1];
		var barrapross = $('#progressbar_'+id_tr);
		var name_bar = $(barrapross).attr("name");
		name_bar = name_bar.split("_");
		var porcentaje=name_bar[1];
		var spanVisita = $(element).find("span[class^='label label-warning']");

		if ($(element).find(".redondo").length) {
			console.log(id_tr + "  " + spanVisita.length + "  " + porcentaje);
			var hijo = $(element).find("td[class^='only cligth2']");
			var cn=0;
			var cn2=0;
			$(element).find(".orange").each(function (index2, element2) {
				cn+=1;
				var hijo2 = $(element2).find(".circle");
				if (!hijo2.length) {
					hijo2 = $(element2).find(".circlemas");
				};
				if (!hijo2.length) {
					hijo2 = $(element2).find(".circlemasmas");
				};
				if ($(hijo2).attr("class").indexOf(ico_null)==-1 && $(hijo2).attr("class").indexOf(ico_remove)==-1) {
					cn2+=1;
				};
				if (cn2<0) {
					cn2=0;
				};
			});

			if (cn===0) {
				//hijo.text("0.00");
			}else{
				//hijo.text((cn2 / cn * 100).toFixed(2));
				porcentaje=(cn2 / cn * 100).toFixed(2);
			}
		}
		
		var td_porc=$(element).find(".fijar3");
		//porcentaje=td_porc.text();
		// Agregar las barras de progreso sirculares
		
		myprogress[id_tr] = $(barrapross).cprogress({
	   		percent: 0, // starting position
	       	img1: server+'/public/img/circle_red.png', // background
	       	img2: server+'/public/img/circle_green.png', // foreground
	       	speed: 25, // speed (timeout)
	       	PIStep : 0.1, // every step foreground area is bigger about this val
	       	limit: porcentaje, // end value
	       	loop : false, //if true, no matter if limit is set, progressbar will be running
	       	showPercent : false, //show hide percent
		});
		var canvas = $(barrapross).find('canvas');
		$(canvas).attr("data-toggle","tooltip");
		$(canvas).attr("title",porcentaje + " %");
		$(canvas).tooltip({
			placement: 'right',
			template: '<div class="tooltip" style="width: 80px;" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
		});
	});
	var time2=setInterval(actualizarBarras, 1000);
});

var actualizarBarras = function(){
	$.each( myprogress, function( key, value ) {
		if (typeof value !== typeof undefined && value !== false) {
			var canvas = $('#progressbar_'+key).find('canvas');
			if (canvas.length) {
				if (canvas.width()!=0) {
				}else{
					value.options({
				    	img1: server+'/public/img/circle_red.png', // background
		      		 	img2: server+'/public/img/circle_green.png'
				    });
				    value.reset();
				}
			};
		}
	});
}
var listaObjetivos = function(id){
	$.post(server+'/sdt/getSDTItems','id='+id, function(datos){
		$("#objetivostarea").html("");
		var entro='<tr><td class="col-md-1"></td><td class="col-md-9">Ningun objetivo...</td></tr>';
		for (var i = 0; i < datos.length; i++) {
			var tr = $('<tr id="tr_'+datos[i].id_tarea_item+'" ></tr>');
			var td1 = $('<td class="col-md-1"></td>');
			var estado="";
			if (datos[i].estado_item==1) {
				estado="checked";
			};
			var inp1 = $('<input type="checkbox" id="chek_'+datos[i].id_tarea_item+'" class="chek" '+estado+'>');
			var td2 = $('<td class="col-md-9"></td>');
			var div = $('<div style="width:310px;word-break: keep-all">'+datos[i].nombre_item+'</div>');
			td1.append(inp1);
			tr.append(td1);
			td2.append(div);
			tr.append(td2);
			$("#objetivostarea").append(tr);
			entro='';
		};
		if (entro!='') {
			$("#objetivostarea").html(entro);
		};

	}, 'json').fail(function() {
	    console.log("error de conexion");
	});
}
var listaComentarios = function(id){
	$.post(server+'/sdt/getSDTNotas','id='+id, function(datos){
		$("#objetivostarea").html("");
		var entro='<tr id="vacio"><td class="col-md-1"></td><td class="col-md-9">Ningun comentario...</td></tr>';
		for (var i = 0; i < datos.length; i++) {
			var tr = $('<tr ></tr>');
			var label = $('<span class="label label-default">'+datos[i].fecha_nota+'</span>')
			var span =$('<span> <strong>'+datos[i].nickname_usuario+' : </strong></span>')
			var div =$('<div style="width:350px;word-break: keep-all">'+datos[i].comentario+'</div>')
			var td = $('<td></td>');
			td.append(label);
			td.append(span);
			td.append(div);
			tr.append(td);
			$("#objetivostarea").append(tr);
			entro='';
		};
		if (entro!='') {
			$("#objetivostarea").html(entro);
		};
	}, 'json').fail(function() {
	    console.log("error de conexion");
	});
}
var calculate = function(tr,hijo,inc){
	if (tr.attr("class")!="input-group") {
		var id_tr = $(tr).attr("id");
		id_tr = id_tr.split("_");
		id_tr=id_tr[1];
		var porcentaje="00.00"
		var td = tr.find("td:eq(5)");
		if (tr.find(".redondo").length) {
			var cn=0;
			var cn2=0;
			tr.find(".orange").each(function (index, element) {
				cn+=1;
				var hijo2 = $(element).find(".circle");
				if ($(hijo2).attr("class")!=(ico_null+ " circle") && $(hijo2).attr("class")!=(ico_remove+ " circle")) {
					cn2+=1;
				};
				if (cn2<0) {
					cn2=0;
				};
			});
			if (cn===0) {
				// hijo.text("0.00");
			}else{
				//  hijo.text((cn2 / cn * 100).toFixed(2));
				porcentaje=(cn2 / cn * 100).toFixed(2);
			}
			myprogress[id_tr].options({limit: porcentaje});
			myprogress[id_tr].reset();
			var canvas = $("#progressbar_"+id_tr).find('canvas');
			$(canvas).attr("data-original-title",porcentaje+ " %");
		}else{
			var row_id = tr.attr("id");
			if (row_id) {
				row_id = row_id.slice(3,row_id.length);
				$.post(server+'/sdt/darporcenTarea','tarea='+row_id+"&inc="+inc, function(datos){
			    	if (datos!="None" && datos!="None2") {
			    		datos = datos.split("_");
			        	porcentaje=datos[0];
			        	if (datos[1]=="0") {
			        		$("#re_"+row_id).attr('class','label label-primary');
			        	};
			        }else{
			        	porcentaje="00.00"
			        }
			        myprogress[row_id].options({
			        	speed: 100,
			        	limit: porcentaje
			        });
					myprogress[row_id].reset();
					var canvas = $("#progressbar_"+row_id).find('canvas');
					$(canvas).attr("data-original-title",porcentaje+ " %");
			    }, 'json');
			};
		}
	};
}
var fijarFilasColumnas = function(){
	if ($("#rangoVista").val()!="semana") {
		//if (!offset) {
			offset = $( "#tb" ).offset();
			offset = offset.top + $( "#tb" ).height();
		//};
		//if (!offset1) {
			// offset1 = $( "#tb" ).offset();
			offset1 =offsetG.left;
		//};
		//if (!offset2) {
			offset2 =offset1+50;
		//};
		//if (!offset3) {
			offset3 =offset2+248;
		//};
		$( "#tb0" ).offset({ top: offset });
		$( ".fijar1" ).offset({ left: offset1  });
		$( ".fijar2" ).offset({ left: offset2  });
		$( ".fijar3" ).offset({ left: offset3  });
	};
}
var NewDate = function(days){
    var fecha=new Date(anio1,mes1,dia1);
    //Obtenemos los milisegundos desde media noche del 1/1/1970
    var tiempo=fecha.getTime();
    //Calculamos los milisegundos sobre la fecha que hay que sumar o restar...
    var milisegundos=parseInt(days*24*60*60*1000);
    //Modificamos la fecha actual
    var total=fecha.setTime(tiempo+milisegundos+1*60*60*1000);
    var day=fecha.getDate();
    var month=fecha.getMonth()+1;
    var year=fecha.getFullYear();
    if (parseInt(day)<10) {
    	day="0"+day;
    };
    if (parseInt(month)<10) {
    	month="0"+month;
    };
    return day+"/"+month+"/"+year;
}
var NewDate_Complete = function(meses, days){
    var fecha=new Date(anio1,mes1,dia1);
    //Obtenemos los milisegundos desde media noche del 1/1/1970
    var tiempo=fecha.getTime();
    //Calculamos los milisegundos sobre la fecha que hay que sumar o restar...
    var milisegundos=parseInt(days*24*60*60*1000);
    //Modificamos la fecha actual
    var total=fecha.setTime(tiempo+milisegundos+1*60*60*1000);
    var day=fecha.getDate();
    var month=fecha.getMonth()+1;
    var year=fecha.getFullYear();
    if (parseInt(day)<10) {
    	day="0"+day;
    };
    if (parseInt(month)<10) {
    	month="0"+month;
    };
    return day+" de "+meses[month] +" del "+year;
}

var NewDate_NumDay = function(days){
    var fecha=new Date(anio1,mes1,dia1,0,0,9);
    //Obtenemos los milisegundos desde media noche del 1/1/1970
    var tiempo=fecha.getTime();
    //Calculamos los milisegundos sobre la fecha que hay que sumar o restar...
    var milisegundos=parseInt(days*24*60*60*1000);
    //Modificamos la fecha actual
    var total=fecha.setTime(tiempo+milisegundos+1*60*60*1000);
    var day=fecha.getDate();
    if (parseInt(day)<10) {
    	day="0"+day;
    };
    return day;
}
var NewDate_Month_Year = function(meses,days){
    var fecha=new Date(anio1,mes1,dia1);
    //Obtenemos los milisegundos desde media noche del 1/1/1970
    var tiempo=fecha.getTime();
    //Calculamos los milisegundos sobre la fecha que hay que sumar o restar...
    var milisegundos=parseInt(days*24*60*60*1000);
    //Modificamos la fecha actual
    var total=fecha.setTime(tiempo+milisegundos+1*60*60*1000);
    var month=fecha.getMonth()+1;
    var year=fecha.getFullYear();
    if (parseInt(month)<10) {
    	month="0"+month;
    };
    return meses[month]+" "+year;
}
// define redipsInit variable
//var redipsInit;
var redips = {};

// redips initialization
redips.Init = function () {
	// reference to the REDIPS.drag library and message line

	var rt = REDIPS.table,
		rd = REDIPS.drag;

	// initialization
	rd.init();

	// dragged elements can be placed to the empty cells only
	rd.dropMode = 'single';

	// attach onmousedown event handler to tblEditor
	//rt.onmousedown(redips.tableEditor, true);

	// set question for row deletion
	rd.trash.questionRow = 'Estas seguro de eliminar esta fila?';
	// REDIPS.drag.trash.question = 'Estas seguro de eliminar esta unidad de tiempo?';
	//rd.clone.keyDiv = true;
	// enable clone element and clone row with shift key
	//rd.clone.keyDiv = rd.clone.keyRow = true;

	// set hover color for TD and TR
	rd.hover.colorTd = '#a6a0a8';
	rd.hover.colorTr = '#9BB3DA';
	// set hover border for current TD and TR
	rd.hover.borderTr = '2px solid #32568E';
	
	$("div[class~='drag']").each(function (index, element) {
		if ($(element).attr("id")) {
			rd.mark.exception[$(element).attr("id")] = 'proyecto';
		};
	});
		

	// event handler invoked after element is cloned
	rd.event.cloned = function () {
		// set id of cloned element
		var clonedId = rd.obj.id;
		// if id of cloned element begins with "e" then make exception (allow DIV element to access cells with class name "mark")
	
		if ($('#unidadTiempo').val() === 'periodico') {   
			rd.mark.exception[clonedId] = 'periodico';
		}else{
			rd.mark.exception[clonedId] = 'proyecto';
		}
	};
	
	rd.event.dropped = function () {
		var el = rd.obj;
		var row_id = REDIPS.drag.findParent('TR', el).id;
		row_id = row_id.slice(3,row_id.length);
		var	objOld = rd.objOld,					// original object
			targetCell = rd.td.target,			// target cell
			targetRow = targetCell.parentNode,	// target row
			i, objNew;							// local variables
		
		
		var id = targetCell.id;
		var dia = id.split("_");
		dia = parseInt(dia[1]);
		//alert(el.id + "  " + el.id.indexOf("c"));

		// if checkbox is checked and original element is of clone type then clone spread subjects to the week
		if (objOld.className.indexOf('periodico') > -1) {
			//el.className = "drag orange dia";
			$('#fecha_1').val(NewDate(dia-4));
			$("#tarea_form").val(row_id);
			
		}else{
			if (el.id.indexOf("c")>-1) {
				$("#"+el.id).attr("disabled", "disabled");
				$.post(server+'/sdt/guardarTareaDia','tarea='+row_id+'&fecha='+NewDate(dia-4)+'&estado='+estado, function(datos){
		        	if (datos!="None" && datos!="") {
			        	el.id=datos;
			        	rd.mark.exception[el.id] = 'proyecto';

			        	var light='';
						if (dia<ntoday) {
							light="light";
						};
						$("#"+el.id).attr("disabled", "none");
						$("#"+el.id).attr("class","drag orange dia vacio"+light);
			        };
			    }, 'json');
			}else{
				var td=$(el).parent();
				var hijo1 = $(td).find(".circle");
				var estado=0;
				var estadoclass = "nohizo";
				if ($(hijo1).attr("class")==(ico_null+ " circle")) {
					estado=1;
					estadoclass = "vacio";
				}else if ($(hijo1).attr("class")==(ico_check+ " circle")) {
					estado=2;
					estadoclass = "chuleado";
				}else if ($(hijo1).attr("class")==(ico_later+ " circle")) {
					estado=3;
					estadoclass = "transferido";
				}

				//$.post(server+'/sdt/actualizarTareaDia','dia='+el.id+'&tarea='+row_id+'&fecha='+NewDate(dia-4)+'&estado='+estado);
				$.post(server+'/sdt/actualizarTareaDia','dia='+el.id+'&tarea='+row_id+'&fecha='+NewDate(dia-4));
				rd.mark.exception[el.id] = 'proyecto';

				var light='';
				if (dia<ntoday) {
					light="light";
				};
				$("#"+el.id).attr("class","drag orange dia "+estadoclass+light);

			};
			// if checkbox is checked and original element is of clone type then clone spread subjects to the week
			if (objOld.className.indexOf('semana') > -1) {
				//drag clone orange dia
				var light='';
				var dia2='';
				if (dia<ntoday) {
					light="light";
				};
				el.className = "drag orange dia vacio"+light;
				// loop through table cells
				for (i = 0; i < targetRow.cells.length; i++) {
					// skip cell if cell has some content (first column is not empty because it contains label)
					if (targetRow.cells[i].childNodes.length > 0) {
						continue;
					}
					if (i>=dia && i<(dia+6)) {
						
						// clone DIV element
						objNew = rd.cloneObject(el);

						var id = targetRow.cells[i].id;
						dia2 = id.split("_");
						dia2 = parseInt(dia2[1]);
						light='';
						if (dia2<ntoday) {
							light="light";
						};
						objNew.className = "drag orange dia vacio"+light;

						
						// append to the table cell
						targetRow.cells[i].appendChild(objNew);
						if (objNew.id.indexOf("c")>-1) {

							$.post(server+'/sdt/guardarTareaDiaClone','tarea='+row_id+'&idtemp='+objNew.id+'&fecha='+NewDate(i-3)+'&estado=0', function(datos){
					        	
					        	if (datos!="None" && datos!="") {
						        	datos = datos.split("_");
						        	$("#"+datos[1]).attr("id",datos[0])
						        	rd.mark.exception[datos[0]] = 'proyecto';
						        };
						    }, 'json');
						}else{
							$.post(server+'/sdt/actualizarTareaDia','dia='+el.id+'&tarea='+row_id+'&fecha='+NewDate(i-3)+'&estado=0');
							rd.mark.exception[el.id] = 'proyecto';
							console.log("aqui2");
							// var light='';
							// if (i<ntoday) {
							// 	light="light";
							// };
							// $("#"+el.id).attr("class","drag orange dia "+estadoclass+light);
						};

						

						//alert(NewDate(i-3));
					};
				}
			}
			if (objOld.className.indexOf('mes') > -1) {
				//drag clone orange dia
				var light='';
				var dia2='';
				if (dia<ntoday) {
					light="light";
				};
				el.className = "drag orange dia vacio"+light;
				// loop through table cells
				for (i = 0; i < targetRow.cells.length; i++) {
					// skip cell if cell has some content (first column is not empty because it contains label)
					if (targetRow.cells[i].childNodes.length > 0) {
						continue;
					}
					if (i>=dia && i<(dia+30)) {
						// clone DIV element
						objNew = rd.cloneObject(el);

						var id = targetRow.cells[i].id;
						dia2 = id.split("_");
						dia2 = parseInt(dia2[1]);
						light='';
						if (dia2<ntoday) {
							light="light";
						};
						objNew.className = "drag orange dia vacio"+light;

						// append to the table cell
						targetRow.cells[i].appendChild(objNew);
						if (objNew.id.indexOf("c")>-1) {
							$.post(server+'/sdt/guardarTareaDiaClone','tarea='+row_id+'&idtemp='+objNew.id+'&fecha='+NewDate(i-3)+'&estado=0', function(datos){
					        	if (datos!="None" && datos!="") {
					        		
						        	datos = datos.split("_");
						        	$("#"+datos[1]).attr("id",datos[0])
						        	rd.mark.exception[datos[0]] = 'proyecto';
						        };
						    }, 'json');
						}else{
							$.post(server+'/sdt/actualizarTareaDia','dia='+objNew.id+'&tarea='+row_id+'&fecha='+NewDate(i-3)+'&estado=0');
						};
					};
				}
			}
			var td=$(el).parent();
			var tr=$(td).parent();
			var hijo1 = $(tr).find("td[class^='only cligth2']");
			var cn=0;
			var cn2=0;
			calculate(tr,hijo1,0);
		}
		
		// print message only if target and source table cell differ
		if (rd.td.target !== rd.td.source) { 
			//printMessage('Content has been changed!');
		}
	};
	rd.event.clicked = function () {
		var el = rd.obj;
		var td=$(el).parent();
		var tr=$(td).parent();
		var hijo1 = $(tr).find("td[class^='only cligth2']");
		// var cn=-1;
		// var cn2=-1;
		// tr.find(".orange").each(function (index, element) {
		// 	cn+=1;
		// 	var hijo2 = $(element).find(".circle");
		// 	if ($(hijo2).attr("class")!=(icon3+ " circle")) {
		// 		cn2+=1;
		// 	};
		// 	if (cn2<0) {
		// 		cn2=0;
		// 	};
		// });
		// if (cn===0) {
		// 	hijo1.text("0.00");
		// }else{
		// 	hijo1.text((cn2 / cn * 100).toFixed(2));
		// }
		// var div,	// DIV element reference
		// 	i;		// loop variable
		// // loop goes through all DIV elements inside table editor
		// for (i = 0; i < redips.tableEditorDivs.length; i++) {
		// 	// set reference to the DIV element
		// 	div = redips.tableEditorDivs[i];
		// 	// if DIV element contains class name of component details then hide
		// 	if (div.className.indexOf(redips.cDetails) > -1) {
		// 		redips.details(div, 'hide');
		// 	}
		// }
		var cn=0;
		var cn2=0;
		var td2=$(el).parent();
		var hijo2 = $(td2).find(".circle");
		var estado=0;
		if ($(hijo2).attr("class")==(ico_check+ " circle")) {
			estado=1;
		}else if ($(hijo2).attr("class")==(ico_later+ " circle")) {
			estado=2;
		}else if ($(hijo2).attr("class")==(ico_remove+ " circle")) {
			estado=3;
		}
		//update state for each day
		
		//$.post(server+'/sdt/actualizarTareaEstado','dia='+el.id+'&estado='+estado);
		calculate(tr,hijo1,el.id);
		// alert("here");
	};
	rd.event.notMoved = function () {
		var el = rd.obj;
		var td=$(el).parent();
		var tr=$(td).parent();
		var hijo1 = $(tr).find("td[class^='only cligth2']");
		var cn=0;
		var cn2=0;
		var td2=$(el).parent();
		var hijo2 = $(td2).find(".circle");
		var estado=0;
		if ($(hijo2).attr("class")==(ico_check+ " circle")) {
			estado=1;
		}else if ($(hijo2).attr("class")==(ico_later+ " circle")) {
			estado=2;
		}else if ($(hijo2).attr("class")==(ico_remove+ " circle")) {
			estado=3;
		}
		//update state for each day
		//$.post(server+'/sdt/actualizarTareaEstado','dia='+el.id+'&estado='+estado);
		calculate(tr,hijo1,0);
	};
	// after element is deleted from the timetable, print message
	rd.event.deleted = function () {
		var el = rd.obj;

		var el = rd.obj;
		var id = el.id;
		id = id.slice(3,id.length);
		//alert(id);

		//var td=$(el).parent();
		//var tr=$(td).parent();
		//var hijo1 = $(tr).find("td[class^='only cligth2']");
		$.post(server+'/sdt/eliminarTareaDia','objeto='+el.id);
		//calculate(tr,hijo1,0,"notMoved ");
	};
	// row was clicked - event handler
	rd.event.rowClicked = function () {
		// set current element (this is clicked TR)
		var el = rd.obj;
		// find parent table
		el = rd.findParent('TABLE', el);
		// every table has only one SPAN element to display messages
		// msg = el.getElementsByTagName('div')[0];
		// display message
		// msg.innerHTML = 'Clicked';
		// alert(msg.attr('class'));
		// if (msg.attr('class')=="orange") {
		// 	msg.attr('class','blue');
		// }else if (msg.attr('class')=="blue") {
		// 	msg.attr('class','orange');
		// };
	};
	// row was moved - event handler
	rd.event.rowMoved = function () {
		// set opacity for moved row
		// rd.obj is reference of cloned row (mini table)
		rd.rowOpacity(rd.obj, 85);
		// set opacity for source row and change source row background color
		// rd.objOld is reference of source row
		rd.rowOpacity(rd.objOld, 20, 'White');
		// display message
		//msg.innerHTML = 'Moved';
	};
	// row was not moved - event handler
	rd.event.rowNotMoved = function () {
		//msg.innerHTML = 'Not moved';
	};
	// row was dropped - event handler
	rd.event.rowDropped = function () {
		// display message
		//msg.innerHTML = 'Dropped';
		var orden=0;
		$("#tbl tr").each(function (index, element) {
			orden+=1;
			var row_id = element.id;
			row_id = row_id.slice(3,row_id.length);
			$.post(server+'/sdt/actualizarOrdenTarea','id='+row_id+'&orden='+orden);
		});
		fijarFilasColumnas();
	};
	
	// row was dropped to the source - event handler
	// mini table (cloned row) will be removed and source row should return to original state
	rd.event.rowDroppedSource = function () {
		// make source row completely visible (no opacity)
		rd.rowOpacity(rd.objOld, 100);
		// display message
		//msg.innerHTML = 'Dropped to the source';
	};
	/*
	// how to cancel row drop to the table
	rd.event.rowDroppedBefore = function () {
		//
		// JS logic
		//
		// return source row to its original state
		rd.rowOpacity(rd.objOld, 100);
		// cancel row drop
		return false;
	}
	*/
	// row position was changed - event handler
	rd.event.rowChanged = function () {
		// get target and source position (method returns positions as array)
		var pos = rd.getPosition();
		// display current table and current row
		//msg.innerHTML = 'Changed: ' + pos[0] + ' ' + pos[1];
	};
	// row deleted
	rd.event.rowDeleted = function () {
		//msg.innerHTML = 'Deleted';
		$("#nrows").val(parseInt($("#nrows").val())-1);
		var el = rd.objOld;
		var id = el.id;
		id = id.slice(3,id.length);
		//$.post(server+'/sdt/eliminarTarea','id='+id);
	};

};

// insert row (below current row)
redips.rowInsert = function (el) {
	var row = REDIPS.drag.findParent('TR', el),	// find source row (skip inner row)
		top_row,									// cells reference in top row of the table editor
		nr,											// new table row
		lc;											// last cell in newly inserted row
	// set reference to the top row cells
	top_row = row.parentNode.rows[0].cells;
	// insert table row
	nr = REDIPS.table.row(redips.tableEditor, 'insert', row.rowIndex + 1);
	// define last cell in newly inserted table row
	//lc = nr.cells[nr.cells.length - 1];
	for (var i = 0; i < nr.cells.length; i++) {
		lc = nr.cells[i];
		lc.innerHTML = top_row[i].innerHTML;
		// if (i==1) {
		// 	nr.addClass("rowhandler");
		// }else if (i==2) {
		// 	nr.addClass("only rowhandler");
		// }else if (i==3) {
		// 	nr.addClass("only cligth");
		// }else if (i==4) {
		// 	nr.addClass("only cligth2");
		// }else{
		// 	nr.addClass("cdark");
		// };
	};
	var trold;
	$("#tbl tr").each(function(index, elemento){
		//elemento.class = "rl";
		if ($(elemento).attr("class")==null) {
			elemento.innerHTML= trold.innerHTML;
		};
		trold=elemento;
		//alert($(elemento).attr("class"))
	});
	lc = nr.cells[0];
	// copy last cell content from the top row to the last cell of the newly inserted row
	lc.innerHTML = top_row[0].innerHTML;
	// ignore last cell (attached onmousedown event listener will be removed)
	//REDIPS.table.cell_ignore(lc);
};

function addTableRow(table) {
    // clonar la ultima fila de la tabla
    var $tr = $(table).find("tbody tr:last").clone();
    // obtener el atributo name para los inputs y selects
    $tr.find("input,select").attr("name", function()
    {
     //  separar el campo name y su numero en dos partes
     var parts = this.id.match(/(\D+)(\d+)$/);
     // crear un nombre nuevo para el nuevo campo incrementando el numero para los previos campos en 1
     return parts[1] + ++parts[2];
    // repetir los atributos ids
    }).attr("id", function(){
     var parts = this.id.match(/(\D+)(\d+)$/);
     return parts[1] + ++parts[2];
    });
    // añadir la nueva fila a la tabla
    var a=$tr.find("div:eq(0)");
    alert(a.attr("class"));
    //b.registerEvents($tr.find(".row"),true);
    redips.event.add(document,"mousemove",a);
    redips.event.add(document,"touchmove",a);
    redips.event.add(document,"mouseup",a);
    redips.event.add(document,"touchend",a);
    $(table).find("tbody tr:last").after($tr);
};

// add onload event listener
if (window.addEventListener) {
	window.addEventListener('load', redips.Init, false);
}
else if (window.attachEvent) {
	window.attachEvent('onload', redips.Init);
}

var ajustarPosicion = function(){
	var offset_tb = $( "#tb0" ).offset();
	//console.log(offset_tb.left + " " + offset_tb.top);
	//console.log(offset_tb.left + " " + offset_tb.top + "--" + offset1.left + " " + offset1.top + "--" + offset2.left + " " + offset2.top);
}