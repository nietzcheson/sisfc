var server = "http://"+window.location.hostname;
var uso_choseen =0;
	$(document).ready(function() {

		$("#contenido").removeClass();
		$("#contenido").css("background-color","transparent");
		$("#contenido").css("border","none");
		

		var options = {
			ovalWidth:  $("#header-contenido").width()*2/5,
			ovalHeight: 50,
			offsetX: 0,
			offsetY: $("#header-contenido").offset().left+$("#header-contenido").width()*1/7.5,
			angle: 0,
			activeItem: 0,
			duration: 350,
			className: 'item'
		}

		var carousel = $('.carousel').CircularCarousel(options);
		if (typeof carousel === 'object') {
			/* Fires when an item is about to start it's activate animation */
			carousel.on('itemBeforeActive', function(e, item) {
				$(item).css('box-shadow', '0 0 20px blue');
			});

			/* Fires after an item finishes it's activate animation */
			carousel.on('itemActive', function(e, item) {
				$(item).css('box-shadow', '0 0 20px green');
			});

			/* Fires when an active item starts it's de-activate animation */
			carousel.on('itemBeforeDeactivate', function(e, item) {
				$(item).css('box-shadow', '0 0 20px yellow');
			})

			/* Fires after an active item has finished it's de-activate animation */
			carousel.on('itemAfterDeactivate', function(e, item) {
				$(item).css('box-shadow', '');
			})

			/* Previous button */
			$('.controls .previous').click(function(e) {
				carousel.cycleActive('previous');
				e.preventDefault();
			});

			/* Next button */
			$('.controls .next').click(function(e) {
				carousel.cycleActive('next');
				e.preventDefault();
			});


			/* Manaully click an item anywhere in the carousel */
			$('.carousel .item').click(function(e) {
				var index = $(this).index();
				carousel.cycleActiveTo(index);
				e.preventDefault();
			});

			resetAllProgressBar();
			carousel.cycleActive('next');

			$('.panel-title').tooltip();
		};

		$(".guardar").click(function(e) {
			actualizarKpis(this);
		});

		$(".eliminar").click(function(e) {
			var id_bp = $(this).attr("id");
			id_bp = id_bp.split("_");
			id_bp = id_bp[1];
			$("#kpi_c").val(id_bp);
			// $.post(server+'/kpis/eliminarKpi','kpi='+id_bp, function(datos){
			// 	if (datos!="None") {
			// 		window.location="http://"+window.location.hostname+"/kpis";
			// 	};
			// }, 'json').fail(function() {
			//     console.log("error de conexion");
			// });
		});
		$(".eliminarSi").click(function(e) {
			var id_bp = $("#kpi_c").val();
			$.post(server+'/kpis/eliminarKpi','kpi='+id_bp, function(datos){
				if (datos!="None") {
					window.location="http://"+window.location.hostname+"/kpis";
				};
			}, 'json').fail(function() {
			    console.log("error de conexion");
			});
		});
		$(".chosen-select").chosen( {allow_single_deselect:true,width:"100%"});

		$("button[id^='ver_']").click(function(e) {
			var id_bp = $(this).attr("id");
			id_bp = id_bp.split("_");
			id_bp = id_bp[1];
			$.post(server+'/kpis/obtenerKpi','kpi='+id_bp, function(datos){
				if (datos!="None") {
					$("#kpi_c").val(id_bp);
					$("#nombre_kpi_c").val(datos.informacion.kpi_nombre);
					$("#desc_kpi_c").val(datos.informacion.kpi_descripcion);
					$('#unidad_kpi_c option[value="'+ datos.informacion.id_unidad +'"]').attr("selected",true);

					noselected_all("area_kpi_c");
					for (x in datos.kpi_area) {
						$('#area_kpi_c option[value="'+ datos.kpi_area[x]["id_area"] +'"]').attr("selected",true);
					}
					noselected_all("puesto_kpi_c");
					for (x in datos.kpi_puesto) {
						$('#puesto_kpi_c option[value="'+ datos.kpi_puesto[x]["id_puesto"] +'"]').attr("selected",true);
					}
					noselected_all("usuario_kpi_c");
					for (x in datos.kpi_usuario) {
						$('#usuario_kpi_c option[value="'+ datos.kpi_usuario[x]["id_usuario"] +'"]').attr("selected",true);
					}
					$("#area_kpi_c").trigger('chosen:updated');
					$("#puesto_kpi_c").trigger('chosen:updated');
					$("#usuario_kpi_c").trigger('chosen:updated');
					$("#unidad_kpi_c").trigger('chosen:updated');
				};
			}, 'json').fail(function() {
			    console.log("error de conexion");
			});
		});

		$('.unidad').tooltip();

		$('#buscarKpi').click(function(e) {
			var nombre = $("#nombre_kpi_b").val();
			var unidad = $("#unidad_kpi_b").val();
			var area = $("#area_kpi_b").val();
			var puesto = $("#puesto_kpi_b").val();
			var usuario = $("#usuario_kpi_b").val();
			$.post(server+'/kpis/buscarKpi','nombre='+nombre+'&unidad='+unidad+'&area='+area+'&puesto='+puesto+'&usuario='+usuario, function(datos){
				if (datos!="None" ) {
					$(".carousel li").fadeOut("slow");
					for (x in datos) {
						$("#"+datos[x]).fadeIn("slow");
					}
				}else{
					$(".carousel li").fadeIn("slow");
				}
			}, 'json').fail(function() {
			    console.log("error de conexion");
			});
		});
		$('#todoKpi').click(function(e) {
			$(".carousel li").fadeIn("slow");
		});


		$('.mx-money').w2field('money', { moneySymbol: '$' });
		$('.us-money').w2field('money', { moneySymbol: '$' });
		$('.eu-money').w2field('money', { groupSymbol: ' ', currencyPrefix: '', currencySuffix: '€' });
		$('.co-money').w2field('money', { moneySymbol: '$' });
		$('.int-format').w2field('int', { autoFormat: false });
		$('.float-format').w2field('float', { autoFormat: false });
		$('.percent-format').w2field('percent', { precision: 1, min: 0, max: 100 });

		$(".bitacora").click(function(e) {
			$('#mibitacora').modal('show');
			var ide = $(this).attr("id");
			ide = ide.slice(5,ide.length);
			kpi_listar_comentarios(ide);
		});
		$("button[id^='crearNota_']").click(function(){
			var ide = $("#kpi_id").val();
			$.post(server+'/kpis/crearKPI_Nota','id='+ide+'&com='+$("#newcom").val(), function(datos){
				if (datos!="None") {
					$("#vacio").remove();
					var tr = $('<tr style="display: none;"></tr>');
					var label = $('<span class="label label-default">'+datos.fecha_nota+'</span>')
					var span =$('<span> <strong>'+datos.nombre+' : </strong></span>')
					var div =$('<div style="width:350px;word-break: keep-all">'+$("#newcom").val()+'</div>')
					var td = $('<td></td>');
					td.append(label);
					td.append(span);
					td.append(div);
					tr.append(td);
					$("#panel-notas").append(tr);
					$("#newcom").val('');
					$(tr).fadeIn();
				};
			}, 'json').fail(function() {
			    console.log("error de conexion");
			});
		});
		
	});

var kpi_listar_comentarios = function(id){
	if ($("#kpi_id").val()!=id) {
		$("#kpi_id").val(id);
		$("#panel-notas").html("");
		$.post(server+'/kpis/getKPI_Notas','id='+id, function(datos){
			var entro='<tr id="vacio"><td class="col-md-12"></td><td class="col-md-12">Ninguna nota...</td></tr>';
			for (var i = 0; i < datos.length; i++) {
				var tr = $('<tr ></tr>');
				var label = $('<span class="label label-default">'+datos[i].fecha_nota+'</span>')
				var span =$('<span> <strong>'+datos[i].nombre+' : </strong></span>')
				var div =$('<div style="width:350px;word-break: keep-all">'+datos[i].comentario+'</div>')
				var td = $('<td></td>');
				td.append(label);
				td.append(span);
				td.append(div);
				tr.append(td);
				$("#panel-notas").append(tr);
				entro='';
				
			};
			$("#contenedor-notas").animate({scrollTop:  1000000});
		}, 'json').fail(function() {
		    console.log("error de conexion");
		});
		
	};
}
var resetAllProgressBar = function(){
	$('.circle').each(function (index, element) {
		iniciarProgressBar(element);
	});
}
var valorNormal = function(valor){
	valor = valor.replace('$', '');
	valor = valor.replace('/$/g', '');
	valor = valor.replace(/€/g, '');
	valor = valor.replace(/,/g, '');
	valor = valor.replace(/%/g, '');
	valor = valor.replace(' ', '');
	return valor;
}
var iniciarProgressBar = function(objeto){
	var id_bp = $(objeto).attr("id");
	id_bp = id_bp.split("_");
	id_bp = id_bp[1];
	var actual = $("#actual_"+id_bp).val();
	var meta = $("#meta_"+id_bp).val();

	actual = valorNormal(actual);
	meta = valorNormal(meta);

	var valor =0;
	if (parseFloat(actual)>=parseFloat(meta)) {
		valor=0.9999;
	};
	if (meta>0) {
		valor=actual/meta;
	}else{
		valor=0;
	}

	$(objeto).circleProgress({
		startAngle: Math.PI / 2,
        value: valor,
        size: 260,
        fill: {
            gradient: ["red", "orange", "green"]
        }
    }).on('circle-animation-progress', function(event, progress, stepValue) {
	    //$(this).find('p').text((String(stepValue.toFixed(4)).substr(1)*100).toFixed(2));
	    var valor = (stepValue*100).toFixed(2);
	    var label =  $(this).find('label');
	    $(label).css("left","220px");
	    $(label).css("top","170px");
	    if (valor.length==4) {
	    	valor="0"+valor;
	    }else if (valor.length>5) {
	    	$(label).css("left","140px");
	    	$(label).css("top","220px");
	    }
	    $(this).find('p').text(valor);
	});
}
var actualizarKpis = function(objeto){
	var id_bp = $(objeto).attr("id");
	id_bp = id_bp.split("_");
	id_bp = id_bp[1];
	var actual = $("#actual_"+id_bp).val();
	var meta = $("#meta_"+id_bp).val();

	var btn = $("#salvar2_"+id_bp);
    btn.button('loading')
	$.post(server+'/kpis/actualizarKpis','kpi='+id_bp+'&actual='+actual+'&meta='+meta, function(datos){
		if (datos!="None") {
			resetAllProgressBar();
			btn.button('reset');
			$("#alert_"+id_bp).remove();
			var span = $("#"+id_bp).find(".nombre-usuario");
			$(span).html(datos);

			

			actual = valorNormal(actual);
			meta = valorNormal(meta);
			if (parseFloat(actual)>=parseFloat(meta)) {
				$('#milogro').modal('show');
				fworks.playFire();
			};
		};
	}, 'json').fail(function() {
	    console.log("error de conexion");
	});
}

var noselected_all = function (select_id){
	obj=document.getElementById(select_id);
	for(var i = 0; i < obj.options.length; i++){
		obj.options[i].selected = false;
	}
}