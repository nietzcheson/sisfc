$(document).ready(function(){

	$("button[id^='b-eliminar_']").click(function(){
		if(confirm("¿Vas a eliminar?")){
			id = $(this).attr("id");
	        id = id.slice(11,id.length);
            $.post(_root_+'/proveedores/eliminarProveedor','id=' + id);
	        $("#tr_"+id).fadeOut(200);
		}
	});

});
