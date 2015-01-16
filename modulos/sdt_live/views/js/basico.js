var server = "http://"+window.location.hostname;
var htd_height_px = 240;
$(document).ready(function() {

	
	

	//$("#rm").click(function(){
		$.post(server+'/sdt_live/ejemplo1', 'fecha='+$("#rm_searchdate").val(),  function(datos){
			$("#rm_contenido").html(datos);
			inicioRM();
 		}).fail(function() {
	   		console.log("error de conexion");
		});
	//});

	// $("#ch").click(function(){
		$.post(server+'/sdt_live/ejemplo3', 'fecha='+$("#rm_searchdate").val()+'&rango=mes&id_usuario=false', function(datos){
			$("#ch_contenido").html(datos);
			inicioCheckList();
			inicioFiltroCheckList();
 		}).fail(function() {
	   		console.log("error de conexion");
		});
	// });

	


	var vista =null;
	
	$("#left_move").click(function(){
		if ($("#right_move").is(':visible')) {
			$("#left_move").css("display","none");
			$("#registro_maestro").css("display","none");
			$("#left_right_move").css("left","0%");
			$("#hoja_diario").attr("class","col-md-12");
			$("#hoja_diario").fadeIn();
			vista="hoja_diario";
			direccion="left_move";
			$('#calendar').fullCalendar('render');
			$("#ht_c_view").css("height",htd_height_px);
			$("#ht_c_view_2").css("height",htd_height_px);
			$("#ht_c_view_6").css("height",htd_height_px);
		}else{
			$("#right_move").fadeIn();
			$("#down_up_move").fadeIn();
			$("#registro_maestro").attr("class","col-md-6");
			$("#hoja_diario").attr("class","col-md-6");
			$("#hoja_diario").fadeIn();
			$("#left_right_move").css("left","48%");
			vista=null;
		}
	});
	$("#right_move").click(function(){
		if ($("#left_move").is(':visible')) {
			$("#right_move").css("display","none");
			$("#hoja_diario").css("display","none");
			$("#left_right_move").css("left","98%");
			$("#registro_maestro").attr("class","col-md-12");
			$("#registro_maestro").fadeIn();
			vista="registro_maestro";
			direccion="right_move";
			
		}else{
			$("#left_move").fadeIn();
			$("#down_up_move").fadeIn();
			$("#hoja_diario").attr("class","col-md-6");
			$("#registro_maestro").attr("class","col-md-6");
			$("#registro_maestro").fadeIn();
			$("#left_right_move").css("left","48%");
			vista=null;
			$('#calendar').fullCalendar('render');
			$("#ht_c_view").css("height",htd_height_px);
			$("#ht_c_view_2").css("height",htd_height_px);
			$("#ht_c_view_6").css("height",htd_height_px);
		}
	});

	$("#up_move").click(function(){
		if ($("#down_move").is(':visible')) {
			$("#up_move").css("display","none");
			$("#left_right_move").css("display","none");
			$("#registro_maestro").css("display","none");
			$("#hoja_diario").css("display","none");
			$("#down_up_move").css("top","-3%");
			$("#checklist").css("height","600");
			$("#tabla").css("height","550");
			$("#drag").css("height","550");
		}else{
			$("#down_move").fadeIn();
			$("#left_right_move").fadeIn();
			$("#left_right_move").css("height","300");
			$("#registro_maestro").css("height","300");
			$("#rm_contenido").css("height","250");
			$("#checklist").css("height","300");
			$("#hoja_diario").css("height","300");
			$("#ht_c_view").css("height","240");
			$("#ht_c_view_2").css("height","240");
			$("#ht_c_view_6").css("height","240");
			htd_height_px=240;
			$("#down_up_move").css("top","47.5%");
			$("#checklist").fadeIn();
			$("#left_right_move").css("top","25%");
		}
	});
	$("#down_move").click(function(){
		if ($("#up_move").is(':visible')) {
			$("#checklist").css("display","none");
			$("#down_move").css("display","none");
			$("#registro_maestro").css("height","600");
			$("#rm_contenido").css("height","550");
			$("#ht_c_view").css("height","550");
			$("#ht_c_view_2").css("height","550");
			$("#ht_c_view_6").css("height","550");
			htd_height_px=550;
			$("#hoja_diario").css("height","600");
			$("#down_up_move").css("top","98%");
			$("#left_right_move").css("top","50%");
		}else{
			$("#up_move").fadeIn();
			if (vista!=null) {
				$("#"+vista).fadeIn();
			}else{
				$("#registro_maestro").fadeIn();
				$("#hoja_diario").fadeIn();
			}
			$("#left_right_move").fadeIn();
			$("#down_up_move").css("top","47.5%");

			$("#checklist").css("height","300");
			

			$("#registro_maestro").css("height","300");
			$("#rm_contenido").css("height","250");
			$("#hoja_diario").css("height","300");
			$("#tabla").css("height","250");
			$("#drag").css("height","250");
		}
	});
});