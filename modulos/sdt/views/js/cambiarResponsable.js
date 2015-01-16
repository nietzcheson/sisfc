server = "http://"+window.location.hostname;
$(document).ready(function(){
	$(".responsable").change(function(){
		var td = $(this).parent();
		var tr = $(td).parent();
		var idt = $(tr).attr("id");
		idt = idt.slice(3,idt.length);
		var nid1 = $(this).val();
		var nid0 = $(this).attr("id");
		$(this).attr("id",idt+"_"+nid1);
		$.post(server+'/sdt/cambiarResponsable','id='+nid0+'_'+nid1, function(datos){
			if (datos!="None") {
				
			}
		}, 'json');
	});
	var texto1="";
	$("#descripcion").keypress(function(e) {
		texto1 = $("#descripcion").val();
	});
	$("#descripcion").keyup(function(e) {
		var texto = $("#descripcion").val().length;
		if ((300-texto)>=0) {
			$("#numch").text("("+(300-texto)+")");
		}else{
			$("#descripcion").val(texto1.slice(0,300));
		}
	});
});