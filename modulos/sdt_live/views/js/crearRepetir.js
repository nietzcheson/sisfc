$(document).ready(function(){

	//$("#contenedor").html(item1);
	$("#repetir").change(function() {
		if ($(this).val()=="1" || $(this).val()=="2") {
			$("#opcion1").css("display","inline");
			$("#opcion2").css("display","none");
			$("#opcion3").css("display","none");
			$("#grupo1").css("display","table-cell");
			if ($(this).val()=="1") {
				$("#mensaje1").text("Repetir cada");
				$("#mensaje11").text("Semana(s)");
				$("#mensaje2").text("Durante");
				$("#mensaje22").text("Semana(s)");
			};
			if ($(this).val()=="2") {
				$("#mensaje1").text("Buscar el");
				$("#mensaje11").text("Dia(s)");
				$("#mensaje2").text("Cada");
				$("#mensaje22").text("Mes(es)");
			};
		};
		if ($(this).val()=="3" ) {
			$("#opcion1").css("display","none");
			$("#opcion2").css("display","inline");
			$("#opcion3").css("display","none");

			$("#grupo1").css("display","none");
			$("#mensaje2").text("Cada");
			$("#mensaje22").text("Mes(es)");
		};
		if ($(this).val()=="4" ) {
			$("#opcion1").css("display","none");
			$("#opcion2").css("display","none");
			$("#opcion3").css("display","inline");

			$("#grupo1").css("display","none");
			$("#mensaje2").text("Cada");
			$("#mensaje22").text("Mes(es)");
		};
	});

	$('#contenedor').on('click', ".btn-primary", function(e){
		var valores="";
		$(".select").each(function(){
			if ( $(this).prop("checked") ) {
				valores+=$(this).val()+",";
			}
		});
		$("#dias").val(valores);
	});
	$('.select').click(function(){
		var valores="";
		$(".select").each(function(){
			if ( $(this).prop("checked") ) {
				valores+=$(this).val()+",";
			}
		});
		$("#dias").val(valores);
	});
});
