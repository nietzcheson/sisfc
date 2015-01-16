$(document).ready(function(){
	server = "http://"+window.location.hostname;
	$("button[id^='b-eliminar_']").click(function(){
		if(confirm("¿Vas a eliminar?")){
			id = $(this).attr("id");
	        id = id.slice(11,id.length);
            $.post(server+'/leads/eliminarLead','id=' + id);
	        $("#tr_"+id).fadeOut(200);
		}
	});

	var cambiarEstatus = function(){
		$("#mostrar").html("");
		$(".no-selected").css("background","#50505050");
		$.post(_root_+"leads/cambiarEstatus","id="+id+"&estatus="+estatus,function(datos){
			$("#mostrar").html(datos);
		},'json');

	}

	$("select[id^='est_']").change(function(){
		id = $(this).attr("id");
		id = id.slice(4,id.length);
		estatus = $(this).val();
		cambiarEstatus();
	});


});
