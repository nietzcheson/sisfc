$(document).ready(function(){
	server = "http://"+window.location.hostname;
	$("button[id^='b-eliminar_']").click(function(){
		if(confirm("¿Vas a eliminar?")){
			id = $(this).attr("id");
	        id = id.slice(11,id.length);
            $.post(_root_+'/servicios/eliminarServicio','id=' + id);
	        $("#tr_"+id).fadeOut(200);
		}
	});
});