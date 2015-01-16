$(document).ready(function(){
	
	server = "http://"+window.location.hostname;
	var enviarDatos = function(){

		// $("li[id^='pet_']").each(function(index,element){
		// 	id = $(element).attr("id").slice(4,$(element).lenght);
		// 	alert(id);
		// });
		$.post(server+"peticiones/enviar","id=1",function(datos){
			alert(datos);
		},"json");

	}

	$("#enviarpeticion").click(function(){
		enviarDatos();
	});
});