$(document).ready(function(){
	server = "http://"+window.location.hostname;
	$("#filtrar").click(function(){
		FiltrarTabla();
	});
	$("#limpiar").click(function(){
		$("input[id^='filtrar_']").each(function(index2, elemento2){
			$(elemento2).val("");
		});
		FiltrarTabla();
	});
	$("input[id^='filtrar_']").keyup(function(){
		FiltrarTabla();
	});
	var FiltrarTabla = function(){
		$("tr[id^='tr_']" ).each(function(index1, elemento1){
			id1 = $(elemento1).attr("id");
	        id1 = id1.slice(3,id1.length);
	        coin1=0;
	        coin2=0;
			$("input[id^='filtrar_']").each(function(index2, elemento2){
				if ($(elemento2).val()!="") {
					coin1+=1;
					id2 = $(elemento2).attr("id");
	            	id2 = id2.slice(8,id2.length);
	            	if ($("#"+id2+id1).text().toUpperCase().search($(elemento2).val().toUpperCase())>-1) {
	            		coin2+=1;
	            	};
				};
	        });
	        if (coin1!=coin2) {
	        	$("#tr_"+id1).fadeOut(500);
	        }else{
	        	$("#tr_"+id1).fadeIn(500);
	        };
	    });
	}
	// Eliminar referencia
	$("button[id^='b-eliminar_']").click(function(){
        if(confirm("¿Está seguro de eliminar la referencia?")){
            id = $(this).attr("id");
            id = id.slice(11,id.length);
            $.post(_root_+'/operaciones/eliminarReferencia','id=' + id);
            $("#tr_"+id).fadeOut(200);
        }
    });

		var cambiarEstatus = function(){
			$.post(_root_+"operaciones/cambiarEstatus","id="+id+"&est="+est,function(datos){},'json');
		}

		$("select[id^='est_']").change(function(){

			id = $(this).attr("id");
			id = id.slice(4,id.length);
			est = $(this).val();
			cambiarEstatus();
		});

});
