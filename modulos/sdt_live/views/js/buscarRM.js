$(document).ready(function(){
	$('#loading-sowrds-rm').click(function () {
		var btn = $(this);
		btn.button('Buscando...');
		$("#lista-Palabras").html('');
		var encabezado = $('<a class="list-group-item active">Lista de palabras encontradas</a>');
		$("#lista-Palabras").append(encabezado);
		$.post(server+'/sdt_live/buscar_palabras_RM','palabra='+$("#sword-to-search").val(), function(datos){
			if (datos!="None") {
				btn.button('reset');
				for (var i = 0; i < datos.length; i++) {
					var lista = $('<a class="list-group-item search-day-rm '+datos[i].url+'"><span class="badge">'+datos[i].fecha+'</span>'+datos[i].texto+'</a>');
					$("#lista-Palabras").append(lista);
				}
			};
		}, 'json').fail(function() { 
		    console.log("error de conexion");
		    SOnline=false;
		});
	});
	$('bt-searchRM').click(function () {
		$("#lista-Palabras").html('');
	});
});