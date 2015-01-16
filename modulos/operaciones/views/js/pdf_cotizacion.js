$(document).ready(function(){
	server = "http://"+window.location.hostname;
	// $('#loading-example-btn').click(function () {
 //    	var btn = $(this);
 //    	btn.button('Generando');
 //    	$.post(server+"/operaciones/pdf_cotizacion",'pdf=' + "Algo");
 //    	alert("Algo");
 //  	});

  	$("#loading-example-btn").click(function(){
		$("#datos").val( $("<div>").append( $("#tabla").eq(0).clone()).html());
		$("#pdf").submit();
	});

	$("button[id^='b-eliminar_']").click(function(){
		if(confirm("¿Vas a eliminar?")){
			id = $(this).attr("id");
	        id = id.slice(11,id.length);
            $.post(server+'/proveedores/eliminarProveedor','id=' + id);
	        $("#tr_"+id).fadeOut(200);
		}
	});
});
