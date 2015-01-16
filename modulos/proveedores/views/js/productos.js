$(document).ready(function(){
	server = "http://"+window.location.hostname;
	$("button[id^='b-eliminar2_']").click(function(){
		if(confirm("¿Vas a eliminar?")){
			id = $(this).attr("id");
	        id = id.slice(12,id.length);
            $.post(server+'/proveedores/eliminarProductoP','id=' + id);
	        $("#tr_"+id).fadeOut(200);
		}
	});
});