$(document).on("ready",function(){

	$(".btn-press").on('click',function(){

		$(".btn-press").attr("class","btn btn-default btn-press");
		$(this).attr("class","btn btn-primary btn-press active");

		valor = $(this).find("input[type=radio]").val();

		if(valor==1){
			$("#usuarioEmail h3 strong").text("Usuario");
			$("#log").attr("name","sisfc");
			$("#usuarioEmail input").attr("placeholder","Usuario");
			$("#usuarioEmail input").attr("name","usuario");
		}

		if(valor==2){
			$("#usuarioEmail h3 strong").text("Email");
			$("#log").attr("name","secs");
			$("#usuarioEmail input").attr("placeholder","Email");
			$("#usuarioEmail input").attr("name","email");
		}

	});

	

});
