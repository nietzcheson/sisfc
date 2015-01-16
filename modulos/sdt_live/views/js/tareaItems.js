server = "http://"+window.location.hostname;
$(document).ready(function(){
	$("input[id^='item']").focusout(function(e) {
		var id = $(this).attr("id");
	    id = id.slice(5,id.length);
		$.post(server+'/sdt/actualizarTareaItem1','id='+id+'&name='+$(this).val()).fail(function() {
		    console.log("error de conexion");
		});
	});
	$("input[id^='chek']").click(function(e) {
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
});